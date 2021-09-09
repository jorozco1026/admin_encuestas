<?php
class dt_cuestionario extends admin_encuestas_datos_tabla
{
	function get_listado($filtro=array())
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
		$sql = "SELECT
			t_c.cue_id,
			t_c.cue_nombre,
			t_c.cue_descripcion,
			t_c.cue_vigente,
			t_c.cue_fecha_inicio,
			t_c.cue_fecha_final,
			t_c.cue_incluir_datos_persona
		FROM
			cuestionario as t_c
		ORDER BY cue_nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('admin_encuestas')->consultar($sql);
	}


	function get_descripciones()
	{
		$sql = "SELECT cue_id, cue_nombre FROM cuestionario ORDER BY cue_nombre";
		return toba::db('admin_encuestas')->consultar($sql);
	}

}
?>