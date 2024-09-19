<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained('agendamentos')->onDelete('cascade');
            $table->integer('notebooks')->default(0);
            $table->integer('projetor')->default(0);
            $table->integer('camera_fotografica')->default(0);
            $table->integer('tripe')->default(0);
            $table->integer('fonte_caixa_som')->default(0);
            $table->integer('microfone')->default(0);
            $table->integer('caneta_quadro_interativo')->default(0);
            $table->integer('controle_tv')->default(0);
            $table->integer('controle_projetor')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipamentos');
    }
}