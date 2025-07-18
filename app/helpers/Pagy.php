<?php 

/**
* @author Robert Orozco 
* @email ventas@joystick.com.mx
* @version 1.0.0
* @date 09/01/2018
*
*/

class Pagy extends Db
{
	/**
	* Establecimiento de parametros necesarios
	* @param
	*
	**/
	private $conexion;
	private $tabla;
	private $query;
	private $resultados;
	private $offset;
	private $limite = 25;
	private $patron = "";
	private $paginas;
	private $pagina;
	private $inicio;
	private $fin;
	private $paginacion;
	private $alineacion = "";
	private $estilo;
	private $orden = "";
	private $direccion = "DESC";
	private $variable = "p";
	
	function __construct()
	{
		//echo "Clase para generar paginaciones!";
	}

	/**
	* @access public
	* @param $_query = string
	* @return none
	**/
	public function setQuery($_query)
	{
		// if (strrpos($_query, "SELECT") < 0) {
		// 	echo "No valido!";
		// }

		## Establece el valor del $query
		$this -> query = $_query;
	}

	public function getTotal()
	{
		$this -> total = count(Db::query($this -> query));
	}

	public function calcularPaginas()
	{
		$this -> paginas = ceil($this -> total / $this -> limite);
	}

	public function paginaActual()
	{
		$this -> pagina = min($this -> paginas, filter_input(INPUT_GET, $this -> variable , FILTER_VALIDATE_INT, array("opciones" => array("default" => 1 , "min" => 1))));
		$this -> pagina = ($this -> pagina < 1) ? 1 : $this -> pagina;
	}

	public function calcularOffset()
	{
		$this -> offset = ($this -> pagina - 1) * $this -> limite;
		$this -> inicio = $this -> offset + 1;
		$this -> fin = min(($this -> offset + $this -> limite), $this -> total);
	}

	public function obtenerResultados()
	{
		$this -> query .= " {$this -> orden} {$this -> direccion} LIMIT {$this->offset},{$this -> limite}";
		$this -> resultados = ($data = Db::query($this -> query )) ? $data : "No hay resultados para mostrar";
	}

	public function setLimite($_limite = 25)
	{
		## Si no es númerico
		if (!is_int($_limite)) {
			throw new Exception("El limite debe ser un valor númerico.");
		}
		$this -> limite = intval($_limite);
	}

	public function setPatron($_patron)
	{
		$this -> patron = str_replace(" ", "-", $_patron);
	}

	public function setVariable($_variable)
	{
		$this -> variable = $_variable;
	}

	public function setOrden($_orden)
	{
		$this -> orden = "ORDER BY {$_orden}";
	}

	public function setDireccion($_direccion)
	{
		switch (strtoupper($_direccion)) {
			case 'ASC':
				$this -> direccion = "ASC";
				break;
			case 'DESC':
				$this -> direccion = "DESC";
				break;
			default:
				$this -> direccion = $this -> direccion;
				break;
		}
	}

	public function setAlineacion($_alineacion)
	{
		switch (strtolower($_alineacion)) {
			case 'left':
				$this -> alineacion = "";
				break;

			case 'center':
				$this -> alineacion = "justify-content-center";
				break;

			case 'right':
				$this -> alineacion = "justify-content-end";
				break;
			
			default:
				$this -> alineacion = $this -> alineacion;
				break;
		}
	}

	public function setPaginacion()
	{

		$paginacion = '<ul class="pagination '.$this -> alineacion.'">';
		$paginacion .= ($this -> pagina > 1) ? 
		'<li class="page-item">
		<a class="page-link" href="'.$this -> patron.'?'.$this -> variable.'=' . ($this -> pagina - 1) . '" title="Anterior">Anterior</a>
		</li>' 
		: 
		'<li class="page-item disabled">
		<a class="page-link" href="'.$this -> patron.'?'.$this -> variable.'=' . ($this -> pagina - 1) . '" title="Anterior">Anterior</a>
		</li>';
		for ($i = 1; $i <= $this -> paginas; $i++) {
			if ($i == $this -> pagina) { ## Página actual
				$paginacion .= '
				<li class="page-item active">
					<a href="" class="page-link">'.$i.'</a>
				</li>
				';
			} else { // show link to other page   
				$paginacion .= '
				<li class="page-item">
					<a href="'.$this -> patron.'?'.$this -> variable.'='.$i.'" class="page-link">'.$i.'</a>
				</li>
				';
			}
		}
		$paginacion .= ($this -> pagina < $this -> paginas) ? 
		'<li class="page-item">
		<a class="page-link" href="'.$this -> patron.'?'.$this -> variable.'=' . ($this -> pagina + 1) . '" title="Siguiente">Siguiente</a>
		</li>' 
		: 
		'<li class="page-item disabled">
		<a class="page-link" href="'.$this -> patron.'?'.$this -> variable.'=' . ($this -> pagina + 1) . '" title="Siguiente">Siguiente</a>
		</li>';
		$paginacion .= '</ul>';

		## Links de paginación dinámicos
		$this -> paginacion = $paginacion;
		$this -> paginacion .= '<small class="text-muted">Página '.$this -> pagina.' de '.$this -> paginas.', mostrando '. $this -> inicio. '-'. $this -> fin. ' de '. $this -> total. ' resultados.</small>';
	}

	public function launch()
	{
		$this -> getTotal();
		$this -> calcularPaginas();
		$this -> paginaActual();
		$this -> calcularOffset();
		$this -> setPaginacion();
		$this -> obtenerResultados();
		return array(
			"resultados" => $this -> resultados ,
			"paginacion" => $this -> paginacion
		);
	}



}


 ?>