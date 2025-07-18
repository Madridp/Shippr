<?php 
class changelogController extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $changelog['2.2.0'] =
    [
      ['fixed', 'En algunos sistemas al ingresar precios superiores a $1,000 presentaban errores y mostraban solo $1.00, se ha solucionado'],
      ['fixed', 'Corregimos un error presente en el link de actualización en los correos de generación de guías'],
      ['done', 'Se han agregado dos tiempos de entrega personalizados seleccionables al agregar un nuevo producto']
    ];
    
    // 29 de junio 2020 - día viernes, antes de día de padre
    $changelog['2.1.9'] =
    [
      ['done', 'Nuevas mejoras realizadas en el sistema de créditos y saldo en cuenta'],
      ['fixed', 'Corregimos un error presente cuando se tenia desactivada la opción de coberturas personalizadas'],
      ['done', 'Nueva sección para visualizar la tabla de tarifas actuales aproximadas de cada servicio'],
      ['done', 'Ahora es posible que los clientes exporten como CSV la tabla de tarifas actuales de cada servicio'],
      ['done', 'Nuevo sistema para actualizar el sistema'],
      ['done', 'Mejoras realizadas al sistema de envío de correos electrónicos'],
      ['done', 'Mejoras en diversas vistas del sistema y del área de clientes']
    ];

    // 19 de junio 2020 - día viernes, antes de día de padre
    $changelog['2.1.8'] =
    [
      ['fixed', 'Se ha corregido  un error con AfterShip que impedia el rastreo y sincronización de los envíos'],
      ['done', 'Mejoramos el área de administración de envíos'],
      ['done', 'Nuevo sistema mejorado de cotización']
    ];

    $changelog['2.1.5'] =
    [
      ['fixed', 'Se han corregido errores en el área de envíos para clientes, y se mejoró la vista de los usuarios'],
      ['done', 'Nuevas mejoras en el área de Administración y Dirección general'],
      ['done', 'Se ha implementado con éxito la nueva base de coberturas para Estafeta y Redpack']
    ];

    $changelog['2.1.0'] =
    [
      ['done', 'Rediseñamos el sistema para asegurar la existencia de remitentes y destinos en todo México utilizando la base de datos de SEPOMEX'],
      ['done', 'Nuevo sistema de autocompletado de direcciones en <b>nuevos envíos</b> y <b>direcciones</b>'],
      ['done', 'Ahora es posible personalizar el tipo de servicio por <b>código postal</b> entre económico y express'],
    ];
    
    $changelog['2.0.1'] =
    [
      ['done', 'Ahora es posible cobrar al usuario de forma manual los cargos por sobrepeso generados con un monto variable según sea el caso'],
      ['done', 'Nuevo sistema de notificaciones para usuarios y administradores'],
      ['done', 'Dashboard para administradores y trabajadores totalmente rediseñado'],
      ['done', 'Sistema para tener el control de todos los recargos por sobrepeso implementado']
    ];

    $changelog['2.0.0'] =
    [
      ['done', 'Nuevo sistema de créditos implementado'],
      ['done', 'Ahora sólo es posible realizar pagos con créditos abonados en la cuenta de cada usuario'],
      ['done', 'Sistema para autocompletado listo para utilizar en el creador de envíos'],
      ['fixed', 'Había una error al momento de editar perfiles de usuario, se ha resuelto'],
      ['fixed', 'Dashboard totalmente rediseñado'],
      ['done', 'Nuevas opciones de configuración en el área de Dirección general y Administración'],
      ['done', 'Ahora es posible cambiar el color del sistema de forma dinámica'],
      ['done', 'Ahora es posible tener trabajadores registrados para administrar Envíos y Ventas'],
      ['done', 'Sistema de registro y usuarios totalmente mejorado y rediseñado'],
      ['done', 'Mejoras en el área de administración, ahora es posible tener separada el área de configuración de la Dirección al área de Administración general'],
      ['done', 'Aftership totalmente personalizable'],
      ['done', 'Nuevos diseños para notificaciones de usuarios y mensajes']
    ];

    $changelog['1.0.4'] =
    [
      ['done','Implementación de nuevos controles para el usuario para facilitar la navegación y el uso en la plataforma'],
      ['done','Implementación de una nueva sección o área disponible para agregar y administrar direcciones de envío persistentes, que son utilizadas consistentemente, para agilizar todos los procesos'],
      ['working','Implementación de área para plantillas de "paquetes de envío", con medidas y pesos preconfigurados para que el usuario en 10 segundos tenga listo un nuevo envío sin más complicaciones'],
      ['done','Ahora el usuario puede seleccionar o filtrar que couriers quiere utilizar en sus envíos, eliminando aquellos que no son de su preferencia'],
      ['working','Nueva herramienta para que el usuario con un clic pueda enviar una notificación a su cliente para solicitar los datos de envíos (su dirección y referencias)'],
      ['working','Nueva sección para solicitar sugerencias y feedback de forma directa a los usuarios, queremos mejorar cada día y con cada versión lanzada de la plataforma, y esto solo se logra escuchando a nuestros usuarios']
    ];
    $changelog['1.0.3'] =
    [
      ['done','Implementación de nuevo sistema de pagos con Código QR Mercado Pago, sin comisiones y más seguro'],
      ['done','El usuario ahora sabrá si alguno de sus envíos tiene sobrepeso, y de ser necesario, se le requerirá un cargo por el mismo'],
      ['done','Mejoras en la interfaz del usuario, haciéndola más amigable para su uso']
    ];
    ## Cambios
    $changelog['1.0.0'] = 
    [
      ['fixed' , 'Errores al subir archivos y guías en el sistema'],
      ['done' , 'Todos los envíos ahora están siendo actualizados en tiempo real, su status se actualizará conforme el envío tome lugar en su trayectoria'],
      ['done' , 'Implementación de changelog'],
      ['working' , 'Implementación de sistema de créditos para cada usuario, para pagar con crédito en su propia cuenta de créditos sin recurrir a transacciones de dinero en efectivo o tarjeta'],
      ['done' , 'Implementamos mejoras en la interfaz de la plataforma para hacer más intuitivo el acceso a todas las herramientas'],
      ['done' , 'Implementación de sistema de "sugerencias", para que los usuarios puedan dejar comentarios y mejorar el sistema a favor de todo el mundo'],
      ['done','Mejora del dashboard de usuario, eliminamos elementos según el feedback recibido por la comunidad'],
      ['working','Implementación de notificaciones de entrega de cada envío'],
      ['working','Pronto estará disponible el sistema de crédito para todos los usuarios'],
      ['working','Implementación de un nuevo socio courier "Paquetexpress" de México'],
      ['working','Sistema para notificar sobrepesos de manera automática a cada usuario']
    ];

    $this->data =
    [
      'title' => 'Changelog',
      'changes' => $changelog
    ];

    View::render('index',$this->data);
  }
}
