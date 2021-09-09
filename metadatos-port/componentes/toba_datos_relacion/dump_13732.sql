------------------------------------------------------------
--[13732]--  Respuestas 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'42', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Respuestas', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'admin_encuestas', --fuente_datos_proyecto
	'admin_encuestas', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2010-02-10 09:59:04', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'42', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'admin_encuestas', --proyecto
	'11213', --dep_id
	'13732', --objeto_consumidor
	'13745', --objeto_proveedor
	'horizontales', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'admin_encuestas', --proyecto
	'11211', --dep_id
	'13732', --objeto_consumidor
	'13721', --objeto_proveedor
	'preguntas', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'admin_encuestas', --proyecto
	'11215', --dep_id
	'13732', --objeto_consumidor
	'13747', --objeto_proveedor
	'text_area', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'5'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'admin_encuestas', --proyecto
	'11214', --dep_id
	'13732', --objeto_consumidor
	'13746', --objeto_proveedor
	'text_field', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'4'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'admin_encuestas', --proyecto
	'11212', --dep_id
	'13732', --objeto_consumidor
	'13744', --objeto_proveedor
	'verticales', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1439', --asoc_id
	NULL, --identificador
	'admin_encuestas', --padre_proyecto
	'13721', --padre_objeto
	'preguntas', --padre_id
	NULL, --padre_clave
	'admin_encuestas', --hijo_proyecto
	'13744', --hijo_objeto
	'verticales', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1440', --asoc_id
	NULL, --identificador
	'admin_encuestas', --padre_proyecto
	'13721', --padre_objeto
	'preguntas', --padre_id
	NULL, --padre_clave
	'admin_encuestas', --hijo_proyecto
	'13745', --hijo_objeto
	'horizontales', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'2'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1441', --asoc_id
	NULL, --identificador
	'admin_encuestas', --padre_proyecto
	'13721', --padre_objeto
	'preguntas', --padre_id
	NULL, --padre_clave
	'admin_encuestas', --hijo_proyecto
	'13746', --hijo_objeto
	'text_field', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'3'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1442', --asoc_id
	NULL, --identificador
	'admin_encuestas', --padre_proyecto
	'13721', --padre_objeto
	'preguntas', --padre_id
	NULL, --padre_clave
	'admin_encuestas', --hijo_proyecto
	'13747', --hijo_objeto
	'text_area', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'4'  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1439', --asoc_id
	'13721', --padre_objeto
	'18120', --padre_clave
	'13744', --hijo_objeto
	'18137'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1439', --asoc_id
	'13721', --padre_objeto
	'18121', --padre_clave
	'13744', --hijo_objeto
	'18135'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1439', --asoc_id
	'13721', --padre_objeto
	'18122', --padre_clave
	'13744', --hijo_objeto
	'18136'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1440', --asoc_id
	'13721', --padre_objeto
	'18120', --padre_clave
	'13745', --hijo_objeto
	'18150'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1440', --asoc_id
	'13721', --padre_objeto
	'18121', --padre_clave
	'13745', --hijo_objeto
	'18148'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1440', --asoc_id
	'13721', --padre_objeto
	'18122', --padre_clave
	'13745', --hijo_objeto
	'18149'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1441', --asoc_id
	'13721', --padre_objeto
	'18120', --padre_clave
	'13746', --hijo_objeto
	'18163'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1441', --asoc_id
	'13721', --padre_objeto
	'18121', --padre_clave
	'13746', --hijo_objeto
	'18161'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1441', --asoc_id
	'13721', --padre_objeto
	'18122', --padre_clave
	'13746', --hijo_objeto
	'18162'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1442', --asoc_id
	'13721', --padre_objeto
	'18120', --padre_clave
	'13747', --hijo_objeto
	'18109'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1442', --asoc_id
	'13721', --padre_objeto
	'18121', --padre_clave
	'13747', --hijo_objeto
	'18107'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'admin_encuestas', --proyecto
	'13732', --objeto
	'1442', --asoc_id
	'13721', --padre_objeto
	'18122', --padre_clave
	'13747', --hijo_objeto
	'18108'  --hijo_clave
);
