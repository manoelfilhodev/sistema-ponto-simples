<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pontos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('_tb_users')
                ->cascadeOnDelete();

            $table->enum('tipo', ['entrada', 'saida']);

            // foto tirada no momento do registro
            $table->string('foto')->nullable();

            // localização
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // origem: web / facial / app
            $table->string('origem')->default('web');

            $table->timestamp('data_hora');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pontos');
    }
};
