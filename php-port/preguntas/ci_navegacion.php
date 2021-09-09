<?php
//error_reporting(0);
require_once('libreria/my_libreria.php');
//----------------------------------------------------------------
class ci_navegacion extends toba_ci {
	protected $s__filtro;

    /*function conf ()    {
        $this->s__mensaje['pantalla'] = 'RESPUESTAS X PREGUNTA X INDICADOR';
        $subtitulo = 'Si va a crear una nueva, pregunta o respuesta, verificar que NO existan<br>Buscar por los campos indicados';
        $encabezado =  '<TABLE CELLSPACING=0 WIDTH=100%><CAPTION><H1><font color=green><CENTER>'.$this->s__mensaje['pantalla'].'</H1></CAPTION>'.
                        '<TR><TD><font color=green><CENTER><STRONG>'.$subtitulo.
                       '</TABLE>';
        $this->pantalla()->set_descripcion($encabezado, "info");
	}*/

	function get_relacion() 	{
		return $this->dependencia('datos');
	}

	function get_editor() 	{
		return $this->dependencia("editor");
	}

	function conf__edicion()	{
        $encabezado = toba::memoria()->get_dato_instancia('encabezado');
        $this->pantalla()->set_descripcion($encabezado,"info");
		if (! $this->get_relacion()->esta_cargada()) {
			$this->pantalla()->eliminar_evento('eliminar');
		}
		$hay_cambios = $this->get_relacion()->hay_cambios();
		toba::menu()->set_modo_confirmacion('Esta a Punto de Abandonar la Edici&oacute;n sin Grabar, ¿Salir de Todas Formas?', $hay_cambios);
	}

	function evt__agregar() 	{
        $pregunta = 'Nueva';
        $encabezado =  '<TABLE CELLSPACING=0><TR><TD><B>Grupo Horizontal<TD></B>'.$pregunta.
                       '</TABLE>';
        toba::memoria()->set_dato_instancia('encabezado',$encabezado);
        toba::memoria()->set_dato_instancia('navegacion', 1);
		$this->set_pantalla('edicion');
	}

	function evt__eliminar() 	{
		$this->get_relacion()->eliminar();
		$this->set_pantalla('seleccion');
	}

	function evt__cancelar() 	{
		$this->get_editor()->disparar_limpieza_memoria();
		$this->get_relacion()->resetear();
		$this->set_pantalla('seleccion');
	}

	function evt__procesar() 	{
		//$this->dependencia('editor')->disparar_limpieza_memoria();
		$this->get_relacion()->sincronizar();
		toba::notificacion()->agregar('<center>OK<br>Operaci&oacute;n Exitosa', 'info');
		//$this->get_relacion()->resetear();
		//$this->set_pantalla('seleccion');
	}

	//-------------------------------------------------------------------
	//-- DEPENDENCIAS
	//-------------------------------------------------------------------

	//-------- FILTRO ----

	function evt__filtro_preguntas__filtrar($datos)	{
		$this->s__filtro = $datos;
	}

	function conf__filtro_preguntas()	{
		if(isset($this->s__filtro)){
			return $this->s__filtro;
		}
	}

	function evt__filtro_preguntas__cancelar(){
		unset($this->s__filtro);
	}

	//-------- CUADRO ----

	function conf__cuadro_preguntas() 	{
		if(isset($this->s__filtro)){
			return my_libreria::get_preguntas($this->s__filtro);
		}else{
			//return libreria::get_preguntas();
		}
	}

	function evt__cuadro_preguntas__seleccion($id)	{
	    /*toba::memoria()->set_dato_instancia('navegacion', 0);
        toba::memoria()->set_dato_instancia('clave', $id);
        $datos = navegacion::get_datos_pregunta($id);
        $fuente  = $datos[0]['fue_descripcion'];
        $codigo  = $datos[0]['pre_indicador'];
        $codigo_pregunta  = $datos[0]['pre_id'];
        $descripcion     = $datos[0]['ind_descripcion'];
        $enunciado  = $datos[0]['pre_enunciado'];
        $encabezado =  '<TABLE CELLSPACING=0>'.
                         '<TR><TD><B>Fuente<TD></B>'.$fuente.
                         '<TR><TD><B>Indicador<TD></B>'.'['.$codigo.'] '.$descripcion.
                         '<TR><TD><B>Pregunta<TD></B>'.'['.$codigo_pregunta.'] '.$enunciado.
                       '</TABLE>';
        toba::memoria()->set_dato_instancia('encabezado', $encabezado);*/

		$this->get_relacion()->cargar($id);
		$this->set_pantalla('edicion');
	}

	//funciones de complemento


}
?>
