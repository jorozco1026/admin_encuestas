<?php
error_reporting(0);
//header('Content-type: text/html; charset=UTF-8') ;
class combos_parametros {   
   function get_programacion_encuestadas ()	{
      $where = array();
      $where[] = "prg_id IN (SELECT val_programacion FROM valoracion)";
      $sql = "  SELECT *
                  FROM programacion
              ORDER BY prg_id DESC;";
      if(count($where)>0) {
         $sql = sql_concatenar_where($sql, $where);
      }          
     $datos = consultar_fuente($sql);         
     return $datos;
  }
  
  function get_fuentes_en_valoracion ($valoracion)	{
          $where = array();
          if($valoracion) {
            $where[] = "fue_id IN (SELECT val_fuente FROM valoracion WHERE val_programacion = ".quote("{$valoracion}").")";
          }
          $sql = "  SELECT *
                      FROM fuentes
                  ORDER BY fue_descripcion;";
          if(count($where)>0) {
             $sql = sql_concatenar_where($sql, $where);
          }          
         $datos = consultar_fuente($sql);         
         return $datos;
   }


  function get_fuentes_valoracion ($filtro=null)	{
          $where = array();
          if(isset($filtro['val_programacion'])) {
            $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
          }
          $where[] = "val_fuente IS NOT NULL ";
          $where[] = "val_valor > 0 AND val_valor is not null";
          $sql = "  SELECT DISTINCT fue_id, fue_descripcion
                      FROM fuentes, valoracion
                     WHERE val_fuente = fue_id ORDER BY fue_descripcion;";
          if(count($where)>0) {
             $sql = sql_concatenar_where($sql, $where);
          }          
         $datos = consultar_fuente($sql);         
         return $datos;
    }

  function get_facultades_valoracion ($filtro=null)	{
          $where = array();
          if(isset($filtro['val_programacion'])) {
            $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
          }
          $where[] = "val_facultad IS NOT NULL ";
          $where[] = "val_valor > 0 AND val_valor is not null";
          $sql = "  SELECT DISTINCT val_facultad
                      FROM valoracion;";
          if(count($where)>0) {
             $sql = sql_concatenar_where($sql, $where);
          }
          //print_r($sql);
         $datos = consultar_fuente($sql);
         
         $i=0;
         foreach ($datos as $facultades){
            foreach ($facultades as $facultade => $value){
              if ($facultade == 'val_facultad') $facultad_codigo = $value;
            }
            $filtro_facultad['fac_codigo'] = $facultades['val_facultad'];
            $datos_facultad = combos_parametros::get_nombre_facultad($filtro_facultad);
            $datos[$i]['facultad_nombre'] = $datos_facultad[0]['fac_nombre'];
            $i++;
         }//fin de factores
         $datos = rs_ordenar_por_columna ($datos, 'facultad_nombre');
         return $datos;
    }

  function get_programas_valoracion ($filtro=null)	{
          $where = array();
          if(isset($filtro['val_programacion'])) {
            $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
          }
          $where[] = "val_programa IS NOT NULL ";
          $where[] = "val_valor > 0 AND val_valor is not null";
          $sql = "  SELECT DISTINCT val_programa
                      FROM valoracion;";
          if(count($where)>0) {
             $sql = sql_concatenar_where($sql, $where);
          }
          //print_r($sql);
         $datos = consultar_fuente($sql);
         
         $i=0;
         foreach ($datos as $programas){
            foreach ($programas as $programa => $value){
              if ($programa == 'val_programa') $programa_codigo = $value;
            }
            $filtro_programa['pro_codigo'] = $programas['val_programa'];
            $datos_programa = combos_parametros::get_nombre_programa($filtro_programa);
            $datos[$i]['programa_nombre'] = $datos_programa[0]['pro_nombre'];
            $i++;
         }//fin de factores
         $datos = rs_ordenar_por_columna ($datos, 'programa_nombre');
         return $datos;
    }

  function get_fuentes_por_factor($filtro=null)	{
    $where = array();
		if(isset($filtro['val_programacion'])) {
   		   $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
        }
        if(isset($filtro['val_factor'])) {
   		   $where[] = "val_factor = ".quote("{$filtro['val_factor']}");
        }
        $where[] = "val_programa is not null";
        $where[] = "val_valor >= 0 AND val_valor is not null";
        $sql = "  SELECT DISTINCT val_programacion, val_factor,
                         val_fuente, fue_descripcion
                    FROM valoracion, fuentes
                   WHERE val_fuente = fue_id
                ORDER BY fue_descripcion;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
       $datos = consultar_fuente($sql);
       $i=0; $cadena = null;
       foreach ($datos as $fuentes){
          foreach ($fuentes as $fuente => $value){
            if ($fuente == 'fue_descripcion') $fuente_descripcion = $value;
          }
          $cadena .= $fuente_descripcion.', ';
       }
       return $cadena;
  }

  function get_fuentes_participantes ($filtro=null)	{
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
          $where[] = "val_programa is not null";
          $where[] = "val_valor >= 0 AND val_valor is not null";
          $sql = "  SELECT DISTINCT val_programacion, val_factor,
                           val_fuente, fue_descripcion
                      FROM valoracion, fuentes
                     WHERE val_fuente = fue_id
                  ORDER BY fue_descripcion;";
          if(count($where)>0) {
                 $sql = sql_concatenar_where($sql, $where);
          }
         $datos = consultar_fuente($sql);
         $i=0; $cadena = null;
         foreach ($datos as $fuentes){
            foreach ($fuentes as $fuente => $value){
              if ($fuente == 'fue_descripcion') $fuente_descripcion = $value;
            }
            $cadena .= $fuente_descripcion.', ';
         }
         return $cadena;
    }

    function get_programacion_autoevaluacion_institucional () {
       $sql = "SELECT * FROM programacion
             ORDER BY prg_id DESC;";
       return consultar_fuente($sql);
    }

    function get_programacion_acreditacion () {
       $sql = "SELECT * FROM programacion
             ORDER BY prg_id DESC;";
       return consultar_fuente($sql);
    }

    function get_programacion_id ($programacion) {
       $sql = "SELECT * FROM programacion
                WHERE prg_id = {$programacion}
             ORDER BY prg_id DESC;";
       return consultar_fuente($sql);
    }

    function get_requerimientos ()    {
        $sql = "SELECT *
                  FROM requerimientos_sistema;";
        return toba::db()->consultar($sql);
    }

    function get_datos_iniciales ($programa, $fuente, $usuario, $sw_revision){
       $datos_usuario = array();
       if ($usuario){
       $sql = "SELECT pro_nombre, usu_nombres
                 FROM usuario_fuentes, usuarios, programas
                WHERE (usufue_usuario = usu_identificacion
                             AND usufue_programa = pro_id)
                             AND usu_identificacion = '$usuario'
                             AND usufue_programa = $programa LIMIT 1;";
        return consultar_fuente($sql);
        }
    }

    function get_nombre_fuente ($fuente){
       $sql = "SELECT fue_descripcion
                 FROM fuentes
                WHERE fue_id = $fuente;";
       $res =  consultar_fuente($sql);
       $res = current($res);
       return $res['fue_descripcion'];
    }

    function get_datos_programacion ($programa) {
       $sql = "SELECT * FROM programacion;";
       return consultar_fuente($sql);
    }

    function set_mensaje_final_enviar (){
      //al final las sugerencias
      echo "<center><table><TR><td><TD colspan='10'><center><font color='green'><h2>"."Sugerencias";
      echo "<tr><td><Td colspan = '10'><TEXTAREA name = respuestas_sugerencias['txtSugerencia'] rows='5' cols='150'></TEXTAREA>";

      echo "<tr><td><Td colspan = '10'>";
      $src = toba_recurso::url_proyecto($proyecto) . "/img/" . 'enviar.png';
      echo "<BR><BR><center><table border='0' cellpadding='0' cellspacing='0' width='726'>";
      echo "<tr>";
      echo "<td   align='center' valign='middle'><center><a href='javascript: validar();'><img src='$src'></a></td>";
      //echo "<td   align='center' valign='middle'><INPUT TYPE = 'submit'><center></td>";
      echo "</tr></table>";

      echo "<BR><center><tABLE><tr><TD>";
      echo "<td  bgcolor='#FFFFFF'  bgcolor='#CCCCCC'><div align='center'>";
      echo "<center><div align='center' class='Contenido_TXT'>&copy;   Universidad Cat&oacute;lica de Manizales UCM <br />
            carrera 23 n&uacute;mero 60-63 // tel&eacute;fonos   (57) +6 8782900 // fax (57) +6 8782950 // apartado a&eacute;reo 357<br />
            Manizales -   Caldas - Colombia</div>";
      echo "</div></td>";
      echo "</tr>";
      echo "</table>";
 }

 function set_mensaje_final_no_enviar (){
      //al final las sugerencias
      echo "<center><table><TR><td><TD colspan='10'><center><font color='green'><h2>"."Sugerencias";
      echo "<tr><td><Td colspan = '10'><TEXTAREA name = respuestas_sugerencias['txtSugerencia'] rows='5' cols='150'></TEXTAREA>";

      echo "<tr><td><Td colspan = '10'>";
      $src = toba_recurso::url_proyecto($proyecto) . "/img/" . 'enviar.png';
      echo "<BR><BR><center><table border='0' cellpadding='0' cellspacing='0' width='726'>";
      echo "<tr>";
      echo "<td   align='center' valign='middle'><center><a href='javascript: no_enviar();'><img src='$src'></a></td>";
      //echo "<td   align='center' valign='middle'><INPUT TYPE = 'submit'><center></td>";
      echo "</tr></table>";

      echo "<BR><center><TABLE><TR><TD>";
      echo "<td  ><div align='center'>";
      echo "<center><div align='center' class='Contenido_TXT'>&copy;   Universidad Cat&oacute;lica de Manizales UCM <br />
            carrera 23 n&uacute;mero 60-63 // tel&eacute;fonos   (57) +6 8782900 // fax (57) +6 8782950 // apartado a&eacute;reo 357<br />
            Manizales -   Caldas - Colombia<br>Desarrollado por Jhon Jairo Orozco D. Ing. - jorozco@ucm.edu.co</div>";
      echo "</div></td>";
      echo "</tr>";
      echo "</table>";
 }

 function get_mensaje_inicial ($fuente){
    $mensaje_estudiantes = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones de los ESTUDIANTES acerca de los distintos aspectos de la vida Institucional y del programa del cual
          Usted hace parte. Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          Su informaci�n nos permitir� comprender la realidad del programa desde las necesidades e inquietudes del estamento
          estudiantil.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";

    $mensaje_empleadores = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones de los EMPLEADORES acerca de los distintos aspectos de la vida Institucional y del programa a evaluar.
          Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";

    $mensaje_docentes = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones de los DOCENTES acerca de los distintos aspectos de la vida Institucional y del programa del cual
          Usted hace parte. Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          Su informaci�n nos permitir� comprender la realidad del programa desde las necesidades e inquietudes del estamento
          Docente.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";

     $mensaje_directivas = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones de las DIRECTIVAS acerca de los distintos aspectos de la vida Institucional y de los diferentes pregrados que la conforman.
          Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          Su informaci�n nos permitir� comprender realidades que sirvan de base en procesos de mejora continua.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";

      $mensaje_administrativos = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones del PERSONAL ADMINISTRATIVO acerca de los distintos aspectos de la vida Institucional y del programa del cual
          Usted hace parte. Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          Su informaci�n nos permitir� comprender la realidad del programa desde su perspectiva.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";

       $mensaje_egresados = "Para el proceso de Autoevaluaci�n Institucional que viene realizando la Universidad, es de vital importancia conocer
          las apreciaciones de los EGRESADOS acerca de los distintos aspectos de la vida Institucional y del programa del cual
          cual Usted hizo parte. Con este prop�sito se ha dise�ado la siguiente encuesta.
          <br><br>
          Su informaci�n nos permitir� comprender la realidad del programa a trav�s del desempe�o laboral y el impacto
          del EgresadO de la UCM.
          <br><br>
          La informaci�n proporcionada ser� tratada de manera confidencial.";
       switch ($fuente){
          case 3: return $mensaje_estudiantes; break;
          case 4: return $mensaje_empleadores; break;
          case 5: return $mensaje_docentes; break;
          case 6: return $mensaje_directivas; break;
          case 7: return $mensaje_administrativos; break;
          case 8: return $mensaje_egresados; break;
       }
    }

    function get_factores_fuente ($filtro){
        $where = array();
        if(isset($filtro['fue_id'])) {
              $where[] = "pre_fuente = ".quote("{$filtro['fue_id']}");
        }
        $sql = "SELECT DISTINCT fac_id, fac_codigo, fac_descripcion
                          FROM factores, preguntas, indicadores
                         WHERE pre_indicador      = ind_id
                           AND pre_factor         = fac_id
                           AND fac_vigente        = TRUE
                           AND pre_vigente        = TRUE
                      ORDER BY fac_codigo;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        } //print_r($sql);
        return consultar_fuente($sql);
    }

    function get_caracteristicas_fuente ($filtro){
        $where = array();
        if(isset($filtro['fue_id'])) {
              $where[] = "pre_fuente = ".quote("{$filtro['fue_id']}");
        }
        if(isset($filtro['fac_id'])) {
              $where[] = "pre_factor = ".quote("{$filtro['fac_id']}");
        }
        $sql = "SELECT DISTINCT car_id, car_codigo, car_descripcion
                          FROM caracteristicas, preguntas, indicadores
                         WHERE pre_indicador      = ind_id
                           AND pre_caracteristica = car_id
                           AND car_vigente = true
                           AND pre_vigente = true
                      ORDER BY car_codigo;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
       return  consultar_fuente($sql);
    }

    function get_indicadores_fuente ($filtro){
        $where = array();
        if(isset($filtro['fue_id'])) {
              $where[] = "pre_fuente = ".quote("{$filtro['fue_id']}");
        }
        if(isset($filtro['fac_id'])) {
              $where[] = "pre_factor = ".quote("{$filtro['fac_id']}");
        }
        if(isset($filtro['car_id'])) {
              $where[] = "pre_caracteristica = ".quote("{$filtro['car_id']}");
        }
        $sql = "SELECT DISTINCT ind_id, ind_codigo, ind_descripcion
                           FROM preguntas, indicadores
                          WHERE pre_indicador      = ind_id
                            AND ind_vigente = true
                            AND pre_vigente = true
                       ORDER BY ind_codigo;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
       return  consultar_fuente($sql);
    }

    function get_respuestas_pregunta_fuente ($filtro){
       $where = array();
        if(isset($filtro['fue_id'])) {
              $where[] = "pre_fuente = ".quote("{$filtro['fue_id']}");
        }
        if(isset($filtro['ind_id'])) {
              $where[] = "pre_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pro_id'])) {
              $programa = $filtro['pro_id'];
        }
        if(isset($filtro['pre_id'])) {
              $where[] = "pre_id = ".quote("{$filtro['pre_id']}");
        }
        if(isset($filtro['rev_orden'])) {
              $where[] = "rev_orden = ".quote("{$filtro['rev_orden']}");
        }
        $sql = "SELECT pre_id, pre_numeracion, pre_pre_enunciado, pre_enunciado,
                       pre_pos_enunciado, pre_factor, pre_caracteristica, pre_indicador,
                       pre_fuente, pre_tipo_pregunta, pre_obligada, pre_vigente, pre_orden, pre_columnas,
                       ind_descripcion,
                       rev_id, rev_enunciado, rev_orden
                  FROM preguntas, indicadores, respuestas_verticales
                 WHERE pre_indicador      = ind_id
                   AND rev_pregunta       = pre_id
                   AND pre_vigente        = true
                   AND pre_id IN (SELECT rev_pregunta FROM respuestas_verticales
                                           WHERE (rev_siguiente = $programa OR rev_siguiente IS NULL))
              ORDER BY pre_indicador, pre_orden, pre_id, rev_id, rev_orden;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
        //print_r($sql);
        return  consultar_fuente($sql);
    }

    function get_preguntas_fuente ($filtro){
       $where = array();
        if(isset($filtro['fue_id'])) {
              $where[] = "pre_fuente = ".quote("{$filtro['fue_id']}");
        }
        if(isset($filtro['ind_id'])) {
              $where[] = "pre_indicador = ".quote("{$filtro['ind_id']}");
        }
        if(isset($filtro['pro_id'])) {
              $programa = $filtro['pro_id'];
        }
        if(isset($filtro['pre_id'])) {
              $where[] = "pre_id = ".quote("{$filtro['pre_id']}");
        }
        $sql = "SELECT pre_id, pre_numeracion, pre_pre_enunciado, pre_enunciado,
                       pre_pos_enunciado, pre_indicador,
                       pre_fuente, pre_tipo_pregunta, pre_obligada, pre_vigente, pre_orden, pre_columnas,
                       ind_descripcion
                  FROM preguntas, indicadores
                 WHERE pre_indicador      = ind_id
                   AND pre_vigente        = true
                   AND pre_id IN (SELECT rev_pregunta FROM respuestas_verticales
                                           WHERE (rev_siguiente = $programa OR rev_siguiente IS NULL))
              ORDER BY pre_indicador, pre_orden;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    function get_respuestas_text_field ($filtro){
        $where = array();
        if(isset($filtro['pre_id'])) {
              $where[] = "rtf_pregunta = ".quote("{$filtro['pre_id']}");
        }
        $sql = "SELECT  rtf_id, rtf_indicador, rtf_fuente,
                       rtf_pregunta, rtf_enunciado, rtf_pos_enunciado, rtf_orden, rtf_numeracion,
                       rtf_valor, rtf_ancho, rtf_vigente
                 FROM  respuestas_text_field
                WHERE  rtf_vigente = TRUE;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    function get_respuestas_text_area ($filtro){
        $where = array();
        if(isset($filtro['pre_id'])) {
              $where[] = "rta_pregunta = ".quote("{$filtro['pre_id']}");
        }
        $sql = "SELECT  rta_id, rta_indicador, rta_fuente,
                       rta_pregunta, rta_enunciado, rta_pos_enunciado, rta_orden, rta_numeracion,
                       rta_valor, rta_ancho, rta_alto, rta_vigente
                  FROM respuestas_text_area
                 WHERE rta_vigente = TRUE;";
        if(count($where)>0) {
           $sql = sql_concatenar_where($sql, $where);
        }
        return  consultar_fuente($sql);
    }

    function get_respuestas_verticales ($filtro) {
        $where = array();
        if(isset($filtro['pre_id'])) {
              $where[] = "rev_pregunta = ".quote("{$filtro['pre_id']}");
        }
        $sql = "SELECT rev_id, rev_indicador, rev_fuente,
                      rev_pregunta, rev_enunciado, rev_pos_enunciado, rev_orden, rev_numeracion,
                      rev_valor, rev_siguiente, rev_vigente
                 FROM respuestas_verticales
                WHERE rev_vigente = TRUE
                ORDER BY rev_orden;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
       return  consultar_fuente($sql);
    }

    function get_respuestas_horizontales ($filtro){
       $where = array();
       if(isset($filtro['pre_id'])) {
   		   $where[] = "reh_pregunta = ".quote("{$filtro['pre_id']}");
        }
        $sql = "SELECT reh_id, reh_indicador, reh_fuente,
                      reh_pregunta, reh_enunciado, reh_pos_enunciado, reh_orden, reh_numeracion,
                      reh_valor, reh_siguiente, reh_vigente
                 FROM respuestas_horizontales
                WHERE reh_vigente = TRUE
             ORDER BY reh_orden;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
       return  consultar_fuente($sql);
    }


  static function get_factores_tipo_programa($tipo_programa)    {
        $sql = "SELECT fac_id, ('[' || fac_codigo || ']' || fac_descripcion) AS fac_descripcion
                  FROM factores
                 WHERE fac_id IN (SELECT car_factor FROM caracteristicas WHERE car_tipo_programa = {$tipo_programa})
              ORDER BY fac_id;";

        return consultar_fuente($sql);
  }

  static function get_factores_programacion_programa($programacion)    {
        $sql = "SELECT fac_id, ('[' || fac_codigo || ']' || fac_descripcion) AS fac_descripcion
                  FROM factores
                 WHERE fac_id IN (SELECT val_factor
                  FROM valoracion WHERE val_programacion = {$programacion})
              ORDER BY fac_id;";
            //print_r($sql);
        return consultar_fuente($sql);
  }

  static function get_fuentes_con_preguntas($filtro=null) {
        $where = array();
        if(isset($filtro['fue_id'])) {
   		   $where[] = "fue_id = ".quote("{$filtro['fue_id']}");
        }
        if(isset($filtro['fue_vigente'])) {
   		   $where[] = "fue_vigente = ".quote("{$filtro['fue_vigente']}");
        }
        $sql = "SELECT DISTINCT fue_id, fue_descripcion, (fue_id) AS acceso_id
                  FROM preguntas, indicadores, fuentes
                 WHERE pre_indicador   = ind_id
                   AND pre_fuente      = fue_id
              ORDER BY fue_descripcion;";
        if(count($where)>0) {
		   $sql = sql_concatenar_where($sql, $where);
        }
        return consultar_fuente($sql);
	}

  function get_fuentes_instrumento($instrumento)    {
     if ($instrumento == 1){
        $sql = "  SELECT fue_id, fue_descripcion, fue_vigente
                  FROM fuentes
                  WHERE fue_id <> 9
               ORDER BY fue_descripcion;";
     }
     elseif ($instrumento == 2){
         $sql = "  SELECT fue_id, fue_descripcion, fue_vigente
                     FROM fuentes
                 WHERE fue_id = 9
               ORDER BY fue_descripcion;";
     }
     else{
         $sql = "  SELECT fue_id, fue_descripcion, fue_vigente
                     FROM fuentes
                 ORDER BY fue_descripcion;";
     }
     return consultar_fuente($sql);
   }

  function get_rango_metas($rango)    {
     if ($rango){
        $sql = "  SELECT rgm_id, rgm_descripcion, rgm_vigente
                    FROM rango_metas WHERE rgm_id = $rango;";

       $res = consultar_fuente($sql);
       $res = current($res);
       if ($res) return $res['rgm_descripcion'];
       return '';
     }
     else return 'SIN PROPUESTA';
   }

   static function get_abreviatura_programas_facultad($facultad)	{
		$sql = "SELECT pro_abreviatura, pro_nombre
                  FROM programas
                 WHERE pro_facultad = $facultad AND pro_vigente = TRUE
                  ORDER BY pro_nombre;";

        return consultar_fuente($sql);
   }

  static function get_programas_facultad($facultad)	{
		$sql = "SELECT pro_id, pro_nombre, pro_vigente
                  FROM programas
                 WHERE pro_facultad = $facultad AND pro_vigente = TRUE
                  ORDER BY pro_nombre;";
        $sql = toba::perfil_de_datos()->filtrar($sql);
        return consultar_fuente($sql);
   }

   static function get_datos_programa ($programa)	{
		$sql = "SELECT *
                  FROM programas
                 WHERE pro_id = {$programa};";
     //$sql = toba::perfil_de_datos()->filtrar($sql);
        return consultar_fuente($sql);
   }

   static function get_datos_instrumento ($instrumento)	{
		$sql = "SELECT *
                  FROM instrumentos
                 WHERE ins_id = {$instrumento};";
   //$sql = toba::perfil_de_datos()->filtrar($sql);
        return consultar_fuente($sql);
   }

  static function get_programas_programados($programacion)	{
		$sql = "SELECT DISTINCT valoracion.*
                  FROM valoracion
                 WHERE val_programacion = $programacion
                  ORDER BY val_programa;";
        return consultar_fuente($sql);
   }

  static function get_indicadores_caracteristica($caracteristica){
     $sql = "SELECT count(*) AS cantidad
			   FROM indicadores
			  WHERE ind_caracteristica = $caracteristica
			    AND ind_vigente = true;";
      $res = toba::db()->consultar($sql);
      $res = current($res);
      return $res['cantidad'];
  }
  static function get_cantidad_indicadores_caracteristica($caracteristica)	{
     $sql = "SELECT count(*) AS cantidad
			   FROM indicadores
			  WHERE ind_caracteristica = $caracteristica
			    AND ind_vigente = true;";
      $res = toba::db()->consultar($sql);
      $res = current($res);
      return $res['cantidad'];
  }
  static function get_caracteristicas_factor($factor)	{
     $sql = "SELECT *, ('[' || car_codigo || '] ' || car_descripcion) AS car_codigo_descripcion
               FROM caracteristicas
              WHERE car_factor = $factor
                AND car_vigente = true
           ORDER BY car_codigo ASC;";
     return toba::db()->consultar($sql);
  }

  static function get_ponderacion_factor($factor)	{
     $sql = "SELECT avg(car_ponderacion) AS promedio
               FROM caracteristicas
              WHERE car_factor = $factor
                AND car_vigente = true;";
     $res = toba::db()->consultar($sql);
     $res = current($res);
     return $res['promedio'];
  }
/*
  //USUARIOS PARA AUTO-INSTITUCIONAL
  static function get_usuarios_vinculados_proyecto ($filtro=null )
  {
        $proyecto = 'sisalertas';        
        $proyecto = quote($proyecto);
        $where = "WHERE   g.usuario_grupo_acc = up.usuario_grupo_acc
                          AND	g.proyecto = up.proyecto
                          AND	u.usuario = up.usuario
                          AND	up.proyecto = $proyecto
                          AND	(up.usuario_grupo_acc <> 'admin' AND up.usuario_grupo_acc <> 'consultas') ";

        $condiciones = array();
        if (isset($filtro)) {
              if (isset($filtro['nombre'])) {
                    $quote = quote("%{$filtro['nombre']}%");
                    $condiciones[] = "(u.nombre ILIKE $quote)";
              }
              if (isset($filtro['usuario'])) {
                    $quote = quote("{$filtro['usuario']}");
                    $condiciones[] = "(u.usuario = $quote)";
              }
              if (isset($filtro['fuente'])) {
                    $quote = quote("{$filtro['fuente']}");
                    $condiciones[] = "(g.usuario_grupo_acc = $quote)";
              }
        }
        if ($condiciones) {
              $where .= ' AND ' . implode(' AND ', $condiciones);
        }
        $sql = "SELECT 	up.proyecto as proyecto,
                                up.usuario as usuario, 
                                u.nombre as nombre,
                                g.nombre as grupo_acceso,
                                g.usuario_grupo_acc as acceso_id 
                    FROM 	apex_usuario u,
                                apex_usuario_proyecto up,
                                apex_usuario_grupo_acc g
                                $where
                    ORDER BY usuario"; 
        //$sql = utf8_decode($sql);  
        //$sql = utf8_decode($sql);  
        //$sql = htmlentities($sql, ENT_QUOTES, 'UTF-8');
        $datos = toba::db('toba_usuarios')->consultar($sql);                    
        
        //$datos = toba::db('toba_usuarios')->consultar(htmlentities($sql, ENT_QUOTES, 'UTF-8'));           
        //$datos = toba::db('toba_usuarios')->consultar($sql);
        //htmlentities($var, ENT_QUOTES, 'UTF-8');
        $temp = array();
        foreach ($datos as $dato) {
              $temp[$dato['usuario']]['proyecto'] = $dato['proyecto'];
              $temp[$dato['usuario']]['usuario'] = $dato['usuario'];
              $temp[$dato['usuario']]['nombre'] = utf8_decode($dato['nombre']);
              $temp[$dato['usuario']]['acceso_id'] = $dato['acceso_id'];
              if (isset($temp[$dato['usuario']]['grupo_acceso'])) {
                    $temp[$dato['usuario']]['grupo_acceso'] .= ', ' . $dato['grupo_acceso'];
              } else {
                    $temp[$dato['usuario']]['grupo_acceso'] = $dato['grupo_acceso'];
              }
        }
        return (array_values($temp));
  } 

  function get_nombre_facultad ($filtro=null)	{
      $where = array();
      if(isset($filtro['fac_codigo'])) {
         $where[] = "fac_codigo = ".quote("{$filtro['fac_codigo']}");
      }
      $sql = "SELECT *
                FROM ucm_facultades";
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      return toba::db('toba_usuarios')->consultar($sql);
  }  

  function get_nombre_programa ($filtro=null)	{
      $where = array();
      if(isset($filtro['pro_codigo'])) {
         $where[] = "pro_codigo = ".quote("{$filtro['pro_codigo']}");
      }
      $sql = "SELECT *
                FROM ucm_programas";
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      } //print_r($sql);
      return toba::db('toba_usuarios')->consultar($sql);
  }*/

  function get_completar_estado ($res_evaluadores, $filtro=null)	{
      $where = array();
      if(isset($filtro['prg_id'])) {
         $where[] = "prg_id = ".quote("{$filtro['prg_id']}");
      }
      $sql ="SELECT * FROM programacion";
      if(count($where)>0) {
        $sql = sql_concatenar_where($sql, $where);
      }
      $res_programaciones = consultar_fuente($sql);

      $fila=0;
      foreach ($res_programaciones as $programaciones){
          foreach ($programaciones as $programacion => $value){
              if ($programacion == 'prg_id') $programacion_id = $value;
          }           
          $filtro['programacion'] = $programacion_id;
          foreach ($res_evaluadores as $evaluadores){
              foreach ($evaluadores as $evaluador => $value_evaluador){
                  if ($evaluador == 'usuario') $evaluador_id = $value_evaluador;
              }
              $res_evaluadores[$fila]['prg_id']     = $programaciones['prg_id'];
              $res_evaluadores[$fila]['prg_nombre'] = $programaciones['prg_nombre'];
              $res_evaluadores[$fila]['estado']     = 0;   
              $filtro['val_programacion'] = $programacion_id;
              $filtro['val_usuario']      = $evaluadores['usuario'];
              $filtro['val_fuente']       = $evaluadores['acceso_id'];                  
              $valoraciones_usuario = combos_parametros::get_valoracion_usuario($filtro);
              $datos_registro = combos_parametros::get_datos_registro($filtro);
              $res_evaluadores[$fila]['aprobacion'] = null;
              $res_evaluadores[$fila]['fecha']      = null;
              if ($valoraciones_usuario) {
                  $res_evaluadores[$fila]['estado'] = 1;
                  $res_evaluadores[$fila]['aprobacion'] = $datos_registro[0]['regeva_id'];
                  $res_evaluadores[$fila]['fecha'] = $datos_registro[0]['regeva_fecha'];
              }
              $fila++;
          }
      }        
      return $res_evaluadores;
  }

  function get_valoracion_usuario ($filtro=null) {
      if(isset($filtro['val_programacion'])) {
          $where[] = "val_programacion = ".quote("{$filtro['val_programacion']}");
      }
      if(isset($filtro['val_usuario'])) {
          $where[] = "val_usuario = ".quote("{$filtro['val_usuario']}");
      }
      if(isset($filtro['val_fuente'])) {
          $where[] = "val_fuente = ".quote("{$filtro['val_fuente']}");
      }        
      $sql ="SELECT DISTINCT val_programacion,val_usuario,val_fuente
               FROM valoracion;";
      if(count($where)>0) {
         $sql = sql_concatenar_where($sql, $where);
      }  
      $datos = consultar_fuente($sql);     
      return $datos;  
  }

  function get_datos_registro ($filtro=null) {
      if(isset($filtro['val_programacion'])) {
          $where[] = "regeva_programacion = ".quote("{$filtro['val_programacion']}");
      }
      if(isset($filtro['val_usuario'])) {
          $where[] = "regeva_usuario = ".quote("{$filtro['val_usuario']}");
      }
      if(isset($filtro['val_fuente'])) {
          $where[] = "regeva_fuente = ".quote("{$filtro['val_fuente']}");
      }        
      $sql ="SELECT *
               FROM registro_evaluaciones;";
      if(count($where)>0) {
         $sql = sql_concatenar_where($sql, $where);
      }  
      $datos = consultar_fuente($sql);     
      return $datos;  
  }

}
?>
