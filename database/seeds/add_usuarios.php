<?php

use Illuminate\Database\Seeder;

class add_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupo_usuarios')->insert([

            ['nombre' => 'Administrador' , 'permiso' => 'W'],
            ['nombre' => 'Empleado' , 'permiso' => 'R']
            
        ]);


        DB::table('usuarios')->insert([

            ['empleado_id' => 2,
            'user_name' => 'carlos',
            'password' => 'carlos',
            'grupo_usuario_id' => 2],

            ['empleado_id' => 3,
            'user_name' => 'eloy',
            'password' => 'eloy',
            'grupo_usuario_id' => 2],

            ['empleado_id' => 1,
            'user_name' => 'admin',
            'password' => 'admin',
            'grupo_usuario_id' => 1]
        ]);


    }
}
