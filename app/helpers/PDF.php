<?php 
use Spipu\Html2Pdf\Html2Pdf;

class PDF {

	private $orientation = 'P'; // P or L
	private $formato = "A4";
	private $lgn = 'es'; // Lenguage
	private $charset = "UTF-8";
	private $margenes = array(20 , 15 , 20 , 20);
	private $path_to_save;
	private $filename;
	private $filesize = 0;
	private $path_to_file = null;

	public function __construct($template = null , $data = null)
	{
		if($template !== null){

			$this->margenes = array(20, 15, 20, 5);
			
			if(!file_exists($template)){
				throw new LumusException('Given template does not exist.', 1);
			}
			
			/** Try to generate our pdf */
			try {
				
				// Información del cliente seleccionado
				$cliente = new clientesModel();
				$data = $cliente->find($data['cliente']);
				
				ob_start();
				include $template;
				$content = ob_get_clean();
				
				$html2pdf = new Html2Pdf($this->orientation , $this->formato, 'es', true, $this->charset, $this->margenes);
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content);
				$html2pdf->output();
				
			} catch (Html2PdfException $e) {
				
				$formatter = new ExceptionFormatter($e);
				throw new LumusException($formatter->getHtmlMessage(), 1);
				
			}

		}

		return $this;
	}
		
	/**
	* Genera un PDF del reporte en curso
	* @access public
	* @param $id del usuario
	* @param array información del reporte
	* @return bool pdf | false
	*/
	public function generar_pdf_reporte($id , $reporte_data) 
	{

		// Nombre del PDF
		$nombre_pdf = $reporte_data['folio'].".pdf";

		// Buffer del formato del PDF
		ob_start();
		require_once PDF. "reporte_pdf.php";
		$template = ob_get_clean();

		//Output del PDF
		$html2pdf = new Html2Pdf('P' , 'A4' , 'es' , 'true' , 'UTF-8' , $this->margenes);
		$html2pdf->writeHTML($template);
		return ($html2pdf->output($nombre_pdf)) ? true : false;
	}


	/**
	* Genera una orden de servicio en blanco para llenado manual
	* @access public
	* @return bool pdf | false
	*/
	public function generar_orden_de_servicio_en_blanco()
	{
		// Nombre de la órden de servicio
		$nombre = "OS-".randomPassword(6,'numeric').".pdf";

		// Buffer del formato del PDF en blanco
		ob_start();
		require_once PDF . 'orden_de_servicio_blank.php';
		$template = ob_get_clean();
		//Output del PDF
		$html2pdf = new Html2Pdf('P' , $this->formato , 'es' , 'true' , $this->charset , $this->margenes);
		$html2pdf->writeHTML($template);
		$html2pdf->output($nombre);
		return true;
	}

	/**
	* Genera una orden de servicio con información pasada por el cliente
	* @access public
	* @param array
	* @return bool pdf | false
	*/
	public function generar_orden_de_servicio($data)
	{
		// Validar variables $_POST
		/*
		* submit
		* folio
		* fecha
		* tipoServicio
		* id_cliente, sucursal, direccion
		* serie, modelo
		* tipo
		* marca
		* serie
		* modelo
		* descripcion
		* dias[]
		* horas_totales
		* fechas[]
		* dias_totales
		* sistema_revisado
		* refacciones
		*/ 

		/* Nombre de la órden de servicio */
		$nombre = $data['folio_orden'].".pdf";

		/* Suma de horas y totales */
		$semana = array(
			$data['lunes'] , $data['martes'], $data['miercoles'] , $data['jueves'], $data['viernes'], $data['sabado'], $data['domingo']
		);
		$horas = array();
		foreach ($semana as $key => $value) {
			$value1 = implode("", explode(":", $value[0]));
			$value2 = implode("", explode(":", $value[1]));
			$horas[] = (intval($value2) - intval($value1)) / 100;
		}
		$horas_totales = array_sum($horas);

		// $horas_totales = array_sum($data['horas']);
		$data['horas_totales'] = ($horas_totales > 1) ? $horas_totales." horas" : $horas_totales." hora";

		/* Suma de días y totales */
		$data['dias_totales'] = sizeof(array_filter($data['fechas']));
		if ($data['dias_totales'] < 1) {
			$data['dias_totales'] = 1;
		}
		$data['dias_totales'] = ($data['dias_totales'] > 1) ? $data['dias_totales']." días" : $data['dias_totales']." día";

		ob_start();
		require_once PDF.'orden_de_servicio.php';
		$template = ob_get_clean();

		//Output del PDF
		try {

			$html2pdf = new Html2Pdf('P', $this->formato, 'es', 'true', $this->charset, $this->margenes);
			$html2pdf->writeHTML($template);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');

		} catch (Html2PdfException $e) {

			$formatter = new ExceptionFormatter($e);
			throw new LumusException($formatter->getHtmlMessage(), 1);

		}
	
		return true;
	}

	/**
	* Genera un checklist de mantenimiento en blanco
	* @access public
	* @return bool pdf | false
	*/
	public function generar_checklist_en_blanco()
	{

		$nombre = 'CL-'.randomPassword(6,'numeric').'.pdf';
		$this -> margenes = array(20, 15, 20, 5);

		// En blanco
		try {

			ob_start();
			include PDF.'checklist_blank.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'fr', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output($nombre);

		} catch (Html2PdfException $e) {

			$formatter = new ExceptionFormatter($e);
			throw new LumusException($formatter->getHtmlMessage(), 1);

		}

		return true;
	}

	/**
	* Genera un checklist de mantenimiento con información mandada por el cliente
	* @access public
	* @return bool pdf | false
	*/
	public function generar_checklist($data)
	{
		$data['folio_orden'] = 'CL-' . randomPassword(6, 'numeric');
		$nombre = $data['folio_orden'] .'.pdf';
		$this -> margenes = array(20, 15, 20, 5);
		try {

			ob_start();
			include PDF.'checklist.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'fr', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
			exit;
				

		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			echo $formatter->getHtmlMessage();
		}
	}

	/**
	* @access public by users
	* @var $_POST array()
	* @return bool pdf | false
	*/
	public function generar_cotizacion($data)
	{
		$this->margenes = array(20, 15, 20, 5);

		$nombre = (empty($data['keyword'])) ? $data['folio_cotizacion'].'.pdf' : $data['folio_cotizacion'].'-'.sluggify($data['keyword']).'.pdf';
		
		// Generación de la cotización con valores
		try {

			// Información del cliente seleccionado
			$cliente = new clientesModel();
			$row = $cliente->find($data['cliente']);
			$data['razonSocial'] = $row['razonSocial'];
			$data['rfc'] = $row['rfc'];
			$data['nombre'] = $row['nombre'];
			$data['email'] = $row['email'];

			// Si el tipo de servicio es 3 o 4
			// la información del equipo es almacenada
			if ($data['tipo_cotizacion'] == 3 || $data['tipo_cotizacion'] == 4) {
				$equipo = new equiposModel();
				$row = $equipo->cargar_con_id($data['equipos']);
				$data['tipo'] = $row['tipo'];
				$data['modelo'] = $row['modelo'];
				$data['marca'] = $row['marca'];
				$data['serie'] = $row['serie'];
			}

			ob_start();
			include PDF.'cotizacion.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'fr', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			throw $formatter;
		}
	}

	/**
	* @access public by users
	* @var $_POST array()
	* @return bool pdf | false
	*/
	public function generar_cotizacion_interna($data)
	{
		$this->margenes = array(20, 15, 20, 5);
		$nombre = $data['folio_cotizacion'].'.pdf';
		
		// Generación de la cotización con valores
		try {

			// Información del cliente seleccionado
			$cliente = new clientesModel();
			$row = $cliente->find($data['cliente']);
			$data['razonSocial'] = $row['razonSocial'];
			$data['rfc'] = $row['rfc'];
			$data['nombre'] = $row['nombre'];
			$data['email'] = $row['email'];

			// Si el tipo de servicio es 2 - 5, no 1
			// la información del equipo es almacenada
			if ($data['tipo_cotizacion_interna'] > 1) {
				$equipo = new equiposModel();
				$row = $equipo->cargar_con_id($data['equipos']);
				$data['tipo'] = $row['tipo'];
				$data['modelo'] = $row['modelo'];
				$data['marca'] = $row['marca'];
				$data['serie'] = $row['serie'];
			}

			ob_start();
			include PDF.'cotizacion_interna.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'fr', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			echo $formatter->getHtmlMessage();
		}
	}

	public function generar_cotizacion_joystick($data)
	{
		$this -> margenes = array(20, 15, 20, 5);
		$nombre = 'COTJOYS-'.$data['folio_cotizacion'].'.pdf';
		
		// Generación de la cotización con valores
		try {

			// Información del cliente seleccionado
			$cliente = new clientesModel();
			$row = $cliente->find($data['cliente']);
			$data['razonSocial'] = $row['razonSocial'];
			$data['rfc'] = $row['rfc'];
			$data['nombre'] = $row['nombre'];
			$data['email'] = $row['email'];

			// Si el tipo de servicio es 3 o 4
			// la información del equipo es almacenada
			if ($data['tipo_cotizacion'] == 3 || $data['tipo_cotizacion'] == 4) {
				$equipo = new equiposModel();
				$row = $equipo->cargar_con_id($data['equipos']);
				$data['tipo'] = $row['tipo'];
				$data['modelo'] = $row['modelo'];
				$data['marca'] = $row['marca'];
				$data['serie'] = $row['serie'];
			}

			ob_start();
			include PDF.'joystick.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'fr', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			echo $formatter->getHtmlMessage();
		}
	}

	public function ordenDeEntrega($data)
	{
		$this -> margenes = array(20, 15, 20, 5);
		$nombre = $data['folio'].'.pdf';
		
		// Generación de la cotización con valores
		try {
			// Información del equipo y cliente
			$equipo = new equiposModel();
			$row = $equipo->cargar_con_id($data['id_equipo']);

			ob_start();
			include PDF.'orden_de_entrega.php';
			$content = ob_get_clean();

			$html2pdf = new Html2Pdf('P', $this->formato, 'es', true, $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			echo $formatter->getHtmlMessage();
		}
	}

	/**
	 * Método para generar la plantilla de impresión de QR
	 * @access private
	 * @param array session
	 * @return bool
	 */
	public function generarPlantillaDeImpresion()
	{
		$this->margenes = array(5, 5, 5, 5);

		$nombre = 'PRINT-'. date('dmy') . '.pdf';
		
		// Generación de la cotización con valores
		try {

			ob_start();
			include PDF . 'plantillaDeImpresion.php';
			$content = ob_get_clean();
			// 330,480 en caso de requerirlo en tabloide extendido
			//print_r($content);
			//exit;
			$html2pdf = new Html2Pdf('L', array(279, 432), 'es', true , $this->charset, $this->margenes);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content);
			$html2pdf->output(ROOT . SAVE_FILES . $nombre, 'FI');
			return true;

		} catch (Html2PdfException $e) {
			$formatter = new ExceptionFormatter($e);
			echo $formatter->getHtmlMessage();
			return false;
		}
	}
	
}
