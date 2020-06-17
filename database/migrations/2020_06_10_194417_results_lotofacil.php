<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResultsLotofacil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('results_lotofacil', function (Blueprint $table) {
            $table->integer('concurso')->unique();
            $table->date('dt_sorteio');
            $table->integer('bola_1');
            $table->integer('bola_2');
            $table->integer('bola_3');
            $table->integer('bola_4');
            $table->integer('bola_5');
            $table->integer('bola_6');
            $table->integer('bola_7');
            $table->integer('bola_8');
            $table->integer('bola_9');
            $table->integer('bola_10');
            $table->integer('bola_11');
            $table->integer('bola_12');
            $table->integer('bola_13');
            $table->integer('bola_14');
            $table->integer('bola_15');
            $table->double('arrecadacao_total');
            $table->integer('ganhadores_15_numeros');
            $table->integer('ganhadores_14_numeros');
            $table->integer('ganhadores_13_numeros');
            $table->integer('ganhadores_12_numeros');
            $table->integer('ganhadores_11_numeros');
            $table->double('valor_rateio_15_numeros');
            $table->double('valor_rateio_14_numeros');
            $table->double('valor_rateio_13_numeros');
            $table->double('valor_rateio_12_numeros');
            $table->double('valor_rateio_11_numeros');
            $table->double('acumulado_15_numeros');
            $table->double('estimativa_premio');
            $table->double('valor_acumulado_especial');
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
        //
    }
}
