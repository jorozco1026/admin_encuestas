<?php
require_once('libreria/libreria.php');
class ci_abiertas extends toba_ci  {
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
      $cajas_texto = 1; $text_area = 2; $multiple = 4;
      $datos = array();
      if (isset($this->s__datos_filtro)) {
        $this->s__datos_filtro['vigente'] = 1;
        $this->s__datos_filtro['tipo_pregunta'] = $cajas_texto;
        $datos_text_field = libreria::get_respuestas_cajas_texto_pregunta ($this->s__datos_filtro);
        $this->s__datos_filtro['tipo_pregunta'] = $cajas_texto;
        $datos_text_area = libreria::get_respuestas_text_area_pregunta ($this->s__datos_filtro);
        $this->s__datos_filtro['tipo_pregunta'] = $multiple;
        $datos_check = libreria::get_respuestas_verticales_check_pregunta ($this->s__datos_filtro); 
        if ($datos_text_field && !$datos_text_area && !$datos_check)  $datos = $datos_text_field;
        if (!$datos_text_field && $datos_text_area && !$datos_check)  $datos = $datos_text_area;
        if (!$datos_text_field && !$datos_text_area && $datos_check)  $datos = $datos_check;
        
        if ($datos_text_field && $datos_text_area && $datos_check)     
             $datos = array_merge($datos_text_field, $datos_text_area, $datos_check);
        elseif($datos_text_field && $datos_text_area)
               $datos = array_merge($datos_text_field, $datos_text_area);
        elseif ($datos_text_field && $datos_check)
               $datos = array_merge($datos_text_field, $datos_check);
        else $datos = array_merge($datos_text_area, $datos_check);
        //print_r($datos_check);
			}
      if ($datos) $cuadro->set_datos($datos);
  }
 }
?>