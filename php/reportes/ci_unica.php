<?php
require_once('libreria/libreria.php');
class ci_unica extends toba_ci  {
	protected $s__datos_filtro;

  /*function conf (){
      $this->s__mensaje['pantalla'] = 'CONSOLIDADO DE RESPUESTAS';
      $subtitulo = 'BUSCAR POR LOS CAMPOS INDICADOS';
      $encabezado =  '<TABLE CELLSPACING=0 WIDTH=100%><CAPTION><H1><font color=green><CENTER>'.$this->s__mensaje['pantalla'].'</H1></CAPTION>'.
                      '<TR><TD><font color=green><CENTER><STRONG>'.$subtitulo.
                    '</TABLE>';
      $this->pantalla()->set_descripcion($encabezado, "info");
  }*/
  
	//---- Filtro -----------------------------------------------------------------------
	function conf__filtro(toba_ei_formulario $filtro)	{
        if (isset($this->s__datos_filtro)) {
          $filtro->set_datos($this->s__datos_filtro);
        }
	}

	function evt__filtro__filtrar($datos)	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()	{
		unset($this->s__datos_filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------
	function conf__cuadro(toba_ei_cuadro $cuadro)	{
      $cuenta = 1; $promedia = 2; $radios = 3; $check = 4;
      $datos = array();
      if (isset($this->s__datos_filtro)) {
        $this->s__datos_filtro['vigente'] = 1;
        $this->s__datos_filtro['cuenta'] = $cuenta;
        $this->s__datos_filtro['tipo_pregunta'] = $radios;
        $datos_radios = libreria::get_respuestas_verticales_pregunta ($this->s__datos_filtro);
        $this->s__datos_filtro['tipo_pregunta'] = $check;
        $datos_check = libreria::get_respuestas_verticales_check_pregunta ($this->s__datos_filtro);        
        if( !$datos_radios &&  !$datos_check ) $datos = null;
        else if ( $datos_radios &&  $datos_check ) 
               $datos = array_merge($datos_radios, $datos_check);
        else if ( $datos_radios ) $datos = $datos_radios;
        else $datos = $datos_check;
			}
      if ($datos) $cuadro->set_datos($datos);
  }
 }
?>