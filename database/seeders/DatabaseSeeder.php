<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Producto;
use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            RolesPermissionsSeeder::class,
        ]);

        \App\Models\User::factory(20)->create();

        Address::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Categorias
        \App\Models\Categoria::create([
            "nombre" => "General",
        ]);
        //1
        \App\Models\Categoria::create([
            "nombre" => "martillo",
        ]);
        //2
        \App\Models\Categoria::create([
            "nombre" => "atornillador",
        ]);
        //3
        \App\Models\Categoria::create([
            "nombre" => "sierra",
        ]);
        //4
        \App\Models\Categoria::create([
            "nombre" => "pintar",
        ]);
        //5
        \App\Models\Categoria::create([
            "nombre" => "reparacion",
        ]);

        //Productos
        Producto::factory()->count(200)->create();

        //Clientes
        //1
        \App\Models\Cliente::create([
            "nombre" => "Edwin",
            "apellido" => "Vill",
            "dni" => "43215678EL",
            "email" => "edvill@gmail.com",
            "movil" => "611521009",

            "contacto" => "Victor",
            "direccion" => "Victor Raul S3",
            "cp" => "35636",
            "poblacion" => "peruano",
            "provincia" => "Lima",
            "fax" => "",
            "cargo" => "",
            "titular_nom" => "Edwin",
            "titular_ape" => "Vill",
            "direccion_envio" => "Victor Raul S3",
            "cp_envio" => "35636",
            "poblacion_envio" => "Peruano",
            "provincia_envio" => "Lima",
            "pago" => "",

        ]);
        //2
        \App\Models\Cliente::create([
            "nombre" => "Rafa",
            "apellido" => "Papaele",
            "dni" => "87651234R",
            "email" => "yonka@gmail.com",
            "movil" => "621621002",

            "contacto" => "Victor",
            "direccion" => "Zeus avenue",
            "cp" => "34342",
            "poblacion" => "griega",
            "provincia" => "Rhodes",
            "fax" => "",
            "cargo" => "",
            "titular_nom" => "Rafa",
            "titular_ape" => "Papaele",
            "direccion_envio" => "Zeus avenue",
            "cp_envio" => "34342",
            "poblacion_envio" => "griega",
            "provincia_envio" => "Rhodes",
            "pago" => "",

        ]);
        //3
        \App\Models\Cliente::create([
            "nombre" => "Joshua",
            "apellido" => "Viruta",
            "dni" => "87654321J",
            "email" => "jrchard@gmail.com",
            "movil" => "611521666",

            "contacto" => "Maca",
            "direccion" => "Cerrocity",
            "cp" => "66666",
            "poblacion" => "peruano",
            "provincia" => "Comas",
            "fax" => "",
            "cargo" => "",
            "titular_nom" => "Joshua",
            "titular_ape" => "Viruta",
            "direccion_envio" => "Cerrocity",
            "cp_envio" => "66666",
            "poblacion_envio" => "peruano",
            "provincia_envio" => "Comas",
            "pago" => "",

        ]);
        //4
        \App\Models\Cliente::create([
            "nombre" => "Luis",
            "apellido" => "Caycho",
            "dni" => "12345678L",
            "email" => "luiscaycho@gmail.com",
            "movil" => "666521666",

            "contacto" => "Victor",
            "direccion" => "Saint Phillip",
            "cp" => "15035",
            "poblacion" => "peruano",
            "provincia" => "Comas",
            "fax" => "",
            "cargo" => "",
            "titular_nom" => "Luis",
            "titular_ape" => "Caycho",
            "direccion_envio" => "Saint Phillip",
            "cp_envio" => "66116",
            "poblacion_envio" => "peruano",
            "provincia_envio" => "Comas",
            "pago" => "",

        ]);
    }
}
