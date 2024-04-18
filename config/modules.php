<?php

return [
// Conexión con API de hgateam para revisar que estos datos no sean modificados.

    /**
     * Estructura de atributos para cada módulo:
     * - Título del módulo
     * - Detalles del módulo
     * - Imagen de referencia
     * - Beneficios
     * - Precio
     * - Descuento
     * - Porcentaje de descuento
     */
    'apps' => [
        'module_1' => [
            'title' => 'e-Commerce',
            'details' => 'Detalles del Módulo 1',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Beneficio 1',
                'Beneficio 2',
                'Beneficio 3',
            ],
            'features' => [
                'Feature 1',
                'Feature 2',
                'Feature 3',
            ],
            'price' => 100,
            'discount' => 20,
            'discount_percentage' => 20,
        ],

        'module_2' => [
            'title' => 'Facturación',
            'details' => 'Detalles del Módulo 2',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                 'Beneficio 1',
                'Beneficio 2',
                'Beneficio 3',
            ],
            'features' => [
                'Feature 1',
                'Feature 2',
                'Feature 3',
            ],
            'price' => 150,
            'discount' => 30,
            'discount_percentage' => 20,
        ],
    ]
];
