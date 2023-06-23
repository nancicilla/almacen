<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/venta.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/almacen.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/compra.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <?php
    Yii::app()->bootstrap->register();
    System::init(array('module' => 'almacen',
        'list' => array(
            // los js de otros modulos siempre deben ir primeros
            array('view' => 'solicitud', 'js' => 'Solicitud', 'module' => 'compra', 'globalName' => 'compraSolicitud'),
            array('view' => 'orden', 'js' => 'Orden', 'module' => 'produccion', 'globalName' => 'produccionOrden'),
            array('view' => 'almacen', 'js' => 'Almacen'),
            array('view' => 'almacen', 'js' => 'admAlmacen'),
            array('view' => 'producto', 'js' => 'Producto'),
            array('view' => 'producto', 'js' => 'ActualizaKardexAlmacen'),
            array('view' => 'producto', 'js' => 'admProducto'),
            array('view' => 'producto', 'js' => 'admProductoDetallado'),
            array('view' => 'producto', 'js' => 'admStock'),
            array('view' => 'producto', 'js' => 'admAsignacionsaldos'),
            array('view' => 'producto', 'js' => 'admAsignacionCostos'),
            array('view' => 'producto', 'js' => 'admAsignacionsaldosimp'),
            array('view' => 'caracteristica', 'js' => 'Caracteristica'),
            array('view' => 'caracteristica', 'js' => 'admCaracteristica'),
            array('view' => 'familia', 'js' => 'Familia'),
            array('view' => 'familia', 'js' => 'admFamilia'),
            array('view' => 'clase', 'js' => 'Clase'),
            array('view' => 'clase', 'js' => 'admClase'),
            array('view' => 'unidad', 'js' => 'Unidad'),
            array('view' => 'unidad', 'js' => 'admUnidad'),
            array('view' => 'productonota', 'js' => 'admKardex'),
            array('view' => 'productonota', 'js' => 'admKardexValorado'),
            array('view' => 'causa', 'js' => 'Causa'),
            array('view' => 'causa', 'js' => 'admCausa'),
            array('view' => 'inventario', 'js' => 'Inventario'),
            array('view' => 'inventario', 'js' => 'admInventario'),
            array('view' => 'nota', 'js' => 'Nota'),
            array('view' => 'nota', 'js' => 'admNota'),
            //--------------TRASPASO ENTRE ALMACENES--------
            array('view' => 'nota', 'js' => 'TraspasoEntreAlmacenes'),
            //----------------------------------------------
            array('view' => 'notaborrador', 'js' => 'Notaborrador'),
            array('view' => 'notaborrador', 'js' => 'admNotaborrador'),
            array('view' => 'chofer', 'js' => 'admChofer'),
            array('view' => 'chofer', 'js' => 'Chofer'),
            array('view' => 'comunicacion', 'js' => 'Comunicacion'),
            array('view' => 'comunicacion', 'js' => 'admComunicacion'),
            array('view' => 'controlseguimiento', 'js' => 'Controlseguimiento'),
            array('view' => 'controlseguimiento', 'js' => 'admControlseguimiento'),
            array('view' => 'solicitud', 'js' => 'admSolicitud'),
            // ------------------------------- "Orden" -------------------------------
            array('view' => 'orden', 'js' => 'admOrden'),
            // ------------------------------- "Devolución de OP" -------------------------------
            // ------------------------------- "Ver Ordenes de productos" -------------------------------
            array('view' => 'vistaordenpedido', 'js' => 'admVistaordenpedido'),
            // ------------------------------- "Tipodocumento" -------------------------------
            array('view' => 'tipodocumento', 'js' => 'Tipodocumento'),
            array('view' => 'tipodocumento', 'js' => 'admTipodocumento'),
            // ------------------------ Inventariar Producto -------------------
            array('view' => 'producto', 'js' => 'admInventariar'),
            //-------------------------- Pedido de Venta ------------------------
            array('view' => 'pedidos', 'js' => 'admPedidos'),
            array('view' => 'venta', 'js' => 'admVentaEntregadespacho'),
            array('view' => 'pedido', 'js' => 'Pedido', 'module' => 'venta', 'globalName' => 'VentaPedido'),
            array('view' => 'venta', 'js' => 'Venta', 'module' => 'venta', 'globalName' => 'VentaProceso'),
            array('view' => 'cambio', 'js' => 'Cambio', 'module' => 'venta', 'globalName' => 'VentaCambio'),
            // ------------------------------- "Alertas" -------------------------
            array('view' => 'alerta', 'js' => 'admAlerta'),
            array('view' => 'alerta', 'js' => 'Alerta'),
            array('view' => 'productonota', 'js' => 'Productonota'),
            array('view' => 'detallenota', 'js' => 'admDetallenota'),
            array('view' => 'detallenota', 'js' => 'Detallenota'),
            //------------------------"Desviación de costos de producto"-----------
            array('view' => 'productodesviacion', 'js' => 'admProductodesviacion'),
            //------------------------"Admin de notas recepcion desde ventas"-----------
            array('view' => 'vistanotarecepcion', 'js' => 'admVistanotarecepcion'),
            array('view' => 'notarecepcion', 'js' => 'Notarecepcion', 'module' => 'venta', 'globalName' => 'VentaNotarecepcion'),
            //-------------------------- Pedidos de Venta ------------------------
            array('view' => 'pedidoespecial', 'js' => 'admPedidoespecial'),
            //-------------------------- Pedidos de Venta ------------------------
            array('view' => 'controlcalidad', 'js' => 'Controlcalidad', 'module' => 'venta', 'globalName' => 'VentaControlcalidad'),
            array('view' => 'controlcalidad', 'js' => 'admControlcalidad', 'module' => 'venta', 'globalName' => 'VentaAdmControlcalidad'),
            //-------------------------- Traspaso de Venta ------------------------
            array('view' => 'traspaso', 'js' => 'Traspaso', 'module' => 'venta', 'globalName' => 'VentaTraspaso'),
            array('view' => 'traspaso', 'js' => 'admTraspaso', 'module' => 'venta', 'globalName' => 'VentaAdmTraspaso'),
            //-------------------------- Punto de Venta ------------------------
            array('view' => 'traspasotpv', 'js' => 'Traspasotpv'),
            array('view' => 'traspasotpv', 'js' => 'admTraspasotpv'),
            array('view' => 'devoluciontpv', 'js' => 'Devoluciontpv'),
            array('view' => 'devoluciontpv', 'js' => 'admDevoluciontpv'),
            //-------------------------- Rango Alertas Vencimientos ------------------------
            array('view' => 'rangoalertas', 'js' => 'Rangoalertas'),
            array('view' => 'rangoalertas', 'js' => 'admRangoalertas'),
            //-------------------------- Control Vencimientos ------------------------
            array('view' => 'vencimiento', 'js' => 'Vencimiento'),
            array('view' => 'vencimiento', 'js' => 'admVencimiento'),
            array('view' => 'vencimiento', 'js' => 'admProductolote'),
            //-------------------------- Orden de Trabajo ------------------------
            array('view' => 'ordentrabajo', 'js' => 'Ordentrabajo'),
            array('view' => 'ordentrabajo', 'js' => 'admOrdentrabajo'),
            //-------------------------- Receta ------------------------
            array('view' => 'receta', 'js' => 'Receta'),
            array('view' => 'receta', 'js' => 'admReceta'),
            //------------------- Agrupación de Productos TPV ------------------
            array('view' => 'producto', 'js' => 'Agrupacion'),
            array('view' => 'producto', 'js' => 'admAgrupacion'),
            //------------------- temporada ------------------
            array('view' => 'temporada', 'js' => 'Temporada'),
            array('view' => 'temporada', 'js' => 'admTemporada'),
            //------------------- Control Calidad Almacen ------------------
            array('view' => 'controlcalidadalmacen', 'js' => 'Controlcalidadalmacen'),
            array('view' => 'controlcalidadalmacen', 'js' => 'admControlcalidadalmacen'),
            //------------------- Control Calidad Almacen ------------------
            array('view' => 'controlcalidadalmacen', 'js' => 'Controlcalidadalmacen'),
            array('view' => 'controlcalidadalmacen', 'js' => 'admControlcalidadalmacen'),
            //------------------- Control Calidad Almacen ------------------
            array('view' => 'reproceso', 'js' => 'Reproceso'),
            array('view' => 'reproceso', 'js' => 'admReproceso'),
            //-----------Diseño de Envases ---------------------
            array('view' => 'caracteristicas', 'js' => 'Caracteristicas'),
            array('view' => 'caracteristicas', 'js' => 'admCaracteristicas'),
            array('view' => 'proveedor', 'js' => 'Proveedor'),
            array('view' => 'proveedor', 'js' => 'admProveedor'),
            array('view' => 'personal', 'js' => 'Personal'),
            array('view' => 'personal', 'js' => 'admPersonal'),
            array('view' => 'proyecto', 'js' => 'Proyecto'),
            array('view' => 'proyecto', 'js' => 'admProyecto'),
            
        )
    ));
    ?> 
    <body>
        <script type="text/javascript">
            var windowMessageDelay =<?= Yii::app()->params['windowMessageDelay']; ?>;
        </script>
<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/protected/components/js/sw.js');
if (Yii::app()->user->isGuest != 1) {
    require_once(Yii::app()->basePath . '/components/main.php');
    ?> 
            <div id="page">
                <div style="height: 20px; padding: 5px;  background: #171717">
            <?php
            $this->widget('bootstrap.widgets.TbNavbar', array(
                'brandLabel' => '',
                'brandUrl' => Yii::app()->createUrl("almacen"),
                'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                'display' => null, // default is static to top
                'items' => array(
                    array(
                        'class' => 'bootstrap.widgets.TbNav',
                        'items' => array(
                            array('label' => 'Almacén',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_almacen'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admAlmacen.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_create')
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admAlmacen.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_admin')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Stock',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_producto_stock'),
                                        'url' => 'javascript:admStock.actionAdmin()',
                                    ),
                                    array('label' => 'Stock Minimo',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_producto_stockminimo'),
                                                'url' => 'javascript:Producto.reportestockminimo()',
                                            ),
                                    array('label' => 'Generar Solicitud',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_producto_stockminimosolicitud'),
                                                'url' => 'javascript:Producto.solicitudtockminimo()',
                                            ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Libro Mayor',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarLibroMayor'),
                                        'url' => 'javascript:Almacen.generarLibroMayor()',
                                    ),
                                    array('label' => 'Resumen Mayor',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarResumenMayor'),
                                        'url' => 'javascript:Almacen.generarResumenMayor()',
                                    ),
                                    array('label' => 'Resumen Compras',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarResumenCompras'),
                                        'url' => 'javascript:Almacen.generarResumenCompras()',
                                    ),
                                    array('label' => 'Movimientos Almacén',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarComprobanteContable'),
                                        'url' => 'javascript:Almacen.generarComprobanteContable()',
                                    ),
                                    array('label' => 'Salidas Almacen',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarSalidasAlmacen'),
                                        'url' => 'javascript:Almacen.generarSalidasAlmacen()',
                                    ),
                                    array('label' => 'Diferencias Almacenes',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_almacen_generarDiferenciasAlmacen'),
                                        'url' => 'javascript:Almacen.formDiferenciasAlmacen()',
                                    )
                                )),
                            array('label' => 'Producto',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_producto'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Crear',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_producto_create'),
                                        'url' => 'javascript:admProducto.create()'
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admProducto.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_producto_admin')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Admistración Detallado',
                                        'url' => 'javascript:admProductoDetallado.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_productodetallado_admin')),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Consumo Promedio',
                                        'url' => 'javascript:Producto.ventanaReporteConsumoPromedioProductos()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_producto_reporteConsumoPromedioProductos')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Asignación de Consumos',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_producto_saldos'),
                                        'url' => 'javascript:admAsignacionsaldos.actionAdmin()',
                                    ),
//                                            array('label' => 'Asignación de Saldos Importe',
//                                                'visible' => Yii::app()->user->getName()=='admin',
//                                                'url' => 'javascript:admAsignacionsaldosimp.actionAdmin()',
//                                            ),
//                                            array('label' => 'Asignación de Costos',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_producto_asignacionCosto'),//Yii::app()->user->getName()=='admin',
//                                                'url' => 'javascript:admAsignacionCostos.actionAdmin()',
//                                            ),
//                                            TbHtml::menuDivider(),
//                                            array('label' => 'Desviación Costo',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_productodesviacion_admin'),
//                                                'url' => 'javascript:admProductodesviacion.actionAdmin()',
//                                            ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Familia',
                                        'visible' => Yii::app()->user->checkAccess('controller_almacen_familia'),
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admFamilia.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_familia_create')),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admFamilia.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_familia_admin'))
                                        ),
                                    ),
                                    array('label' => 'Clase',
                                        'visible' => Yii::app()->user->checkAccess('controller_almacen_clase'),
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admClase.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_clase_create')
                                            ),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admClase.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_clase_admin')
                                            ),
                                        )
                                    ),
                                    array('label' => 'Unidad',
                                        'visible' => Yii::app()->user->checkAccess('controller_almacen_unidad'),
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admUnidad.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_unidad_create')
                                            ),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admUnidad.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_unidad_admin')
                                            ),
                                        )
                                    ),
                                    array('label' => 'Características',
                                        'visible' => Yii::app()->user->checkAccess('controller_almacen_caracteristica'),
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear General',
                                                'url' => 'javascript:admCaracteristica.create(\'idgenero=2\')',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristica_create')
                                            ),
                                            array('label' => 'Crear con Imagen',
                                                'url' => 'javascript:admCaracteristica.create(\'idgenero=1\')',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristica_create')
                                            ),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admCaracteristica.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristica_admin')
                                            ),
                                            array('label' => 'Ordenar',
                                                'url' => 'javascript:admCaracteristica.personalizar()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristica_personalizar')
                                            ),
                                        )
                                    ),
                                    array('label' => 'Producto Temporada',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_temporada_create'),
                                                'url' => 'javascript:admTemporada.create()'
                                            ),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admTemporada.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_almacen_temporada_admin')
                                            ),
                                        )),
//                                            array('label' => 'Chofer',
//                                                'visible' => Yii::app()->user->checkAccess('controller_almacen_chofer'),
//                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
//                                                    array('label' => 'Crear',
//                                                        'url' => 'javascript:admChofer.create()',
//                                                        'visible' => Yii::app()->user->checkAccess('action_almacen_chofer_create')
//                                                    ),
//                                                    array('label' => 'Administrar',
//                                                        'url' => 'javascript:admChofer.actionAdmin()',
//                                                        'visible' => Yii::app()->user->checkAccess('action_almacen_chofer_admin')
//                                                    ),
//                                                )
//                                            ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Kardex',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_productonota_admin'),
                                        'url' => 'javascript:Productonota.Kardex()',
                                    ),
                                    array('label' => 'Kardex Valorado',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_productonota_adminValorado'),
                                        'url' => 'javascript:Productonota.KardexValorado()',
                                    ),
//                                            TbHtml::menuDivider(),
//                                            array('label' => 'Actualizar Kardex Almacen',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_producto_actualizarKardexProducto'),
//                                                'url' => 'javascript:ActualizaKardexAlmacen.actualizarKardexProducto()',
//                                            ),
                                )),
//                                    array('label' => 'Seguimiento',
//                                        'visible' => Yii::app()->user->checkAccess('controller_almacen_seguimiento'),
//                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
//                                            array('label' => 'Administrar',
//                                                'url' => 'javascript:admControlseguimiento.actionAdmin()',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_controlseguimiento_admin')),
//                                            array('label' => 'Comunicación'),
//                                            array('label' => 'Crear',
//                                                'url' => 'javascript:admComunicacion.create()',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_comunicacion_create')),
//                                            array('label' => 'Administrar',
//                                                'url' => 'javascript:admComunicacion.actionAdmin()',
//                                                'visible' => Yii::app()->user->checkAccess('action_almacen_comunicacion_admin')),
//                                            
//                                        )),
                            array('label' => 'Devoluciones',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_devoluciones'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admControlcalidadalmacen.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_controlcalidadalmacen_admin')),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Crear Grupo Reproceso',
                                        'url' => 'javascript:admReproceso.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_reproceso_create')),
                                    array('label' => 'Administrar Grupo Reproceso',
                                        'url' => 'javascript:admReproceso.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_reproceso_admin')),
                                )),
                            array('label' => 'Orden',
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admOrden.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_orden_admin')
                                    ),
                                    array('label' => 'Ver Ordenes',
                                        'url' => 'javascript:admVistaordenpedido.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_vistaordenpedido_admin')
                                    ),
                                    array('label' => 'Crear Ordenes de Trabajo',
                                        'url' => 'javascript:admOrdentrabajo.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_ordentrabajo_create')
                                    ),
                                    array('label' => 'Administrar Orden de Trabajo',
                                        'url' => 'javascript:admOrdentrabajo.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_ordentrabajo_admin')
                                    ),
                                    array('label' => 'Reporte Ordenes En Proceso',
                                        'url' => 'javascript:Ordentrabajo.ventanaReportePendientesFecha()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_orden_ventanaReportePendientesFecha')
                                    ),
                                    array('label' => 'Crear Receta Orden de Trabajo',
                                        'url' => 'javascript:admReceta.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_ordentrabajoReceta_create')
                                    ),
                                    array('label' => 'Administrar Recta Orden de Trabajo',
                                        'url' => 'javascript:admReceta.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_ordentrabajoReceta_admin')
                                    ),
                                )),
                            array('label' => 'Venta',
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'PEDIDO'),
//                                            array('label' => 'Crear Pedido Traspaso',
//                                                'visible' => Yii::app()->user->checkAccess('action_venta_pedido_create'),
//                                                'url' => "javascript:admPedidos.create('tipo=TRASPASO')"),
                                    array('label' => 'Administrar Pedidos',
                                        'url' => 'javascript:admPedidos.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_pedido_admin')
                                    ),
                                    /* Codigo daniel
                                      array('label' => 'Entrega/Despacho',
                                      'url' => 'javascript:admVentaEntregadespacho.actionAdmin()',
                                      'visible' => Yii::app()->user->checkAccess('action_almacen_venta_adminVentaEntregadespacho')
                                      ), */
                                    array('label' => 'TRASPASO'),
//                                            array('label' => 'Crear Traspaso',
//                                                'visible' => Yii::app()->user->checkAccess('action_venta_traspaso_create'),
//                                                'url' => 'javascript:VentaAdmTraspaso.create()'),
//                                            array('label' => 'Crear Traspaso Devolución',
//                                                'visible' => Yii::app()->user->checkAccess('action_venta_traspaso_create'),
//                                                'url' => "javascript:VentaAdmTraspaso.create('tipo=DEVOLUCION')"),
                                    array('label' => 'Administrar Traspasos',
                                        'url' => 'javascript:VentaAdmTraspaso.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_traspaso_admin')),
                                    array('label' => 'Control Calidad'),
                                    array('label' => 'Administrar',
                                        'visible' => Yii::app()->user->checkAccess('action_venta_controlcalidad_admin'),
                                        'url' => 'javascript:VentaAdmControlcalidad.actionAdmin()'),
                                    array('label' => 'Pedido Especial'),
                                    array('label' => 'Administrar',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_pedidoespecial_admin'),
                                        'url' => 'javascript:admPedidoespecial.actionAdmin()'),
                                )),
                            array('label' => 'Procesos',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_inventario'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Inventario'),
                                    array('label' => 'Crear',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_inventario_create'),
                                        'url' => 'javascript:admInventario.create()'
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admInventario.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_inventario_admin')
                                    ),
                                    array('label' => 'Seleccionar Productos',
                                        'url' => 'javascript:Producto.inventariarxalm()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_inventario_admin')
                                    ),
                                    array('label' => 'Reporte Gestional',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_inventario_generarReporteGestional'),
                                        'url' => 'javascript:Inventario.generarReporteGestional()'
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Traspaso',
                                        'visible' => Yii::app()->user->getName() == 'admin',
                                        'url' => 'javascript:Notaborrador.registrarTraspaso()'
                                    ),
                                )),
                            //----------------------- Movimientos de Productos TPV -----------------
                            array('label' => 'Punto de Venta',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_traspasotpv'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'TRASPASOS'),
                                    array('label' => 'Crear',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_traspasotpv_create'),
                                        'url' => 'javascript:Traspasotpv.create()'
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admTraspasotpv.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_traspasotpv_admin')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'DEVOLUCIONES'),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admDevoluciontpv.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_devoluciontpv_admin')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Agrupación Producto'),
                                    array('label' => 'Crear',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_agrupacion_create'),
                                        'url' => 'javascript:Agrupacion.agrupacionProductoCreate()'
//                                                'url' => 'javascript:Libros.registroLibroCompra()',
//                                                'url' => 'javascript:admAgrupacion.create()'
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admAgrupacion.actionAdmin()',
//                                                'url' => 'javascript:admControlCalidad.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_agrupacion_admin')
                                    ),
                                )),
                            //----------------------- Control de Caducidad -----------------
                            array('label' => 'Control de Caducidad',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_vencimiento'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Administrar',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_vencimiento_administrar'),
                                        'url' => 'javascript:admVencimiento.actionAdmin()'
                                    ),
                                    array('label' => 'Administrar Productos',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_vencimiento_administrarLote'),
                                        'url' => 'javascript:admProductolote.actionAdmin()'
                                    ),
                                )),
                            //----------------------- Notas -----------------
                            array('label' => 'Notas',
                                'visible' => Yii::app()->user->checkAccess('controller_almacen_nota'),
                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                    array('label' => 'Nota'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admNota.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_nota_create')
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admNota.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_nota_admin')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Traspaso entre almacenes',
                                        'url' => 'javascript:TraspasoEntreAlmacenes.traspaso()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_nota_traspasoEntreAlmacenes')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Informe Bajas',
                                        'url' => 'javascript:Nota.ventanaInformeBajas()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_nota_ventanaInformeBajas')
                                    ),
                                    TbHtml::menuDivider(),
                                    array('label' => 'Nota Borrador'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admNotaborrador.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_notaborrador_create')
                                    ),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admNotaborrador.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_notaborrador_admin')
                                    ),
                                )),
                            array('class' => 'nav navbar-nav navbar-right', 'icon' => 'wrench white', 'items' => array(
                                    // ------------------------------- "Tipo de documento" -------------------------------
                                    array('label' => 'Tipo de Documento'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admTipodocumento.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_tipodocumento_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admTipodocumento.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_tipodocumento_admin')),
                                    // ------------------------------- "Causa" -------------------------------
                                    array('label' => 'Causa'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admCausa.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_causa_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admCausa.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_causa_admin')),
                                    array('label' => 'Detalle Nota'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admDetallenota.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_detallenota_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admDetallenota.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_detallenota_admin')),
                                    // ------------------------------- "Rango Alertas Vencimiento" -------------------------------
                                    array('label' => 'Rango Alertas'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admRangoalertas.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_rangoalertas_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admRangoalertas.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_rangoalertas_admin')),
                                )),
                             array('class' => 'nav navbar-nav navbar-right','label'=>'Configuraciòn',  'items' => array(
                                    // ------------------------------- "Caracteristicas" -------------------------------
                                    array('label' => 'Caracteristicas'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admCaracteristicas.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristicas_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admCaracteristicas.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_caracteristicas_admin')),
                                    // ------------------------------- "Proveedor" -------------------------------
                                    array('label' => 'Proveedor'),
                                    array('label' => 'Registrar',
                                        'url' => 'javascript:admProveedor.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_proveedor_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admProveedor.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_proveedor_admin')),
                                    array('label' => 'Personal'),
                                    array('label' => 'Registrar',
                                        'url' => 'javascript:admPersonal.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_personal_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admPersonal.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_personal_admin')),
                                    
                                )),
                            array('class' => 'nav navbar-nav navbar-right','label'=>'Proyecto',  'items' => array(
                                    // ------------------------------- "Proyecto" -------------------------------
                                    array('label' => 'Proyecto'),
                                    array('label' => 'Crear',
                                        'url' => 'javascript:admProyecto.create()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_proyecto_create')),
                                    array('label' => 'Administrar',
                                        'url' => 'javascript:admProyecto.actionAdmin()',
                                        'visible' => Yii::app()->user->checkAccess('action_almacen_proyecto_admin')),
                                   
                                ))
                        ),
                    ),
                ),
            ));
            ?>
                    <div id="mainmenu">
                    </div><!-- mainmenu -->
                    <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        ));
        ?><!-- breadcrumbs -->
                    <?php endif ?>

                    <?php $this->widget('Flashes'); ?>
                    <div id="mainContainer" style="padding-top:3px; height: 200px">
                    <?php echo $content; ?></div>

                    <div class="clear"></div>
                </div> 
            </div><!-- page -->
    <?php
}else {
    echo $content;
    if (Yii::app()->getController()->action->id == 'login') {
        ?>
                <body
                    <div id='custom-background-login'>    
                    </div>
                </body>        
        <?php
    }
}
?>
        <?php echo gestionSchema::navegacion(); ?>
    </body>
</html>
