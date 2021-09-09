<?php
//error_reporting(0);
class ci_edicion extends toba_ci {
    protected $s__filtro_ciudades;
    protected $s__filtro_devoluciones;
    protected $s__filtro_preguntas;
    protected $s__filtro_verticales;
	protected $s__filtro_horizontales;
	
    /*function conf ()    {
        $this->s__mensaje['pantalla'] = 'RESPUESTAS X PREGUNTA X INDICADOR';
        $subtitulo = 'Si va a crear una nueva, pregunta o respuesta, verificar que NO existan<br>Buscar por los campos indicados';
        $encabezado =  '<TABLE CELLSPACING=0 WIDTH=100%><CAPTION><H1><font color=green><CENTER>'.$this->s__mensaje['pantalla'].'</H1></CAPTION>'.
                        '<TR><TD><font color=green><CENTER><STRONG>'.$subtitulo.
                       '</TABLE>';
        $this->pantalla()->set_descripcion($encabezado, "info");
	}*/

    function get_relacion()	 	{
		return $this->controlador->get_relacion();
	}

	//-------------------------------------------------------------------
	//--- Pantalla 'preguntas'
	//-------------------------------------------------------------------
	function conf__form_preguntas() 	{
		$datos = $this->get_relacion()->tabla('preguntas')->get();
		return $datos;
	}

	function evt__form_preguntas__modificacion($registro) 	{
		$this->get_relacion()->tabla('preguntas')->set($registro);
	}

	//-------------------------------------------------------------------
	//--- Pantalla 'verticales'
	//-------------------------------------------------------------------

	//-- Cuadro --

	function conf__cuadro_verticales()	{
        if(isset($this->s__filtro_verticales)){
			//return navegacion::get_paises($this->s__filtro);
			return $this->get_relacion()->tabla('verticales')->get_filas($this->s__filtro_verticales);
		}else{
			//return navegacion::get_paises();
			return $this->get_relacion()->tabla('verticales')->get_filas();
		}

	}

	function evt__cuadro_verticales__seleccion($seleccion) {
		$this->get_relacion()->tabla('verticales')->set_cursor($seleccion);
        $this->controlador()->evento('procesar')->desactivar();
	}

	//-- Formulario --
	function conf__form_verticales()	{
		if ($this->get_relacion()->tabla('verticales')->hay_cursor()) {
			return $this->get_relacion()->tabla('verticales')->get();
		}
	}

	function evt__form_verticales__modificacion($registro)	{
		
		$this->get_relacion()->tabla('verticales')->set($registro);
        $this->get_relacion()->sincronizar();
		$this->evt__form_verticales__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_verticales__baja()	{
		$this->get_relacion()->tabla('verticales')->set(null);
		$this->evt__form_verticales__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_verticales__alta($registro)	{
		//print_r($registro);
		$this->get_relacion()->tabla('verticales')->nueva_fila($registro);
        $this->get_relacion()->sincronizar();
		$this->controlador()->evento('procesar')->activar();

	}

	function evt__form_verticales__cancelar() 	{
		$this->get_relacion()->tabla('verticales')->resetear_cursor();
	}

	//-------------------------------------------------------------------
	//--- Pantalla 'horizontales'
	//-------------------------------------------------------------------

	//-- Cuadro --

	function conf__cuadro_horizontales()	{
        if(isset($this->s__filtro_horizontales)){
			//return navegacion::get_paises($this->s__filtro);
			return $this->get_relacion()->tabla('horizontales')->get_filas($this->s__filtro_horizontales);
		}else{
			//return navegacion::get_paises();
			return $this->get_relacion()->tabla('horizontales')->get_filas();
		}

	}

	function evt__cuadro_horizontales__seleccion($seleccion) {
		$this->get_relacion()->tabla('horizontales')->set_cursor($seleccion);
        $this->controlador()->evento('procesar')->desactivar();
	}

	//-- Formulario --
	function conf__form_horizontales()	{
		if ($this->get_relacion()->tabla('horizontales')->hay_cursor()) {
			return $this->get_relacion()->tabla('horizontales')->get();
		}
	}

	function evt__form_horizontales__modificacion($registro)	{
		$this->get_relacion()->tabla('horizontales')->set($registro);
        $this->get_relacion()->sincronizar();
		$this->evt__form_horizontales__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_horizontales__baja()	{
		$this->get_relacion()->tabla('horizontales')->set(null);
		$this->evt__form_horizontales__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_horizontales__alta($registro)	{
		$this->get_relacion()->tabla('horizontales')->nueva_fila($registro);
        $this->get_relacion()->sincronizar();
		$this->controlador()->evento('procesar')->activar();

	}

	function evt__form_horizontales__cancelar() 	{
		$this->get_relacion()->tabla('horizontales')->resetear_cursor();
	}


	//-------------------------------------------------------------------
	//--- Pantalla 'text_field'
	//-------------------------------------------------------------------

	//-- Cuadro --

	function conf__cuadro_text_field()	{
        if(isset($this->s__filtro_text_field)){
			return $this->get_relacion()->tabla('text_field')->get_filas($this->s__filtro_text_field);
		}else{
			return $this->get_relacion()->tabla('text_field')->get_filas();
		}

	}

	function evt__cuadro_text_field__seleccion($seleccion) {
		$this->get_relacion()->tabla('text_field')->set_cursor($seleccion);
        $this->controlador()->evento('procesar')->desactivar();
	}

	//-- Formulario --
	function conf__form_text_field()	{
		if ($this->get_relacion()->tabla('text_field')->hay_cursor()) {
			return $this->get_relacion()->tabla('text_field')->get();
		}
	}

	function evt__form_text_field__modificacion($registro)	{
		$this->get_relacion()->tabla('text_field')->set($registro);
        $this->get_relacion()->sincronizar();
		$this->evt__form_text_field__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_text_field__baja()	{
		$this->get_relacion()->tabla('text_field')->set(null);
		$this->evt__form_text_field__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_text_field__alta($registro)	{
		$this->get_relacion()->tabla('text_field')->nueva_fila($registro);
        $this->get_relacion()->sincronizar();
		$this->controlador()->evento('procesar')->activar();

	}

	function evt__form_text_field__cancelar() 	{
		$this->get_relacion()->tabla('text_field')->resetear_cursor();
	}

	//-------------------------------------------------------------------
	//--- Pantalla 'text_area'
	//-------------------------------------------------------------------

	//-- Cuadro --

	function conf__cuadro_text_area()	{
        if(isset($this->s__filtro_text_area)){
			return $this->get_relacion()->tabla('text_area')->get_filas($this->s__filtro_text_area);
		}else{
			return $this->get_relacion()->tabla('text_area')->get_filas();
		}

	}

	function evt__cuadro_text_area__seleccion($seleccion) {
		$this->get_relacion()->tabla('text_area')->set_cursor($seleccion);
        $this->controlador()->evento('procesar')->desactivar();
	}

	//-- Formulario --
	function conf__form_text_area()	{
		if ($this->get_relacion()->tabla('text_area')->hay_cursor()) {
			return $this->get_relacion()->tabla('text_area')->get();
		}
	}

	function evt__form_text_area__modificacion($registro)	{
		$this->get_relacion()->tabla('text_area')->set($registro);
        $this->get_relacion()->sincronizar();
		$this->evt__form_text_area__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_text_area__baja()	{
		$this->get_relacion()->tabla('text_area')->set(null);
        $this->get_relacion()->sincronizar();
		$this->evt__form_text_area__cancelar();
		$this->controlador()->evento('procesar')->activar();
	}

	function evt__form_text_area__alta($registro)	{
		$this->get_relacion()->tabla('text_area')->nueva_fila($registro);
		$this->controlador()->evento('procesar')->activar();

	}

	function evt__form_text_area__cancelar() 	{
		$this->get_relacion()->tabla('text_area')->resetear_cursor();
	}


}
?>
