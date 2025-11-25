<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('_tb_users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('email')->nullable();
            $table->string('senha'); // bcrypt
            $table->boolean('ativo')->default(true);

            // foto cadastrada no fluxo facial
            $table->string('foto_face')->nullable();

            // relacionamento com clientes
            $table->foreignId('cliente_id')
                  ->nullable()
                  ->constrained('_tb_clientes')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('_tb_users');
    }
};
