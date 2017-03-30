<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Resolver o problema de compatibilidade com o MariaDb

        Schema::defaultStringLength(191);

        // Criar a regra de validação para nomes

        Validator::extend('alpha_spaces', function($atributo, $valor, $parametros, $validador){

            return preg_match('/^[\pL\s]+$/u', $valor);

        });

        // Criar a regra de validação para RG e outros documentos

        Validator::extend('documento', function($atributo, $valor, $parametros, $validador){

            return preg_match('/([0-9\-\.]+){8,}/', $valor);

        });

        // Criar a regra de validação para cpf

        Validator::extend('cpf', function($atributo, $valor, $parametros, $validador){

            // Verifica se um número foi informado,
            // retorna true nesse caso, pois o campo CPF não é 
            // obrigatório
            if(empty($valor)) {
                return true;
            }
         
            // Elimina possivel mascara

            $valor = str_replace(['.', '-'], '', $valor);
            $valor = str_pad($valor, 11, '0', STR_PAD_LEFT);
             
            // Verifica se o numero de digitos informados é igual a 11 
            if (strlen($valor) != 11) {
                return false;
            }

            // Verifica se nenhuma das sequências invalidas abaixo 
            // foi digitada. Caso afirmativo, retorna falso
            if ($valor == '00000000000' || 
                $valor == '11111111111' || 
                $valor == '22222222222' || 
                $valor == '33333333333' || 
                $valor == '44444444444' || 
                $valor == '55555555555' || 
                $valor == '66666666666' || 
                $valor == '77777777777' || 
                $valor == '88888888888' || 
                $valor == '99999999999') {
             // Calcula os digitos verificadores para verificar se o
             // CPF é válido
             } else {   

                for ($t = 9; $t < 11; $t++) {
                     
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $valor{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($valor{$c} != $d) {
                        return false;
                    }
                }
         
                return true;
            }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
