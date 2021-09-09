<?php
  require_once('libreria/combos_parametros.php');
  $programa_filtro = toba::memoria()->get_dato_instancia('programa_filtro');
  //print_r($programa_filtro);
  $parametros = toba::memoria()->get_parametros();
  $fuente   = $parametros['usufue_fuente'];
  $programa = $parametros['usufue_programa'];
  $usuario  = $parametros['usufue_usuario'];
  if (! $parametros['usufue_programa']) $programa = 0;
  //if (! $programa)  $programa = $programa_filtro['pro_id'];
  $datos_programa  = combos_parametros::get_datos_programa($programa);
  $nombre_programa = $datos_programa[0]['pro_nombre'];
  $tipo_programa   = $datos_programa[0]['pro_tipo_programa'];

  $es_obligada = true;
  $encuesta_acreditacion = 1; $encuesta_institucional = 2;
  $datos_programacion = combos_parametros::get_datos_programacion ($programa); // echo "PROGRAMACION ".$programacion;
  $instrumento  = $datos_programacion[0]['prg_instrumento'];
  $programacion = $datos_programacion[0]['prg_id'];
  if (! $instrumento ) $instrumento = $programa_filtro['ins_id'];
  $base = $programacion.'_'.$programa.'_'.$fuente.'_'.$usuario.'_'.$instrumento.'_'.$tipo_programa;

  if (! $fuente) {
    $fuente = $parametros['fue_id']; $sw_revision = true;
  }
  else $sw_revision = false;


  echo "<TABLE BGCOLOR='#A9D0F5'><TR><TD>";
  $filtro_inicial[''] = $programa;
  $filtro_inicial[''] = $fuente;
  $filtro_inicial[''] = $usuario;
  $filtro_inicial[''] = $sw_revision;

  $datos_usuario = combos_parametros::get_datos_iniciales ($programa, $fuente, $usuario, $sw_revision);
  $nombre_fuente = combos_parametros::get_nombre_fuente ($fuente);

  $url = toba::vinculador()->get_url('encuestas','4887');
  echo "<FORM name='frm' ACTION='$url' method='POST'>";
    echo "<INPUT TYPE = 'hidden' name='base' value = $base>";
    //traemos solamente los factores que tengan preguntas de esa fuente
    $mensaje_inicial = combos_parametros::get_mensaje_inicial ($fuente);
    $filtro_factores['tippro_id'] = $tipo_programa;
    $filtro_factores['fue_id']    = $fuente;
    $filtro_factores['ins_id']    = $instrumento;
    $datos_factores = combos_parametros::get_factores_fuente ($filtro_factores);
     echo "<P><center><TABLE BORDER='0' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'>
          <b><strong>UNIVERSIDAD CATÓLICA DE MANIZALES<br>DIRECCIÓN DE PLANEACIÓN - DIRECCIÓN DE ASEGURAMIENTO DE LA CALIDAD
          </b></font></CAPTION>
          <tr><td><td colspan = 10 align='center'>"; echo toba_recurso::imagen_proyecto("logo_encuestas.png",true);
    echo "<tr><td><td colspan = 10 align='left'><h3>".$mensaje_inicial;
    echo "</table></P><BR>";
    $pregrado = 1; $postgrado = 2;
    if ($tipo_programa == $pregrado) {
      switch ($fuente) {
        case 4:  $datos_empleador = get_datos_empleador ($fuente, $usuario);
                 set_cabecera_empleador  ($nombre_fuente,$datos_usuario,$datos_empleador, $nombre_programa); break;
        case 8:  $datos_egresado = get_datos_egresado ($programa, $usuario);
                 //set_cabecera_egresado  ($nombre_fuente,$datos_usuario,$datos_egresado, $nombre_programa); break;
                 set_cabecera_normal    ($nombre_fuente,$datos_usuario, $nombre_programa); break;
        default:  set_cabecera_normal    ($nombre_fuente,$datos_usuario, $nombre_programa); break;
      }
    }

    echo "<br><br><P><center><TABLE BORDER='1' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'><b><H4><strong>SISTEMA INSTITUCIONAL DE ASEGURAMIENTO DE LA CALIDAD
          </h4>";
    foreach ($datos_factores as $factores) {
      foreach ($factores as $factor => $value_factor){
        if ($factor == 'fac_id')    		$fac_id          = $value_factor;
	    if ($factor == 'fac_codigo')  		$fac_codigo      = $value_factor;
	    if ($factor == 'fac_descripcion')  	$fac_descripcion = $value_factor;
      }//fin de un factor
      //echo "<TR><TH width='15%' ALIGN = 'right'>FACTOR [".$fac_codigo.']'.'</TH>';
      //echo "<TD colspan = 10 ALIGN = 'left'><FONT COLOR = 'green'><H3>".$fac_descripcion.'</TD>';
      $filtro_caracteristicas = $filtro_factores;
      $filtro_caracteristicas['fac_id']    = $fac_id;
      $filtro_caracteristicas['pro_id']    = $programa;
      $datos_caracterisiticas = combos_parametros::get_caracteristicas_fuente ($filtro_caracteristicas);
      foreach ($datos_caracterisiticas as $caracteristicas){
        foreach ($caracteristicas as $caracteristica => $value_caracteristica){
          if ($caracteristica == 'car_id')    		$car_id          = $value_caracteristica;
	      if ($caracteristica == 'car_codigo')  	$car_codigo      = $value_caracteristica;
	      if ($caracteristica == 'car_descripcion') $car_descripcion = $value_caracteristica;
        }//fin de una caracteristica
        //echo "<TR><TH width='15%' ALIGN = 'right'>CARACTERÍSTICA [".$car_codigo.']'.'</TH>';
        //echo "<TD colspan = 10 ALIGN = 'left'><FONT COLOR = 'blue'><H3>".$car_descripcion.'</TD>';
        $filtro_indicador = $filtro_caracteristicas;
        $filtro_indicador['car_id']    = $car_id;
        $datos_indicadores = combos_parametros::get_indicadores_fuente ($filtro_indicador);
        foreach ($datos_indicadores as $indicadores){
          foreach ($indicadores as $indicador => $value_indicador){
            if ($indicador == 'ind_id')    		   $ind_id          = $value_indicador;
	        if ($indicador == 'ind_codigo')  	   $ind_codigo      = $value_indicador;
	        if ($indicador == 'ind_descripcion')   $ind_descripcion = $value_indicador;
          }//fin de una caracteristica
          $filtro_preguntas = $filtro_indicador;
          $filtro_preguntas['ind_id']    = $ind_id;
          $datos_preguntas = combos_parametros::get_preguntas_fuente ($filtro_preguntas);
          $datos_preguntas = rs_ordenar_por_columna ($datos_preguntas, 'pre_orden');
          foreach ($datos_preguntas as $preguntas){
            foreach ($preguntas as $pregunta => $value_pregunta){
                if ($pregunta == 'pre_id')    			$pre_id             = $value_pregunta;
			    if ($pregunta == 'pre_codigo')  		$pre_codigo         = $value_pregunta;
			    if ($pregunta == 'pre_numeracion')  	$pre_numeracion     = $value_pregunta;
			    if ($pregunta == 'pre_pre_enunciado')  	$pre_pre_enunciado  = $value_pregunta;
			    if ($pregunta == 'pre_enunciado')  		$pre_enunciado      = $value_pregunta;
			    if ($pregunta == 'pre_pos_enunciado')   $pre_pos_enunciado  = $value_pregunta;
			    if ($pregunta == 'pre_factor')  		$pre_factor         = $value_pregunta;
			    if ($pregunta == 'pre_caracteristica')  $pre_caracteristica = $value_pregunta;
			    if ($pregunta == 'pre_indicador')  		$pre_indicador      = $value_pregunta;
			    if ($pregunta == 'pre_fuente')  		$pre_fuente         = $value_pregunta;
			    if ($pregunta == 'pre_tipo_pregunta')   $pre_tipo_pregunta  = $value_pregunta;
			    if ($pregunta == 'pre_obligada')  		$pre_obligada       = $value_pregunta;
			    if ($pregunta == 'pre_vigente')  		$pre_vigente        = $value_pregunta;
			    if ($pregunta == 'pre_orden')  			$pre_orden          = $value_pregunta;
			    if ($pregunta == 'pre_columnas')  		$pre_columnas       = $value_pregunta;
			    if ($pregunta == 'fac_descripcion')  	$fac_descripcion    = $value_pregunta;
			    if ($pregunta == 'car_descripcion')    	$car_descripcion    = $value_pregunta;
			    if ($pregunta == 'ind_descripcion')  	$ind_descripcion    = $value_pregunta;
            }//fin de una pregunta
            echo "<TR bgcolor='#81BEF7'><b><TH ALIGN = 'right'><font color = 'red'>[".$pre_orden.']'.'</B>';
            echo "<TH colspan = 10 ALIGN = 'left'><H3>".$pre_enunciado;

            //echo "pregunta ".$pre_enunciado;
            //[1]. caja una linea [2]. Text Area [3]. seleccion unica [4]. seleccion multiple [5]. Tabla Items
            $filtro_preguntas['pre_id'] = $pre_id;
            switch ($pre_tipo_pregunta){
               case 1: $caja_text_field = combos_parametros::get_respuestas_text_field ($filtro_preguntas) ;
                       set_text_field ($caja_text_field, 0, $pre_pos_enunciado);
                       break;
               case 2: $caja_text_area = combos_parametros::get_respuestas_text_area ($filtro_preguntas) ;
                       set_text_area ($caja_text_area, 0, $pre_pos_enunciado);
                       break;
               case 3: $seleccion_unica  = combos_parametros::get_respuestas_verticales ($filtro_preguntas) ;
                       $caja_text_field = combos_parametros::get_respuestas_text_field ($filtro_preguntas) ;
                       $caja_text_area  = combos_parametros::get_respuestas_text_area ($filtro_preguntas) ;
                       set_cuadro_vertical ($seleccion_unica, $pre_id, $pre_columnas, $pre_pos_enunciado, $caja_text_field, $caja_text_area, $pre_obligada); break;
               case 4: break;
               case 5: $seleccion_vertical   = combos_parametros::get_respuestas_verticales   ($filtro_preguntas) ;
                       $seleccion_horizontal = combos_parametros::get_respuestas_horizontales ($filtro_preguntas) ;
                       set_cuadro_tabla ($seleccion_vertical, $seleccion_horizontal, $pre_id, $pre_pos_enunciado, $pre_obligada);
                       break;
            }

          }//fin de preguntas
        }//fin de indicadores
      }//fin de caracteristicas
    }//fin de factores

    function set_cuadro_vertical ($datos_respuestas, $pre_id, $columnas, $pos_enunciado, $datos_text_field, $datos_text_area, $pre_obligada){
       $filas = count($datos_respuestas); $celdas = 0;
            echo "<TR>
                  <TD><TD colspan = '10'><TABLE BORDER = '1'>";
            foreach ($datos_respuestas as $respuestas){
              foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'rev_id')    		   $res_id        = $value_respuesta;
	            if ($respuesta == 'rev_orden')  	   $res_orden     = $value_respuesta;
	            if ($respuesta == 'rev_enunciado')     $res_enunciado = $value_respuesta;
	            if ($respuesta == 'rev_valor')         $res_valor     = $value_respuesta;

	            if ($respuesta == 'rev_factor')         $res_factor         = $value_respuesta;
	            if ($respuesta == 'rev_caracteristica') $res_caracteristica = $value_respuesta;
	            if ($respuesta == 'rev_indicador')      $res_indicador      = $value_respuesta;
             }//fin de una respuesta
             if ($columnas == 1) echo "<TR>";
             else if ($celdas <= $columnas) {
                 $celdas++;
               }
               else { echo "<TR>"; $celdas = 1;}
             if ($pre_obligada)  $obligada = 1; else $obligada = 0;
             $pregunta = $res_factor.'_'.$res_caracteristica.'_'.$res_indicador.'_'.$pre_id.'_'.$obligada;
             ?>
             <TD align = "left" bgcolor="#DFEBFF" onmouseover="bgColor='orange'" style="CURSOR: hand" onmouseout="bgColor='#DFEBFF'">
             <?php
             //echo '<TD align = "left" bgcolor="#DFEBFF" onmouseover="bgColor=orange" style="CURSOR: hand" onmouseout="bgColor=#DFEBFF">'.
             echo      "<INPUT TYPE='radio' name = respuestas_verticales[$pregunta] value=$res_valor>";
             echo $res_enunciado;
           }//fin de respuestas
           if ($datos_text_field) set_text_field($datos_text_field, $columnas, '');
           if ($datos_text_area)  set_text_area($datos_text_area, $columnas, '');
           echo "<TR><TH colspan = $columnas><FONT COLOR='green'>".$pos_enunciado;
           echo "</TABLE><BR>";
    }

    function set_cuadro_tabla ($datos_verticales, $datos_horizontales, $pre_id, $pos_enunciado, $pre_obligada){
       $filas    = count($datos_verticales);
       $columnas = count($datos_horizontales);
       $celdas = 1;
       echo "<TR><TD><TD>";
       foreach ($datos_horizontales as $horizontales){
         foreach ($horizontales as $horizontal => $value_horizontal){
           if ($horizontal == 'reh_id')    	    $hor_id        = $value_horizontal;
	       if ($horizontal == 'reh_orden')  	$hor_orden     = $value_horizontal;
	       if ($horizontal == 'reh_enunciado')  $hor_enunciado = $value_horizontal;
	       if ($horizontal == 'reh_valor')      $hor_valor     = $value_horizontal;
         }
         echo "<TH><FONT COLOR='blue'>".$hor_enunciado;
       }//fin horizontales


       foreach ($datos_verticales as $verticales){
          echo "<TR>";
          foreach ($verticales as $vertical => $value_vertical){
            if ($vertical == 'rev_id')    	   $ver_id        = $value_vertical;
	        if ($vertical == 'rev_orden')  	   $ver_orden     = $value_vertical;
	        if ($vertical == 'rev_enunciado')  $ver_enunciado = $value_vertical;
	        if ($vertical == 'rev_valor')      $ver_valor     = $value_vertical;

	        if ($vertical == 'rev_factor')         $ver_factor         = $value_vertical;
	        if ($vertical == 'rev_caracteristica') $ver_caracteristica = $value_vertical;
	        if ($vertical == 'rev_indicador')      $ver_indicador      = $value_vertical;
          }//fin de una vertical

          if ($celdas <= $columnas) {
             echo "<TD>";
             $celdas++;
          }
          else {
            echo "<TR>";

            $celdas = 1; echo "<TD>";
          }
          //echo "<TD>";
          ?>
             <Td align = "center" bgcolor="#DFEBFF" onmouseover="bgColor='orange'" style="CURSOR: hand" onmouseout="bgColor='#DFEBFF'">
          <?php
          echo $ver_enunciado;

          foreach ($datos_horizontales as $horizontales){
               foreach ($horizontales as $horizontal => $value_horizontal){
                 if ($horizontal == 'reh_id')    	 $hor_id        = $value_horizontal;
	             if ($horizontal == 'reh_orden')  	 $hor_orden     = $value_horizontal;
	             if ($horizontal == 'reh_enunciado') $hor_enunciado = $value_horizontal;
	             if ($horizontal == 'reh_valor')     $hor_valor     = $value_horizontal;
              }
              if ($pre_obligada)  $obligada = 1; else $obligada = 0;
              $pregunta = $ver_factor.'_'.$ver_caracteristica.'_'.$ver_indicador.'_'.$pre_id.'_'.$ver_id.'_'.$obligada;
              //echo "<TD align='center' bgcolor=#DFEBFF>
              ?>
               <TD align = "center" bgcolor="#DFEBFF" onmouseover="bgColor='orange'" style="CURSOR: hand" onmouseout="bgColor='#DFEBFF'">
             <?php
              echo "<INPUT TYPE='radio' name = respuestas_horizontales[$pregunta] value=$hor_valor>";
             }//fin horizontales

           }//fin de verticales
           $columnas++;
           echo "<TR><Td><Td><TH colspan = $columnas><FONT COLOR='green'>".$pos_enunciado;
           echo "<BR>";
    }

    function set_text_field ($datos_respuestas, $columnas, $pos_enunciado){
       $filas = count($datos_respuestas); $celdas = 1;
            //echo "<TR>";
            foreach ($datos_respuestas as $respuestas){
              foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'rtf_id')    		    $res_id            = $value_respuesta;
	            if ($respuesta == 'rtf_orden')  	    $res_orden         = $value_respuesta;
	            if ($respuesta == 'rtf_enunciado')      $res_enunciado     = $value_respuesta;
	            if ($respuesta == 'rtf_ancho')          $res_ancho         = $value_respuesta;
	            if ($respuesta == 'rtf_unidad')         $res_unidad    = $value_respuesta;
	            if ($respuesta == 'rtf_factor')         $res_factor         = $value_respuesta;
	            if ($respuesta == 'rtf_caracteristica') $res_caracteristica = $value_respuesta;
	            if ($respuesta == 'rtf_indicador')      $res_indicador      = $value_respuesta;
	            if ($respuesta == 'rtf_pregunta')       $res_pregunta      = $value_respuesta;
             }//fin de una respuesta
             //echo "<TR><TD colspan='$columnas'>$res_enunciado";
             //if ($columnas == 0)  echo "<TR><td><td>";
             //else echo "<TR><td><td>";
             //echo "<Td colspan = $columnas><input type='text'  name = respuestas_text_field[$res_id] value='' size=$res_ancho'>$res_unidad ";

             $pregunta = $res_factor.'_'.$res_caracteristica.'_'.$res_indicador.'_'.$res_pregunta.'_'.$res_id;
             echo "<tr><td><Td colspan = $columnas><input type='text'  name = respuestas_text_field[$pregunta] size=$res_ancho'>";
             //echo "<input type='text'  name = respuestas_text_field[$pregunta] size=$res_ancho' align='right'>";
           }//fin de respuestas
    }

    function set_text_area ($datos_respuestas, $columnas, $pos_enunciado){
       $filas = count($datos_respuestas); $celdas = 1;
            echo "<TR>";
            foreach ($datos_respuestas as $respuestas){
              foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'rta_id')    		    $res_id              = $value_respuesta;
	            if ($respuesta == 'rta_orden')  	    $res_orden          = $value_respuesta;
	            if ($respuesta == 'rta_enunciado')      $res_enunciado      = $value_respuesta;
	            if ($respuesta == 'rta_ancho')          $res_ancho          = $value_respuesta;
	            if ($respuesta == 'rta_alto')           $res_alto           = $value_respuesta;
	            if ($respuesta == 'rta_factor')         $res_factor         = $value_respuesta;
	            if ($respuesta == 'rta_caracteristica') $res_caracteristica = $value_respuesta;
	            if ($respuesta == 'rta_indicador')      $res_indicador      = $value_respuesta;
	            if ($respuesta == 'rta_pregunta')       $res_pregunta       = $value_respuesta;
             }//fin de una respuesta

             //echo $res_enunciado;

             echo "<TR><TD colspan='$columnas'>$res_enunciado";
             if ($columnas == 0)  echo "";
             else echo "<TR>";
             $pregunta = $res_factor.'_'.$res_caracteristica.'_'.$res_indicador.'_'.$res_pregunta.'_'.$res_id;
             echo "<Td colspan = $columnas><TEXTAREA name = respuestas_text_area[$pregunta] rows='$res_alto' cols='$res_ancho'></TEXTAREA>";

           }//fin de respuestas
    }

    echo "<P></TABLE>";
    if (! $sw_revision) combos_parametros::set_mensaje_final_enviar ();
    else combos_parametros::set_mensaje_final_no_enviar ();

    function get_datos_egresado ($programa, $usuario){
       $datos_usuario = array();
       if ($programa && $usuario) {
       $sql = "SELECT  dategr_usuario, dategr_programa, dategr_ingreso,
				       dategr_finalizacion, dategr_fecha_graduacion, dategr_situacion_laboral,
				       dategr_sector_laboral, dategr_tipo_sector, dategr_ambito_laboral,
				       dategr_vigente
				 FROM  datos_egresados
				WHERE (dategr_usuario = '$usuario' AND dategr_programa = $programa);";
        return consultar_fuente($sql);
        }
    }

    function get_datos_empleador ($fuente, $usuario){
       $datos_usuario = array();
       $sql = "SELECT  datemp_id, datemp_usuario, datemp_sector_laboral, datemp_tipo_sector,
				       datemp_nombre_empresa, datemp_cargo, datemp_profesionales_ucm,
				       datemp_anyo_vinculacion, datemp_vigente
				 FROM public.datos_empleador
				WHERE (datemp_usuario = '$usuario');";
        return consultar_fuente($sql);

    }

    function get_situacion_laboral (){
       $sql = "SELECT sitlab_id, sitlab_descripcion, sitlab_vigente
                 FROM public.situacion_laboral;";
        return consultar_fuente($sql);
    }

    function get_sector_laboral (){
       $sql = "SELECT seclab_id, seclab_descripcion, seclab_vigente
                 FROM sector_laboral;";
        return consultar_fuente($sql);
    }
    function get_descripcion_sector ($sector){
       $sql = "SELECT seclab_descripcion
                 FROM sector_laboral WHERE seclab_id = $sector;";
        $res = consultar_fuente($sql);
        $res = current($res);
        return $res['seclab_descripcion'];
    }

    function get_tipo_sector (){
       $sql = "SELECT tipsec_id, tipsec_descripcion, tipsec_vigente
                 FROM public.tipo_sector;";
        return consultar_fuente($sql);
    }

    function set_cabecera_empleador   ($nombre_fuente,$datos_usuario, $datos_empleador, $nombre_programa){
       $datos_sector_laboral = get_sector_laboral();
       $datos_tipo_sector = get_tipo_sector();
       echo "<P><TABLE BORDER='1' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'><b><H4>INFORMACIÓN INICIAL</H4>";
       if ($datos_usuario[0]['pro_nombre']) echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$datos_usuario[0]['pro_nombre'];
       else echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$nombre_programa;
       echo "<td ALIGN='left'><b>CARGO QUE DESEMPEÑA: </b>";
       $cargo=$datos_empleador[0]['datemp_cargo'];
       echo "<td ALIGN='left' COLSPAN=3><INPUT TYPE='text' name='cargo' value='$cargo' size='60'>";


       echo "<TR><td ALIGN='left'><b>".$nombre_fuente."</b>: ".$datos_usuario[0]['usu_nombres'];
       echo "<td ALIGN='left'><b>AÑO DE LA PRIMERA VINCULACIÓN DE PROFESIONALES UCM: </b>".$datos_empleador[0]['datemp_cargo'];
       $anyo_vinculacion=$datos_empleador[0]['datemp_anyo_vinculacion'];
       echo "<td ALIGN='left'><INPUT TYPE='text' name='anyo_vinculacion' value='$anyo_vinculacion' size='5'>";

       $sector=$datos_empleador[0]['datemp_sector_laboral'];
       if (! $sector) $sector = 0;
       $sector_defecto = get_descripcion_sector($sector);
       echo "<td ALIGN='left'><b>SECTOR LABORAL: </b>";
       echo "<td ALIGN='left'><SELECT name='sector_laboral'>";
       echo "<OPTION VALUE=0>"."--Seleccionar--"."</OPTION>";
       foreach ($datos_sector_laboral as $sector_laboral){
         foreach ($sector_laboral as $registro => $value){
           if ($registro == 'seclab_id')                    $seclab_id = $value;
           if ($registro == 'seclab_descripcion')  $seclab_descripcion = $value;
         }
         if ($sector == $seclab_id) echo "<OPTION  SELECTED VALUE=$seclab_id>".$seclab_descripcion."</OPTION>";
         else echo "<OPTION  VALUE=$seclab_id>".$seclab_descripcion."</OPTION>";
       }
       echo "</SELECT>";

       echo "<TR><td ALIGN='left'><b>EMPRESA O INSTITUCION: </b>".$datos_empleador[0]['datemp_nombre_empresa'];
       echo "<td ALIGN='left'><b>CANTIDAD PROFESIONALES UCM EN SU EMPRESA: </b>".$datos_egresado[0]['datemp_cargo'];
       $cantidad = $datos_empleador[0]['datemp_profesionales_ucm'];
       echo "<td ALIGN='left'><INPUT TYPE='text' name='cantidad' value='$cantidad' size='5'>";
       $sector=$datos_empleador[0]['datemp_tipo_sector'];
       echo "<td ALIGN='left'><b>CARACTERISTICA DEL SECTOR: </b>";
       echo "<td ALIGN='left'><SELECT name='tipo_sector'>";
       echo "<OPTION VALUE=0>"."--Seleccionar--"."</OPTION>";
       foreach ($datos_tipo_sector as $tipo_sector){
         foreach ($tipo_sector as $registro => $value){
           if ($registro == 'tipsec_id')                    $tipsec_id = $value;
           if ($registro == 'tipsec_descripcion')  $tipsec_descripcion = $value;
         }
         if ($sector == $tipsec_id) echo "<OPTION  SELECTED VALUE=$tipsec_id>".$tipsec_descripcion."</OPTION>";
         else echo "<OPTION  VALUE=$tipsec_id>".$tipsec_descripcion."</OPTION>";
       }
       echo "</SELECT>";
       echo "</TABLE>";
    }

    function set_cabecera_egresado   ($nombre_fuente,$datos_usuario, $datos_egresado, $nombre_programa){
       $datos_situacion_laboral = get_situacion_laboral();
       $datos_sector_laboral = get_sector_laboral();
       $datos_tipo_sector = get_tipo_sector();
       echo "<P><TABLE BORDER='1' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'><b><H4>INFORMACIÓN INICIAL</H4>";
       if ($datos_usuario[0]['pro_nombre']) echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$datos_usuario[0]['pro_nombre'];
       else echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$nombre_programa;
       echo "<td ALIGN='left'><b>AÑO INGRESO A LA UCM: </b>".$datos_egresado[0]['dategr_ingreso'];
       $situacion=$datos_egresado[0]['dategr_situacion_laboral'];
       echo "<td ALIGN='left'><b>SITUACIÓN LABORAL: </b>";
       echo "<td ALIGN='left'><SELECT name='situacion_laboral'>";
       echo "<OPTION VALUE=0>"."--Seleccionar--"."</OPTION>";
       foreach ($datos_situacion_laboral as $situacion_laboral){
         foreach ($situacion_laboral as $registro => $value){
           if ($registro == 'sitlab_id')                    $sitlab_id = $value;
           if ($registro == 'sitlab_descripcion')  $sitlab_descripcion = $value;
         }
         if ($situacion == $sitlab_id) echo "<OPTION  SELECTED VALUE=$sitlab_id>".$sitlab_descripcion."</OPTION>";
         else echo "<OPTION  VALUE=$sitlab_id>".$sitlab_descripcion."</OPTION>";
       }
       echo "</SELECT>";

       echo "<TR><td ALIGN='left'><b>".$nombre_fuente."</b>: ".$datos_usuario[0]['usu_nombres'];
       echo "<td ALIGN='left'><b>AÑO DE FINALIZACION: </b>".$datos_egresado[0]['dategr_finalizacion'];

       $sector = $datos_egresado[0]['dategr_sector_laboral'];
       echo "<td ALIGN='left'><b>SECTOR LABORAL: </b>";
       echo "<td ALIGN='left'><SELECT name='sector_laboral'>";
       echo "<OPTION VALUE=0>"."--Seleccionar--"."</OPTION>";
       foreach ($datos_sector_laboral as $sector_laboral){
         foreach ($sector_laboral as $registro => $value){
           if ($registro == 'seclab_id')                    $seclab_id = $value;
           if ($registro == 'seclab_descripcion')  $seclab_descripcion = $value;
         }
         if ($sector == $seclab_id) echo "<OPTION  SELECTED VALUE=$seclab_id>".$seclab_descripcion."</OPTION>";
         else echo "<OPTION  VALUE=$seclab_id>".$seclab_descripcion."</OPTION>";
       }
       echo "</SELECT>";

       echo "<TR><td><td ALIGN='left'><b>FECHA DE GRADUACIÓN: </b>".$datos_egresado[0]['dategr_fecha_graduacion'];
       $tipo = $datos_egresado[0]['dategr_tipo_sector'];
       echo "<td ALIGN='left'><b>CARACTERISTICA DEL SECTOR: </b>";
       echo "<td ALIGN='left'><SELECT name='tipo_sector'>";
       echo "<OPTION VALUE=0>"."--Seleccionar--"."</OPTION>";
       foreach ($datos_tipo_sector as $tipo_sector){
         foreach ($tipo_sector as $registro => $value){
           if ($registro == 'tipsec_id')                    $tipsec_id = $value;
           if ($registro == 'tipsec_descripcion')  $tipsec_descripcion = $value;
         }
         if ($tipo == $tipsec_id) echo "<OPTION  SELECTED VALUE=$tipsec_id>".$tipsec_descripcion."</OPTION>";
         else echo "<OPTION  VALUE=$tipsec_id>".$tipsec_descripcion."</OPTION>";
       }
       echo "</SELECT>";
       $ambito = $datos_egresado[0]['dategr_ambito_laboral'];
       echo "<TR><td><td ALIGN='right' colspan=2><b>TRABAJA EN EL ÁMBITO DE SU FORMACIÓN PROFESIONAL ? </b>";
       if ($ambito) echo "<td align='left'><INPUT TYPE='checkbox' checked name='ambito'>";
       else echo "<td align='left'><INPUT TYPE='checkbox' name='ambito'></td>";
       echo "</TABLE>";
    }

    function set_cabecera_normal   ($nombre_fuente,$datos_usuario, $nombre_programa){
       echo "<P><TABLE  BORDER='0' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'><b><H4>INFORMACIÓN INICIAL</H4>";
       if ($datos_usuario[0]['pro_nombre']) echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$datos_usuario[0]['pro_nombre'];
       else echo "<tr><td ALIGN='left'><b>PROGRAMA: </b>".$nombre_programa;
       echo "<tr><td ALIGN='left'><b>".$nombre_fuente."</b>: ".$datos_usuario[0]['usu_nombres'];
       echo "</TABLE></P>";
    }

    //para postgrados
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
    echo "</FORM>";
 ?>


<script type="text/javascript">
function validar(){
  var sw=0; var k=1; var Fuente;
  var el = document.frm.elements; var k=1;
  for (var i = 0 ; i < el.length ; ++i) {
	var pregunta = document.frm.elements[i].name;
	var numero   = pregunta.charAt(pregunta.length-2); //si es uno es obligado
	if (numero == 1){
	    if (el[i].type == "radio") {   //radio vertical una sola respuesta  0306003010502a la que no es obligada
	        var radiogroup = el[el[i].name];
	        var itemchecked = false;
	        for (var j = 0 ; j < radiogroup.length ; ++j) {   // 0302004010304a0100    0302004010304a0200
	            if (radiogroup[j].checked) {
	              itemchecked = true;
	              break;
	            }       //

	        }//fin items del grupo

	        if (!itemchecked) {
	            //alert("No ha respondido la pregunta con " + );
	            sw = 1;
	            break;
	        }
	    }//fin radios
	}//fin de obligado
  }//fin recorrer todos los elementos
  if (sw == 0) {
    //return true;
    document.forms[0].submit();
    opener.focus();
    //window.close();
  } else {
	  alert("Favor Responder la Pregunta. ");
      document.frm.elements[i].focus();
  }

}
</script>

<script type="text/javascript">
  function no_enviar(){
	  var sw=0; var k=1; var Fuente;
	  var el = document.frm.elements; var k=1;
	  for (var i = 0 ; i < el.length ; ++i) {
		var pregunta = document.frm.elements[i].name;
		var numero   = pregunta.charAt(pregunta.length-2); //si es uno es obligado
		if (numero == 1){
		    if (el[i].type == "radio") {   //radio vertical una sola respuesta  0306003010502a la que no es obligada
		        var radiogroup = el[el[i].name];
		        var itemchecked = false;
		        for (var j = 0 ; j < radiogroup.length ; ++j) {   // 0302004010304a0100    0302004010304a0200
		            if (radiogroup[j].checked) {
		              itemchecked = true;
		              break;
		            }       //

		        }//fin items del grupo

		        if (!itemchecked) {
		            //alert("No ha respondido la pregunta con " + );
		            sw = 1;
		            break;
		        }
		    }//fin radios
		}//fin de obligado
	  }//fin recorrer todos los elementos
	  if (sw == 0) {
	    //return true;
	    alert("Este Formato es solo de Revisión, No se envia la Información. ");
	    opener.focus();
	    //window.close();
	  } else {
		  alert("Favor Responder la Pregunta. ");
	      document.frm.elements[i].focus();
	  }
  }
</script>
</body>
</html>
