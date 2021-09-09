<?php
class ci_tipo_de_alertas extends admin_encuestas_ci
{
	/*function conf ()      {
		$encabezado =  '<TABLE WIDTH=100%><CAPTION><h1><FONT COLOR=GREEN>TIPO DE ALETAS'.
					   '</h1></caption></TABLE>';
		$this->pantalla()->set_descripcion($encabezado, "info");
    }*/

	function ini__operacion()
	{
		$this->dep('datos')->cargar();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar();
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->procesar_filas($datos);
	}

	function conf__formulario(toba_ei_formulario_ml $componente)
	{
		$componente->set_datos($this->dep('datos')->get_filas());
	}

}

?>