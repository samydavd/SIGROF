<?php

Route::name('/')->get('/','loginController@index');

Route::name('archivo_reporte')->post('archivo_reporte', 'reporteController@buscar');

Route::name('asignar')->post('asignar','asignacionController@asignar');

Route::name('cerrar_sesion')->get('cerrar_sesion','loginController@cerrar_sesion');

Route::name('clientes')->get('clientes', 'clienteController@clientes');

Route::name('clientes_add')->get('clientes_add', 'clienteController@clientes_add');

Route::name('clientes_add/{id}')->get('clientes_add/{id}', 'clienteController@clientes_add');

Route::name('clientes_add_db')->post('clientes_add_db','clienteController@clientes_add_db');

Route::name('clientes_elm')->post('clientes_elm','clienteController@eliminar');

Route::name('comprador')->post('comprador', 'contactoController@comprador');

Route::name('contactos_act')->post('contactos_act','contactoController@actualizar');

Route::name('contrataciones')->get('contrataciones', 'contratacionController@contrataciones');

Route::name('contrataciones_detalles/{id?}')->get('contrataciones_detalles/{id?}', 'contratacionController@contrataciones_detalles');

Route::name('cotizacion_acc')->post('cotizacion_acc','cotizacionController@aprobacion');

Route::name('cotizaciones')->get('cotizaciones', 'cotizacionController@cotizaciones');

Route::name('cotizaciones_aprobadas')->get('cotizaciones_aprobadas', 'cotizacionController@cotizaciones_aprobadas'); 

Route::name('cotizaciones_liberacion')->get('cotizaciones_liberacion', 'cotizacionController@cotizaciones_liberacion');

Route::name('cotizar')->post('cotizar','cotizacionController@cotizar');

Route::name('datos_mas_informacion')->post('datos_mas_informacion', 'consultaController@datos_mas_informacion');

Route::name('declinadas')->get('declinadas', 'declinarController@declinadas');

Route::name('declinar')->post('declinar','declinarController@requerimiento_declinar');

Route::name('declinar_confirmar')->post('declinar_confirmar', 'declinarController@confirmar');

Route::name('departamento_limite')->post('departamento_limite', 'departamentoController@limites');

Route::name('departamentos')->get('departamentos', 'departamentoController@departamentos');

Route::name('departamentos_act')->post('departamentos_act','departamentoController@actualizar');

Route::name('departamentos_add')->get('departamentos_add', 'departamentoController@departamentos_add');

Route::name('departamentos_add/{id}')->get('departamentos_add/{id}', 'departamentoController@departamentos_add');

Route::name('departamentos_add_db')->post('departamentos_add_db', 'departamentoController@departamentos_add_db');

Route::name('departamentos_elm')->post('departamentos_elm','departamentoController@eliminar');

Route::name('empresas')->get('empresas', 'empresaController@empresas');

Route::name('empresas_add')->get('empresas_add', 'empresaController@empresas_add');

Route::name('empresas_add/{id}')->get('empresas_add/{id}', 'empresaController@empresas_add');

Route::name('empresas_add_db')->post('empresas_add_db', 'empresaController@empresas_add_db');

Route::name('empresas_elm')->post('empresas_elm','empresaController@eliminar');

Route::name('entregas_facturar')->get('entregas_facturar','entregaController@por_facturar');

Route::name('entregas_pendientes')->get('entregas_pendientes','entregaController@pendientes');

Route::name('enviar_cot')->post('enviar_cot','cotizacionController@enviar');

Route::name('enviar_solicitud')->post('enviar_solicitud','consultaController@enviar_solicitud');

Route::name('feriados')->get('feriados', 'feriadoController@feriados');

Route::name('feriados_add')->get('feriados_add', 'feriadoController@feriados_add');

Route::name('feriados_add/{id?}')->get('feriados_add/{id?}', 'feriadoController@feriados_add');

Route::name('feriados_add_db')->post('feriados_add_db', 'feriadoController@feriados_add_db');

Route::name('feriados_elm')->post('feriados_elm','feriadoController@eliminar');

Route::name('mapa_acceso')->get('mapa_acceso','mapaController@mapa_acceso');

Route::name('mapa_acceso_add_db')->post('mapa_acceso_add_db','mapaController@mapa_acceso_add_db');

Route::name('mapas_act')->post('mapas_act','mapaController@actualizar');

Route::name('mapas_elm')->post('mapas_elm','mapaController@eliminar');

Route::name('mas_informacion')->post('mas_informacion','consultaController@mas_informacion');

Route::name('modificar_nde')->post('modificar_nde', 'entregaController@modificar');

Route::name('niveles')->get('niveles', 'nivelController@niveles');

Route::name('niveles_add')->get('niveles_add', 'nivelController@niveles_add');

Route::name('niveles_add/{id?}')->get('niveles_add/{id?}', 'nivelController@niveles_add');

Route::name('niveles_add_db')->post('niveles_add_db', 'nivelController@niveles_add_db');

Route::name('notificaciones')->post('notificaciones', 'notificacionController@cargar');

Route::name('ordenes_add/{id?}')->get('ordenes_add/{id?}', 'ordenController@ordenes_add');

Route::name('ordenes_add_db')->post('ordenes_add_db', 'ordenController@ordenes_add_db');

Route::name('ordenes_detalles/{id}')->get('ordenes_detalles/{id}', 'ordenController@ordenes_detalles');

Route::name('ordenes_detalles/cerrar_orden')->post('ordenes_detalles/cerrar_orden', 'ordenController@cerrar');

Route::name('ordenes_detalles/comentarios_add')->post('ordenes_detalles/comentarios_add', 'comentarioController@comentarios_add');

Route::name('ordenes_detalles/procesar')->post('ordenes_detalles/procesar', 'ordenController@procesar');

Route::name('ordenes_detalles/registrar_nde')->post('ordenes_detalles/registrar_nde', 'entregaController@registrar');

Route::name('ordenes_new')->get('ordenes_new', 'ordenController@ordenes_new');

Route::name('ordenes_nuevas')->get('ordenes_nuevas','ordenController@listado_nuevos');

Route::name('pagar_factura')->post('pagar_factura', 'pagoController@pagar');

Route::name('principal')->get('principal','principalController@principal');

Route::name('procesar')->post('procesar','requerimientoController@requerimiento_procesar');

Route::name('reactivar')->post('reactivar', 'declinarController@reactivar');

Route::name('registrar_factura')->post('registrar_factura', 'facturaController@registrar');

Route::name('reporte/{id?}')->get('reporte/{id?}', 'reporteController@generado');

Route::name('reporte_general/{id?}')->get('reporte_general/{id?}', 'reporteController@generado_general');

Route::name('reportes_especificos')->get('reportes_especificos', 'reporteController@formulario');

Route::name('reportes_especificos_add_bd')->post('reportes_especificos_add_bd', 'reporteController@especifico_add_db');

Route::name('reportes_especificos_generar')->post('reportes_especificos_generar', 'reporteController@especifico_generar');

Route::name('reportes_generales')->get('reportes_generales', 'reporteController@formulario_generales');

Route::name('reportes_generales_add_db')->post('reportes_generales_add_db', 'reporteController@generales_add_db');

Route::name('reportes_generales_generar')->post('reportes_generales_generar', 'reporteController@generales_generar');

Route::name('requerimiento_rechazar')->post('requerimiento_rechazar','requerimientoController@rechazar');

Route::name('requerimientos')->get('requerimientos','requerimientoController@requerimientos');

Route::name('requerimientos_add')->get('requerimientos_add','requerimientoController@requerimientos_add');

Route::name('requerimientos_add_db')->post('requerimientos_add_db','requerimientoController@requerimientos_add_db');

Route::name('requerimientos_detalles/{id?}')->get('requerimientos_detalles/{id?}','requerimientoController@requerimientos_detalles');

Route::name('requerimientos_detalles/comentarios_add')->post('requerimientos_detalles/comentarios_add','comentarioController@comentarios_add');

Route::name('requerimientos_nuevos')->get('requerimientos_nuevos','requerimientoController@listado_nuevos');

Route::name('respuesta_recibida_db')->post('respuesta_recibida_db', 'respuestaController@respuesta_db');

Route::name('solicitud_informacion')->get('solicitud_informacion', 'consultaController@listado_mas_informacion');

Route::name('solicitud_respuesta')->get('solicitud_respuesta', 'respuestaController@listado_respuestas');

Route::name('solicitudes_detalles/analistas')->post('solicitudes_detalles/analistas','usuarioController@lista_analistas');

Route::name('solicitudes_detalles/contactos_correos')->post('solicitudes_detalles/contactos_correos','contactoController@correos');

Route::name('sondeos_add')->get('sondeos_add', 'sondeoController@sondeos');

Route::name('subclientes')->get('subclientes','subclienteController@subclientes');

Route::name('subclientes_act')->post('subclientes_act','subclienteController@actualizar'); 

Route::name('subclientes_add')->get('subclientes_add','subclienteController@subclientes_add');

Route::name('subclientes_add/{id?}')->get('subclientes_add/{id?}','subclienteController@subclientes_add');

Route::name('subclientes_add/{id?}/{id_sub?}')->get('subclientes_add/{id?}/{id_sub?}','subclienteController@subclientes_add');

Route::name('subclientes_add_db')->post('subclientes_add_db','subclienteController@subclientes_add_db');

Route::name('subclientes_elm')->post('subclientes_elm','subclienteController@eliminar');

Route::name('usuarios')->get('usuarios', 'usuarioController@usuarios');

Route::name('usuarios_add')->get('usuarios_add','usuarioController@usuarios_add');

Route::name('usuarios_add/{id?}')->get('usuarios_add/{id?}', 'usuarioController@usuarios_add');

Route::name('usuarios_add/departamentos_act')->post('usuarios_add/departamentos_act','departamentoController@actualizar');

Route::name('usuarios_add_db')->post('usuarios_add_db','usuarioController@usuarios_add_db');

Route::name('usuarios_elm')->post('usuarios_elm','usuarioController@eliminar');

Route::name('validar_sesion')->post('validar_sesion', 'loginController@validar_sesion');

/*FUNCION VALIDAR SESION - PROXIMAMENTE*/ 

// clientes_add')->get('clientes_add', ['middleware' => 'auth', 'principalController@clientes_add']);
