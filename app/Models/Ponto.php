<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    protected $table = 'pontos';

    protected $fillable = [
        'user_id',
        'tipo',
        'foto',
        'lat',
        'lng',
        'origem',
        'data_hora',
    ];

    // Formatar automaticamente a data caso precise no front
    protected $casts = [
        'data_hora' => 'datetime',
    ];

    // Cada ponto pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
