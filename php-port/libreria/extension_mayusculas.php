<?php
class extension_mayusculas extends toba_ei_formulario {
	function extender_objeto_js()	{
		echo "
			{$this->objeto_js}.ini = function () {
			    //this.controlador.dep('filtro_personas').colapsar();			   
				this.ef('fac_descripcion').input().onkeyup = function() {
					var ef = {$this->objeto_js}.ef('fac_descripcion');
					ef.set_estado(ef.get_estado().toUpperCase());
				}
			}
			";
		}
}
?>
