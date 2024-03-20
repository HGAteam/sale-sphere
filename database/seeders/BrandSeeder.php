<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Str;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data();

        foreach ($data as $value) {
            \App\Models\Brand::create([
                'name' => $value['name'],
                'slug' => Str::slug($value['name']),
                'status' => 'Published',
                'details' => 'Ayuda a que uno sepa donde colocara la marca y evitara errores humanos.'
            ]);
        }

    }

    public function data()
    {
        $data = [];

        $model = [
                    "La Serenísima",
                    "Sancor",
                    "Ilolay",
                    "Danone",
                    "Yogurísimo",
                    "La Vascongada",
                    "SanCor Bebé",
                    "Mastellone Hermanos",
                    "Verónica",
                    "Santa Clara",
                    "Apóstoles",
                    "Quaker",
                    "Kellogg's",
                    "Nestlé",
                    "Granix",
                    "Cerealto Siro",
                    "Post",
                    "Bagley",
                    "Mielcitas",
                    "Estrella Azul",
                    "Choco Krispis (Kellogg's)",
                    "Gallo",
                    "La Cigala",
                    "Nutrileche",
                    "Porta",
                    "Santa Rosa",
                    "Terrabusi",
                    "Tía Maruca",
                    "Bonafide",
                    "Oreo",
                    "Marolio",
                    "Cocinero",
                    "Cañuelas",
                    "Natura",
                    "La Española",
                    "Lira",
                    "Girasol",
                    "Ideal",
                    "Ybarra",
                    "Cada Día",
                    "Mazola",
                    "Coca-Cola",
                    "Pepsi",
                    "Sprite",
                    "Fanta",
                    "Schweppes",
                    "Manantial",
                    "Levité",
                    "Villa del Sur",
                    "Quilmes",
                    "Ser",
                    "Knorr",
                    "Heinz",
                    "La Campagnola",
                    "Granja del Sol",
                    "Maggi",
                    "Nesquik",
                    "Villar",
                    "Milanesa",
                    "McCain",
                    "Pringles",
                    "Arcor",
                    "Bagley",
                    "Cadbury",
                    "Ferrero Rocher",
                    "Milka",
                    "Havanna",
                    "Bon o Bon",
                    "Cofler",
                    "Mantecol",
                    "Tía Maruca",
                    "Knorr",
                    "Maggi",
                    "Hellmann's",
                    "Heinz",
                    "Dánica",
                    "La Campagnola",
                    "Prima",
                    "Gourmet",
                    "Mendicrim",
                    "Mostaza Creevey",
                    "Quilmes",
                    "Brahma",
                    "Isenbeck",
                    "Andes",
                    "Stella Artois",
                    "Budweiser",
                    "Trapiche",
                    "Norton",
                    "Salentein",
                    "Fernet Branca",
                    "Patagonia",
                    "Imperial",
                    "Gancia",
                    "Cinzano",
                    "Cynar",
                    "Campari",
                    "Laphroaig",
                    "Chandon",
                    "Rutini Wines",
                    "Malbec Argento"
        ];

        foreach ($model as $value) {
                $data[] = ['name' => $value];
        }

        return $data;
    }
}
