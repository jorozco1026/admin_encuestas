<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class admin_encuestas_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'admin_encuestas_ci' => 'extension_toba/componentes/admin_encuestas_ci.php',
		'admin_encuestas_cn' => 'extension_toba/componentes/admin_encuestas_cn.php',
		'admin_encuestas_datos_relacion' => 'extension_toba/componentes/admin_encuestas_datos_relacion.php',
		'admin_encuestas_datos_tabla' => 'extension_toba/componentes/admin_encuestas_datos_tabla.php',
		'admin_encuestas_ei_arbol' => 'extension_toba/componentes/admin_encuestas_ei_arbol.php',
		'admin_encuestas_ei_archivos' => 'extension_toba/componentes/admin_encuestas_ei_archivos.php',
		'admin_encuestas_ei_calendario' => 'extension_toba/componentes/admin_encuestas_ei_calendario.php',
		'admin_encuestas_ei_codigo' => 'extension_toba/componentes/admin_encuestas_ei_codigo.php',
		'admin_encuestas_ei_cuadro' => 'extension_toba/componentes/admin_encuestas_ei_cuadro.php',
		'admin_encuestas_ei_esquema' => 'extension_toba/componentes/admin_encuestas_ei_esquema.php',
		'admin_encuestas_ei_filtro' => 'extension_toba/componentes/admin_encuestas_ei_filtro.php',
		'admin_encuestas_ei_firma' => 'extension_toba/componentes/admin_encuestas_ei_firma.php',
		'admin_encuestas_ei_formulario' => 'extension_toba/componentes/admin_encuestas_ei_formulario.php',
		'admin_encuestas_ei_formulario_ml' => 'extension_toba/componentes/admin_encuestas_ei_formulario_ml.php',
		'admin_encuestas_ei_grafico' => 'extension_toba/componentes/admin_encuestas_ei_grafico.php',
		'admin_encuestas_ei_mapa' => 'extension_toba/componentes/admin_encuestas_ei_mapa.php',
		'admin_encuestas_servicio_web' => 'extension_toba/componentes/admin_encuestas_servicio_web.php',
		'admin_encuestas_comando' => 'extension_toba/admin_encuestas_comando.php',
		'admin_encuestas_modelo' => 'extension_toba/admin_encuestas_modelo.php',
	);
}
?>