# adaptacion_datatables
listar.php -- nuevo
listar_old.php --archivo viejo de ejemplo.

Se incluyen los CDN necesarios de datatables y plugins (idioma español, importar pdf y excel, datetime moment, etc).
se adapta la tabla con el id y las etiquetas html (thead, tbody).

La funcion se inicializa al cargar el documento completo por javascript (document.ready), antes de inicializar la tabla con datatables.
Lo cual permite que primero se visualice el documento con todas las tablas y luego ejecuta el datatables para no romper la vista.

Es ideal separar esto y llamarlo mediante una peticion.. ¿ajax?
btw, this is the way 💻
