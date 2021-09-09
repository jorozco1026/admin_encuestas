<?
 session_register('Usuario','Identificacion','PrimerApellido','SegundoApellido','PrimerNombre','SegundoNombre','Fuente','DescripcionFuente','Programa','DescripcionPrograma','SqlRpt');
 echo "<fieldset><legend><b><font color='blue'>";
 //echo "$DescripcionFuente - $DescripcionPrograma: $PrimerNombre $SegundoNombre $PrimerApellido $SegundoApellido";
 echo "</font></legend>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td img {display: block;}
</style>
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('./images/img_botonera/botonera_00_r2_c2_f2.gif','./images/img_botonera/botonera_00_r2_c3_f2.gif','./images/img_botonera/botonera_00_r2_c4_f2.gif','./images/img_botonera/botonera_00_r2_c5_f2.gif','./images/img_botonera/botonera_00_r2_c6_f2.gif','./images/img_botonera/botonera_00_r2_c7_f2.gif','./images/img_botonera/botonera_00_r2_c8_f2.gif','./images/img_botonera/botonera_00_r3_c9_f2.gif','./images/img_botonera/botonera_00_r3_c10_f2.gif')">
<table width="726" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?echo "<b><br><font color='blue'>$DescripcionFuente - $DescripcionPrograma: $PrimerNombre $SegundoNombre $PrimerApellido $SegundoApellido</font><br>";
      ?>
    </td>
  </tr>
  <tr>
    <td  bgcolor='#FFFFFF' ><div align="center">
      <table border="0" cellpadding="0" cellspacing="0" width="726">
        <!-- fwtable fwsrc="botonera_00.png" fwbase="botonera_00.jpg" fwstyle="Dreamweaver" fwdocid = "1002049238" fwnested="0" -->
        <tr>
          </tr>
        <tr>
          <td  bgcolor='#FFFFFF'  colspan="11"><img name="botonera_00_r1_c1" src="./images/img_botonera/botonera_00_r1_c1.jpg" width="726" height="126" border="0" id="botonera_00_r1_c1" alt="" /></td>
          <td  bgcolor='#FFFFFF' ><img src="./images/img_botonera/spacer.gif" width="1" height="115" border="0" alt="" /></td>
        </tr>
        <tr>
          </tr>
        <tr>
          </tr>
        <tr>
          <td  bgcolor='#FFFFFF'  colspan="2"><img name="botonera_00_r4_c9" src="./images/img_botonera/botonera_00_r4_c9.jpg" width="160" height="1" border="0" id="botonera_00_r4_c9" alt="" /></td>
          <td  bgcolor='#FFFFFF' ><img src="./images/img_botonera/spacer.gif" width="1" height="1" border="0" alt="" /></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td  bgcolor='#FFFFFF'  bgcolor="#FFFFFF">
    <p>
    <?php  
    include "./Libreria/db_open.php";
    include "./Libreria/validanumericos.php";
    $Fuente = $HTTP_POST_VARS['txtFuente'];
    //echo "<body background ='./images/linea_fondo.gif'>";
    echo "<form name='frm' action='registrar.php' method='POST'>";
    echo "<input type='hidden' name='$Fuente'>";
    //SQL PREguntas dependiendo de la fuente y el isntrumento
    $query_preguntas = "SELECT * FROM factores, caracteristicas, indicadores, instrumentos, fuentes, preguntas
                         WHERE fac_codigo = car_fac_codigo
                           AND car_codigo = ind_car_codigo
			               AND ind_codigo = pre_ind_codigo
                           AND fue_codigo = pre_fue_codigo AND pre_fue_codigo = '$Fuente'
			               AND ins_codigo = pre_ins_codigo AND pre_ins_codigo = '01'
                         ORDER BY fac_codigo, car_codigo, ind_codigo, pre_codigo ASC";
    $res_preguntas   = pg_query($query_preguntas);
    $facAnterior = '';  $preAnterior = ''; $carAnterior = '';
    while ($row_preguntas = pg_fetch_array($res_preguntas)){
     $$encabezado       =  False;
     $fac_codigo        = $row_preguntas["fac_codigo"];    $facActual = $fac_codigo;
     $fac_descripcion   = $row_preguntas["fac_descripcion"];
     $car_codigo        = substr($row_preguntas["car_codigo"],-2);    $carActual = $car_codigo;
     $car_codigosisalertas     = $row_preguntas["car_codigosisalertas"];
     $ind_codigosisalertas     = $row_preguntas["ind_codigosisalertas"];
     $car_descripcion   = $row_preguntas["car_descripcion"];
     $pre_codigo        = $row_preguntas["pre_codigo"];    $preActual = $pre_codigo;//$preActual = substr($pre_codigo,0,13);
     $pre_enunciado     = $row_preguntas["pre_enunciado"];
     $pre_posenunciado     = $row_preguntas["pre_posenunciado"];
     $pre_tippre_codigo = $row_preguntas["pre_tippre_codigo"];
     $pre_gruhor_codigo = $row_preguntas["pre_gruhor_codigo"];

    if ($pre_tippre_codigo != '00'){
     //if($car_codigosisalertas < 10) $car_codigosisalertas = '0'.$car_codigosisalertas;
     //if($ind_codigosisalertas < 10) $ind_codigosisalertas = '00'.$ind_codigosisalertas;
     //elseif($ind_codigosisalertas < 100) $ind_codigosisalertas = '0'.$ind_codigosisalertas;
     $codigoMostrar = $fac_codigo.'-'.$car_codigosisalertas.'-'.$ind_codigosisalertas;
     echo "<div align='center'>";
     if ($facAnterior != $facActual ){  //INICIO FACTOR
       $auxfac_codigo = 'Usted Evaluará el FACTOR '.$fac_codigo. ' Referido a ';
       echo "<div align='center'>";
       if ($facActual == '00') {$fac_descripcion = ""; $auxfac_codigo = "INFORMACIÓN INICIAL";}
       if ($facActual == '99') {$fac_descripcion = ""; $auxfac_codigo = "";}

       if (($facActual != '99')&& ($facActual != '00')) echo "<br><br>";
         echo "<table border='0' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' width='726'>"; //inicio tabla factores
         echo "  <tr>";
         echo "    <td  bgcolor='#FFFFFF'  width='100' height='20' valign='top'><b><font color='#FF0000'>$auxfac_codigo</font></b></td>";
         echo "    <td  bgcolor='#FFFFFF'  width='900' valign='top'><b>$fac_descripcion</b></td>";
         echo "  </tr>";
       }
       //inicio las caracteristicas
       if ($carAnterior != $carActual){  //INICIO CARACTERISTICA
         $car_descripcion = '  '.$car_descripcion;
         $auxcar_codigo = 'Característica ';
         if ($carActual == '00') {$car_descripcion = "INFORMACIÓN ACADÉMICA Y LABORAL"; $auxcar_codigo = "";}
         if ($carActual == '99') {$car_descripcion = ""; $auxcar_codigo = "";}
         echo "<table border='0' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' width='726'><br>"; //inicio tabla caracteristicas
         echo " <tr>";
         echo "<td  bgcolor='#FFFFFF'  width='100' height='38'></td>";
         echo " <td  bgcolor='#FFFFFF'  width='120' valign='top'><b><font color='#008000'>$auxcar_codigo</font></b></td>";
         echo " <td  bgcolor='#FFFFFF'  width='780' valign='top'><b>$car_descripcion</b></td>";
         echo " </tr>";
       } //fin de la caracteristica  espacio entre caracteristicas
       $carAnterior = $carActual;
         //inicio preguntas
         if ($preAnterior != $preActual ){  //INICIO FACTOR
           echo "<br>";
           echo "<table border='0' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' width='726'>";
           echo "     <tr>";
           echo "       <td  bgcolor='#FFFFFF'  width='220' height='24'></td>";
           if (($carActual != '99') &&($carActual != '00'))
            echo "       <td  bgcolor='#FFFFFF'  width='100' valign='top'><b>$codigoMostrar</b></td>";
           else echo "   <td  bgcolor='#FFFFFF'  width='100' valign='top'><b></b></td>";
           echo "       <td  bgcolor='#FFFFFF'  width='680' valign='top'>$pre_enunciado</td>";
           if (($pre_posenunciado != '')&& ($pre_posenunciado != ' ')){
              echo "     <tr>";
              echo "       <td  bgcolor='#FFFFFF'  width='220' height='24'></td>";
              echo "       <td  bgcolor='#FFFFFF'  width='100' valign='top'><b></b></td>";
              echo "       <td  bgcolor='#FFFFFF'  width='680' valign='top'><B>$pre_posenunciado</B></td>";
              //echo "<br><br><b>$pre_posenunciado</b>";
           }
            echo "     </tr>";
           //extraemos sus respuestas
           $query_respuestas = "SELECT * FROM respuestas
                                WHERE res_pre_codigo = '$pre_codigo'
                                  AND res_codigo LIKE '%00'
                                ORDER BY res_codigo ASC";
           $res_respuestas   = pg_query($query_respuestas);
           $literal = 'a';
           echo "<table border='1' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' width='726'>";
           	  while ($row_respuestas = pg_fetch_array($res_respuestas)){
                 $res_codigo         = $row_respuestas["res_codigo"];
                 $res_tipdat_codigo  = $row_respuestas["res_descripcion"];
                 $res_longitud       = $row_respuestas["res_longitud"];
                 $res_tipuni_codigo  = $row_respuestas["res_tipuni_codigo"];
                 $res_tipdat_codigo  = $row_respuestas["res_tipdat_codigo"];
                 $litera ="a";
                 $res_abreviada      = substr($res_enunciado,0,3);
                 $res_enunciado      = $row_respuestas["res_enunciado"];
                 $res_abreviada = substr($res_enunciado,0,4);

                 if ($res_tipuni_codigo != '00'){
                   $query_unidad = "SELECT * FROM tipounidades
                                     WHERE tipuni_codigo = '$res_tipuni_codigo'";
                   $res_unidad   = pg_query($query_unidad);
                   $row_unidad   = pg_fetch_array($res_unidad);
                   $tipuni_descripcion  = $row_unidad["tipuni_descripcion"];
                 }
                 else $tipuni_descripcion = '';
                 
                 if ($res_abreviada == 'Cuál') $pre_tippre_codigo = '01';
                 echo "<tr>";
                    echo "<td  bgcolor='#FFFFFF'  width='100'></td>";
                    if($pre_tippre_codigo == '05'){
                     if(!$encabezado){  //el encabezado una sola vez
                      //sql para el encabezado de los items horizontales
                      $query_horizontales = "SELECT * FROM itemshorizontales
                                WHERE itehor_gruhor_codigo = '$pre_gruhor_codigo'
                                ORDER BY itehor_codigo ASC";
                      $res_horizontales   = pg_query($query_horizontales);
                      echo "<th  bgcolor='#FFFFFF'  width='50'></th>";
                      echo "<th  bgcolor='#FFFFFF'  width='300'></th>";
                      while ($row_horizontales = pg_fetch_array($res_horizontales)){
                       $itehor_descripcion = $row_horizontales["itehor_descripcion"];
                       echo "  <th  bgcolor='#FFFFFF'  width='100' valign='top'><b><font color='#008000'>$itehor_descripcion</font></th>";
                      }
                      echo "</tr>";
                      $encabezado = True;
                     }
                     //else{
                        //echo "<th  bgcolor='#FFFFFF'  width='120' height='24'></th>";
                        echo "<tr>";
                        echo "<th  bgcolor='#FFFFFF'  width='50'></th>";
                      //echo "<th  bgcolor='#FFFFFF'  width='300'></th>";
                        echo "<th  bgcolor='#FFFFFF'  width='30' valign='top' align='center'><b>$literal.</b></th>";
                        echo "<td  bgcolor='#FFFFFF'   valign='top'>$res_enunciado</td>";
                        $res_codigo  = substr($row_respuestas["res_codigo"],0,16);
                        $query_radios = "SELECT * FROM respuestas
                                          WHERE res_pre_codigo = '$pre_codigo'
                                            AND res_codigo NOT LIKE '%00'
                                            AND res_codigo LIKE '$res_codigo%'
                                       ORDER BY res_codigo ASC";
                        $res_radios   = pg_query($query_radios);
                        while ($row_radios = pg_fetch_array($res_radios)){
                         $res_codigo = $row_radios["res_codigo"];
                         $resAux_codigo =  substr($row_respuestas["res_codigo"],0,16);
                         $resAux_codigo = $resAux_codigo.'00';
                         echo "<th  bgcolor='#FFFFFF'  valign='top'><input type='radio' name = respuestas[$resAux_codigo] value=$res_codigo>";
                        }
                        echo "<tr>";
					}
					elseif ($pre_tippre_codigo == '03') { //para radios  seleccion unica
                        echo "<td  bgcolor='#FFFFFF'  width='120' height='24'></td>";
                        echo "<td  bgcolor='#FFFFFF'  width='30' valign='top' align='center'><b>$literal.</b></td>";
                        if(($res_abreviada == 'Otro')||($res_abreviada == 'Otra')||($res_codigo == '150200')||($res_codigo == '100300')||($res_codigo == '230200')){
                           echo "<td  bgcolor='#FFFFFF'  width='850' valign='top'><input type='radio' name = respuestas[$pre_codigo] value=$res_codigo onclick='habilita($pre_codigo)'>";
                        }
                        else{
                           echo "<td  bgcolor='#FFFFFF'  width='736' valign='top'><input type='radio' name = respuestas[$pre_codigo] value=$res_codigo onclick='deshabilita($pre_codigo)'>";
                        }
                        echo "$res_enunciado";
                    echo "<tr>";
				   } //fin del seleccion unica
				   elseif ($pre_tippre_codigo == '02') { //para radios  seleccion unica
                        echo "<td  bgcolor='#FFFFFF'  width='155' height='24'></td>";
                        echo "<td  bgcolor='#FFFFFF'  width='250' valign='top' align='center'><b></b></td>";
                        echo "<td  bgcolor='#FFFFFF'  width='736' valign='top'><TEXTAREA name = respuestas[$res_codigo] rows='3' cols='$res_longitud' value='' ></TEXTAREA>";
                        echo "$res_enunciado";
                    echo "<tr>";
				   } //fin del seleccion unica
                   elseif ($pre_tippre_codigo == '01') { //para cajas de texto una linea
                        echo "<td  bgcolor='#FFFFFF'  width='155' height='24'></td>";
                        echo "<td  bgcolor='#FFFFFF'  width='250' valign='top' align='center'><b></b></td>";
                        if ($res_tipdat_codigo =='02')
                         echo "<td  bgcolor='#FFFFFF'  width='736' valign='top'>$res_enunciado<input type='text'  name = respuestas[$res_codigo] value='' size=$res_longitud onkeypress='pulsada(event, 1);'>$tipuni_descripcion ";
                        else
                         echo "<td  bgcolor='#FFFFFF'  width='736' valign='top'>$res_enunciado<input type='text'  name = respuestas[$res_codigo] value='' size=$res_longitud >$tipuni_descripcion ";
                        //echo "<td  bgcolor='#FFFFFF' >$res_enunciado</td>";
                    echo "<tr>";
				   } //fin cajas de texto una sola linea
               $literal++;
              }
              echo "</table>";  //fin tabla caracteristicas
              $encabezado = False;
         } //fin de la pregunta
         $preAnterior = $preActual;

        echo "</table>"; //fin tabla respuestas x pregunta
     echo "   </table>"; //fin tabla pregunta
       echo "  <tr>";
       echo "    <td  bgcolor='#FFFFFF'  height='150'></td>";
       echo "    <td  bgcolor='#FFFFFF' ></td>";
       echo "  </tr>";
     echo "</table>";
     //}//FIN DEL FACTOR
     $facAnterior = $facActual;
     }//fin tipo pregunta 00
     else{
       echo "<br><P>$pre_enunciado</P>";
     }
    }//fin del cuestionario

  echo "<BR><BR><table border='0' cellpadding='0' cellspacing='0' width='726'>";
  echo "  <tr>";
  //echo "    <td  bgcolor='#FFFFFF'  align='center' valign='middle'><center><a href='javascript: validar();'><img src='./images/enviar.PNG'></a></td>";
  echo "    <td   align='center' valign='middle'><center><a href='javascript: validar();'><img src='./images/enviar.PNG'></a></td>";
  echo "  </tr>";
  echo "</table>";

?>
    </p>
    </td>
  </tr>
  <tr>
    <td  bgcolor='#FFFFFF'  bgcolor="#CCCCCC"><div align="center">
      <div align="center" class="Contenido_TXT">&copy;   Universidad Cat&oacute;lica de Manizales UCM <br />
        carrera 23 n&uacute;mero 60-63 // tel&eacute;fonos   (57) +6 8782900 // fax (57) +6 8782950 // apartado a&eacute;reo 357<br />
        Manizales -   Caldas - Colombia</div>
    </div></td>
  </tr>
</table>

<script type="text/javascript">
function validar(){
  var sw=0; var k=1; var Fuente;
  var el = document.frm.elements; var k=1;
  for (var i = 0 ; i < el.length ; ++i) {
    if (el[i].type == "hidden") {
      Fuente = document.frm.elements[i].name;
    }

    if (el[i].type == "radio") {   //radio vertical una sola respuesta  0306003010502a la que no es obligada
        var radiogroup = el[el[i].name];
        var itemchecked = false;
        for (var j = 0 ; j < radiogroup.length ; ++j) {   // 0302004010304a0100    0302004010304a0200
            if (radiogroup[j].checked) {
              itemchecked = true;
              break;
            }       //
            if ((radiogroup[j].name == "respuestas[0411006010402a]")
             ||((radiogroup[j].name == "respuestas[0604003010402a0100]")|| (radiogroup[j].name == "respuestas[0604003010402a0200]")|| (radiogroup[j].name == "respuestas[0604003010402a0300]"))
             ||((radiogroup[j].name == "respuestas[0101004010302a]")||(radiogroup[j].name == "respuestas[0101004010303a]")||(radiogroup[j].name == "respuestas[0101004010304a]")
             || (radiogroup[j].name == "respuestas[0101004010305a0100]")|| (radiogroup[j].name == "respuestas[0101004010305a0200]")|| (radiogroup[j].name == "respuestas[0101004010305a0300]"))
             ||((radiogroup[j].name == "respuestas[0103003010302a]")||(radiogroup[j].name == "respuestas[0204004010301a]")||(radiogroup[j].name == "respuestas[0205002010301a]")
             || (radiogroup[j].name == "respuestas[0302004010304a0100]")||(radiogroup[j].name == "respuestas[0302004010304a0200]"))

             ||((radiogroup[j].name == "respuestas[0101004010502a]")||(radiogroup[j].name == "respuestas[0101004010503a]")||(radiogroup[j].name == "respuestas[0101004010504a]")
             || (radiogroup[j].name == "respuestas[0101004010505a0100]")|| (radiogroup[j].name == "respuestas[0101004010505a0200]")|| (radiogroup[j].name == "respuestas[0101004010505a0300]"))
             ||((radiogroup[j].name == "respuestas[0103002010502a]")||(radiogroup[j].name == "respuestas[0103003010502a]")||(radiogroup[j].name == "respuestas[0205002010501a]")
             || (radiogroup[j].name == "respuestas[0306003010502a]")||(radiogroup[j].name == "respuestas[010302010501a]"))
             
             ||((radiogroup[j].name == "respuestas[0101004010602a]")||(radiogroup[j].name == "respuestas[0101004010603a]")||(radiogroup[j].name == "respuestas[0101004010604a]")
             || (radiogroup[j].name == "respuestas[0101004010605a0100]")|| (radiogroup[j].name == "respuestas[0101004010605a0200]")|| (radiogroup[j].name == "respuestas[0101004010605a0300]"))
             ||((radiogroup[j].name == "respuestas[0101004010603a]")||(radiogroup[j].name == "respuestas[0101004010604a]"))
             
             ||((radiogroup[j].name == "respuestas[0101004010802a]")||(radiogroup[j].name == "respuestas[0101004010803a0100]")||(radiogroup[j].name == "respuestas[0101004010803a0200]")||(radiogroup[j].name == "respuestas[0101004010803a0300]"))
             ||((radiogroup[j].name == "respuestas[0402003010302a0100]")||(radiogroup[j].name == "respuestas[0402003010302a0200]"))
             
             ||(radiogroup[j].name == "respuestas[0305006010802a]")
             ||(radiogroup[j].name == "respuestas[0103003010601a]")



             )
             {
              itemchecked = true;
              break;
            }
        }//fin items del grupo

        if (!itemchecked) {
            //alert("No ha respondido la pregunta con " + );
            sw = 1;
            break;
        }
    }//fin radios

    if (el[i].type == "text") {
        var caja = el[el[i].name];
        var cajallena = false;
        if (document.frm.elements[i].value != "") {
              cajallena = true;
        }
        if ((document.frm.elements[i].name == "respuestas[0604003010402a0100]")
          ||(document.frm.elements[i].name == "respuestas[0403003010301a0300]")
          ||(document.frm.elements[i].name == "respuestas[0403003010501a0300]")
          ||(document.frm.elements[i].name == "respuestas[0000000010602a0500]")
          ||(document.frm.elements[i].name == "respuestas[0000000010702a0600]")
          ||(document.frm.elements[i].name == "respuestas[0000000010807a0600]")
          ||(document.frm.elements[i].name == "respuestas[0000000010808a0700]")
          
        ){
              cajallena = true;
        }
        if (!cajallena) {
            sw = 1; break;
        }
    }//fin cajas de texto

    if (el[i].type == "textarea") {
        var caja = el[el[i].name];
        var cajallena = false;
        if (document.frm.elements[i].value != "") {
              cajallena = true;
        }    //
        if ((document.frm.elements[i].name == "respuestas[0411006010403a0100]")
         || (document.frm.elements[i].name == "respuestas[9999000010401a0100]")
         || (document.frm.elements[i].name == "respuestas[9999000010301a0100]")
         || (document.frm.elements[i].name == "respuestas[0501002010302a0100]")
         || (document.frm.elements[i].name == "respuestas[9999000010501a0100]")
         || (document.frm.elements[i].name == "respuestas[0501002010502a0100]")
         || (document.frm.elements[i].name == "respuestas[0501002010602a0100]")
         || (document.frm.elements[i].name == "respuestas[0501002010702a0100]")
         || (document.frm.elements[i].name == "respuestas[9999000010601a0100]")
         || (document.frm.elements[i].name == "respuestas[9999000010701a0100]")
         
         || (document.frm.elements[i].name == "respuestas[9999000010801a0100]")

           ) {
              cajallena = true;
        }
        if (!cajallena) {
            //alert("No ha respondido la pregunta con " + );
            sw = 1; break;
        }
    }//fin text area
  }//fin recorrer todos los elementos
  if (sw == 0) {
    //return true;
    document.forms[0].submit();
    opener.focus();
    window.close();
  } else {
    var pregunta = document.frm.elements[i].name;
    var numero   = pregunta.slice(11,13);
    if (numero == '00'){
      alert("Favor completar la Información Inicial");
      document.frm.elements[i].focus();
    }
    else
      alert("Faltan preguntas por responder en el Factor Nro. " + numero);
      //OJO activar, para ver el codigo de la respuesta que NO es obligada,para colocarlo en la condicion anterior
      //alert("Faltan preguntas por responder en el Factor Nro. " + document.frm.elements[i].name);

      document.frm.elements[i].focus();
  }

}

</script>

<script language="JavaScript">

function habilita(pre_codigo){
  var j = 0;
  var pregunta = parseInt(pre_codigo);
  switch (pregunta){
    case 6: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[060900]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 7: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[070700]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 8: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[080300]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 10: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[100400]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 15: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[150300]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 17: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[170900]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 19: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[190400]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 22: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[221000]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 23: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[230300]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
    case 27: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[270900]") {
                 document.frm.elements[j].disabled = false;
                 document.frm.elements[j].value = "";
                 document.frm.elements[j].focus();
                 break;
               }
               j++;
            } break;
  }
}

function deshabilita(pre_codigo){
    //document.frm.respuestas[060900].disabled = true;
    //document.frm.respuestas[06].value = "";
    var j = 0;
  var pregunta = parseInt(pre_codigo);
  switch (pregunta){
    case 6: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[060900]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 7: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[070700]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 8: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[080300]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 10: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[100400]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 15: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[150300]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 17: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[170900]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 19: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[190400]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 22: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[221000]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 23: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[230300]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
    case 27: while (j < document.frm.elements.length) {
               if (document.frm.elements[j].name == "respuestas[270900]") {
                 document.frm.elements[j].disabled = true;
                 document.frm.elements[j].value = " ";
                 break;
               }
               j++;
            } break;
  }
}

</script>
</body>
</html>
