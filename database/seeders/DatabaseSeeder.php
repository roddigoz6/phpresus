<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        //1
        \App\Models\Producto::create([
            "nombre" => "martillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "Martillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "Atornillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "BSierra circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "CLata de pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "DReparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);
        //1
        \App\Models\Producto::create([
            "nombre" => "Emartillo3",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "FMartillo 4",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "GDestornillador eléctric2o",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "HSierra circu1lar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ILata de pint2ura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "JRepara4ciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Kmarti1llo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "LMar1tillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorEnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierra cFircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata dew pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "QReparacwiones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Rmartillasdo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "SMartilfglo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "TDestornivcllador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "USierra circxcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "VLata de zxpintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "WReparacighones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Xmasadfrtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "YMartilloasdf 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "ZDestornilladbvnmor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "ASierra cibnvmrcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctribvnmca para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "BLata de pinthbvjura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "CReparasadfciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Dmartidfsgllo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "EMartillodsfg 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "FDestornillaweardor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "GSierra circulyuiar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "HLata de piyfuintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "IReparfghjaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "jmardfgtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "KMarwrewertillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorcxbvnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierrsadfa circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata sdasdffde pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "LRdsfgsdfeparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Omartilaflo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "PMartidfllo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "QDestornilladofgdfr eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "RSierra ccvbircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "SLata de pintucvbra blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "TReparaciogdhnnes",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        \App\Models\Producto::create([
            "nombre" => "UMartidflo 3",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "VMartidflo 8",
            "precio" => 3.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "WMartidflo 34",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "XMartidflo 313",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "ZMa1rtidflo 3",
            "precio" => 113.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);




        //kjyafd<adgf
        //Productos
        //1
        \App\Models\Producto::create([
            "nombre" => "martillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "Martillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "Atornillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "BSierra circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "CLata de pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "DReparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);
        //1
        \App\Models\Producto::create([
            "nombre" => "Emartillo3",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "FMartillo 4",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "GDestornillador eléctric2o",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "HSierra circu1lar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ILata de pint2ura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "JRepara4ciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Kmarti1llo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "LMar1tillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorEnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierra cFircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata dew pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "QReparacwiones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Rmartillasdo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "SMartilfglo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "TDestornivcllador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "USierra circxcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "VLata de zxpintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "WReparacighones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Xmasadfrtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "YMartilloasdf 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "ZDestornilladbvnmor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "ASierra cibnvmrcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctribvnmca para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "BLata de pinthbvjura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "CReparasadfciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Dmartidfsgllo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "EMartillodsfg 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "FDestornillaweardor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "GSierra circulyuiar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "HLata de piyfuintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "IReparfghjaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "jmardfgtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "KMarwrewertillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorcxbvnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierrsadfa circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata sdasdffde pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "LRdsfgsdfeparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Omartilaflo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "PMartidfllo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "QDestornilladofgdfr eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "RSierra ccvbircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "SLata de pintucvbra blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "TReparaciogdhnnes",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        \App\Models\Producto::create([
            "nombre" => "UMartidflo 3",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "VMartidflo 8",
            "precio" => 3.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "WMartidflo 34",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "XMartidflo 313",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "ZMa1rtidflo 3",
            "precio" => 113.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

         //1
         \App\Models\Producto::create([
            "nombre" => "martillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "Martillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "Atornillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "BSierra circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "CLata de pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "DReparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);
        //1
        \App\Models\Producto::create([
            "nombre" => "Emartillo3",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "FMartillo 4",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "GDestornillador eléctric2o",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "HSierra circu1lar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ILata de pint2ura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "JRepara4ciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Kmarti1llo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "LMar1tillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorEnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierra cFircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata dew pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "QReparacwiones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Rmartillasdo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "SMartilfglo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "TDestornivcllador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "USierra circxcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "VLata de zxpintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "WReparacighones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Xmasadfrtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "YMartilloasdf 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "ZDestornilladbvnmor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "ASierra cibnvmrcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctribvnmca para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "BLata de pinthbvjura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "CReparasadfciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Dmartidfsgllo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "EMartillodsfg 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "FDestornillaweardor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "GSierra circulyuiar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "HLata de piyfuintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "IReparfghjaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "jmardfgtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "KMarwrewertillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorcxbvnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierrsadfa circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata sdasdffde pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "LRdsfgsdfeparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Omartilaflo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "PMartidfllo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "QDestornilladofgdfr eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "RSierra ccvbircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "SLata de pintucvbra blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "TReparaciogdhnnes",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        \App\Models\Producto::create([
            "nombre" => "UMartidflo 3",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "VMartidflo 8",
            "precio" => 3.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "WMartidflo 34",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "XMartidflo 313",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "ZMa1rtidflo 3",
            "precio" => 113.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);




        //kjyafd<adgf
        //Productos
        //1
        \App\Models\Producto::create([
            "nombre" => "martillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "Martillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "Atornillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "BSierra circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "CLata de pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "DReparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);
        //1
        \App\Models\Producto::create([
            "nombre" => "Emartillo3",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "FMartillo 4",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "GDestornillador eléctric2o",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "HSierra circu1lar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ILata de pint2ura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "JRepara4ciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Kmarti1llo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "LMar1tillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorEnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierra cFircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata dew pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "QReparacwiones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Rmartillasdo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "SMartilfglo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "TDestornivcllador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "USierra circxcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "VLata de zxpintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "WReparacighones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Xmasadfrtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "YMartilloasdf 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "ZDestornilladbvnmor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "ASierra cibnvmrcular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctribvnmca para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "BLata de pinthbvjura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "CReparasadfciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Dmartidfsgllo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "EMartillodsfg 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "FDestornillaweardor eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "GSierra circulyuiar",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "HLata de piyfuintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "IReparfghjaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "jmardfgtillo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "KMarwrewertillo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "MDestorcxbvnillador eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "NSierrsadfa circular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "ÑLata sdasdffde pintura blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "LRdsfgsdfeparaciones",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        //1
        \App\Models\Producto::create([
            "nombre" => "Omartilaflo1",
            "precio" => 9.99,
            "descripcion" => "Martillo de goma",
            "stock" => 10,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);
        //2
        \App\Models\Producto::create([
            "nombre" => "PMartidfllo 2",
            "precio" => 12.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        //3
        \App\Models\Producto::create([
            "nombre" => "QDestornilladofgdfr eléctrico",
            "precio" => 29.99,
            "descripcion" => "Destornillador inalámbrico",
            "stock" => 20,
            "tipo" => "articulo",
            "categoria_id" => 2,
        ]);

        //4
        \App\Models\Producto::create([
            "nombre" => "RSierra ccvbircular",
            "precio" => 49.99,
            "descripcion" => "Sierra eléctrica para cortes precisos",
            "stock" => 12,
            "tipo" => "articulo",
            "categoria_id" => 3,
        ]);

        //5
        \App\Models\Producto::create([
            "nombre" => "SLata de pintucvbra blanca",
            "precio" => 15.99,
            "descripcion" => "Pintura de látex para interiores",
            "stock" => 25,
            "tipo" => "articulo",
            "categoria_id" => 4,
        ]);

        //6
        \App\Models\Producto::create([
            "nombre" => "TReparaciogdhnnes",
            "precio" => 39.99,
            "descripcion" => "Visita para reparaciones domésticas",
            "stock" => 99,
            "tipo" => "visita",
            "categoria_id" => 5,
        ]);

        \App\Models\Producto::create([
            "nombre" => "UMartidflo 3",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "VMartidflo 8",
            "precio" => 3.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "WMartidflo 34",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "XMartidflo 313",
            "precio" => 13.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);

        \App\Models\Producto::create([
            "nombre" => "ZMa1rtidflo 3",
            "precio" => 113.99,
            "descripcion" => "Martillo de acero",
            "stock" => 15,
            "tipo" => "articulo",
            "categoria_id" => 1,
        ]);



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
