<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea las categorías principales
        $categories = [
            ['name' => 'Panadería y Repostería', 'children' => [
                'Pan Fresco',
                'Pasteles y Tortas',
                'Galletas y Snacks Dulces',
                'Pan Integral',
                'Productos sin Gluten',
                'Pastelería fresca',
            ]],
            ['name' => 'Frutas y Verduras', 'children' => [
                'Frutas Frescas',
                'Verduras Frescas',
                'Ensaladas y Vegetales Cortados',
                'Frutos Secos',
            ]],
            ['name' => 'Carnes y pescados', 'children' => [
                'Carne de res',
                'Pollo y aves de corral',
                'Carne de cerdo',
                'Pescado fresco',
                'Mariscos',
                'Embutidos y salchichas',
            ]],
            ['name' => 'Congelados', 'children' => [
                'Comidas preparadas congeladas',
                'Vegetales congelados',
                'Frutas congeladas',
                'Pizzas congeladas',
                'Helados y postres helados',
            ]],
            ['name' => 'Alimentos enlatados y envasados', 'children' => [
                'Conservas de vegetales',
                'Sopas y caldos enlatados',
                'Conservas de frutas',
                'Salsas y condimentos',
                'Productos envasados para cocinar',
            ]],
            ['name' => 'Lácteos y huevos', 'children' => [
                'Leche y derivados',
                'Quesos',
                'Yogures',
                'Huevos',
                'Mantequilla y margarina',
            ]],
            ['name' => 'Bebidas', 'children' => [
                'Aguas',
                'Refrescos y sodas',
                'Jugos y néctares',
                'Bebidas energéticas',
                'Cervezas',
                'Vinos',
                'Licores',
            ]],
            ['name' => 'Productos secos y enlatados', 'children' => [
               'Arroz y legumbres',
               'Pastas y salsas',
               'Conservas',
               'Aceites y vinagres',
               'Cereales',
            ]],
            ['name' => 'Cereales, Pastas y Legumbres', 'children' => [
               'Arroz',
               'Pastas',
               'Legumbres secas',
               'Cereales para el desayuno',
               'Harinas',
               'Pan rallado y rebozadores',
            ]],
            ['name' => 'Aperitivos y Snacks', 'children' => [
               'Papas fritas y snacks salados',
               'Frutos secos',
               'Palomitas de maíz',
               'Pretzels',
               'Snacks saludables',
            ]],
            ['name' => 'Productos de limpieza', 'children' => [
               'Detergentes',
               'Limpiadores multiusos',
               'Productos para el cuidado del suelo',
               'Desinfectantes',
               'Utensilios de limpieza',
               'Papel higiénico y productos de papel',
            ]],
            ['name' => 'Productos de higiene personal', 'children' => [
               'Champús y acondicionadores',
               'Jabones y geles de baño',
               'Cremas hidratantes',
               'Productos de cuidado facial',
               'Maquillaje',
               'Artículos de cuidado dental',
               'Perfumes y fragancias',
            ]],
            ['name' => 'Artículos de papelería', 'children' => [
               'Papel higiénico',
               'Pañuelos de papel',
               'Productos de limpieza para el hogar',
               'Bolsas de basura',
               'Papel de cocina',
            ]],
            ['name' => 'Cuidado del Hogar y Mascotas', 'children' => [
               'Alimentos para mascotas',
               'Productos de cuidado para mascotas',
               'Arena para gatos y productos de higiene',
               'Productos para el cuidado del jardín',
               'Utensilios para mascotas',
            ]],
            // Puedes agregar más categorías principales con sus respectivas subcategorías aquí
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => \Illuminate\Support\Str::slug($categoryData['name']), // Genera un slug a partir del nombre
                'details' => 'Las Categories Padre no deben contener directamente productos',
            ]);
            // Crea las subcategorías para esta categoría principal
            if (isset($categoryData['children']) && is_array($categoryData['children'])) {
                foreach ($categoryData['children'] as $childName) {
                    $category->children()->create([
                        'name' => $childName,
                        'slug' => \Illuminate\Support\Str::slug($childName), // Genera un slug a partir del nombre
                        'details' => 'Las Categories Hijos deben contener directamente productos y el detalle debe indicar que productos corresponde',
                    ]);
                }
            }
        }
    }
}
