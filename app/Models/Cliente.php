<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = '_tb_clientes';

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'ativo',
    ];

    // Relacionamento com Usuários
    public function usuarios()
    {
        return $this->hasMany(User::class, 'cliente_id');
    }
}
