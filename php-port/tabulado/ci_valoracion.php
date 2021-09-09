<?php
require_once('libreria/libreria.php');
class ci_valoracion extends toba_ci  {
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
      //$this->dep('cuadro')->desactivar_modo_clave_segura();     
      $test_covid = 2; $datos = null;
      if ($this->s__datos_filtro['cue_id'] == $test_covid){
        if (! $this->s__datos_filtro['val_fecha']) $this->s__datos_filtro['val_fecha'] = date('Y-m-d');
        $cuadro->eliminar_columnas(array('14', '15' ,'16', '17', '18', '19', '20'));
        $cuadro->set_titulo_columna( '13', 'Puntos'  );
      }  
      if (isset($this->s__datos_filtro)) {
        $datos = $this->get_valoraciones ($this->s__datos_filtro);
        if ($this->s__datos_filtro['cue_id'] == $test_covid) {
          $datos = $this->setCompletarCovid ($datos);
        }
        else $datos = $this->setCompletar ($datos);
			}
      if ($datos) $cuadro->set_datos($datos);
  }
  
  function setCompletar ($datos)    {
      $filtro_cuestionario['cue_id'] = $datos[0]['val_cuestionario'];
      $filtro_cuestionario['pre_vigente'] = 1;
      $preguntas = libreria::get_preguntas_indicador_con_respuestas($filtro_cuestionario);
      $fila = 0;
      foreach ($datos as $usuarios => $value_usuario) {
        $filtro_usuario['usuario'] = $datos[$fila]['val_usuario']; 
        $datos_usuario = libreria::getDatosUsuario($filtro_usuario);
        $datos[$fila]['usuario_nombre'] = $datos_usuario[0]['nombre'];
        foreach ($preguntas as $pregunta => $value_pregunta) {
          $clave_valoracion = $value_usuario; 
          $clave_valoracion['val_pregunta']  = $value_pregunta['pre_id'];
          $clave_valoracion['val_indicador'] = $value_pregunta['pre_indicador'];
          $clave_valoracion['val_usuario']   = $value_usuario['val_usuario'];
          $respuestas = null;
          $respuestas = $this->getValoracionEscrita($clave_valoracion);
          switch ($value_pregunta['pre_id']) {
             case 21: $datos[$fila]['1'] = $respuestas; break;
              case 2: $datos[$fila]['2'] = $respuestas; break;
              case 3: $datos[$fila]['3'] = $respuestas; break;
              case 4: $datos[$fila]['4'] = $respuestas; break;
              case 5: $datos[$fila]['5'] = $respuestas; break;
              case 6: $datos[$fila]['6'] = $respuestas; break;
              case 7: $datos[$fila]['7'] = $respuestas; break;
              case 8: $datos[$fila]['8'] = $respuestas; break;
              case 9: $datos[$fila]['9'] = $respuestas; break;
              case 10: $datos[$fila]['10'] = $respuestas; break;
              case 11: $datos[$fila]['11'] = $respuestas; break;
              case 18: $datos[$fila]['12'] = $respuestas; break;
              case 19: $datos[$fila]['13'] = $respuestas; break;
              case 20: $datos[$fila]['14'] = $respuestas; break;
              case 12: $datos[$fila]['15'] = $respuestas; break;              
              case 13: $datos[$fila]['16'] = $respuestas; break;
              case 14: $datos[$fila]['17'] = $respuestas; break;
              case 15: $datos[$fila]['18'] = $respuestas; break;
              case 16: $datos[$fila]['19'] = $respuestas; break;
              case 17: $datos[$fila]['20'] = $respuestas; break;              
          }          
          //print_r($value_pregunta);
        }
        $fila++;
      }
      return $datos;
  }
  
  function setCompletarCovid ($datos)    {
      $filtro_cuestionario['cue_id'] = $datos[0]['val_cuestionario'];
      $filtro_cuestionario['pre_vigente'] = 1;
      $preguntas = libreria::get_preguntas_indicador_con_respuestas($filtro_cuestionario);
      $fila = 0;
      foreach ($datos as $usuarios => $value_usuario) {
        $total_puntos = 0;
        $filtro_usuario['usuario'] = $datos[$fila]['val_usuario']; 
        $datos_usuario = libreria::getDatosUsuario($filtro_usuario);
        $datos[$fila]['usuario_nombre'] = $datos_usuario[0]['nombre'];
        foreach ($preguntas as $pregunta => $value_pregunta) {
          $clave_valoracion = $value_usuario; 
          $clave_valoracion['val_pregunta']  = $value_pregunta['pre_id'];
          $clave_valoracion['val_indicador'] = $value_pregunta['pre_indicador'];
          $clave_valoracion['val_usuario']   = $value_usuario['val_usuario'];
          $clave_valoracion['val_fecha']     = $this->s__datos_filtro['val_fecha'];
          $respuestas = null;
          $respuestas = $this->getValoracionCovid($clave_valoracion);
          $total_puntos = $total_puntos + $respuestas;
          switch ($value_pregunta['pre_id']) {
              case 22: $datos[$fila]['1'] = $respuestas; break;
              case 23: $datos[$fila]['2'] = $respuestas; break;
              case 24: $datos[$fila]['3'] = $respuestas; break;
              case 25: $datos[$fila]['4'] = $respuestas; break;
              case 26: $datos[$fila]['5'] = $respuestas; break;
              case 27: $datos[$fila]['6'] = $respuestas; break;
              case 28: $datos[$fila]['7'] = $respuestas; break;
              case 29: $datos[$fila]['8'] = $respuestas; break;
              case 30: $datos[$fila]['9'] = $respuestas; break;
              case 31: $datos[$fila]['10'] = $respuestas; break;
              case 32: $datos[$fila]['11'] = $respuestas; break;
              case 33: $datos[$fila]['12'] = $respuestas; break;             
          }          
          //print_r($value_pregunta);
        }
        $datos[$fila]['13'] = $total_puntos;
        $datos[$fila]['val_fecha'] = $this->s__datos_filtro['val_fecha'];
        $fila++;
      }
      return $datos;
  }

	static function getValoracionEscrita ($filtro=null)    {
         $where = array();
         if(isset($filtro['val_cuestionario'])) {
           $where[] = "val_cuestionario = ".quote("{$filtro['val_cuestionario']}");
         }
         if(isset($filtro['val_indicador'])) {
           $where[] = "val_indicador = ".quote("{$filtro['val_indicador']}");
         }
         if(isset($filtro['val_pregunta'])) {
           $where[] = "val_pregunta = ".quote("{$filtro['val_pregunta']}");
         }
         if(isset($filtro['val_usuario'])) {
           $where[] = "val_usuario = ".quote("{$filtro['val_usuario']}");
         }
         if(isset($filtro['val_fuente'])) {
           $where[] = "val_fuente = ".quote("{$filtro['val_fuente']}");
         }
         if(isset($filtro['val_programa_ucm'])) {
           $where[] = "val_programa_ucm = ".quote("{$filtro['val_programa_ucm']}");
         }
         if(isset($filtro['val_centro_regional'])) {
           $where[] = "val_centro_regional = ".quote("{$filtro['val_centro_regional']}");
         }       
         $sql = " SELECT val_escritos FROM valoracion;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        } 
        $res = consultar_fuente($sql);  
        $cadena = '';      
        if (count($res) > 0) {          
          foreach ($res as $respuestas => $value){
            $cadena .= $value['val_escritos'].',';
          }
          $cadena = substr($cadena, 0, -1);
        }
        return $cadena;
	}

	static function getValoracionCovid ($filtro=null)    {
         $where = array();
         if(isset($filtro['val_cuestionario'])) {
           $where[] = "val_cuestionario = ".quote("{$filtro['val_cuestionario']}");
         }
         if(isset($filtro['val_indicador'])) {
           $where[] = "val_indicador = ".quote("{$filtro['val_indicador']}");
         }
         if(isset($filtro['val_pregunta'])) {
           $where[] = "val_pregunta = ".quote("{$filtro['val_pregunta']}");
         }
         if(isset($filtro['val_usuario'])) {
           $where[] = "val_usuario = ".quote("{$filtro['val_usuario']}");
         }
         if(isset($filtro['val_fecha'])) {
           $where[] = "substr(val_fecha::text,0,11)::date = ".quote("{$filtro['val_fecha']}");
         }
         $sql = " SELECT val_valor_respuesta FROM valoracion;";
         if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
         } //print_r($sql);
         $res = consultar_fuente($sql);
         $res = current($res);
         $valor = 0;
         if ($res['val_valor_respuesta']) $valor = $res['val_valor_respuesta'];
         return $valor;
	}

	static function get_valoraciones ($filtro=null)    {
         $where = array();
         if(isset($filtro['cue_id'])) {
           $where[] = "val_cuestionario = ".quote("{$filtro['cue_id']}");
         }
         if(isset($filtro['val_programa_ucm'])) {
           $where[] = "val_programa_ucm = ".quote("{$filtro['val_programa_ucm']}");
         }
         if(isset($filtro['val_fecha'])) {
           $where[] = "substr(val_fecha::text,0,11)::date = ".quote("{$filtro['val_fecha']}");
         }
         if(isset($filtro['val_usuario'])) {
           $where[] = "val_usuario = ".quote("{$filtro['val_usuario']}");
         }
         /*if(isset($filtro['nombres'])) {
           $where[] = "val_programa_ucm = ".quote("{$filtro['val_programa_ucm']}");
         }*/

         $sql = " SELECT DISTINCT val_cuestionario, val_usuario, val_programa_ucm, val_centro_regional, val_fuente, cue_nombre
                    FROM valoracion, cuestionario
                   WHERE val_cuestionario = cue_id 
                ORDER BY val_centro_regional, val_programa_ucm;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }  //print_r($sql);
        $res = consultar_fuente($sql);
        return $res;
	}
 }
?>