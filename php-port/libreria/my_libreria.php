<?php
//error_reporting(0);
class my_libreria {         
   static function get_datos_tipo_alerta ($tipo_alerta)	{
	$sql = "SELECT tipo_alertas.*, 
                       (tipale_nombre || ' - ' || tipale_color) as tipale_nombre_color
                  FROM tipo_alertas WHERE tipale_id = {$tipo_alerta}
              ORDER BY tipale_id;";
        return consultar_fuente($sql);
   } 
            
   static function get_tipo_alertas ()	{
	$sql = "SELECT tipo_alertas.*, 
                       (tipale_nombre || ' - ' || tipale_color) as tipale_nombre_color
                  FROM tipo_alertas
              ORDER BY tipale_id;";
        return consultar_fuente($sql);
   }  

   static function get_tipo_preguntas()	{
	$sql = "SELECT *
                  FROM tipo_preguntas
              ORDER BY tippre_id;";
        return consultar_fuente($sql);
   }  
   
   static function get_indicadores_cuestionario($cuestionario)	{
	$sql = "SELECT *
                  FROM indicadores
                 WHERE ind_cuestionario = {$cuestionario}  
              ORDER BY ind_orden;";
        return consultar_fuente($sql);
   }  

   static function get_cuestionarios ($filtro=array())
   {
           $where = array();
           if (isset($filtro['cue_id'])) {
                   $where[] = "cue_id = ".quote($filtro['cue_id']);
           }
           if (isset($filtro['cue_nombre'])) {
                   $where[] = "cue_nombre ILIKE ".quote("%{$filtro['cue_nombre']}%");
           }
           if (isset($filtro['cue_fecha_inicio'])) {
                   $where[] = "cue_fecha_inicio = ".quote($filtro['cue_fecha_inicio']);
           }
           $sql = "SELECT cuestionario.*, substr(('[' || cue_id || '] ' || cue_nombre || '...'),0, 200) AS cuestionario 
                     FROM cuestionario
                 ORDER BY cue_id DESC";
           if (count($where)>0) {
                   $sql = sql_concatenar_where($sql, $where);
           }
           return toba::db('admin_encuestas')->consultar($sql);
   }  

   static function get_preguntas($filtro=null)	{ 
        $where = array();
        if(isset($filtro['pre_id'])) {
   		   $where[] = "pre_id = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['pre_cuestionario'])) {
   		   $where[] = "pre_cuestionario = ".quote("{$filtro['pre_cuestionario']}");
        }
        if(isset($filtro['pre_indicador'])) {
   		   $where[] = "ind_id = ".quote("{$filtro['pre_indicador']}");
        }
        if(isset($filtro['pre_enunciado'])) {
   		   $where[] = "pre_enunciado ILIKE ".quote("%{$filtro['pre_enunciado']}%");
        }
        $sql = " SELECT preguntas.*,
                        ind_nombre, cue_nombre,
                        tippre_nombre
                   FROM preguntas, indicadores, tipo_preguntas, cuestionario  
                  WHERE pre_cuestionario   = cue_id
                    AND pre_indicador      = ind_id
                    AND pre_tipo_pregunta  = tippre_id
               ORDER BY pre_cuestionario, ind_orden, pre_orden;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
   }

   /*static function get_facultades($filtro=null)	{
        $where = array();
		if(isset($filtro['fac_codigo'])) {
   		   $where[] = "fac_codigo = ".quote("{$filtro['fac_codigo']}");
        }
        if(isset($filtro['fac_nombre'])) {
   		   $where[] = "fac_nombre ILIKE ".quote("%{$filtro['fac_nombre']}%");
        }

        $sql = "  SELECT fac_codigo, fac_nombre
				  FROM facultades;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }

        return consultar_fuente($sql);
	}

   static function set_estado_usuario()	{
        $where = array();
        $realizada = 2; $auto = 2; $acreditacion = 1;
        $sql = "UPDATE usuario_fuentes SET usufue_estado_auto = {$realizada}
				 WHERE usufue_usuario IN (SELECT val_usuario FROM valoracion);";
        consultar_fuente($sql);
        $sql = "UPDATE usuario_fuentes SET usufue_estado = {$realizada}
				 WHERE usufue_usuario = usufue_usuario
                   AND usufue_programa = {$programa}
                   AND usufue_usuario IN (SELECT val_usuario
                                            FROM valoracion
                                           WHERE val_programacion = {$programacion});";


        return consultar_fuente($sql);
	}

   static function get_usuario_fuentes($filtro=null)	{
        navegacion::set_estado_usuario();
        $where = array();
		if(isset($filtro['usu_identificacion'])) {
   		   $where[] = "usu_identificacion = ".quote("{$filtro['usu_identificacion']}");
        }
        if(isset($filtro['usu_nombres'])) {
   		   $where[] = "usu_nombres ILIKE ".quote("%{$filtro['usu_nombres']}%");
        }
        if(isset($filtro['usufue_usuario'])) {
   		   $where[] = "usufue_usuario = ".quote("{$filtro['usufue_usuario']}");
        }
        $sql = "  SELECT usufue_usuario, usufue_fuente, usufue_programa,
                         usufue_estado, usufue_estado_auto, est_descripcion,
				         usu_nombres, pro_nombre, fue_descripcion
				  FROM usuario_fuentes, usuarios, programas, fuentes, estados
				 WHERE usufue_usuario  = usu_identificacion
				   AND usufue_fuente   = fue_id
				   AND usufue_programa = pro_id
				   AND usufue_estado   = est_id;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        } //print_r($sql);

        return consultar_fuente($sql);
	}

  static function get_usuarios($filtro=null)	{
        $where = array();
		if(isset($filtro['usu_identificacion'])) {
   		   $where[] = "usu_identificacion = ".quote("{$filtro['usu_identificacion']}");
        }
        if(isset($filtro['usu_nombres'])) {
   		   $where[] = "usu_nombres ILIKE ".quote("%{$filtro['usu_nombres']}%");
        }
        $sql = "SELECT usu_identificacion, usu_contrasena, usu_nombres, usu_vigente
                    FROM usuarios ";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        $sql = $sql.' ORDER BY usu_nombres LIMIT 10';
        return consultar_fuente($sql);
	}

   static function get_indicadores($filtro=null)	{
        $where = array();
        if(isset($filtro['ind_id'])) {
   		   $where[] = "ind_id = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['ind_codigo'])) {
   		   $where[] = "ind_codigo = ".quote("{$filtro['ind_codigo']}");
        }
        if(isset($filtro['ind_descripcion'])) {
   		   $where[] = "ind_descripcion ILIKE ".quote("%{$filtro['ind_descripcion']}%");
        }
        $sql = "SELECT *
                    FROM indicadores
                ORDER BY ind_codigo;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
	}

   static function get_factores($filtro=null)	{
        $where = array();
        if(isset($filtro['fac_id'])) {
   		   $where[] = "fac_id = ".quote("{$filtro['fac_id']}");
        }
	if(isset($filtro['fac_codigo'])) {
   		   $where[] = "fac_codigo = ".quote("{$filtro['fac_codigo']}");
        }
        $sql = "SELECT factores.*
                  FROM factores
              ORDER BY fac_codigo;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
	}

	//PARA LOS ENCABEZADOS
	static function get_datos_factor($clave)	{
        $sql = "SELECT fac_id, fac_codigo, fac_descripcion, fac_vigente,
                       fac_logro_ideal, fac_ponderacion
                  FROM factores
		 WHERE fac_id = {$clave['fac_id']};";
        //print_r($sql);
        $res = consultar_fuente($sql);

        return $res;
	}

    static function get_datos_indicador($clave)	{
        $sql = "SELECT *
                    FROM indicadores
		   WHERE  ind_id = {$clave['ind_id']};";
        //print_r($sql);
        $res = consultar_fuente($sql);

        return $res;
	}

    static function get_datos_pregunta($clave)	{
        $sql = "SELECT pre_id, pre_numeracion, pre_pre_enunciado, pre_enunciado,
                               pre_pos_enunciado, pre_indicador,
                               pre_fuente, pre_tipo_pregunta, pre_obligada, pre_vigente, pre_orden,
                               ind_descripcion, fue_descripcion
                          FROM preguntas, indicadores, fuentes
                         WHERE pre_indicador      = ind_id
                           AND pre_fuente         = fue_id
			   AND pre_id = {$clave['pre_id']};";
        //print_r($sql);
        $res = consultar_fuente($sql);

        return $res;
	}

    static function get_datos_usuario($clave)	{
        if(isset($clave)) {
   		   $where[] = "usu_identificacion = ".quote("{$clave['usu_identificacion']}");
        }
        $sql = "SELECT usu_identificacion, usu_contrasena, usu_nombres, usu_vigente
                  FROM usuarios;";
        //print_r($sql);
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        $res = consultar_fuente($sql);

        return $res;
	}*/


}
?>
