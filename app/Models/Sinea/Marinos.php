<?php

namespace App\Models\Sinea;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marinos extends Model
{
    use HasFactory;

    protected $connection = 'gemar';
    protected $table = 'marinos';

    protected $fillable = [
        'pnj',
        'ci',
        'nombre',
        'apellido',
        'padre',
        'madre',
        'estado_civil',
        'nacionalidad',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'estado_id',
        'municipio_id',
        'parroquia_id',
        'direccion',
        'telefono',
        'fax',
        'email',
        'rangodef_id',
        'edad',
        'fotografia',
        'pasaporte',
        'solicitante_id',
        'cedula_m_sigla',
        'cedula_m_tipo',
        'cedula_m_numero',
        'sexo',
        'nro_inscripcion_militar',
        'ctrl_cedula_marino_id'
    ];

    protected $casts = [
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    // Relación con Solicitantes
    public function solicitante()
    {
        return $this->belongsTo(Solicitantes::class, 'solicitante_id');
    }
}
