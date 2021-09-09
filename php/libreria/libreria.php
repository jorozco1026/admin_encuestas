<?php
  class libreria {   

   

   static function get_fecha_actual()	{
      $fecha = date('d/m/Y');
      return  $fecha;
   }
   
   static function get_programas_con_cuestionarios($filtro=array())
	{
		$where = array();
		if (isset($filtro['cue_id'])) {
			$where[] = "cue_id = ".quote($filtro['cue_id']);
		}
		if (isset($filtro['cue_nombre'])) {
			$where[] = "cue_nombre ILIKE ".quote("%{$filtro['cue_nombre']}%");
		}
		if (isset($filtro['vigente'])) {
			$where[] = "cue_vigente = TRUE ";
		}
		$sql = "SELECT DISTINCT cue_dependencia_programa FROM cuestionario ORDER BY cue_dependencia_programa";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('admin_encuestas')->consultar($sql);
	}

   static function get_cuestionarios_programa( $dependencia )
	{
		$where = array();
		if ($dependencia) {
			$where[] = "cue_dependencia_programa = ".quote($dependencia);
		}
		if (isset($filtro['cue_nombre'])) {
			$where[] = "cue_nombre ILIKE ".quote("%{$filtro['cue_nombre']}%");
		}
		if (isset($filtro['vigente'])) {
			$where[] = "cue_vigente = TRUE ";
		}
		if (isset($filtro['cue_fecha_inicio'])) {
			$where[] = "cue_fecha_inicio = ".quote($filtro['cue_fecha_inicio']);
		}
		$sql = "SELECT * FROM cuestionario ORDER BY cue_nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('admin_encuestas')->consultar($sql);
	}


   static function get_cuestionarios($filtro=array())
	{
		$where = array();
		if (isset($filtro['cue_id'])) {
			$where[] = "cue_id = ".quote($filtro['cue_id']);
		}
		if (isset($filtro['cue_nombre'])) {
			$where[] = "cue_nombre ILIKE ".quote("%{$filtro['cue_nombre']}%");
		}
		if (isset($filtro['vigente'])) {
			$where[] = "cue_vigente = TRUE ";
		}
		if (isset($filtro['cue_fecha_inicio'])) {
			$where[] = "cue_fecha_inicio = ".quote($filtro['cue_fecha_inicio']);
		}
		$sql = "SELECT * FROM cuestionario ORDER BY cue_nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('admin_encuestas')->consultar($sql);
	}

   /*static function get_respuestas_verticales_check_pregunta ( $filtro=null ) { 
       $where = array();
       if(isset($filtro['cue_id'])) {
          $where[] = "val_cuestionario = ".quote("{$filtro['cue_id']}");
       }
       if(isset($filtro['vigente'])) {
          $where[] = "pre_vigente = TRUE";
       }
       if(isset($filtro['cuenta'])) {
          $cuenta = 1; $promedia = 2;
          $where[] = "pre_cuenta_promedia =".quote("{$filtro['cuenta']}");
       }
       if(isset($filtro['tipo_pregunta'])) {
          //$radios = 3; 
          $where[] = "pre_tipo_pregunta =".quote("{$filtro['tipo_pregunta']}");
       }
       $where[] = "val_escritos IS NOT NULL";
      $sql = "SELECT val_usuario, val_cuestionario AS cuestionario_id, cue_nombre, 
                     val_indicador AS indicador_id, 
                     ind_nombre, val_pregunta AS pregunta_id, pre_enunciado, 
                     val_escritos AS texto_escrito
                FROM valoracion, preguntas, indicadores, cuestionario
               WHERE (val_cuestionario=pre_cuestionario AND val_indicador=pre_indicador AND val_pregunta=pre_id)
                 AND (pre_cuestionario = ind_cuestionario AND pre_indicador=ind_id)
                 AND cue_id=ind_cuestionario
            GROUP BY val_usuario, val_cuestionario, cue_nombre, val_indicador, ind_nombre,  
                     val_pregunta, pre_enunciado, val_escritos
            ORDER BY val_cuestionario, val_indicador, val_pregunta;"; 
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      return  consultar_fuente($sql);
   }*/
   
   static function get_respuestas_text_area_pregunta ( $filtro=null ) { 
      $where = array();
      if(isset($filtro['cue_id'])) {
         $where[] = "txtare_cuestionario = ".quote("{$filtro['cue_id']}");
      }
      if(isset($filtro['vigente'])) {
         $where[] = "txtare_vigente = TRUE";
      }
      if(isset($filtro['tipo_pregunta'])) {
         //$radios = 3; 
         $where[] = "pre_tipo_pregunta =".quote("{$filtro['tipo_pregunta']}");
         //$where[] = "(val_valor_respuesta = 0 AND val_vertical IS NULL AND val_escritos IS NOT NULL)";
      }
      $sql = "SELECT txtare_id AS objeto_id, txtare_cuestionario AS cuestionario_id, cue_nombre, txtare_indicador AS indicador_id, 
                     ind_nombre, txtare_pregunta AS pregunta_id, pre_enunciado, 
                     txtare_orden AS orden, txtare_numeracion AS numeracion, txtare_enunciado AS enunciado_objeto,
                     val_escritos AS texto_escrito
                FROM valoracion, respuestas_text_area, preguntas, indicadores, cuestionario
               WHERE (val_cuestionario=txtare_cuestionario AND val_indicador=txtare_indicador 
                 AND val_pregunta=txtare_pregunta)
                 AND (txtare_cuestionario=pre_cuestionario AND txtare_indicador=pre_indicador 
                 AND txtare_pregunta=pre_id)
                 AND (pre_cuestionario = ind_cuestionario AND pre_indicador=ind_id)
                 AND (txtare_cuestionario = cue_id and ind_cuestionario = cue_id)
            GROUP BY txtare_id, txtare_cuestionario, cue_nombre, txtare_indicador, ind_nombre,  
                     txtare_pregunta, pre_enunciado, txtare_id, txtare_orden, txtare_enunciado, val_escritos
            ORDER BY txtare_cuestionario, txtare_indicador, txtare_pregunta, txtare_orden;;"; 
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } 
      return  consultar_fuente($sql);
   }

   static function get_respuestas_cajas_texto_pregunta ( $filtro=null ) { 
      $where = array();
      if(isset($filtro['cue_id'])) {
         $where[] = "txtfie_cuestionario = ".quote("{$filtro['cue_id']}");
      }
      if(isset($filtro['vigente'])) {
         $where[] = "txtfie_vigente = TRUE";
      }
      if(isset($filtro['tipo_pregunta'])) {
         //$radios = 3; 
         $where[] = "pre_tipo_pregunta =".quote("{$filtro['tipo_pregunta']}");
         //$where[] = "(val_valor_respuesta = 0 AND val_vertical IS NULL AND val_escritos IS NOT NULL)";
      }
      $sql = "SELECT txtfie_id AS objeto_id, txtfie_cuestionario AS cuestionario_id, cue_nombre, txtfie_indicador AS indicador_id, 
                     ind_nombre, txtfie_pregunta AS pregunta_id, pre_enunciado, 
                     txtfie_orden AS orden, txtfie_numeracion AS numeracion, txtfie_enunciado AS enunciado_objeto,
                     val_escritos AS texto_escrito
                FROM valoracion, respuestas_text_field, preguntas, indicadores, cuestionario
               WHERE (val_cuestionario=txtfie_cuestionario AND val_indicador=txtfie_indicador 
                 AND val_pregunta=txtfie_pregunta)
                 AND (txtfie_cuestionario=pre_cuestionario AND txtfie_indicador=pre_indicador 
                 AND txtfie_pregunta=pre_id)
                 AND (pre_cuestionario = ind_cuestionario AND pre_indicador=ind_id)
                 AND (txtfie_cuestionario = cue_id and ind_cuestionario = cue_id)
            GROUP BY txtfie_id, txtfie_cuestionario, cue_nombre, txtfie_indicador, ind_nombre,  
                     txtfie_pregunta, pre_enunciado, txtfie_id, txtfie_orden, txtfie_enunciado, val_escritos
            ORDER BY txtfie_cuestionario, txtfie_indicador, txtfie_pregunta, txtfie_orden;;"; 
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      return  consultar_fuente($sql);
   }

   static function get_respuestas_verticales_check_pregunta ( $filtro=null ) { 
       $where = array();
       if(isset($filtro['cue_id'])) {
          $where[] = "resver_cuestionario = ".quote("{$filtro['cue_id']}");
       }
       if(isset($filtro['vigente'])) {
          $where[] = "resver_vigente = TRUE";
       }
       if(isset($filtro['cuenta'])) {
          $cuenta = 1; $promedia = 2;
          $where[] = "pre_cuenta_promedia =".quote("{$filtro['cuenta']}");
       }
       if(isset($filtro['tipo_pregunta'])) {
          //$radios = 3; 
          $where[] = "pre_tipo_pregunta =".quote("{$filtro['tipo_pregunta']}");
       }
      $sql = "SELECT resver_id, resver_cuestionario, cue_nombre, resver_indicador, 
                     ind_nombre, resver_pregunta, pre_enunciado, 
                     resver_orden, resver_numeracion, resver_enunciado,
                     traercuantosporcheckvertical (resver_cuestionario, resver_indicador, resver_pregunta, resver_enunciado::text) AS total_vertical
                FROM respuestas_verticales, preguntas, indicadores, cuestionario
               WHERE (resver_cuestionario=pre_cuestionario AND resver_indicador=pre_indicador 
                 AND resver_pregunta=pre_id)
                 AND (pre_cuestionario = ind_cuestionario AND pre_indicador=ind_id)
                 AND (resver_cuestionario = cue_id and ind_cuestionario = cue_id)
            GROUP BY resver_id, resver_cuestionario, cue_nombre, resver_indicador, ind_nombre,  
                     resver_pregunta, pre_enunciado, resver_id, resver_orden, resver_enunciado
            ORDER BY resver_cuestionario, resver_indicador, resver_pregunta, resver_orden;"; 
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      $datos =   consultar_fuente($sql);
      //print_r($datos);
      return $datos;
   }

   static function get_respuestas_verticales_pregunta ( $filtro=null ) { 
       $where = array();
       if(isset($filtro['cue_id'])) {
          $where[] = "resver_cuestionario = ".quote("{$filtro['cue_id']}");
       }
       if(isset($filtro['vigente'])) {
          $where[] = "resver_vigente = TRUE";
       }
       if(isset($filtro['cuenta'])) {
          $cuenta = 1; $promedia = 2;
          $where[] = "pre_cuenta_promedia =".quote("{$filtro['cuenta']}");
       }
       if(isset($filtro['tipo_pregunta'])) {
          //$radios = 3; 
          $where[] = "pre_tipo_pregunta =".quote("{$filtro['tipo_pregunta']}");
       }
      $sql = "SELECT resver_id, resver_cuestionario, cue_nombre, resver_indicador, 
                     ind_nombre, resver_pregunta, pre_enunciado, 
                     resver_orden, resver_numeracion, resver_enunciado,
                     traercuantosporvertical (resver_cuestionario, resver_indicador, resver_pregunta, resver_id) AS total_vertical
                FROM respuestas_verticales, preguntas, indicadores, cuestionario
               WHERE (resver_cuestionario=pre_cuestionario AND resver_indicador=pre_indicador 
                 AND resver_pregunta=pre_id)
                 AND (pre_cuestionario = ind_cuestionario AND pre_indicador=ind_id)
                 AND (resver_cuestionario = cue_id and ind_cuestionario = cue_id)
            GROUP BY resver_id, resver_cuestionario, cue_nombre, resver_indicador, ind_nombre,  
                     resver_pregunta, pre_enunciado, resver_id, resver_orden, resver_enunciado
            ORDER BY resver_cuestionario, resver_indicador, resver_pregunta, resver_orden;"; 
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      return  consultar_fuente($sql);
   }


    static function get_respuestas_verticales ( $filtro=null ) { 
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "resver_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        if(isset($filtro['ind_id'])) {
           $where[] = "resver_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pre_id'])) {
           $where[] = "resver_pregunta = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['vigente'])) {
           $where[] = "resver_vigente = TRUE";
        }
        $sql = "SELECT *
                 FROM respuestas_verticales ORDER BY resver_orden;"; 
       if(count($where)>0) {
         $sql = sql_concatenar_where($sql, $where);
       } //print_r($sql);
       return  consultar_fuente($sql);
    }

    static function get_respuestas_horizontales ( $filtro=null ){
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "reshor_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        if(isset($filtro['ind_id'])) {
           $where[] = "reshor_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pre_id'])) {
           $where[] = "reshor_pregunta = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['vigente'])) {
           $where[] = "reshor_vigente = TRUE";
        }
        $sql = "SELECT *
                 FROM respuestas_horizontales
             ORDER BY reshor_orden;"; 
        if(count($where)>0) {
         $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    static function get_respuestas_text_area ( $filtro=null ){
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "txtare_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        if(isset($filtro['ind_id'])) {
           $where[] = "txtare_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pre_id'])) {
           $where[] = "txtare_pregunta = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['vigente'])) {
           $where[] = "txtare_vigente = TRUE";
        }
        $sql = "SELECT  *
                   FROM respuestas_text_area  ORDER BY txtare_orden;";
                 //print_r($sql);
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    static function get_respuestas_text_field ( $filtro=null ){
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "txtfie_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        if(isset($filtro['ind_id'])) {
           $where[] = "txtfie_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pre_id'])) {
           $where[] = "txtfie_pregunta = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['txtfie_vigente'])) {
           $where[] = "txtfie_vigente = TRUE";
        }
        $sql = "SELECT *
                  FROM respuestas_text_field ORDER BY txtfie_orden;"; //print_r($sql);
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    static function get_preguntas_indicador_con_respuestas ( $filtro=null ){
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "pre_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        if(isset($filtro['ind_id'])) {
           $where[] = "pre_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pre_vigente'])) {
           $where[] = "pre_vigente = TRUE";
        }
        $where[] = "(pre_id IN (SELECT resver_pregunta FROM respuestas_verticales WHERE resver_vigente = TRUE) OR pre_id IN (SELECT reshor_pregunta FROM respuestas_horizontales WHERE reshor_vigente = TRUE) OR pre_id IN (SELECT txtfie_pregunta FROM respuestas_text_field WHERE txtfie_vigente = TRUE) OR pre_id IN (SELECT txtare_pregunta FROM respuestas_text_area WHERE txtare_vigente = TRUE)) ";
        $sql = "SELECT *
                  FROM preguntas, indicadores
                 WHERE (pre_cuestionario = ind_cuestionario
                   AND pre_indicador      = ind_id)
                   AND pre_indicador      = ind_id
              ORDER BY ind_orden, pre_orden;";         
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    static function get_indicadores_cuestionario ( $filtro=null ){
        $where = array();
        if(isset($filtro['cue_id'])) {
           $where[] = "ind_cuestionario = ".quote("{$filtro['cue_id']}");
        }
        $sql = "SELECT * FROM indicadores ORDER BY ind_orden;";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        } 
        return  consultar_fuente($sql);
    }

    static function get_cuestionarios_con_preguntas($filtro=null) {
        $where = array();
        if(isset($filtro['cue_id'])) {
            $where[] = "cue_id = ".quote("{$filtro['cue_id']}");
        }
        $sql = "SELECT DISTINCT cue_id, cue_nombre
                 FROM preguntas, cuestionario
                WHERE pre_cuestionario = cue_id
             ORDER BY cue_nombre;";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        //print_r($sql);
        return consultar_fuente($sql);
    }
  }    
?>