<?php
   require_once('libreria/combos_parametros.php');
   class extension_login extends toba_tp_logon {
        function pre_contenido()    {
            $datos_requerimientos = combos_parametros::get_requerimientos ();
            echo "<div class='login-titulo'>".toba_recurso::imagen_proyecto("logo_login.gif",true);
            echo "<div><STRONG><H1>".$datos_requerimientos[0]['reqsis_nombre_sistema']."</div>";
            echo "<div><STRONG><H1>Percepci&oacute;n Institucional</div>";  
            echo "</div>";
            echo "\n<div align='center' class='cuerpo'>\n";
	    }

        function post_contenido() {
            $datos_requerimientos = combos_parametros::get_requerimientos ();
            echo "<div style='color:#E3E3E3;'><center><TABLE border=1 cellspacing=0 cellpadding=2 bordercolor=white>";
                echo "<TR><TD style='text-align:center; color:red;'><b>Usuario<TD style='text-align:center; color:red;'>Clave";
                //echo "<TR><TD>Nro.Identificaci&oacute;n<TD>C&oacute;digo UCM - May&uacute;scula";
                echo "<TR><TD>Nro.Identificaci&oacute;n<TD>Nro.Identificaci&oacute;n";
            echo "</div></TABLE>";
            echo "<div>";
                echo "<div class='login-pie'>";
                echo "<div>Desarrollado por</div>";
                echo "<div style='color:#E3E3E3;'>".$datos_requerimientos[0]['reqsis_desarrollado_por']."</div>";
                echo "<div>Tel&eacute;fonos ".$datos_requerimientos[0]['reqsis_telefonos']."</div>";
                echo "<div>".$datos_requerimientos[0]['reqsis_mails']."</div>";
                echo "<div>Todos los Derechos Reservados.</div>";
            echo "</div>";
        }
   }
?>
