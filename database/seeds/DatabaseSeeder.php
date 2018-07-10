<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar as áreas de atuação

       /* $areas = [
            'Auxiliar de Serviços Gerais',
            'Atendente',
            'Balconista',
            'Bancário',
            'Contador',
            'Carteiro',
            'Dentista',
            'Enfermeira',
            'Fisioterapeuta',
            'Gerente de Vendas',
            'Operador de Telemarketing',
            'Técnico de Informática',
            'Professor'
        ];

        $id_areas = [];

        foreach($areas as $area)
        {
            $id_areas[] = factory(App\Area::class)->create(['descricao' => $area])->id;
        }

        factory(App\Curriculo::class, 2000)->create()
        ->each(function($curriculo){

            $areas = DB::select("select id from areas");

            $id_area = array_rand($areas);

            echo $curriculo->id."\n";

            $curriculo->areas()->attach($areas[$id_area]->id);

        });*/

        $this->call(UsersTableSeeder::class);
    }
}
