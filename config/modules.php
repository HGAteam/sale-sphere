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
            'title' => 'Gestión de Ventas',
            'details' => 'Un módulo diseñado para ayudar a las empresas a gestionar sus procesos de ventas de manera efectiva, desde la generación de leads hasta el cierre de ventas.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Optimiza el proceso de ventas y seguimiento de clientes.',
                'Mejora la gestión de leads y oportunidades de ventas.',
                'Proporciona insights y análisis para mejorar el rendimiento de ventas.',
            ],
            'features' => [
                'Seguimiento de leads y clientes potenciales.',
                'Gestión de oportunidades de ventas y pipelines.',
                'Generación de informes y análisis de rendimiento de ventas.',
            ],
            'price' => 200,
            'discount' => 50,
            'discount_percentage' => 25,
        ],

        'module_2' => [
            'title' => 'Gestión de Clientes y Fidelización',
            'details' => 'Este módulo amplía las capacidades del POS permitiendo gestionar la base de datos de clientes, realizar seguimiento de compras, establecer programas de fidelización y enviar promociones personalizadas.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Mejora la relación con los clientes mediante programas de fidelización.',
                'Permite ofrecer promociones personalizadas y descuentos.',
                'Facilita la recopilación de datos para análisis de comportamiento del cliente.',
                'Incrementa la retención de clientes y el valor de vida útil del cliente (CLV).',
                'Ofrece un servicio al cliente más personalizado y eficiente.',
            ],
            'features' => [
                'Gestión de perfiles de clientes y datos de contacto.',
                'Seguimiento detallado de historial de compras y preferencias.',
                'Configuración flexible de programas de fidelización y envío de ofertas.',
                'Análisis avanzado de datos de clientes para identificar patrones de compra.',
                'Integración con sistemas de marketing por correo electrónico y SMS.',
            ],
            'price' => 180,
            'discount' => 30,
            'discount_percentage' => 16.67,
        ],

        // Módulo 3 y otros módulos se han omitido por brevedad

        'module_3' => [
            'title' => 'Gestión de Inventarios Avanzado',
            'details' => 'Este módulo amplía las capacidades de gestión de inventarios del POS, permitiendo un control más detallado de existencias, gestión de proveedores, análisis de ventas y optimización de pedidos.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Optimiza la gestión de inventarios y reduce las pérdidas por stock agotado o exceso de inventario.',
                'Facilita la colaboración con proveedores y la gestión de pedidos.',
                'Proporciona insights para tomar decisiones basadas en datos sobre la reposición de inventario.',
                'Mejora la eficiencia operativa y reduce los costos de almacenamiento.',
                'Permite realizar seguimiento de productos desde la recepción hasta la venta.',
            ],
            'features' => [
                'Seguimiento detallado de existencias por SKU, ubicación y proveedor.',
                'Análisis de ventas y tendencias de demanda para optimizar inventarios.',
                'Integración con sistemas de gestión de compras y pedidos a proveedores.',
                'Funcionalidades avanzadas de escaneo de códigos de barras y etiquetado.',
                'Generación automática de órdenes de compra en función de la demanda y los niveles de inventario.',
            ],
            'price' => 250,
            'discount' => 50,
            'discount_percentage' => 20,
        ],

        'module_4' => [
            'title' => 'Gestión de Personal y Horarios',
            'details' => 'Este módulo permite gestionar el personal del negocio, incluyendo programación de turnos, seguimiento de horas trabajadas, gestión de vacaciones y control de acceso.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Optimiza la planificación y gestión de personal para garantizar una operación eficiente del negocio.',
                'Facilita la programación de turnos y la gestión de vacaciones.',
                'Mejora el control de acceso y seguridad del personal.',
                'Permite la asignación de tareas y seguimiento del desempeño de los empleados.',
                'Ofrece una experiencia laboral más transparente y colaborativa para el equipo.',
            ],
            'features' => [
                'Programación de turnos y gestión de horarios de trabajo.',
                'Registro detallado de horas trabajadas y gestión de tiempos extras.',
                'Solicitud y aprobación de vacaciones y licencias directamente desde el sistema.',
                'Tableros de control personalizables para supervisar la asistencia y la productividad del personal.',
            ],
            'price' => 200,
            'discount' => 40,
            'discount_percentage' => 20,
        ],

        'module_5' => [
            'title' => 'Análisis y Reportes de Ventas',
            'details' => 'Este módulo proporciona herramientas avanzadas de análisis y generación de informes para evaluar el rendimiento de ventas, identificar tendencias y tomar decisiones estratégicas basadas en datos.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Proporciona insights clave sobre el rendimiento de ventas y el comportamiento del cliente.',
                'Facilita la identificación de oportunidades de crecimiento y áreas de mejora.',
                'Permite tomar decisiones informadas basadas en datos sólidos.',
                'Ofrece informes detallados y visualizaciones personalizadas para una comprensión más profunda.',
                'Integración con herramientas de análisis de negocios externas para una perspectiva más amplia.',
            ],
            'features' => [
                'Generación de informes personalizados sobre ventas, márgenes de beneficio, productos más vendidos, etc.',
                'Análisis de tendencias de ventas y comportamiento del cliente en diferentes períodos de tiempo.',
                'Visualización de datos a través de gráficos interactivos, tablas dinámicas y paneles de control.',
                'Funcionalidades avanzadas de segmentación de clientes y análisis de cohortes.',
                'Exportación de informes en varios formatos y programación de informes automáticos.'
            ],
            'price' => 150,
            'discount' => 30,
            'discount_percentage' => 20,
        ],

        'module_6' => [
            'title' => 'Gestión de Caja y Pagos',
            'details' => 'Este módulo agrega funcionalidades avanzadas para la gestión de caja y procesamiento de pagos, facilitando el seguimiento preciso de transacciones y la administración de efectivo.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Optimiza la gestión de caja y facilita el seguimiento de transacciones en efectivo.',
                'Facilita el procesamiento de pagos seguros y sin problemas, incluyendo tarjetas de crédito/débito y otras formas de pago.',
                'Permite la integración con pasarelas de pago populares para una experiencia de compra fluida.',
                'Mejora la seguridad y reduce los errores en el manejo de efectivo.',
                'Proporciona informes detallados sobre ingresos, gastos y flujo de efectivo para una mejor toma de decisiones financiera.',
            ],
            'features' => [
                'Registro detallado de transacciones de venta y recaudación de efectivo.',
                'Integración con terminales de punto de venta (TPV) y sistemas de pago en línea.',
                'Gestión de cierres de caja diarios y reportes de arqueo de caja.',
                'Funcionalidades avanzadas de conciliación bancaria para una contabilidad precisa.',
                'Configuración flexible de impuestos, descuentos y propinas en las transacciones.',
            ],
            'price' => 220,
            'discount' => 55,
            'discount_percentage' => 25,
        ],

        'module_7' => [
            'title' => 'Gestión de Envíos y Logística',
            'details' => 'Este módulo amplía las capacidades del sistema de punto de venta para incluir la gestión completa de envíos y logística, desde la generación de etiquetas de envío hasta el seguimiento de paquetes y la gestión de inventario en tránsito.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Facilita el procesamiento eficiente de pedidos y la preparación para el envío.',
                'Ofrece múltiples opciones de transporte y tarifas para satisfacer las necesidades del cliente.',
                'Optimiza la gestión de inventario en almacenes y centros de distribución.',
                'Proporciona seguimiento en tiempo real de los envíos y actualizaciones automáticas para clientes.',
                'Integración con servicios de envío líderes para una experiencia de envío sin problemas.',
            ],
            'features' => [
                'Generación de etiquetas de envío y preparación de paquetes para su envío.',
                'Integración con servicios de transporte para cotizaciones de envío en tiempo real.',
                'Seguimiento de envíos en tiempo real y notificaciones automáticas para clientes.',
                'Gestión de devoluciones y procesamiento de reembolsos para una atención al cliente excepcional.',
                'Optimización de rutas de envío y gestión de inventario en tránsito.',
            ],
            'price' => 280,
            'discount' => 60,
            'discount_percentage' => 21.43,
        ],

        'module_8' => [
            'title' => 'Integración de E-commerce',
            'details' => 'Este módulo permite integrar el sistema de punto de venta con una plataforma de comercio electrónico, sincronizando inventarios, pedidos y clientes para una gestión unificada de ventas en línea y fuera de línea.',
            'image' => 'images/apps/default.jpg',
            'benefits' => [
                'Amplía el alcance de ventas a través de una tienda en línea integrada con el sistema de punto de venta.',
                'Ofrece una experiencia de compra sin fisuras para los clientes con sincronización en tiempo real de inventarios y pedidos.',
                'Facilita la gestión centralizada de productos, clientes y pedidos desde una sola plataforma.',
                'Optimiza los procesos de cumplimiento de pedidos y mejora la eficiencia operativa.',
                'Proporciona análisis unificados de ventas en línea y fuera de línea para una toma de decisiones estratégicas.',
            ],
            'features' => [
                'Sincronización automática de inventarios entre el sistema de punto de venta y la tienda en línea.',
                'Gestión centralizada de productos, precios y promociones en ambos canales de venta.',
                'Procesamiento automático de pedidos en tiempo real y actualización de estado de pedidos para clientes.',
                'Integración con plataformas de comercio electrónico líderes como Shopify, WooCommerce, Magento, etc.',
                'Seguimiento unificado de clientes y análisis de ventas para una comprensión completa del rendimiento del negocio.',
            ],
            'price' => 300,
            'discount' => 70,
            'discount_percentage' => 23.33,
        ],
    ]
];
