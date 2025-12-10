<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->unique()->after('email');
            $table->string('cargo')->nullable()->after('cpf');
            $table->unsignedBigInteger('cliente_id')->nullable()->after('cargo');
            $table->string('foto')->nullable()->after('cliente_id');
            $table->boolean('ativo')->default(1)->after('foto');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'cargo', 'cliente_id', 'foto', 'ativo']);
        });
    }
};
