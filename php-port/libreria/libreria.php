<?php
  class libreria {   

    

   static function get_fecha_actual()	{
      $fecha = date('d/m/Y');
      return  $fecha;
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

    static function get_cuestionarios($filtro=null) {
        $where = array();
        if(isset($filtro['cue_id'])) {
            $where[] = "cue_id = ".quote("{$filtro['cue_id']}");
        }
        $sql = "SELECT *
                  FROM cuestionario
              ORDER BY cue_nombre;";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
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