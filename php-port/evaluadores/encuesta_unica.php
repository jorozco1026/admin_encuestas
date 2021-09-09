<?php
  require_once('libreria/libreria.php');
  $parametros = toba::memoria()->get_parametros();
  
  $titulo = null;
  if (! $parametros['cue_id'])    {
    $parametros['cue_id']  = 1;
    $titulo = "SOLAMENTE DE REVISI&Oacute;N ";
  } 
  $cuestionario  = $parametros['cue_id'];

  $base = $cuestionario;

  echo "<TABLE BGCOLOR='#e5e7e9'><TR><TD>";  

  $url = toba::vinculador()->get_url('admin_encuestas','7140');  //donde se registran las
  echo "<FORM name='frm' ACTION='$url' method='POST'>";
    echo "<INPUT TYPE = 'hidden' name='base' value = $base>";
    //traemos solamente los factores que tengan preguntas de esa fuente
    $clave_cuestionario['cue_id'] = $cuestionario;
    $datos_cuestionario = libreria::get_cuestionarios ( $clave_cuestionario );
    echo "<P><center><TABLE BORDER='0' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'>
          <b>".$datos_cuestionario[0]['cue_nombre']."</b></font></CAPTION>
          <tr><td><td colspan = 10 align='center'>"; echo toba_recurso::imagen_proyecto("logo_encuesta.jpg",true);
    echo "<tr><td><td colspan = 10 align='left'><h3>".$datos_cuestionario[0]['cue_descripcion'];
    echo "</table></P><BR>";

    echo "<br><br><P><center><TABLE BORDER='1' WIDTH='80%'><CAPTION><H2><FONT COLOR='green'><b><H4>"."<BR>".$datos_cuestionario[0]['cue_nombre']."</h4>";
    
    $datos_indicadores = libreria::get_indicadores_cuestionario ( $clave_cuestionario );
    foreach ($datos_indicadores as $indicadores){
      foreach ($indicadores as $indicador => $value_indicador){
        if ($indicador == 'ind_id')    		   $ind_id          = $value_indicador;
	      if ($indicador == 'ind_codigo')  	   $ind_codigo      = $value_indicador;
	      if ($indicador == 'ind_descripcion') $ind_descripcion = $value_indicador;
      }//fin de un indicador

      $clave_cuestionario['ind_id'] = $indicadores['ind_id'];
      $clave_cuestionario['pre_vigente'] = 1;
      $datos_preguntas = libreria::get_preguntas_indicador_con_respuestas ( $clave_cuestionario );
    //if (! $datos_preguntas) {echo "SIN ARMAR LAS PRETUNTAS"; return;}
      // $datos_preguntas = rs_ordenar_por_columna ($datos_preguntas, 'pre_orden');
      
      //echo "<TR><b><TH ALIGN = 'right'><font color = 'red'>[".$indicadores['ind_orden'].']'.'</B>';
      echo "<TR><TH>";
      echo "<TH colspan = 10 ALIGN = 'left'><H3><font color='BLUE'>".strtoupper($indicadores['ind_nombre']);
      foreach ($datos_preguntas as $preguntas){
        foreach ($preguntas as $pregunta => $value_pregunta){
          if ($pregunta == 'pre_id')    			  $pre_id = $value_pregunta;
          if ($pregunta == 'pre_enumeracion')  	$pre_numeracion = $value_pregunta;
          if ($pregunta == 'pre_preenunciado')  $pre_pre_enunciado= $value_pregunta;
          if ($pregunta == 'pre_enunciado')  		$pre_enunciado = $value_pregunta;
          if ($pregunta == 'pre_pos_enunciado') $pre_pos_enunciado= $value_pregunta;
          if ($pregunta == 'pre_indicador')  	  $pre_indicador = $value_pregunta;
          if ($pregunta == 'pre_cuestionario')  $pre_cuestionario = $value_pregunta;
          if ($pregunta == 'pre_tipo_pregunta') $pre_tipo_pregunta= $value_pregunta;
          if ($pregunta == 'pre_obligada')  		$pre_obligada = $value_pregunta;
          if ($pregunta == 'pre_vigente')  		  $pre_vigente  = $value_pregunta;
          if ($pregunta == 'pre_orden')  			  $pre_orden = $value_pregunta;
          if ($pregunta == 'pre_columnas')  	  $pre_columnas = $value_pregunta;
          if ($pregunta == 'ind_descripcion')   $ind_descripcion = $value_pregunta;
        }//fin de una pregunta
        echo "<TR><b><TH ALIGN = 'right'><font color = 'red'><H4><b>[".$pre_orden.']'.'</b></H4></B>';
        echo "<TH colspan = 10 ALIGN = 'left'><H3>".$pre_enunciado;
        $clave_cuestionario['pre_id'] = $preguntas['pre_id'];
        $clave_cuestionario['vigente'] = 1;
        //echo "pregunta ".$pre_enunciado;
            //[1]. caja una linea [2]. Text Area [3]. seleccion unica [4]. seleccion multiple [5]. Tabla Items
            switch ($preguntas['pre_tipo_pregunta']) {
               case 1: $caja_text_field = libreria::get_respuestas_text_field ($clave_cuestionario);
                       set_text_field ($caja_text_field, 0, $pre_pos_enunciado);
                       break;
               case 2: $caja_text_area = libreria::get_respuestas_text_area ($clave_cuestionario);
                       set_text_area ($caja_text_area, 0, $pre_pos_enunciado);
                       break;
               case 3: $seleccion_unica = libreria::get_respuestas_verticales ($clave_cuestionario);
                       $caja_text_field = libreria::get_respuestas_text_field ($clave_cuestionario);
                       $caja_text_area  = libreria::get_respuestas_text_area ($clave_cuestionario);
                       set_cuadro_vertical ($seleccion_unica, $pre_id, $pre_columnas, $pre_pos_enunciado, $caja_text_field, $caja_text_area, $pre_obligada); 
                       break;
               case 4: $seleccion_varias = libreria::get_respuestas_verticales ($clave_cuestionario);
                       $caja_text_field = libreria::get_respuestas_text_field ($clave_cuestionario);
                       $caja_text_area  = libreria::get_respuestas_text_area ($clave_cuestionario);
                       set_cuadro_vertical_check ($seleccion_varias, $pre_id, $pre_columnas, $pre_pos_enunciado, $caja_text_field, $caja_text_area, $pre_obligada); 
                       break;
               case 5: $seleccion_vertical   = libreria::get_respuestas_verticales   ($clave_cuestionario);
                       $seleccion_horizontal = libreria::get_respuestas_horizontales ($clave_cuestionario);
                       set_cuadro_tabla ($seleccion_vertical, $seleccion_horizontal, 'checkbox', $pre_id, $pre_pos_enunciado, $pre_obligada);
                       break;              
               case 6: $seleccion_vertical   = libreria::get_respuestas_verticales   ($clave_cuestionario);
                       $seleccion_horizontal = libreria::get_respuestas_horizontales ($clave_cuestionario);
                       set_cuadro_tabla ($seleccion_vertical, $seleccion_horizontal, 'radio', $pre_id, $pre_pos_enunciado, $pre_obligada);
                       break;
            }
          }//fin de preguntas
        }//fin de indicadores    

    function set_cuadro_vertical ($datos_respuestas, $pre_id, $columnas, $pos_enunciado, $datos_text_field, $datos_text_area, $pre_obligada){
       $filas = count($datos_respuestas); $celdas = 0;
            echo "<TR>
                  <TD><TD colspan = '10'><TABLE BORDER = '1'>";
            foreach ($datos_respuestas as $respuestas){
              foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'resver_id')    		    $res_id        = $value_respuesta;
	            if ($respuesta == 'resver_orden')  	      $res_orden     = $value_respuesta;
	            if ($respuesta == 'resver_enunciado')      $res_enunciado = $value_respuesta;
	            if ($respuesta == 'resver_valor')          $res_valor     = $value_respuesta;
	            if ($respuesta == 'resver_indicador')      $res_indicador      = $value_respuesta;
             }//fin de una respuesta
             if ($columnas == 1) echo "<TR>";
             else if ($celdas <= $columnas) {
                 $celdas++;
               }
               else { echo "<TR>"; $celdas = 1;}
             if ($pre_obligada)  $obligada = 1; else $obligada = 0;
             $pregunta = $res_indicador.'_'.$pre_id.'_'.$obligada;
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

    function set_cuadro_vertical_check ($datos_respuestas, $pre_id, $columnas, $pos_enunciado, $datos_text_field, $datos_text_area, $pre_obligada){
      $filas = count($datos_respuestas); $celdas = 0;
           echo "<TR>
                 <TD><TD colspan = '10'><TABLE BORDER = '1'>";
           foreach ($datos_respuestas as $respuestas){
             foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'resver_id')    		  $res_id        = $value_respuesta;
                if ($respuesta == 'resver_orden')  	  $res_orden     = $value_respuesta;
                if ($respuesta == 'resver_enunciado')  $res_enunciado = $value_respuesta;
                if ($respuesta == 'resver_valor')      $res_valor     = $value_respuesta;
                if ($respuesta == 'resver_indicador')  $res_indicador      = $value_respuesta;
            }//fin de una respuesta
            if ($columnas == 1) echo "<TR>";
            else if ($celdas <= $columnas) {
                $celdas++;
            }
            else { echo "<TR>"; $celdas = 1;}
            if ($pre_obligada)  $obligada = 1; else $obligada = 0;
            $pregunta = $res_indicador.'_'.$pre_id.'_'.$res_id.'_'.$res_enunciado;
            ?>
            <TD align = "left" bgcolor="#DFEBFF" onmouseover="bgColor='orange'" style="CURSOR: hand" onmouseout="bgColor='#DFEBFF'">
            <?php
            //echo '<TD align = "left" bgcolor="#DFEBFF" onmouseover="bgColor=orange" style="CURSOR: hand" onmouseout="bgColor=#DFEBFF">'.
            echo "<INPUT TYPE='checkbox' name = respuestas_verticales_check[] value=$pregunta>";
            echo $res_enunciado;
          }//fin de respuestas
          if ($datos_text_field) set_text_field($datos_text_field, $columnas, '');
          if ($datos_text_area)  set_text_area($datos_text_area, $columnas, '');
          echo "<TR><TH colspan = $columnas><FONT COLOR='green'>".$pos_enunciado;
          echo "</TABLE><BR>";
   }

    function set_cuadro_tabla ($datos_verticales, $datos_horizontales, $tipo, $pre_id, $pos_enunciado, $pre_obligada){
       $filas    = count($datos_verticales);
       $columnas = count($datos_horizontales);
       $celdas = 1;
       echo "<TR><TD><TD>";
       foreach ($datos_horizontales as $horizontales){
         foreach ($horizontales as $horizontal => $value_horizontal){
            if ($horizontal == 'reshor_id')    	    $hor_id        = $value_horizontal;
            if ($horizontal == 'reshor_orden')  	  $hor_orden     = $value_horizontal;
            if ($horizontal == 'reshor_enunciado')  $hor_enunciado = $value_horizontal;
            if ($horizontal == 'reshor_valor')      $hor_valor     = $value_horizontal;
         }
         echo "<TH><FONT COLOR='blue'><center>".$hor_enunciado;
       }//fin horizontales


       foreach ($datos_verticales as $verticales){
          echo "<TR>";
          foreach ($verticales as $vertical => $value_vertical){
            if ($vertical == 'resver_id')    	    $ver_id        = $value_vertical;
            if ($vertical == 'resver_orden')  	  $ver_orden     = $value_vertical;
            if ($vertical == 'resver_enunciado')  $ver_enunciado = $value_vertical;
            if ($vertical == 'resver_valor')      $ver_valor     = $value_vertical;
            if ($vertical == 'resver_indicador')  $ver_indicador = $value_vertical;
            if ($vertical == 'resver_numeracion')  $ver_numeracion = $value_vertical;
          }//fin de una vertical

          if ($celdas <= $columnas) {
             echo "<TD><H4><b>".$ver_numeracion."</b></H4>";
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
                  if ($horizontal == 'reshor_id')    	 $hor_id        = $value_horizontal;
                  if ($horizontal == 'reshor_orden')  	 $hor_orden     = $value_horizontal;
                  if ($horizontal == 'reshor_enunciado') $hor_enunciado = $value_horizontal;
                  if ($horizontal == 'reshor_valor')     $hor_valor     = $value_horizontal;
              }
              if ($pre_obligada)  $obligada = 1; else $obligada = 0;
              $pregunta = $ver_indicador.'_'.$pre_id.'_'.$ver_id.'_'.$obligada;
              //echo "<TD align='center' bgcolor=#DFEBFF>
              ?>
               <TD align = "center" bgcolor="#DFEBFF" onmouseover="bgColor='orange'" style="CURSOR: hand" onmouseout="bgColor='#DFEBFF'">
             <?php
              if ($tipo == 'radio')    echo "<INPUT TYPE='radio' name = respuestas_horizontales[$pregunta] value=$hor_valor>";
              if ($tipo == 'checkbox') echo "<INPUT TYPE='checkbox' name = respuestas_horizontales[$pregunta] value=$hor_valor>";
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
                if ($respuesta == 'txtfie_id')        $res_id = $value_respuesta;
                if ($respuesta == 'txtfie_orden')  	  $res_orden = $value_respuesta;
                if ($respuesta == 'txtfie_enunciado') $res_enunciado = $value_respuesta;
                if ($respuesta == 'txtfie_ancho')     $res_ancho = $value_respuesta;
                if ($respuesta == 'txtfie_indicador') $res_indicador = $value_respuesta;
                if ($respuesta == 'txtfie_pregunta')  $res_pregunta = $value_respuesta;
                if ($respuesta == 'txtfie_holder')    $res_holder = $value_respuesta;
             }//fin de una respuesta
             $pregunta = $res_indicador.'_'.$res_pregunta.'_'.$res_id;
             echo "<tr><td><Td colspan = $columnas><input type='text' placeholder='".$res_holder."' name = respuestas_text_field[$pregunta] size=$res_ancho>";
           }//fin de respuestas
    }

    function set_text_area ($datos_respuestas, $columnas, $pos_enunciado){
       $filas = count($datos_respuestas); $celdas = 1;
            echo "<TR>";
            foreach ($datos_respuestas as $respuestas){
              foreach ($respuestas as $respuesta => $value_respuesta){
                if ($respuesta == 'txtare_id')    		    $res_id              = $value_respuesta;
	            if ($respuesta == 'txtare_orden')  	      $res_orden          = $value_respuesta;
	            if ($respuesta == 'txtare_enunciado')      $res_enunciado      = $value_respuesta;
	            if ($respuesta == 'txtare_ancho')          $res_ancho          = $value_respuesta;
	            if ($respuesta == 'txtare_alto')           $res_alto           = $value_respuesta;
	            if ($respuesta == 'txtare_indicador')      $res_indicador      = $value_respuesta;
	            if ($respuesta == 'txtare_pregunta')       $res_pregunta       = $value_respuesta;
              if ($respuesta == 'txtare_holder')         $res_holder       = $value_respuesta;
             }//fin de una respuesta

             //echo $res_enunciado;

             echo "<TR><TD colspan='$columnas'>$res_enunciado";
             if ($columnas == 0)  echo "";
             else echo "<TR>";
             $pregunta = $res_indicador.'_'.$res_pregunta.'_'.$res_id;
             echo "<Td colspan = $columnas><TEXTAREA name = respuestas_text_area[$pregunta] rows='$res_alto' cols='$res_ancho' placeholder='".$res_holder."'></TEXTAREA>";

           }//fin de respuestas
    }

 echo "<P></TABLE>";
 
 echo "</FORM>";

 set_mensaje_final_enviar ($titulo);

 function set_mensaje_final_enviar ($titulo){
	  echo "<P><center><table  BORDER='0' WIDTH='80%'>";
    //<TR><td><TD colspan='10'><center><font color='green'><h2>"."Sugerencias";
	  //echo "<tr><td><Td colspan = '10'><TEXTAREA name = respuestas_sugerencias['txtSugerencia'] rows='5' cols='150'></TEXTAREA>";

      echo "<tr><td><Td colspan = '10'>";
    $proyecto = 'encuestas';
    //if (! $titulo) 
    $src = toba_recurso::url_proyecto($proyecto) . "/img/" . 'enviar.png';
	  echo "<BR><BR><center><table border='0' cellpadding='0' cellspacing='0' width='726'>";
	  echo "<tr>";
    
    //echo "<div class='modal-footer'>
      //          <button type='button' class='btn btn-default' data-dismiss='modal'>Enviar</button>
        //    </div>";

    
    echo "<td align='center' valign='middle'><center><a href='javascript: validar();'><img src='$src'></a></td>";
	  //echo "<td align='center' valign='middle'><INPUT TYPE = 'submit'><center></td>";
    echo "</tr></table>";

	  /*echo "<BR><center><tABLE><tr><TD>";
    echo "<td><div align='center'>";
    $pie = utf8_decode("Universidad Católica");
	  echo "<center><div align='center' class='Contenido_TXT'>&copy; ".$pie." <br />
    <br />
	        Manizales -   Caldas - Colombia</div>";
	  echo "</div></td>";
	  echo "</tr>";
	  echo "</table>";*/
 }

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
</body>
</html>
