<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Gestión de Clientes y Fidelización',
            'details' => 'Amplía las capacidades del POS permitiendo gestionar la base de datos de clientes, realizar seguimiento de compras, establecer programas de fidelización y enviar promociones personalizadas.',
            'benefits' => '<li>Mejora la relación con los clientes mediante programas de fidelización.</li>
                            <li>Permite ofrecer promociones personalizadas y descuentos.</li>
                            <li>Facilita la recopilación de datos para análisis de comportamiento del cliente.</li>
                            <li>Incrementa la retención de clientes y el valor de vida útil del cliente (CLV).</li>
                            <li>Ofrece un servicio al cliente más personalizado y eficiente.</li>',
            'features' => '<li>Gestión de perfiles de clientes y datos de contacto.</li>
                            <li>Seguimiento detallado de historial de compras y preferencias.</li>
                            <li>Configuración flexible de programas de fidelización y envío de ofertas.</li>
                            <li>Análisis avanzado de datos de clientes para identificar patrones de compra.</li>
                            <li>Integración con sistemas de marketing por correo electrónico y SMS.</li>',
            'price' => '180',
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Gestión de Inventarios Avanzado',
            'details' => 'Amplía las capacidades de gestión de inventarios del POS, permitiendo un control más detallado de existencias, gestión de proveedores, análisis de ventas y optimización de pedidos.',
            'benefits' => '<li>Optimiza la gestión de inventarios y reduce las pérdidas por stock agotado o exceso de inventario.</li>
                <li>Facilita la colaboración con proveedores y la gestión de pedidos.</li>
                <li>Proporciona insights para tomar decisiones basadas en datos sobre la reposición de inventario.</li>
                <li>Mejora la eficiencia operativa y reduce los costos de almacenamiento.</li>
                <li>Permite realizar seguimiento de productos desde la recepción hasta la venta.</li>',
            'features' => '<li>Seguimiento detallado de existencias por SKU, ubicación y proveedor.</li>
                <li>Análisis de ventas y tendencias de demanda para optimizar inventarios.</li>
                <li>Integración con sistemas de gestión de compras y pedidos a proveedores.</li>
                <li>Funcionalidades avanzadas de escaneo de códigos de barras y etiquetado.</li>
                <li>Generación automática de órdenes de compra en función de la demanda y los niveles de inventario.</li>',
            'price' => 250,
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Gestión de Personal y Horarios',
            'details' => 'Permite gestionar el personal del negocio, incluyendo programación de turnos, seguimiento de horas trabajadas, gestión de vacaciones y control de acceso.',
            'benefits' => '<li>Optimiza la planificación y gestión de personal para garantizar una operación eficiente del negocio.</li>
                <li>Facilita la programación de turnos y la gestión de vacaciones.</li>
                <li>Mejora el control de acceso y seguridad del personal.</li>
                <li>Permite la asignación de tareas y seguimiento del desempeño de los empleados.</li>
                <li>Ofrece una experiencia laboral más transparente y colaborativa para el equipo.</li>',
            'features' => '<li>Programación de turnos y gestión de horarios de trabajo.</li>
                <li>Registro detallado de horas trabajadas y gestión de tiempos extras.</li>
                <li>Solicitud y aprobación de vacaciones y licencias directamente desde el sistema.</li>
                <li>Tableros de control personalizables para supervisar la asistencia y la productividad del personal.</li>',
            'price' => 200,
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Reportes de Ventas y Finanzas',
            'details' => 'Este módulo proporciona herramientas avanzadas para generar informes detallados sobre ventas, gastos, ganancias y desempeño de empleados. Con él, podrás analizar el rendimiento financiero de tu negocio y tomar decisiones estratégicas basadas en datos.',
            'benefits' => '<li>Obtén insights clave sobre el rendimiento financiero de tu negocio.</li>
                        <li>Identifica áreas de oportunidad y mejora en tu operación.</li>
                        <li>Realiza un seguimiento detallado de las ventas, gastos y ganancias.</li>
                        <li>Evalúa el desempeño de tus empleados y equipos de trabajo.</li>',
            'features' => '<li>Generación de informes personalizados sobre ventas, gastos y ganancias.</li>
                        <li>Análisis detallado del flujo de efectivo y rentabilidad.</li>
                        <li>Seguimiento de métricas clave como margen de beneficio, ROI y KPIs financieros.</li>
                        <li>Visualización de datos a través de gráficos interactivos y tablas dinámicas.</li>
                        <li>Funcionalidades de filtrado y segmentación para un análisis más específico.</li>',
            'price' => 200, // Precio del módulo
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Gestión de Caja y Pagos',
            'details' => 'Agrega funcionalidades avanzadas para la gestión de caja y procesamiento de pagos, facilitando el seguimiento preciso de transacciones y la administración de efectivo.',
            'benefits' => '<li>Optimiza la gestión de caja y facilita el seguimiento de transacciones en efectivo.</li>
                <li>Facilita el procesamiento de pagos seguros y sin problemas, incluyendo tarjetas de crédito/débito y otras formas de pago.</li>
                <li>Permite la integración con pasarelas de pago populares para una experiencia de compra fluida.</li>
                <li>Mejora la seguridad y reduce los errores en el manejo de efectivo.</li>
                <li>Proporciona informes detallados sobre ingresos, gastos y flujo de efectivo para una mejor toma de decisiones financiera.</li>',
            'features' => '<li>Registro detallado de transacciones de venta y recaudación de efectivo.</li>
                <li>Integración con terminales de punto de venta (TPV) y sistemas de pago en línea.</li>
                <li>Gestión de cierres de caja diarios y reportes de arqueo de caja.</li>
                <li>Funcionalidades avanzadas de conciliación bancaria para una contabilidad precisa.</li>
                <li>Configuración flexible de impuestos, descuentos y propinas en las transacciones.</li>',
            'price' => 220,
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Gestión de Envíos y Logística',
            'details' => 'Amplía las capacidades del sistema de punto de venta para incluir la gestión completa de envíos y logística, desde la generación de etiquetas de envío hasta el seguimiento de paquetes y la gestión de inventario en tránsito.',
            'benefits' => '<li>Facilita el procesamiento eficiente de pedidos y la preparación para el envío.</li>
                <li>Ofrece múltiples opciones de transporte y tarifas para satisfacer las necesidades del cliente.</li>
                <li>Optimiza la gestión de inventario en almacenes y centros de distribución.</li>
                <li>Proporciona seguimiento en tiempo real de los envíos y actualizaciones automáticas para clientes.</li>
                <li>Integración con servicios de envío líderes para una experiencia de envío sin problemas.</li>',
            'features' => '<li>Generación de etiquetas de envío y preparación de paquetes para su envío.</li>
                <li>Integración con servicios de transporte para cotizaciones de envío en tiempo real.</li>
                <li>Seguimiento de envíos en tiempo real y notificaciones automáticas para clientes.</li>
                <li>Gestión de devoluciones y procesamiento de reembolsos para una atención al cliente excepcional.</li>
                <li>Optimización de rutas de envío y gestión de inventario en tránsito.</li>',
            'price' => 280,
        ]);

        \App\Models\Module::create([
            'setting_id' => 1,
            'title' => 'Integración de E-commerce',
            'details' => 'Permite integrar el sistema de punto de venta con una plataforma de comercio electrónico, sincronizando inventarios, pedidos y clientes para una gestión unificada de ventas en línea y fuera de línea.',
            'benefits' => '<li>Amplía el alcance de ventas a través de una tienda en línea integrada con el sistema de punto de venta.</li>
                <li>Ofrece una experiencia de compra sin fisuras para los clientes con sincronización en tiempo real de inventarios y pedidos.</li>
                <li>Facilita la gestión centralizada de productos, clientes y pedidos desde una sola plataforma.</li>
                <li>Optimiza los procesos de cumplimiento de pedidos y mejora la eficiencia operativa.</li>
                <li>Proporciona análisis unificados de ventas en línea y fuera de línea para una toma de decisiones estratégicas.</li>',
            'features' => '<li>Sincronización automática de inventarios entre el sistema de punto de venta y la tienda en línea.</li>
                <li>Gestión centralizada de productos, precios y promociones en ambos canales de venta.</li>
                <li>Procesamiento automático de pedidos en tiempo real y actualización de estado de pedidos para clientes.</li>
                <li>Integración con plataformas de comercio electrónico líderes como Shopify, WooCommerce, Magento, etc.</li>
                <li>Seguimiento unificado de clientes y análisis de ventas para una comprensión completa del rendimiento del negocio.</li>',
            'price' => 300,
        ]);
    }
}
