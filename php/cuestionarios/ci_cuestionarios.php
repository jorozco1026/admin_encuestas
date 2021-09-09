<?php
require_once('libreria/libreria.php');
require_once('libreria/libreria_usuarios.php');

class ci_cuestionarios extends admin_encuestas_ci
{
	protected $s__datos_filtro;

	/*function conf ()      {
		switch ($this->get_id_pantalla()) {
              case 'pant_seleccion': $this->pantalla()->tab('pant_edicion')->ocultar(); 
			                         $this->pantalla()->tab('pant_indicadores')->ocultar();   
									 $this->pantalla()->tab('pant_roles')->ocultar();
			                         break;
              case 'pant_edicion':   
			  case 'pant_indicadores':
			  case 'pant_roles':     $this->pantalla()->tab('pant_seleccion')->ocultar(); 		                   break;              
        }
    }*/

	//---- Filtro -----------------------------------------------------------------------

	function conf__filtro(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$datos = libreria::get_cuestionarios ($this->s__datos_filtro);			
		} else {
			$this->s__datos_filtro['cue_vigente'];
			$datos = libreria::get_cuestionarios ($this->s__datos_filtro);
		}
		if($datos) {
			$datos = $this->set_completar_dependencias($datos);
			$cuadro->set_datos($datos);
		}
	}

	function set_completar_dependencias($cuestionarios)
	{   
		$fila=0;
        foreach ($cuestionarios as $cuestionario => $value) {
			//print_r($value);
			$clave['pro_codigo'] = $value['cue_dependencia_programa'];
			$datos_dependencia = libreria_usuarios::get_datos_programa($clave);
            $cuestionarios[$fila]['pro_codigo'] = $clave['pro_codigo'];
			$cuestionarios[$fila]['pro_nombre'] = $datos_dependencia[0]['pro_nombre'];
			$fila++;
		}
		return $cuestionarios;
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('cuestionario')->get());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('cuestionario')->set($datos);
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$mensaje = '<center>OK, ACTUALIZADO';
		toba::notificacion()->agregar($mensaje, 'info');
		//$this->resetear();
	}

	//INDICADORES
	function conf__indicadores (toba_ei_formulario_ml $componente)
	{
		$componente->set_datos($this->dep('datos')->tabla('indicadores')->get_filas());
	}

	function evt__indicadores__modificacion($datos)
	{
		$this->dep('datos')->tabla('indicadores')->procesar_filas($datos);
	}

	//ROLES O PERFILES EN EL CUESTIONARIO
	function conf__roles (toba_ei_formulario_ml $componente)
	{
		$componente->set_datos($this->dep('datos')->tabla('cuestionario_roles')->get_filas());
	}

	function evt__roles__modificacion($datos)
	{
		$this->dep('datos')->tabla('cuestionario_roles')->procesar_filas($datos);
	}

}

?>