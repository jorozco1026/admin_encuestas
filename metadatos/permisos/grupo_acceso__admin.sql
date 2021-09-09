
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	'Administrador', --nombre
	'0', --nivel_acceso
	'Accede a toda la funcionalidad', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'1', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7038'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7039'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7040'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7042'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7043'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7046'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7137'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7139'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7140'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7272'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7273'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7297'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'admin_encuestas', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'7298'  --item
);
--- FIN Grupo de desarrollo 0
