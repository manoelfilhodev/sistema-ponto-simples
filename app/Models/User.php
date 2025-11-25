<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = '_tb_users';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha',
        'ativo',
        'foto_face',
        'cliente_id',
    ];

    protected $hidden = [
        'senha', // esconder senha nas respostas
    ];

    // Laravel usa getAuthPassword para saber qual coluna é a senha
    public function getAuthPassword()
    {
        return $this->senha;
    }

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relacionamento com Pontos
    public function pontos()
    {
        return $this->hasMany(Ponto::class, 'user_id');
    }
}
