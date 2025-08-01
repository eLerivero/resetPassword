<?php

namespace App\Models\Sinea;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitantes extends Model
{
    use HasFactory;

    protected $connection = 'sinea';
    protected $table = 'solicitantes';

    protected $fillable = [
        'user_id',
        'nombre',
        'direccion',
        'rif',
        'fax',
        'telefono',
        'correo',
        'pnj',
        'old_id',
        'coincidente'
    ];

    protected $casts = [
        'created' => 'datetime',
        'modified' => 'datetime'
    ];

    // Relación con AuthakeUsers
    public function authakeUser()
    {
        return $this->belongsTo(AuthakeUsers::class, 'user_id');
    }

    // Relación con Marinos
    public function marinos()
    {
        return $this->hasMany(Marinos::class, 'solicitante_id'); 
    }
}
