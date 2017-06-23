<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
        if  (! DB::table('users')->find(1)) {
           
            DB::table('users')->insert([
                'name'      =>  'Filipe Molina',
                'email'     =>  'filipemolina@live.com',
                'password'  =>  bcrypt('123456'),
                'admin'     => "Master",
            ]);

            DB::table('users')->insert([
                'name'      =>  'Luciano Teles',
                'email'     =>  'luciano.junior@live.com',
                'password'  =>  bcrypt('123456'),
                'admin'     => "Master",
            ]);

             DB::table('users')->insert([
                'name'      =>  'Leandro Accioly',
                'email'     =>  'leandro.accioly@hotmail.com',
                'password'  =>  bcrypt('123456'),
                'admin'     => "Master",
            ]);

             DB::table('users')->insert([
                'name'      =>  'Marcelo Milanda',
                'email'     =>  'marcelo.miranda.pp@gmail.com',
                'password'  =>  bcrypt('123456'),
                'admin'     => "Master",
            ]);
        }
    }
}
