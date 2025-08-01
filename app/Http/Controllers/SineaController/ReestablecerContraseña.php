<?php

namespace App\Http\Controllers\SineaController;

use App\Http\Controllers\Controller;
use App\Models\Sinea\Marinos;
use App\Models\Sinea\Solicitantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sinea\ResetPassword; // Asegúrate de incluir la clase de correo
use App\Models\Sinea\AuthakeUsers;
use Str;
use Carbon\Carbon;

class ReestablecerContraseña extends Controller
{
    public function index()
    {
        $solicitante = Solicitantes::with('authakeUser')
            ->where('rif', 'like', '26475336')
            ->first();

        return view('desarrollo.page', compact('solicitante'));
    }

    public function buscarSolicitante(Request $request)
    {
        $request->validate([
            'cedula' => 'required|integer',
        ]);

        // Verificar si la cédula existe en la tabla solicitantes
        $solicitante = Solicitantes::with('authakeUser')->where('rif', 'like', (string)$request->input('cedula'))->first();

        if (!$solicitante) {
            return response()->json([
                'success' => false,
                'message' => 'Cédula no encontrada en nuestra base de datos SINEA, por favor registrese',
            ]);
        }

        // Verificar si el rif está duplicado en la tabla solicitantes
        $solicitantesCount = Solicitantes::where('rif', (string)$request->input('cedula'))->count();
        if ($solicitantesCount > 1) {
            // Enviar notificación por correo
            Mail::to($solicitante->authakeUser->email)->send(new \App\Mail\Sinea\UsersDuplicados($solicitante));
            return response()->json([
                'success' => false,
                'message' => 'La cédula existe más de una vez. Se ha enviado un correo para verificar su caso, recibirás un mensaje a su correo electrónico una vez se haya corregido la incidencia.',
            ]);
        }

        // Consultar en la tabla marinos
        $marino = Marinos::where('ci', (string)$request->input('cedula'))->first();
        if (!$marino) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró un marino asociado a esta cédula.',
            ]);
        }

        // Verificar si ci está duplicado en la tabla marinos
        $marinosCount = Marinos::where('ci', (string)$request->input('cedula'))->count();
        if ($marinosCount > 1) {
            // Enviar notificación por correo
            Mail::to($marino->email)->send(new \App\Mail\Sinea\UsersDuplicados($marino));
            return response()->json([
                'success' => false,
                'message' => 'La cédula existe más de una vez. Se ha enviado un correo para verificar su caso, recibirás un mensaje a su correo electrónico una vez se haya corregido la incidencia.',
            ]);
        }

        // Mostrar preguntas de seguridad
        $preguntas = $this->obtenerPreguntasSeguridad($marino);
        return response()->json([
            'success' => true,
            'data' => [
                'nombre' => $solicitante->nombre ?? '',
                'email' => $solicitante->authakeUser->email ?? '',
                'login' => $solicitante->authakeUser->login ?? '',
                'preguntas' => $preguntas,
                'user_id' => $solicitante->user_id ?? '',
            ],
        ]);
    }

    private function obtenerPreguntasSeguridad($marino)
    {
        $campos = [];
        if ($marino->fecha_nacimiento) $campos['fecha_nacimiento'] = $marino->fecha_nacimiento;
       // if ($marino->lugar_nacimiento) $campos['lugar_nacimiento'] = $marino->lugar_nacimiento;
        if ($marino->sexo) $campos['sexo'] = $marino->sexo;
        if ($marino->telefono) $campos['telefono'] = $marino->telefono;
      //  if ($marino->estado_civil) $campos['estado_civil'] = $marino->estado_civil;

        // Seleccionar 3 preguntas aleatorias del expediente de marino
        $keys = array_keys($campos);
        shuffle($keys);
        $selectedKeys = array_slice($keys, 0, 3);

        return array_intersect_key($campos, array_flip($selectedKeys));
    }
    public function validarPreguntas(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'user_id' => 'required|integer',
            'respuestas' => 'required|array',
        ]);

        // Obtener el solicitante_id a través del user_id
        $solicitante = Solicitantes::with('authakeUser')->where('user_id', $request->input('user_id'))->firstOrFail();

        // Buscar datos del expediente del marino asociado al solicitante_id
        $marino = Marinos::where('solicitante_id', $solicitante->id ?? '')->first();

        // Verificar si se encontró un marino asociado al solicitante_id
        if (!$marino) {
            return response()->json(['success' => false, 'message' => 'No se encontró un marinero asociado a este solicitante.']);
        }

        $errores = [];
        foreach ($request->input('respuestas') as $key => $respuesta) {
            if (strtolower($marino->$key) !== strtolower($respuesta)) {
                $errores[$key] = $respuesta; // Guardar respuesta incorrecta
            }
        }

        if (!empty($errores)) {
            return response()->json(['success' => false, 'message' => 'Algunas respuestas son incorrectas.', 'errores' => $errores]);
        }

        // Rescata éxito
        return response()->json([
            'success' => true,
            'message' => 'Las respuestas son correctas. Puede restablecer su contraseña.',
            'user_id' => $solicitante->user_id ?? '', // Enviar el user_id para el siguiente paso que es reestablecer la contraseña o enviar email-sai
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        $solicitante = Solicitantes::with('authakeUser')->where('user_id', $request->input('user_id'))->firstOrFail();

        // Generar nueva contraseña aleatoria
        $newPassword = bin2hex(random_bytes(4));
        $hashedPassword = md5($newPassword); // Hashear la nueva contraseña a formato md5 como lo necesita BD sinea

        $authakeUser = $solicitante->authakeUser;

        if ($authakeUser) {
            // Actualizar la contraseña en la base de datos Y registrar log
            $authakeUser->update([
                'password' => $hashedPassword,
                'cambio_login' => "AutogestionSinea",
                'ip' => $request->ip(),
                'cambios_hora' => Carbon::now(),
            ]);

            // Enviar correo con la nueva contraseña
            Mail::to($request->input('email'))->send(new ResetPassword($newPassword, $authakeUser->login));

            return response()->json([
                'success' => true,
                'message' => 'Se ha enviado un correo con su nueva contraseña.',
                'login' => $authakeUser->login ?? '',
                'nombre' => $solicitante->nombre ?? '',
                'user_id' => $solicitante->user_id ?? '',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
    }

    public function vista()
    {
        ///////* Testing para ver la plantilla que va recibir el solicitantes *//////////
        $login = 'UsuarioTest';
        $newPassword = 'ContraseñaTest';
        return view('mails.sinea.resetPassword', compact('login', 'newPassword'));
    }
}
