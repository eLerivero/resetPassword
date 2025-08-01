<?php

namespace App\Models\Sinea;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthakeUsers extends Model
{
    use HasFactory;

    protected $connection = 'sinea';
    protected $table = 'authake_users';

    public $timestamps = false;

    protected $fillable = [
        'login',
        'emailcheckcode',
        'passwordchangecode',
        'expire_account',
        'password',
        'email',
        'disable',
        'capitania_id',
        'old_id',
        'ip',
        'cambio_login',
        'cambios_hora'
    ];
    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'cambios_hora' => 'datetime'
    ];


    // Relación con Solicitantes
    public function solicitantes()
    {
        return $this->hasMany(Solicitantes::class, 'user_id');
    }
}
