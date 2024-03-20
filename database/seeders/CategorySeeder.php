<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::create([
            'name' => 'Frutas',
            'slug' => 'frutas',
            'details' => 'Incluye productos naturalmente dulces y ricos en vitaminas, minerales y fibra. Pueden consumirse frescas, secas, enlatadas o congeladas.'
       ]);
        \App\Models\Category::create([
            'name' => 'Verduras',
            'slug' => 'verduras',
            'details' => 'Ofrecen una amplia variedad de nutrientes esenciales como vitaminas, minerales y fibra. Pueden consumirse crudas o cocidas de diversas formas.'
       ]);
        \App\Models\Category::create([
            'name' => 'Carnes y sustitutos',
            'slug' => 'carnes-y-sustitutos',
            'details' => 'Fuentes de proteínas esenciales para el cuerpo. Incluyen carnes frescas, aves, pescado y alternativas vegetales como tofu.'
       ]);
        \App\Models\Category::create([
            'name' => 'Productos lácteos',
            'slug' => 'productos-lacteos',
            'details' => 'Fuente de calcio y proteínas. Incluye leche, quesos, yogur y mantequilla.'
       ]);
        \App\Models\Category::create([
            'name' => 'Granos y cereales',
            'slug' => 'granos-y-cereales',
            'details' => 'Principal fuente de carbohidratos y fibra. Incluye arroz, pan, pasta y cereales.'
       ]);
        \App\Models\Category::create([
            'name' => 'Legumbres y frutos secos',
            'slug' => 'legumbres-y-frutos-secos',
            'details' => 'Ricos en proteínas, fibra y grasas saludables. Incluyen frijoles, lentejas, garbanzos, almendras y nueces.'
       ]);
        \App\Models\Category::create([
            'name' => 'Aceites y grasas',
            'slug' => 'aceites-y-grasas',
            'details' => 'Fuentes de grasas esenciales para el cuerpo. Incluyen aceite de oliva, aceite de girasol, mantequilla y grasas animales.'
       ]);
        \App\Models\Category::create([
            'name' => 'Bebidas',
            'slug' => 'bebidas',
            'details' => 'Mantienen el cuerpo hidratado. Incluyen agua, jugos, refrescos, té y café.'
       ]);
        \App\Models\Category::create([
            'name' => 'Productos procesados',
            'slug' => 'productos-procesados',
            'details' => 'Alimentos que han sido sometidos a algún proceso para su conservación. Incluyen alimentos enlatados, congelados y preenvasados.'
       ]);
        \App\Models\Category::create([
            'name' => 'Productos dulces',
            'slug' => 'productos-dulces',
            'details' => 'Alimentos ricos en azúcares y grasas. Incluyen chocolates, galletas, pasteles y helados.'
       ]);
        \App\Models\Category::create([
            'name' => 'Condimentos y salsas',
            'slug' => 'condimentos-y-salsas',
            'details' => 'Mejoran el sabor de los alimentos. Incluyen sal, pimienta, salsas para cocinar y aderezos para ensaladas.'
       ]);
        \App\Models\Category::create([
            'name' => 'Bebidas alcohólicas',
            'slug' => 'bebidas-alcoholicas',
            'details' => 'Contienen alcohol y se consumen principalmente por placer. Incluyen vino, cerveza y licores.'
        ]);
        \App\Models\Category::create([
         'name' => 'Galletas y Productos de Panadería',
         'slug' => 'galletas-y-productos-de-panaderia',
         'details' => 'Abarca una amplia gama de deliciosos productos horneados, como galletas dulces y saladas, panecillos, bizcochos, tortas, facturas, panes especiales y productos de pastelería. Estos productos son apreciados en todo el mundo y son versátiles en su uso, ya sea como merienda, desayuno o postre.'
        ]);
        \App\Models\Category::create([
             'name' => 'Infusiones y Bebidas Calientes',
             'slug' => 'infusiones-y-bebidas-calientes',
             'details' => 'Engloba una variedad de bebidas calientes preparadas mediante infusiones. Incluye opciones como té, café y yerba mate, cada una con sus características únicas. Estas infusiones son consumidas comúnmente para disfrutar de su sabor, aroma y propiedades estimulantes.'
         ]);
    }
}
