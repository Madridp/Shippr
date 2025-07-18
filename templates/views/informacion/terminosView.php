<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['informacion','Información'],['','Artículos prohibidos']]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header"><?php echo $d->title; ?></h5>

          <h1><?php echo $d->title; ?></h1>
          <p class="text-muted"><?php echo 'Última actualización '.fecha('2018-11-22'); ?></p>
          <p>Para utilizar la página de Joystick S.A. de C.V. (en adelante <?php echo get_system_name() ?>), sus aplicaciones o cualquiera de sus servicios y por lo tanto comprometerse al cumplimiento de los presentes términos y condiciones usted (EL CLIENTE) debe ser mayor de 18 años y contar con capacidad legal suficiente para ser titular de derechos y obligaciones. Usted manifiesta bajo protesta de decir verdad que los datos con los que se registra son veraces y que lo hace por propio interés y derecho, y no representa a tercero alguno; en el caso de que sea su intención abrir una cuenta de negocio en nombre de una persona moral, acepta y garantiza que tienen facultades suficientes para hacerlo, de lo contrario toda la responsabilidad correrá por su cuenta como persona física.</p>
          
          <p>Es importante que antes de iniciar con el registro y por lo tanto de usar los servicios de <?php echo get_system_name() ?> lea detenidamente los términos y condiciones ya que contienen la manera de operar y los pormenores de la relación entre usted y <?php echo get_system_name() ?>. Igualmente es recomendable que antes de utilizar los servicios verifique que no hayan cambiado o sido actualizados de forma alguna los términos y condiciones de referencia, lo que aparecerá en la parte superior derecha del presente estableciendo la fecha de la última actualización.</p>

          <p>Al utilizar los servicios o las aplicaciones proporcionadas por <?php echo get_system_name() ?>, usted está aceptando las condiciones y cláusulas contempladas en el presente contrato. Cada vez que utilice los servicios de <?php echo get_system_name() ?> se entenderá que ratifica su voluntad de aplicar estos Términos y Condiciones para regular su relación con <?php echo get_system_name() ?> y los acuerdos que se encuentran en el presente y en el Aviso de Privacidad correspondiente. En caso de estar en desacuerdo o inconforme con alguno de los puntos que más adelante se describen, no utilice el servicio.</p>

          <p>Los términos y condiciones que a continuación se establecen pueden ser modificados en el momento que <?php echo get_system_name() ?> lo considere, de forma unilateral por medio de la publicación de una versión renovada en nuestro sitio web, momento en el que entrará en vigor dicha modificación para todos los usuarios y clientes presentes y futuros de la página y aplicaciones creadas por <?php echo get_system_name() ?>. Es recomendable que constantemente esté verificando las actualizaciones de los términos y condiciones de referencia, lo que aparecerá en la parte superior derecha del presente documento estableciendo la fecha de la última actualización.</p>

          <p>Igualmente le recordamos que las aplicaciones de <?php echo get_system_name() ?> van dirigidas a apoyarlo en su negocio por medio de los servicios que presta, pero usted es el único responsable de cualquier relación que adquiera y de su negocio en sí mismo, razón por la cual desde este momento libera a <?php echo get_system_name() ?> de cualquier tipo de responsabilidad presente o futura que pudiera surgir por la prestación del servicio, suspensión o inexactitud del mismo. Usted es el único responsable de comprender y dar cumplimiento a la legislación aplicable y desde este momento se compromete a que el uso que dé a las aplicaciones y servicios de <?php echo get_system_name() ?> tendrá que ver en todo momento con negocios y operaciones lícitas bajo su más estricta supervisión y responsabilidad.</p>

          <p><?php echo get_system_name() ?> se reserva el derecho de suspender la cuenta o el servicio completo en cualquier momento y sin previo aviso, en cuyo caso no seremos responsables de pérdidas.</p>

          <p>El CLIENTE manifiesta desde este momento que todos los datos proporcionados son veraces y correctos, en el entendido de que en caso contrario se suspenderá de inmediato el servicio. Dichos datos se reciben en congruencia con lo establecido en el aviso de privacidad.</p>

          <p>El CLIENTE autoriza a <?php echo get_system_name() ?> para realizar cualquier investigación tendiente a identificar y corroborar sus datos.</p>

          <p>EL CLIENTE reconoce y está de acuerdo en que <?php echo get_system_name() ?> por sí mismo no presta servicio de mensajería ni paquetería, sino que estos servicios los prestan terceros y <?php echo get_system_name() ?> se dedica exclusivamente a prestar el servicio de intermediación, gestión y emisión de guías expedidas por empresas especializadas en dicho rubro con los que <?php echo get_system_name() ?> tiene convenio. Cualquier inconformidad, daño o inexactitud en el servicio de mensajería o paquetería deberá ser arreglado y ventilado directamente con las empresas designadas para dicho servicio.</p>

          <p>Las partes están de acuerdo en aplicar las siguientes definiciones para efectos de interpretación del presente contrato:</p>

          <p>CLIENTE: Se entiende por CLIENTE al remitente del paquete o a cualquier usuario que utilice la página web de <?php echo get_system_name() ?> y que por este simple hecho se adhiere a las cláusulas que más adelante se detallan de los términos y condiciones.</p>

          <p>EMPRESAS DE PAQUETERÍA: Empresas aliadas de <?php echo get_system_name() ?> quienes prestan el servicio de mensajería y paquetería.</p>

          <p>GUÍAS: Documentos emitidos por las empresas de mensajería y paquetería que amparan el envío de mercancías o de paquetes y que son gestionados y obtenidos por <?php echo get_system_name() ?>.</p>

          <p><?php echo get_system_name() ?>: Es la marca propiedad de Joystick S.A. DE C.V. que ampara el servicio a que se refriere la cláusula primera.</p>

          <p>PREPAGO: Modalidad de contraprestación por el servicio en la que EL CLIENTE paga una determinada cantidad para cubrir uno o varios eventos indeterminados a futuro.</p>

          <p>SERVICIOS: Aquellos descritos en la cláusula primera.</p>

          <p>ASEGURADORA: Aquella compañía autorizada para tales efectos con la que se contrata un seguro que ampare y proteja las mercancías o el o los paquetes en el caso de algún siniestro, servicio que se presta por separado y solo cuando así lo solicite EL CLIENTE.</p>

          <p>Joystick: Joystick S.A. DE C.V. el proveedor del servicio y el administrador de la plataforma <?php echo get_system_name() ?>.</p>

          <p>1.- NUESTROS SERVICIOS</p>

          <p>El sitio Web <?php echo get_system_name() ?> y el servicio que presta:</p>

          <p><?php echo get_system_name() ?> es responsable de proveer información disponible de los diferentes medios de transporte para su paquetería de tal modo que usted pueda seleccionar el transporte de su preferencia con las que el sitio <?php echo get_system_name() ?> colabora. La precisión de dicha información no es responsabilidad de <?php echo get_system_name() ?> ya que es obtenida de los sitios web que las compañías de mensajería tienen para tales efectos.</p>

          <p>La entrega y condiciones de la misma son responsabilidad directa de la compañía que Usted elija de las opciones que <?php echo get_system_name() ?> proporciona</p>

          <p><?php echo get_system_name() ?> puede llegar a proporcionar además servicios de contratación de seguros lo que por ningún motivo implica que adquiere el riesgo de la mercancía o paquete que se pretenda enviar o la obligación de gestionar el cobro de dicho seguro en caso de siniestro, esto lo deberá realizar directamente EL CLIENTE ante la aseguradora que haya elegido de las opciones que <?php echo get_system_name() ?> proporciona.</p>

          <p><?php echo get_system_name() ?> puede prestar el servicio de última milla dentro del área designada para tal efecto en su sitio Web, servicio que consiste en recoger el paquete en el lugar proporcionado por el CLIENTE y entregarlo a la compañía de mensajería elegida por EL CLIENTE.</p>

          <p>El servicio prestado por <?php echo get_system_name() ?> consiste en proporcionar la información necesaria para que el usuario o CLIENTE pueda comparar precios, tiempos y servicios de las distintas compañías de mensajería además de fungir como un gestor para la adquisición de guías, seguros y de así solicitarlo el cliente recoger el paquete que se pretenda enviar.</p>

          <p>2.- CONDICIONES PARA EL USO DEL SERVICIO Y LIMITACIONES DEL MISMO</p>

          <p>2.1 EL CLIENTE se compromete y deberá proporcionar con toda veracidad los datos del paquete que desea enviar, de forma enunciativa y no limitativa, tamaño, peso y contenido del paquete; datos del destinatario, nombre completo, dirección completa, código postal y número telefónico.</p>

          <p>2.2 EL CLIENTE pagará a <?php echo get_system_name() ?> las cantidades correspondientes por el envío de su paquete, de forma enunciativa y no limitativa:</p>

          <p>2.2.1 Impuestos causados por el servicio</p>

          <p>2.2.2 Aranceles</p>

          <p>2.2.3 Gastos extraordinarios de almacenaje (si aplica)</p>

          <p>2.2.4 Cargos por expedición de guía</p>

          <p>2.2.5 Prima de Seguros (si se contrata)</p>

          <p>2.2.6 cualquier otra cantidad que se devengue en razón del envío, así como los generados por la devolución del envío a su lugar de origen por causas imputables al CLIENTE.</p>

          <p>2.3. EL CLIENTE declara bajo protesta de decir verdad que cuenta con la legal posesión del o los artículos que se envían, por medio del <?php echo get_system_name() ?>, así como con la capacidad legal para celebrar y aceptar el contenido de este contrato.</p>

          <p>2.4. EL CLIENTE exime de toda responsabilidad a <?php echo get_system_name() ?> y a Joystick S.A. DE C.V. en el caso de que se ocasionen daños y perjuicios ya sea directamente a EL CLIENTE o a terceros por el desarrollo del servicio de mensajería o paquetería. Entendiendo EL CLIENTE que <?php echo get_system_name() ?> no presta dicho servicio.</p>

          <p>3.- CONFIDENCIALIDAD DE LOS DATOS</p>

          <p>3.1 <?php echo get_system_name() ?> y el CLIENTE guardarán confidencialidad sobre la información que se facilite en o para la ejecución de los Servicios o que por su propia naturaleza deba ser tratada como tal. Y se comprometen a no utilizarla en su propio beneficio o en beneficio de terceros. Se excluye de la categoría de información confidencial toda aquella información que sea divulgada por <?php echo get_system_name() ?> o por el CLIENTE y aquella que haya de ser revelada de acuerdo con las leyes o con una resolución judicial o acto de autoridad competente.</p>

          <p>3.2 En el caso de que la prestación de los Servicios suponga la necesidad de acceder a datos de carácter personal, las partes se someterán a las Políticas de Privacidad establecidas en el Aviso que se encuentra a disposición en la página de internet de <?php echo get_system_name() ?>, mismas que por el simple hecho de utilizar el portal electrónico de <?php echo get_system_name() ?>, EL CLIENTE acepta.</p>

          <p>3.3 <?php echo get_system_name() ?> responderá, por tanto, de las infracciones en que pudiera incurrir en el caso de que destine los datos personales a otra finalidad, los comunique a un tercero, o en general, los utilice de forma irregular, así como cuando no adopte las medidas correspondientes para el almacenamiento y custodia de los mismos.</p>

          <p>3.4 <?php echo get_system_name() ?> únicamente tratará los datos de carácter personal a los que tenga acceso conforme a las instrucciones del CLIENTE y no los aplicará o utilizará con un fin distinto al objeto de este contrato, ni los comunicará, ni siquiera para su conservación, a otras personas.</p>

          <p>3.5 <?php echo get_system_name() ?> adoptará las medidas de índole técnica y organizativas necesarias que garanticen la seguridad de los datos de carácter personal y eviten su alteración, pérdida, tratamiento o acceso no autorizado, habida cuenta del estado de la tecnología, la naturaleza de los datos almacenados y los riesgos a que están expuestos, ya provengan de la acción humana o del medio físico o natural.</p>

          <p>3.6 El CLIENTE podrá en cualquier momento ejercitar los derechos de acceso, oposición, rectificación y cancelación de sus datos personales, siempre y cuando esto se solicite por escrito al correo correspondiente.</p>

          <p>4.- PAQUETERÍA NO PERMITIDA</p>

          <p><?php echo get_system_name() ?> no acepta ni recibe envíos que contengan: dinero, instrumentos o títulos valor negociables, joyas, antigüedades, metales preciosos, piezas de arte, carbones o diamantes industriales, licores y vinos, armas, explosivos, vegetales y animales, materiales obscenos u ofensivos, efectos restringidos por las leyes locales o federales, internacionales y por disposiciones de la autoridad competente y/o por la IATA (Internactional Air Transport Asosociation) incluyendo materiales peligrosos en su manejo, tales como corrosivos o inflamables, de fácil descomposición y aquellos que despidan malos olores, así como tampoco artículos de procedencia extranjera que no se encuentren legalmente amparados con la documentación que acredite su legal adquisición y/o internación al país, debiendo adjuntar al envío el original o copia certificada notarial, de igual manera enviar cualquier material que suponga o sea una amenaza, sea difamatorio, obsceno, indecente, ofensivo, pornográfico, abusivo, xenófobo, discriminatorio, escandaloso o blasfemos; que constituya o fomente una conducta que sería considerada como una conducta criminal, que diera lugar a responsabilidad civil, que sea ilegal o infrinja los derechos de terceros, en cualquier país del mundo; que sea técnicamente dañino (incluyendo sin limitación; virus informáticos, bombas lógicas, troyanos gusanos, datos corruptos o software malicioso.</p>

          <p>5.- PAGO DEL SERVICIO Y MODOS DE PAGO</p>

          <p>EL CLIENTE se compromete a pagar las cantidades y comisiones establecidas en la lista de precios de nuestra plataforma.</p>

          <p>El CLIENTE está de acuerdo en que <?php echo get_system_name() ?> se reserva el derecho de modificar dicha lista en cualquier momento.</p>

          <p>El usuario pagará a través de su cuenta <?php echo get_system_name() ?> por los medios autorizados habilitados y reconocidos por que de manera enunciativa pueden ser:</p>

          <p>5.1 Tarjeta de crédito</p>

          <p>5.2 Tarjeta de débito</p>

          <p>5.3 Otros medios que EL CLIENTE encontrará en la aplicación correspondiente.</p>

          <p>5.4 Abriendo una cuenta de prepago. Para lo cual el cliente deberá tomar en consideración lo siguiente:</p>

          <p>5.4.1 EL CLIENTE puede abonar a su cuenta <?php echo get_system_name() ?> una determinada cantidad de dinero que sea aprovechable para uno o varios eventos por medio de las opciones establecidas en los numerales 5.1, 5.2 y 5.3.</p>

          <p>5.4.2 Dentro de la cuenta de <?php echo get_system_name() ?> se encuentra la opción para hacer cargos automáticos, en este caso EL CLIENTE autoriza expresamente a <?php echo get_system_name() ?> para que haga mensualmente los cargos automáticos que EL CLIENTE programe. Aclarando que en caso de que se consuma dicho cargo EL CLIENTE tendrá la opción de abonar más efectivo a su cuenta.</p>

          <p>6.- DESCRIPCIÓN DEL PAQUETE</p>

          <p>EL CLIENTE acepta que el sitio <?php echo get_system_name() ?> y su administrador Joystick S.A de C.V. queda liberado de cualquier responsabilidad, en caso de que el contenido del paquete no concuerde con lo declarado o en todo caso se encuentre dentro del listado de artículos señalados en la cláusula cuarta, sin limitación de los prohibidos por la ley local y federal aplicables en el territorio nacional y/o internacional.</p>

          <p>7.- INEXACTITUD DE LA ENTREGA, DESTRUCCIÓN O PÉRDIDA DEL PAQUETE</p>

          <p>En caso de pérdida y/o destrucción del envío de EL CLIENTE, éste último deberá hacer la reclamación del seguro (en caso de que se haya contratado) o ante la compañía transportista que haya elegido, <?php echo get_system_name() ?> de ninguna manera se hace responsable del paquete ni de la pérdida o destrucción del mismo. Tampoco se hará responsable <?php echo get_system_name() ?> de las gestiones necesarias para la aplicación del seguro o del reclamo a la compañía transportista o de paquetería designada por EL CLIENTE.</p>

          <p><?php echo get_system_name() ?> tampoco se responsabiliza de los daños o perjuicios ocasionados por la pérdida, mala entrega, no entrega o demora en el envío.</p>

          <p>8.- TERMINOS Y CONDICIONES DE TERCEROS</p>

          <p>Para la entrega de los envíos, se aplicarán los términos y condiciones de cada una de las agencias de Transporte y/o Paquetería con las que colabora <?php echo get_system_name() ?>. Se pueden consultar estas condiciones en sus respectivas páginas web. En caso de existir discrepancia entre lo publicado por <?php echo get_system_name() ?> y el transportista, se estará a las condiciones de servicio del transportista, pues en ellas se basan todo lo relativo al servicio de mensajería. Lo mismo aplicara en el caso de que EL CLIENTE contrate el seguro que ampare las mercancías en el sentido de que aplicará las cláusulas del contrato del seguro así como los requerimientos que para tal efecto establezca la aseguradora.</p>

          <p>9. GENERALIDADES Y POLÍTICAS DE USO</p>

          <p>9.1 <?php echo get_system_name() ?> gestionará y obtendrá, a su cargo, todas las licencias, permisos y autorizaciones administrativas que pudieren ser necesarias para la realización de los Servicios.</p>

          <p>9.2 <?php echo get_system_name() ?> dispone de un servicio de atención al CLIENTE a través del siguiente correo electrónico: contacto@<?php echo get_system_name() ?>.mx</p>

          <p>9.3 <?php echo get_system_name() ?> se compromete a que el CLIENTE podrá acceder y verificar en todo momento su estado de cuenta, salvo cuando el portal se encuentre en mantenimiento.</p>

          <p>9.4 <?php echo get_system_name() ?> ejecutará el contrato realizando de manera competente y profesional los Servicios, cumpliendo los niveles de calidad exigidos.</p>

          <p>9.5 <?php echo get_system_name() ?> se reserva el derecho de contactar al titular de la tarjeta con la que se esté realizando cualquier tipo de transacción para asegurarse que sea el legítimo propietario y evitar cualquier tipo de fraude o ilícito.</p>

          <p>9.6 El CLIENTE es el único responsable de determinar si los servicios que constituyen el objeto de estos Términos y Condiciones se ajustan a sus necesidades.</p>

          <p>9.7 El CLIENTE autoriza a <?php echo get_system_name() ?> a realizar las medidas de control que considere oportunas para comprobar la legalidad de las transacciones efectuadas a través de sus servicios.</p>

          <p>9.8 <?php echo get_system_name() ?> no ofrece ningún tipo de garantía en cuanto a la ejecución o la disponibilidad ininterrumpida de los servicios o los materiales de <?php echo get_system_name() ?>. Los Servicios y materiales de <?php echo get_system_name() ?> se proporcionan como se refleja en el presente contrato y según disponibilidad sin garantía de ningún tipo, ya sean expresas o implícitas. <?php echo get_system_name() ?> niega cualquier tipo de garantía expresa o implícita incluyendo los servicios y la información, el contenido y los materiales contenidos en el mismo. En este acto se manifiesta que los servicios pueden no ser exactos, completos, confiables, actuales o libres de errores. <?php echo get_system_name() ?> se compromete a realizar todo lo que se encuentre en sus manos para hacer lo más seguro y confiable el acceso y uso de los servicios.</p>

          <p>9.9 <?php echo get_system_name() ?> se reserva el derecho de modificar todos y cada uno de los contenidos en los Servicios en cualquier momento sin previo aviso.</p>

          <p>9.10 La referencia a cualquier producto, servicio, proceso u otra información, por nombre comercial, marca registrada, fabricante, proveedor u otro no constituye o implica respaldo, patrocinio o recomendación de los mismos o cualquier afiliación con estos por parte de <?php echo get_system_name() ?>.</p>

          <p>9.11 El CLIENTE acepta defender, indemnizar y eximir de responsabilidad a <?php echo get_system_name() ?>, sus contratistas independientes, proveedores de servicios y consultores, y sus respectivos directores, empleados y agentes, de y contra cualquier reclamación, daños, costos, responsabilidad y gastos (incluyendo, pero no limitado a honorarios razonables de abogados) que surjan de o en relación con:</p>
          <ul>
            <li>El uso de los servicios</li>
            <li>La violación del presente contrato</li>
            <li>La violación de cualquier derecho a <?php echo get_system_name() ?> o a terceros.</li>
          </ul>

          <p>10.- PROPIEDAD INTELECTUAL</p>

          <p>Las partes convienen que el presente instrumento no otorga a las mismas licencia alguna, o algún tipo de derecho respecto de la “Propiedad Intelectual” de la parte contraria. Para efectos de este convenio, “Propiedad Intelectual” incluye todas las marcas registradas y/o usadas en México o en el extranjero por cualquiera de las partes, así como todo derecho sobre invenciones (patentadas o no), diseños industriales, modelos de utilidad, información confidencial, nombres comerciales, avisos comerciales, reservas de derechos, nombres de dominio, así como todo tipo de derechos patrimoniales sobre obras y creaciones protegidas por derechos de autor y demás formas de propiedad industrial o intelectual reconocida o que lleguen a reconocer las leyes correspondientes.</p>

          <p>Cada una de las partes se obliga a no usar, comercializar, revelar a terceros, distribuir, regalar, o de cualquier otro modo disponer de cualquier desarrollo realizado por la otra parte, ni de cualquier material o material excedente que sea resultado de la Propiedad Intelectual, sin tener permiso previo y por escrito de la parte titular; mismos que una vez concluida la vigencia del presente convenio, deberán ser devueltos a su propietario.</p>

          <p>Queda estrictamente prohibido para cada una de las partes, y para su personal en su caso, reproducir sin permiso de la parte propietaria, cualquier tipo de material que se le hubiese proporcionado o desarrollado al amparo del presente convenio, bajo pena de incurrir en alguna sanción establecida en las leyes en materia de derechos de autor, además de la rescisión del presente convenio.</p>

          <p>Asimismo, EL CLIENTE se compromete a no hacer, creer o suponer la existencia de una asociación o relación entre EL CLIENTE y <?php echo get_system_name() ?>, o que la fabricación de un producto y/o la prestación de un servicio se realiza bajo ciertas normas, licencia o autorización de <?php echo get_system_name() ?>, o que presta un servicio con autorización o licencia de éste.</p>

          <p>EL CLIENTE desliga de toda responsabilidad a <?php echo get_system_name() ?> frente a terceros por cualquier violación a los derechos de autor y propiedad que cometa EL CLIENTE al llevarse a cabo el objeto de este convenio. EL CLIENTE será responsable de obtener y cubrir todos los pagos y obtener las autorizaciones necesarias para cumplir con el objeto del presente convenio, así como sacar en paz y a salvo a <?php echo get_system_name() ?> de cualquier reclamación y a responder ante las autoridades competentes.</p>

          <p>Adicionalmente, las partes se obligan a no hacer mal uso de la imagen, logotipos, tipografía, marcas, diseños o imágenes en la publicidad, obligándose a retirarla inmediatamente y a corregir dicho material publicitario en un plazo no mayor a 3 (tres) días posteriores al momento en que se solicite la corrección por escrito de dicho material publicitario.</p>

          <p>10.1 Derechos de Autor: A menos que se indique lo contrario, los servicios y todo el contenido y otros materiales en los Servicios, incluyendo, sin limitación, el logotipo de la empresa y todos los diseños, textos, gráficos, imágenes, información, datos, software, archivos de sonido, archivos de otro tipo y su selección y disposición son propiedad exclusiva de <?php echo get_system_name() ?> y se encuentran protegidos por las leyes de derechos de autor mexicanas e internacionales.</p>

          <p>10.2 Marcas: El CLIENTE no podrá utilizar de forma alguna metatags o cualquier otro “texto oculto” utilizando las Marcas de <?php echo get_system_name() ?>, sin el previo consentimiento por escrito. Además, el aspecto y la sensación de los Servicios, incluyendo todos los encabezados de página, gráficos personalizados, íconos de botones y secuencias de comandos, son la marca de servicio, marca registrada y/o imagen comercial de <?php echo get_system_name() ?> y forman parte de las marcas de <?php echo get_system_name() ?> y no pueden ser copiados, imitados o utilizados en todo o en partes, sin el previo consentimiento por escrito.</p>

          <p>10.3 Se concede un derecho limitado, no exclusivo para crear un hipervínculo de texto a los servicios, siempre que dicho vínculo no represente <?php echo get_system_name() ?> o cualquiera de sus servicios de una manera falsa, engañosa, despectiva o difamatoria y se indique que el sitio de enlace no contiene ningún material para adulos o ilegal, o cualquier material que sea ofensivo, de acoso o de otra manera. Este derecho limitado puede ser revocado en cualquier momento. El CLIENTE no puede utilizar ninguna marca de <?php echo get_system_name() ?> u otro gráfico para acceder a los Servicios sin el permiso expreso y por escrito de <?php echo get_system_name() ?>, además no puede utilizar, enmarcar o utilizar técnicas de enmarcado para adjuntar cualquier Marca de <?php echo get_system_name() ?>. El CLIENTE tampoco podrá sin consentimiento utilizar el contenido de cualquier texto o la disposición/diseño de cualquier página o formulario contenido en una de las páginas de <?php echo get_system_name() ?>.</p>

          <p>11.- RESPONSABILIDAD PATRONAL</p>

          <p>Las partes acuerdan que este convenio no podrá interpretarse de manera alguna como constitutivo de cualquier tipo de asociación o vínculo de carácter laboral entre las partes; por lo que las relaciones laborales, ya sean de naturaleza individual o colectiva, se mantendrán en todos los casos entre la parte contratante y sus respectivo personal, aún en los casos de los trabajos realizados conjuntamente y que se desarrollen en el lugar o lugares donde se deba desarrollar el objeto del presente convenio y/o con equipo de cualquiera de las partes.</p>

          <p>En ningún caso podrá considerarse a la contraparte como patrón sustituto, solidario ni tampoco intermediario con respecto a su personal. Las partes se liberan de toda responsabilidad laboral, ya sea de naturaleza individual o colectiva, fiscal, de seguridad social, administrativa, penal y de cualquier otra naturaleza jurídica que al respecto pudiera existir. En consecuencia, cada una de las partes asume totalmente las obligaciones de las relaciones laborales con sus trabajadores, entre ellas, el pago de salario, el pago de las cuotas obrero patronales al Instituto Mexicano del Seguro Social, la retención y entero del impuesto sobre la renta, así como el otorgamiento de las prestaciones a que tengan derecho los trabajadores a su servicio. Por lo tanto, las partes se liberan de cualquier tipo de responsabilidad y se obligan a responder por cualquier demanda o reclamación que se promueva en su contra, así como a correr con todos los gastos y honorarios en que, por estos conceptos y por cualquier otro, pudiesen incurrir con motivo o como consecuencia del ejercicio de la acción legal de que se trate y, en general, de las que por su naturaleza sean a su cargo.</p>

          <p>12.- TERMINACIÓN DEL CONTRATO</p>

          <p>El CLIENTE está de acuerdo en que <?php echo get_system_name() ?> se reserva el derecho de denegar, dar por terminado o suspender de manera unilateral el servicio. Acepta que basta con una constancia emitida vía electrónica por <?php echo get_system_name() ?>.</p>

          <p>Se podrá suspender o congelar la cuenta o método de pago si se sospecha que existe algún involucramiento con cargos a tarjetas u operaciones con tarjetas de crédito o débito ilegítimas, contrarias a derecho, al presente o a nuestras políticas.</p>

          <p>Acepta el CLIENTE que <?php echo get_system_name() ?> podrá dar de baja inmediata o bloquear cualquier Método de Pago ofrecido como parte del servicio, a solicitud expresa por los terceros involucrados en las operaciones, como la Cámara de Compensación, CNBV, Banca Adquirente y los diversos tipos de tarjetas. Se libera a <?php echo get_system_name() ?> de cualquier responsabilidad u obligación tendiente a exhibir, comprobar o proveer información o documentos tendientes a comprobar las razones por las que se da de baja cualquier cuenta. Ninguna baja de cuenta decidida por <?php echo get_system_name() ?> unilateralmente será refutable por ninguna vía administrativa o jurisdiccional.</p>

          <p>En caso de ser detectado un uso indebido de la licencia o del sistema proporcionado por <?php echo get_system_name(); ?> se podrá realizar la suspensión o completa eliminación de la instancia de la plataforma desarrollada por Joystick SA. de CV. sin previo aviso al CLIENTE, esto con la finalidad de proteger la propiedad intelectual y derechos de autor, así como la seguridad de la misma.</p>

          <p>13.- RESCISIÓN</p>

          <p><?php echo get_system_name() ?> podrá rescindir este contrato, con derecho a indemnización de daños y perjuicios causados, en caso de incumplimiento de las obligaciones establecidas en el mismo y de forma unilateral bastando para dichos efectos una notificación vía correo electrónico al CLIENTE.</p>

          <p>14.- NOTIFICACIONES</p>

          <p>Las notificaciones que se realicen por correo electrónico tendrán pleno valor para efectos del presente contrato, razón por la cual el CLIENTE ratifica que cualquier notificación realizada en el correo que proporcionó será válida. Por su parte se puede contactar a <?php echo get_system_name() ?> por medio del correo electrónico: <?php echo get_smtp_email(); ?></p>

          <p>15.- CESIÓN DE DERECHOS</p>

          <p>Ninguna de las partes podrá ceder, parcial o totalmente, los derechos y obligaciones derivadas de este convenio sin el previo consentimiento por escrito otorgado por la contraparte.</p>

          <p>16.- DEL RECONOCIMIENTO</p>

          <p>El presente convenio constituye todo lo acordado entre las partes en relación con su objeto y deja sin efecto cualquier otra negociación, obligación o comunicación entre éstas, ya sea verbal o escrita, efectuada con anterioridad al presente.</p>

          <p>17.- REGIMEN JURÍDICO</p>

          <p>El presente contrato tiene carácter mercantil, no existiendo en ningún caso vínculo laboral alguno entre el CLIENTE y el personal de <?php echo get_system_name() ?> que preste concretamente los Servicios.</p>

          <p>Toda controversia derivada de este contrato o que guarde relación con él –incluida cualquier cuestión relativa a su existencia, validez o terminación- será resuelta mediante arbitraje DE DERECHO, administrado por el Centro de Arbitraje de México, CAM, de conformidad con su Reglamento de Arbitraje vigente a la fecha de presentación de la solicitud de arbitraje. El Tribunal Arbitral que se designe a tal efecto estará compuesto por un único árbitro y el idioma del arbitraje será Español. La sede del arbitraje será la Ciudad de México. </p>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>