<?php
class combos_navegacion {
    static function get_rango_metas()    {
        $rango_actual =  toba::memoria()->get_dato_instancia('rango_actual');;
        $sql = "SELECT rgm_id, rgm_descripcion FROM rango_metas
                 WHERE rgm_id <= $rango_actual
              ORDER BY rgm_id;";
        return consultar_fuente($sql);
    }

	static function get_caracteristicas_factor()	{
	 $filtro = toba::memoria()->get_dato_instancia('clave');

	 $where = array();
	 if($filtro['fac_id']) {
   	   $where[] = "car_factor = ".quote($filtro['fac_id']);
     }
     $sql = "SELECT car_id, ('[' || car_codigo || '] - ' || car_descripcion) AS car_descripcion
               FROM caracteristicas
              ORDER BY car_id;";
     if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
     }
     return consultar_fuente($sql);
    }
} //fin clase combos_navegacion
?>
