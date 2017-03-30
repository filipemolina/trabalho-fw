<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculos', function (Blueprint $table) {

            // Chave Primária

            $table->increments('id');

            // Documentação

            $table->string('nome', 100);
            $table->string('rg', 30)->nullable();
            $table->string('cpf', 30)->nullable();
            $table->string('pis', 30)->nullable();
            $table->string('ctps', 30)->nullable();
            $table->string('titulo', 30)->nullable();

            // Endereço

            $table->string('rua');
            $table->string('numero', 10);
            $table->string('complemento')->nullable();
            $table->string('bairro', 100);
            $table->string('cep', 10)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 100)->nullable();

            // Telefones

            $table->string('telefone_1', 10)->nullable();
            $table->string('telefone_2', 10)->nullable();

            // Miscelânia
            
            $table->boolean('indicacao_politica');
            $table->string('quem_indicou')->nullable();
            $table->text('comentarios')->nullable();

            // Data de criação e modificação

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
        Schema::dropIfExists('curriculos');
    }
}
