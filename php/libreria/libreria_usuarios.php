<?php
//<label for="inputPassword" class="col-lg-2 control-label">Contraseña</label>
//http://localhost/toba_3.3/siu/manejador_salida_bootstrap/css/generic.css
  require_once('libreria/libreria.php');
  class libreria_usuarios {  
            
    static function get_programas_con_cuestionarios () {
        $where = array();
        $array_programas = libreria::get_programas_con_cuestionarios();
        //print_r( $array_programas);
        if ($array_programas){
            $cadena = '';
            foreach ($array_programas as $programas => $value) {
                $cadena .= "'".$value['cue_dependencia_programa']."',";
            }
            $cadena = substr($cadena,0,-1);
            $sql = "SELECT *
                    FROM ucm_programas
                    WHERE pro_codigo IN (".($cadena).");";
            if(count($where)>0) {
                $sql = sql_concatenar_where($sql, $where);
            }
            //print_r($sql);
            return toba::db('toba_usuarios')->consultar($sql);
        }
    }

    static function get_datos_programa ($filtro=null) {
        $where = array();
        if(isset($filtro['pro_codigo'])) {
            $where[] = "pro_codigo = ".quote("{$filtro['pro_codigo']}");
        }
        $sql = "SELECT *
                  FROM ucm_programas;";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        //print_r($sql);
        return toba::db('toba_usuarios')->consultar($sql);
    }

    static function get_datos_usuario ($filtro=null) {
        $where = array();
        if(isset($filtro['usuario'])) {
            $where[] = "usuario = ".quote("{$filtro['usuario']}");
        }
        $sql = "SELECT usuario, nombre, email, parametro_a, parametro_b, parametro_c, ciu, telefono
                  FROM apex_usuario;";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        //print_r($sql);
        return toba::db('toba_usuarios')->consultar($sql);
    }

    static function get_perfiles_toba_usuario ($filtro=null) {
        $where = array();
        if(isset($filtro['proyecto'])) {
            $where[] = "auga.proyecto = ".quote("{$filtro['proyecto']}");
        }
        if(isset($filtro['usuario'])) {
            $where[] = " aup.usuario = ".quote("{$filtro['usuario']}");
        }
        $sql = "SELECT auga.proyecto, auga.usuario_grupo_acc, nombre AS perfil
                  FROM apex_usuario_grupo_acc AS auga, apex_proyecto AS ap, apex_usuario_proyecto AS aup
                 WHERE (auga.proyecto = ap.proyecto AND auga.proyecto= aup.proyecto) AND (ap.proyecto = aup.proyecto) 
                   AND (aup.usuario_grupo_acc = auga.usuario_grupo_acc);";
        if(count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        //print_r($sql);
        return toba::db('toba_usuarios')->consultar($sql);
    }
 }
?>

