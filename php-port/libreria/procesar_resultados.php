<?php
  require_once('libreria/combos_total.php');  
  require_once('libreria/combos_parametros.php');  
  
  function set_factores_fuente($filtro=null)	{
        $where = array();        
		if(isset($filtro['val_programacion'])) {
   		   $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
        }	
        if(isset($filtro['val_factor'])) {
   		   $where[] = "val_factor = ".quote("{$filtro['val_factor']}");
        }	
        if(isset($filtro['val_caracteristica'])) {
   		   $where[] = "val_caracteristica = ".quote("{$filtro['val_caracteristica']}");
        }	
        if(isset($filtro['val_indicador'])) {
   		   $where[] = "val_indicador = ".quote("{$filtro['val_indicador']}");
        }	
        if(isset($filtro['val_programa'])) {
   		   $where[] = "val_programa = ".quote("{$filtro['val_programa']}");
        }	
        if(isset($filtro['val_fuente'])) {
   		   $where[] = "val_fuente = ".quote("{$filtro['val_fuente']}");
        }	
        
        $sql = "  SELECT val_programacion, val_programa, val_fuente, val_factor, val_caracteristica, 
                         val_indicador,
                         avg(val_valor) AS grado_cumplimiento, count(*) AS cantidad_indicadores,
                         pro_nombre, fue_descripcion,
                         fac_descripcion, car_descripcion, ind_descripcion,
                         car_ponderacion 
                    FROM valoracion, programacion, programas, fuentes, factores, caracteristicas, indicadores
                   WHERE val_programacion = prg_id
                     AND val_programa = pro_id
                     AND val_fuente = fue_id
                     AND val_factor = fac_id
                     AND val_caracteristica = car_id
                     AND val_indicador  = ind_id
                GROUP BY val_programacion, val_factor, val_caracteristica, 
                         val_indicador, val_programa, val_fuente,
                         pro_nombre, pro_nombre, fue_descripcion,
                         fac_descripcion, car_descripcion, ind_descripcion, car_ponderacion;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
  }
  
  function set_factores_programa($filtro=null)	{
        $where = array();        
		if(isset($filtro['val_programacion'])) {
   		   $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
        }	
        if(isset($filtro['val_factor'])) {
   		   $where[] = "val_factor = ".quote("{$filtro['val_factor']}");
        }	
        if(isset($filtro['val_caracteristica'])) {
   		   $where[] = "val_caracteristica = ".quote("{$filtro['val_caracteristica']}");
        }	
        if(isset($filtro['val_indicador'])) {
   		   $where[] = "val_indicador = ".quote("{$filtro['val_indicador']}");
        }	
        if(isset($filtro['val_programa'])) {
   		   $where[] = "val_programa = ".quote("{$filtro['val_programa']}");
        }	        
        
        $sql = "  SELECT val_programacion, val_programa, val_factor, val_caracteristica, 
                         val_indicador, 
                         avg(val_valor) AS grado_cumplimiento, count(*) AS cantidad_indicadores,
                         pro_nombre, pro_nombre, fue_descripcion,
                         fac_descripcion, car_descripcion, ind_descripcion,
                         car_ponderacion 
                    FROM valoracion, programacion, programas, factores, caracteristicas, indicadores
                   WHERE val_programacion = prg_id
                     AND val_programa = pro_id
                     AND val_factor = fac_id
                     AND val_caracteristica = car_id
                     AND val_indicador  = ind_id
                GROUP BY val_programacion, val_factor, val_caracteristica, 
                         val_indicador, val_programa, 
                         pro_nombre, pro_nombre, 
                         fac_descripcion, car_descripcion, ind_descripcion, car_ponderacion;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
  }	
  
?>

