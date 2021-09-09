<?php
//error_reporting(0);
require_once('libreria/libreria.php');
class ci_encuestas extends toba_ci {
	protected $s__filtro;
	protected $s__mensaje;
	
    function conf ()    {
        $this->s__mensaje['pantalla'] = 'FORMATOS DE ENCUESTAS CREADAS';
        $subtitulo = 'Buscar por los campos indicados';
        $encabezado =  '<TABLE CELLSPACING=0 WIDTH=100%><CAPTION><H1><font color=green><CENTER>'.$this->s__mensaje['pantalla'].'</H1></CAPTION>'.
                        '<TR><TD><font color=green><CENTER><STRONG>'.$subtitulo.
                       '</TABLE>';
        $this->pantalla()->set_descripcion($encabezado, "info");
	}

    //-------- FILTRO ----
    function evt__filtro__filtrar($datos)    {
        $this->s__filtro = $datos;
        toba::memoria()->set_dato_instancia('programa_filtro', $datos);
    }

    function conf__filtro()    {
        if(isset($this->s__filtro)) {
			return $this->s__filtro;
		}
	}

	function evt__filtro__cancelar(){
		unset($this->s__filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------
	function conf__cuadro(toba_ei_cuadro $cuadro)	{
		$cuadro->desactivar_modo_clave_segura(); 
		$this->s__filtro['fue_vigente'] = TRUE;
		if ($this->s__filtro) {
		   $datos = libreria::get_cuestionarios_con_preguntas($this->s__filtro);
		   $cuadro->set_datos($datos);			
		}
	    if (count($datos) > 0) $cuadro->set_datos($datos);			
	}

	function evt__cuadro__seleccion($datos)	{
	    toba::memoria()->set_dato_instancia('clave', $datos);
		$this->dep('datos')->cargar($datos);
	}


	function resetear()	{
		$this->dep('datos')->resetear();
	}
 }
?>