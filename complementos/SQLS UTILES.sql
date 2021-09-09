--PERFILES CREADOS
SELECT auga.proyecto, auga.usuario_grupo_acc, nombre
  FROM desarrollo.apex_usuario_grupo_acc AS auga, desarrollo.apex_proyecto AS ap
 WHERE auga.proyecto = ap.proyecto
   AND auga.proyecto = 'admin_encuestas'
   
--PERFILES X USUARIO
SELECT auga.proyecto, auga.usuario_grupo_acc, nombre 
  FROM desarrollo.apex_usuario_grupo_acc AS auga, desarrollo.apex_proyecto AS ap, desarrollo.apex_usuario_proyecto AS aup
 WHERE (auga.proyecto = ap.proyecto AND auga.proyecto= aup.proyecto) AND (ap.proyecto = aup.proyecto) 
   and (aup.usuario_grupo_acc = auga.usuario_grupo_acc) 
   AND auga.proyecto = 'admin_encuestas' and aup.usuario = 'toba';


 SELECT auga.proyecto, auga.usuario_grupo_acc, nombre  FROM desarrollo.apex_usuario_grupo_acc AS auga, desarrollo.apex_proyecto AS ap, desarrollo.apex_usuario_proyecto AS aup
 WHERE (auga.proyecto = ap.proyecto AND auga.proyecto= aup.proyecto) AND (ap.proyecto = aup.proyecto)  
 AND (aup.usuario_grupo_acc = auga.usuario_grupo_acc) AND auga.proyecto = 'admin_encuestas' AND aup.usuario = 'toba'