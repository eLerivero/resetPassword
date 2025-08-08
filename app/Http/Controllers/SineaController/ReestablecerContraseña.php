<?php

namespace App\Http\Controllers\SineaController;

use App\Http\Controllers\Controller;
use App\Models\Sinea\Marinos;
use App\Models\Sinea\Solicitantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sinea\ResetPassword;
use Carbon\Carbon;

class ReestablecerContraseña extends Controller
{
    public function index()
    {
        return view('desarrollo.page');
    }

    public function buscarSolicitante(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string',
        ]);

        $solicitante = Solicitantes::with('authakeUser')->where('rif', 'like', (string)$request->input('cedula'))->first();

        if (!$solicitante) {
            return response()->json([
                'success' => false,
                'message' => 'Cédula no encontrada en nuestra base de datos SINEA, por favor registrese',
            ]);
        }

        $solicitantesCount = Solicitantes::where('rif', (string)$request->input('cedula'))->count();
        if ($solicitantesCount > 1) {
            Mail::to($solicitante->authakeUser->email)->send(new \App\Mail\Sinea\UsersDuplicados($solicitante));
            return response()->json([
                'success' => false,
                'message' => 'La cédula existe más de una vez. Se ha enviado un correo para verificar su caso.',
            ]);
        }

        $marino = Marinos::where('ci', (string)$request->input('cedula'))->first();
        if (!$marino) {
            // Obtener preguntas de seguridad del solicitante
            $preguntas = $this->obtenerPreguntasSeguridadSolicitante($solicitante);
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

        $preguntas = $this->obtenerPreguntasSeguridadExpedienteMarino($marino);
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

    private function obtenerPreguntasSeguridadExpedienteMarino($marino)
    {
        $campos = [];
        if ($marino->fecha_nacimiento) $campos['fecha_nacimiento'] = $marino->fecha_nacimiento;
        if ($marino->lugar_nacimiento) $campos['lugar_nacimiento'] = $marino->lugar_nacimiento;
        if ($marino->sexo) $campos['sexo'] = $marino->sexo;
        if ($marino->telefono) $campos['telefono'] = $marino->telefono;
        if ($marino->estado_civil) $campos['estado_civil'] = $marino->estado_civil;

        // Seleccionar 3 preguntas aleatorias del expediente de marino
        $keys = array_keys($campos);
        shuffle($keys);
        $selectedKeys = array_slice($keys, 0, 3);

        return array_intersect_key($campos, array_flip($selectedKeys));
    }

    private function obtenerPreguntasSeguridadSolicitante($solicitante)
    {
        $campos = [];
        if ($solicitante->telefono) $campos['telefono'] = $solicitante->telefono;
    //  if ($solicitante->direccion) $campos['direccion'] = $solicitante->direccion;

        // Seleccionar cantidad de preguntas aleatorias del solicitante
        $keys = array_keys($campos);
        shuffle($keys);
        $selectedKeys = array_slice($keys, 0, 1);

        return array_intersect_key($campos, array_flip($selectedKeys));
    }

    public function validarPreguntas(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'respuestas' => 'required|array',
        ]);

        $solicitante = Solicitantes::with('authakeUser')->where('user_id', $request->input('user_id'))->firstOrFail();
        $marino = Marinos::where('solicitante_id', $solicitante->id ?? '')->first();

        // Validar respuesta de seguridad del marino
        $errores = [];
        if ($marino) {
            foreach ($request->input('respuestas') as $key => $respuesta) {
                if (strtolower($marino->$key) !== strtolower($respuesta)) {
                    $errores[$key] = $respuesta; // Guardar respuesta incorrecta
                }
            }
            // validar respuestas de seguridad del solicitante
        } else {
            foreach ($request->input('respuestas') as $key => $respuesta) {
                if (strtolower($solicitante->$key) !== strtolower($respuesta)) {
                    $errores[$key] = $respuesta; // Guardar respuesta incorrecta
                }
            }
        }

        if (!empty($errores)) {
            return response()->json(['success' => false, 'message' => 'Algunas respuestas son incorrectas.', 'errores' => $errores]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Las respuestas son correctas. Puede restablecer su contraseña.',
            'user_id' => $solicitante->user_id ?? '',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'email' => 'required|email',
        ]);

        $solicitante = Solicitantes::with('authakeUser')->where('user_id', $request->input('user_id'))->firstOrFail();
        $newPassword = bin2hex(random_bytes(4));
        $hashedPassword = md5($newPassword);

        $authakeUser = $solicitante->authakeUser;

        if ($authakeUser) {
            $authakeUser->update([
                'password' => $hashedPassword,
                'cambio_login' => "AutogestionSinea",
                'ip' => $request->ip(),
                'cambios_hora' => Carbon::now(),
            ]);

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
        return view('mails.sinea.ResetPassword');
    }
}
