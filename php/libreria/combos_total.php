<?php
error_reporting(0);
class combos_total {
   //para encuesta postgrados
   function get_medios_oferta () {
       $sql = "SELECT *
                 FROM medios_oferta;";
        return consultar_fuente($sql);
    }

    function get_razones_eleccion () {
       $sql = "SELECT *
                 FROM razones_eleccion;";
        return consultar_fuente($sql);
    }

    function get_lugares_trabajo () {
       $sql = "SELECT *
                 FROM lugares_trabajo;";
        return consultar_fuente($sql);
    }

    function get_formas_financiacion () {
       $sql = "SELECT *
                 FROM formas_financiacion ORDER BY forfin_id;";
        return consultar_fuente($sql);
    }

    function get_si_no () {
       $sql = "SELECT *
                 FROM si_no;";
        return consultar_fuente($sql);
    }
   //fin jpostgrados
   static function get_instrumentos()    {
        $sql = "SELECT ins_id, ins_descripcion
                  FROM instrumentos WHERE ins_vigente = true
              ORDER BY ins_id;";
        return consultar_fuente($sql);
   }

   static function get_rango_metas()    {
        $sql = "SELECT rgm_id, rgm_descripcion FROM rango_metas
              ORDER BY rgm_id;";
        return consultar_fuente($sql);
   }

   static function get_facultades()	{
		$sql = "SELECT fac_codigo, fac_nombre FROM facultades
              ORDER BY fac_nombre ASC;";
        return consultar_fuente($sql);
   }

   static function get_estados()	{
		$sql = "SELECT est_id, est_descripcion FROM estados
              ORDER BY est_id ASC;";
        return consultar_fuente($sql);
   }
   static function get_programacion()	{
		$sql = "SELECT prg_id, prg_nombre FROM programacion
              ORDER BY prg_id DESC;";
        return consultar_fuente($sql);
   }
   static function get_factores()	{
		$sql = "SELECT * FROM factores
              ORDER BY fac_codigo ASC;";

        return consultar_fuente($sql);
   }

   static function get_fecha_hora()	{
        $fecha_hora = date('Y-m-d H:i');
		return  $fecha_hora;
   }

   static function get_fecha_actual()	{
        $fecha = date('d/m/Y');
		return  $fecha;
   }

   static function get_programas()	{
		$sql = "SELECT pro_id, pro_nombre, pro_vigente
                  FROM programas WHERE pro_vigente = TRUE
                  ORDER BY pro_nombre;";

        return consultar_fuente($sql);
   }


   static function get_fuentes()	{
		$sql = "SELECT fue_id, fue_descripcion, fue_vigente
                  FROM fuentes WHERE fue_vigente = TRUE
                  ORDER BY fue_descripcion;";

        return consultar_fuente($sql);
	}

    static function get_tipo_programas()	{
		$sql = "SELECT *
                  FROM tipo_programas
                  ORDER BY tippro_id;";

        return consultar_fuente($sql);
	}

    static function get_tipo_preguntas()	{
		$sql = "SELECT tippre_id, tippre_descripcion, tippre_vigente
                  FROM tipo_preguntas
                  ORDER BY tippre_id;";

        return consultar_fuente($sql);
	}

    static function get_tipo_unidades()	{
		$sql = "SELECT tipuni_id, tipuni_descripcion, tipuni_vigente
                  FROM tipo_unidades
                  ORDER BY tipuni_id;";

        return consultar_fuente($sql);
	}

    static function get_situacion_laboral()	{
		$sql = "SELECT sitlab_id, sitlab_descripcion, sitlab_vigente
                  FROM situacion_laboral
                  ORDER BY sitlab_id;";

        return consultar_fuente($sql);
	}

    static function get_sector_laboral()	{
		$sql = "SELECT seclab_id, seclab_descripcion, seclab_vigente
                  FROM sector_laboral
                  ORDER BY seclab_id;";

        return consultar_fuente($sql);
	}

    static function get_tipo_sector()	{
		$sql = "SELECT tipsec_id, tipsec_descripcion, tipsec_vigente
                  FROM tipo_sector
                  ORDER BY tipsec_id;";

        return consultar_fuente($sql);
	}


}
?>
