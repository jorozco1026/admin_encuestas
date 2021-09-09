<?php
  error_reporting(0);
  
  $respuestas_base = $_POST['base']; 
  $respuestas_horizontales = $_POST['respuestas_horizontales'];
  $respuestas_verticales   = $_POST['respuestas_verticales'];
  $respuestas_verticales_check   = $_POST['respuestas_verticales_check'];
  $respuestas_text_field   = $_POST['respuestas_text_field'];
  $respuestas_text_area    = $_POST['respuestas_text_area'];
  $respuestas_sugerencias  = $_POST['respuestas_sugerencias'];
  //traer usuario fuente programa facultad, para guardar
  $existe = set_actualizar_usuario_fuente($respuestas_base); //VALIDAR REPETIDOS
    if (! $existe[0]['encontrado']) {
    if ($respuestas_verticales)   set_valoracion_radios ($respuestas_base, $respuestas_verticales);
    if ($respuestas_verticales_check)   set_valoracion_check ($respuestas_base, $respuestas_verticales_check);
    if ($respuestas_horizontales) set_valoracion_tabla ($respuestas_base,  $respuestas_horizontales);
    if ($respuestas_text_field)   set_valoracion_text_field ($respuestas_base,  $respuestas_text_field);
    if ($respuestas_text_area)    set_valoracion_text_area ($respuestas_base,  $respuestas_text_area);
    if ($respuestas_sugerencias)  set_sugerencias ($respuestas_base,  $respuestas_sugerencias);
  }
  
  set_pantalla_salida($existe[0]);
  list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
  
  //buscar de la lista de los check el id de la respuesta a que pregunta pertenece y concatenar y guardar
  //no trae los datos de la pregunta, solo el id de la respuesta
  
    
  function set_sugerencias ($respuestas_base, $respuestas_sugerencias){
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
     $respuestas_sugerencias = quote($respuestas_sugerencias);
     foreach ($respuestas_sugerencias as $respuestas => $valor){
       if (strlen($valor) > 2){
        $sql = "INSERT INTO sugerencias (sug_programacion, sug_fuente, sug_usuario, sug_descripcion)
   					VALUES ($programacion, $fuente,'$usuario', $valor);";

        consultar_fuente($sql);
       }
     }
  }

  function set_valoracion_text_field ($respuestas_base, $respuestas_text_field){
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
     $respuestas_text_field = quote($respuestas_text_field);
     foreach ($respuestas_text_field as $respuestas => $valor){
       list($factor, $caracteristica, $indicador,  $pregunta, $vertical) = split('_',$respuestas);
       if (strlen($valor) > 2){
        $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				                    val_caracteristica, val_indicador, val_pregunta, val_vertical, val_escritos)
   				           VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                             $pregunta, $vertical, $valor);";
        consultar_fuente($sql);
       }
     }
  }

  function set_valoracion_text_area ($respuestas_base, $respuestas_text_area){
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
     $respuestas_text_area = quote($respuestas_text_area);
     foreach ($respuestas_text_area as $respuestas => $valor){
       list($factor, $caracteristica, $indicador,  $pregunta, $vertical) = split('_',$respuestas);
       if (strlen($valor) > 2){
        $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				            val_caracteristica, val_indicador, val_pregunta, val_vertical, val_escritos)
   					VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                    $pregunta, $vertical, $valor);";
         consultar_fuente($sql);
       }
     }
  }

  function set_valoracion_radios ($respuestas_base, $respuestas_verticales){
     //no importa la respuesta vertical, ya que se guarda es el valor de la respuesta ne la pregunta
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
     $respuestas_verticales = quote($respuestas_verticales);
     foreach ($respuestas_verticales as $respuestas => $valor){
       list($factor, $caracteristica, $indicador,  $pregunta) = split('_',$respuestas);
       $vertical = get_respuesta_vertical($factor,$caracteristica,$indicador,$fuente, $pregunta);
       $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				            val_caracteristica, val_indicador, val_pregunta, val_vertical, val_valor)
   					VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                    $pregunta, $vertical, $valor);";
        consultar_fuente($sql);
     }
  }

  function set_valoracion_check ($respuestas_base, $respuestas_verticales_check) {
     //buscar los items check de la pregunta para buscarlos, concateneralos y guardarlos una sola vez
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);     
     //$respuestas_verticales_check = quote($respuestas_verticales_check);
     $pregunta_anterior = 0; $cadena_seleccionados = null; 
     foreach ($respuestas_verticales_check as $respuestas => $valor) {
       $sw = 0; 
       //print_r($valor); echo "<br>";
       list($factor, $caracteristica, $indicador,  $pregunta, $respuesta, $seleccionado) = split('_',$valor);
       //$vertical = get_checks_pregunta ($factor, $caracteristica, $indicador, $fuente, $pregunta);       
       if ($cadena_seleccionados && ($pregunta  != $pregunta_anterior)) {
         $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				                    val_caracteristica, val_indicador, val_pregunta, val_vertical, val_escritos)
   				           VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                             $pregunta, $respuesta, '$cadena_seleccionados');";
         //echo "sql1 ".$sql;                     
         consultar_fuente($sql);
         $cadena_seleccionados = null; $sw = 1;
       }       
       $cadena_seleccionados .= $seleccionado.',';
       $pregunta_anterior = $pregunta;        
     }
     if (!$sw) {
       $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				                    val_caracteristica, val_indicador, val_pregunta, val_vertical, val_escritos)
   				           VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                             $pregunta, $respuesta, '$cadena_seleccionados');";
         //echo "sql2 ".$sql;                     
         consultar_fuente($sql);
     }
  }

  function set_valoracion_tabla ($respuestas_base, $respuestas_horizontales){
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);
     $respuestas_horizontales = quote($respuestas_horizontales);
     foreach ($respuestas_horizontales as $respuestas => $valor){
       list($factor, $caracteristica, $indicador,  $pregunta, $vertical) = split('_',$respuestas);
       $horizontal = get_respuesta_horizontal($factor,$caracteristica,$indicador,$fuente, $pregunta);
       $sql = "INSERT INTO valoracion (val_programacion, val_fuente, val_usuario, val_factor,
				            val_caracteristica, val_indicador, val_pregunta, val_vertical, val_horizontal, val_valor)
   					VALUES ($programacion, $fuente,'$usuario',$factor, $caracteristica, $indicador,
                            $pregunta, $vertical, $horizontal, $valor);";
        consultar_fuente($sql);
     }
  }

  function set_actualizar_usuario_fuente ($respuestas_base){
     list($programacion, $fuente, $usuario) = split('_',$respuestas_base);    
     $sql = "SELECT regeva_id, regeva_programacion, regeva_fuente, regeva_usuario
               FROM registro_evaluaciones
              WHERE regeva_programacion=$programacion
                AND regeva_fuente = $fuente
                AND regeva_usuario = '$usuario';";               
     $result = consultar_fuente($sql); 
     if (! $result) {
      $sql = "INSERT INTO 
                          registro_evaluaciones(regeva_programacion, regeva_fuente, regeva_usuario)      
                    VALUES ($programacion, $fuente, '$usuario');";               
      $result = consultar_fuente($sql);
      $secuencia = toba::db()->recuperar_secuencia('registro_evaluaciones_regeva_id_seq');
      $res[0]['encontrado'] = 0;
      $res[0]['secuencia'] = $secuencia;
     }
     else {
       $res[0]['encontrado'] = 1;
       $res[0]['secuencia'] = $result[0]['regeva_id'];
     } 
     return $res;
  }

  function get_respuesta_vertical($factor, $caracteristica, $indicador, $fuente, $pregunta){
     $sql = "SELECT DISTINCT rev_id
			         FROM respuestas_verticales
              WHERE rev_factor = $factor AND rev_caracteristica = $caracteristica
                AND rev_indicador = $indicador AND rev_fuente = $fuente 
                AND rev_pregunta  = $pregunta;";
     $res = consultar_fuente($sql);
     $res = current($res);
     return $res['rev_id'];
  }

  function get_checks_pregunta ($factor,$caracteristica,$indicador,$fuente, $pregunta){
     $sql = "SELECT respuestas_verticales.*
			         FROM respuestas_verticales
              WHERE rev_factor = $factor AND rev_caracteristica = $caracteristica
                AND rev_indicador = $indicador AND rev_fuente = $fuente 
                AND rev_pregunta  = $pregunta;";
     return consultar_fuente($sql);
  }

   function get_respuesta_horizontal($factor,$caracteristica,$indicador,$fuente, $pregunta){
     $sql = "SELECT reh_id
			   FROM respuestas_horizontales
              WHERE reh_factor = $factor AND reh_caracteristica = $caracteristica
                AND reh_indicador = $indicador AND reh_fuente = $fuente 
                AND reh_pregunta = $pregunta;";
     $res = consultar_fuente($sql);
     $res = current($res);
     return $res['reh_id'];
  }

  function set_pantalla_salida ($existe) { 
     echo "<P><BR><BR><BR><TABLE BORDER='1' WIDTH='80%'><tr><td align='center'>";
     echo toba_recurso::imagen_proyecto("logo_percepcion.png",true);
      echo "<tr><td>";
      echo("<b><CENTER><font color='white'>SU ENCUESTA HA SIDO REGISTRADA SATISFACTORIAMENTE <br> Y SERA TENIDA EN CUENTA PARA LOS PLANES DE MEJORAMIENTO
           <BR><BR> GRACIAS POR SU COLABORACI&Oacute;N");
      echo "<tr><td>";
      echo "<b><CENTER><font color='white'><H1>NRO. DE APROBACI&Oacute;N
                <BR><BR>".$existe['secuencia']."</H1>";
	  echo "<tr><td  bgcolor='#FFFFFF'  bgcolor='#CCCCCC'><div align='center'>";
	  echo "<center><div align='center' class='Contenido_TXT'><FONT COLOR='blue'><b>&copy;   Universidad Cat&oacute;lica de Manizales UCM <br />
	        carrera 23 n&uacute;mero 60-63 // tel&eacute;fonos   (57) +6 8782900 // fax (57) +6 8782950 // apartado a&eacute;reo 357<br />
	        Manizales -   Caldas - Colombia</div>";
	  echo "</div></td>";
    echo "</table>";
    session_destroy();
  }
?>
