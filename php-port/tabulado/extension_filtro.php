<?php
class extension_filtro extends toba_ei_formulario {
	function extender_objeto_js()	{
        echo "
            {$this->objeto_js}.evt__cue_id__procesar = function (es_inicial) {
            var test_covid = 2;
            var cuestionario = this.ef('cue_id').get_estado();
                if (cuestionario == test_covid){
                this.ef('val_fecha').mostrar()
                }
                else{
                this.ef('val_fecha').ocultar();
                }
            }
        ";
	}
}
?>
