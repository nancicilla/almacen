<?php

/*
 * InventarioController.php
 *
 * Version 0.$Rev: 1080 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2021-01-14 08:50:42 -0400 (jue, 14 ene 2021) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class InventarioController extends Controller {
    /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */

    /*
     * se debe usar este método filters en todos los controladores para permitir
     * filtrar si el usuario tiene acceso a las acciones y controlador o no, 
     */

    public function filters() {
        return array_merge(
                array(
                    'accessControl',
                    array('CrugeUiAccessControlFilter', 'publicActions' => self::_publicActionsList()),
                )
        );
    }

    /*
     * en este array deben ir las acciones publicas del modulo, las que se 
     * pueden acceder sin necesitar permisos, por defecto todas las acciones
     * se acceden solo con autorizacion, por eso el array no tiene acciones
     */

    private function _publicActionsList() {
        //en este array deben ir las acciones publicas del modulo, las que se 
        //pueden acceder sin necesitar permisos, por defecto todas las acciones
        //se acceden solo con autorizacion, por eso el array no tiene acciones
        return array(
            '',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => self::_publicActionsList(),
                'users' => array('*'),
            ),
            array(
                'allow',
                'users' => array('@'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false, 'bootbox.min.js' => false);
        $model = new Inventario;

        if (isset($_POST['Inventario'])) {
            $model->attributes = $_POST['Inventario'];
            $idAlmacen = $_POST['Inventario']['idAlmacen'];
            if (Producto::model()->existenProductosParaInventario($idAlmacen)) {
                if ($model->save()) {
                    $model->aniadirProductosInventario($model->id, $idAlmacen);
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {

                    echo System::hasErrors('Revise los datos!', $model);
                    return;
                }
            } else {
                echo System::hasErrors('El almacén no tiene productos por inventariar', $model);
                return;
            }
        }
        $this->renderPartial('create', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        if (Estado::model()->esEstadoInicio($model->idestado)) {
            $model = $this->loadModel(SeguridadModule::dec($id));

            if (isset($_POST['Inventario'])) {
                $model->attributes = $_POST['Inventario'];
                if ($model->save()) {
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos!', $model);
                    return;
                }
            }

            $this->renderPartial('update', array(
                'model' => $model,
                'productoInventario' => Productoinventario::model()->obtenerProductoinventario(SeguridadModule::dec($id)),
                    ), false, true);
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel(SeguridadModule::dec($id))->safeDelete();
        self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Inventario('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Inventario'])) {
            $model->attributes = $_GET['Inventario'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        $this->renderPartial('admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Inventario the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Inventario::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Inventario $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventario-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Genera el reporte en formato pdf del inventario, en caso de contener 
     * paginas se muestra una excepción
     */
    public function actionReporteInventario($id) {
        $re = new JasperReport('/reports/Almacen/inventario', JasperReport::FORMAT_PDF, array(
            'pId' => SeguridadModule::dec($id),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));

        $re->exec();

        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }

    /**
     * Cierra el inventario para evitar su edición
     * @param integer $id el id del modelo a ser cerrado
     */
    public function actionCerrar($id) {
        $aux = $this->loadModel(SeguridadModule::dec($id))->cerrarInventario();
        if ($aux !== 'exito') {
            echo $aux;
        }
    }

    /**
     * Reabre un inventario previamente cerrado para habilitar su edición
     * @param integer $id el id del modelo a ser reabierto
     */
    public function actionReabrir($id) {
        $aux = $this->loadModel(SeguridadModule::dec($id))->reabrirInventario();
        if ($aux !== 'exito') {
            echo $aux;
        }
    }

    /**
     * Anula un inventario
     * @param integer $id el id del modelo a ser anulado
     */
    public function actionAnular($id) {
        $aux = $this->loadModel(SeguridadModule::dec($id))->anularInventario();
        if ($aux !== 'exito') {
            echo $aux;
        }
    }

    /**
     * Confirma las diferencias de inventario y genera las notas de ingreso
     * y salida correspondientes
     * @param integer $id el id del inventario a confirmarse
     */
    public function actionConfirmar($id) {
        $aux = $this->loadModel(SeguridadModule::dec($id))->confirmarDiferenciasInventario();
        if ($aux !== 'exito') {
            echo $aux;
        }
    }

    /**
     * Invoca al metodo del modelo Productoinventario que actualiza el saldo de 
     * un determinado producto, se reciben los parametros por get a partir de la
     * función Inventario.actualizarSaldo en inventario.js 
     */
    public function actionActualizarSaldo() {
        if ($_GET['saldo'] != null) {
            $saldo = $_GET['saldo'];
        } else {
            $saldo = 0;
        }
        Productoinventario::model()->actualizarSaldo($_GET['idproducto'], SeguridadModule::dec($_GET['idinventario']), $saldo);
    }
    
    /**
     * Función que invoca al metodo ActualizarSaldoProducto en el modelo Productoinventario
     * que actualiza el saldo, saldoimporte y calcula el ppp
     */
    public function actionActualizarSaldoProducto() {
        if (isset($_GET['idproducto'])) {
            $idproducto = $_GET['idproducto'];
            if (isset($_GET['idinventario'])) {
                $idinventario = SeguridadModule::dec($_GET['idinventario']);
            } else {
                echo System::hasErrors('El producto no pertenece a este inventario!');
                return;
            }
        } else {
            echo System::hasErrors('Seleccione un producto!');
            return;
        }
        Productoinventario::model()->actualizarSaldoProducto($idproducto, $idinventario);
    }

    /**
     * Genera el reporte en formato pdf del inventario valorado, en caso de contener 
     * paginas se muestra una excepción
     */
    public function actionReporteInventarioValorado($id) {
        $re = new JasperReport('/reports/Almacen/inventarioValorado', JasperReport::FORMAT_PDF, array(
            'pId' => SeguridadModule::dec($id),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberContabilidad'],
            'pFormatoNumeroAlm' => Yii::app()->params['formatNumberAlm'],            
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));

        $re->exec();

        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    
    /**
     * Genera el reporte en formato pdf del inventario valorado al precio de venta,
     * en caso de contener paginas se muestra una excepción
     */
    public function actionReporteInventarioValoradoPrecioVenta($id) {
        $re = new JasperReport('/reports/Almacen/inventarioValoradoPrecioVenta', JasperReport::FORMAT_PDF, array(
            'pId' => SeguridadModule::dec($id),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberContabilidad'],
            'pFormatoNumeroAlm' => Yii::app()->params['formatNumberAlm'],            
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));

        $re->exec();

        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    
    /**
     * Función que abre la ventana de edición(adición y eliminación) de productos
     * a un determinado inventario
     * @param type $id
     */
    public function actionEditar($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);        
        $model = $this->loadModel(SeguridadModule::dec($id));
        if (Estado::model()->esEstadoInicio($model->idestado)) {
            $this->renderPartial('editar', array(
                'model' => $model,
                'productoInventario' => Productoinventario::model()->obtenerProductoinventario(SeguridadModule::dec($id)),
            ), false, true);
        }
    }
    
    /**
     * Función que adiciona el producto para un inventario determinado
     */
    public function actionAdicionarProductoInventario() {
        header("Content-type: application/json");
        if (isset($_GET['idproducto'])) {
            $idproducto = $_GET['idproducto'];
            if (isset($_GET['idinventario'])) {
                $idinventario = SeguridadModule::dec($_GET['idinventario']);
                $respuesta = Productoinventario::model()->adicionarProductoInventario($idproducto, $idinventario);
                if ($respuesta) echo CJSON::encode(array('bandera' => '1'));
                else echo CJSON::encode(array('bandera' => '0'));
            } else {
                echo CJSON::encode(array('bandera' => '0', 'mensaje' => 'Ocurrio un error al adicionar el producto'));
            }
        } else {
            echo CJSON::encode(array('bandera' => '0', 'mensaje' => 'Ocurrio un error'));
        }
    }

    /**
     * Función que elimina el producto de un inventario determinado
     */
    public function actionEliminarProductoInventario() {
        header("Content-type: application/json");
        if (isset($_GET['idproducto'])) {
            $idproducto = $_GET['idproducto'];
            if (isset($_GET['idinventario'])) {
                $idinventario = SeguridadModule::dec($_GET['idinventario']);
                Productoinventario::model()->eliminarProductoInventario($idproducto, $idinventario);
                echo CJSON::encode(array('bandera' => '1'));
            } else {
                echo CJSON::encode(array('bandera' => '0', 'mensaje' => 'Ocurrio un error'));
            }
        } else {
            echo CJSON::encode(array('bandera' => '0', 'mensaje' => 'Ocurrio un error'));
        }
    }
    
    /**
     * Despliega la ventana de generacion de reporte gestional
     */
    public function actionGenerarReporteGestional() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Inventario;

        $this->renderPartial('inventarioGestional', array(
            'model' => $model,
                ), false, true);
    }
    
    
    /**
     * Genera el reporte de inventario gestional de almacenes 
     * en caso de que el reporte no tenga paginas se muestra una excepción
     */
    public function actionReporteInventarioGestional() {

        if (isset($_GET['Inventario'])) {
            $idAlmacen = $_GET['Inventario']['idAlmacen'];
            $re = new JasperReport('/reports/Almacen/inventarioGestional', JasperReport::FORMAT_PDF, array(
            'pIdAlmacen' => SeguridadModule::dec($idAlmacen),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberContabilidad'],
            'pFormatoNumeroAlm' => Yii::app()->params['formatNumberAlm'],            
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
            ));

            $re->exec();

            if ($re->getPages() > 0) {
                echo $re->toPDF();
            } else {
                throw new CrugeException('El reporte no tiene páginas.', 483);
            }
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    
    public function actionReporteInventarioExcelPrecioVenta($id) {
        $inventarios = Yii::app()->almacen->createCommand('select p.codigo,p.nombre,pi.saldo as fisico,pi.saldoproducto as saldosistema,p.precio from "'.getGestionSchema().'".productoinventario pi
                                                            join producto p on p.id=pi.idproducto
                                                            where pi.idinventario='.SeguridadModule::dec($id).
                                                            'order by 1')->queryAll();
        ini_set('memory_limit', '-1');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SOLUR SRL")
                ->setLastModifiedBy("SOLUR SRL")
                ->setTitle("Reporte Inventarios")
                ->setSubject("Reporte Inventarios")
                ->setDescription("Reportes para gerencia")
                ->setKeywords("Reporte Gerencial/SOLUR SRL")
                ->setCategory("ALMACEN");

        $inf = 1;
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $fillTitulo = array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        );
        $fillCabecera = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                    'color' => array('rgb' => '000000')
                                ),
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E7EBDA')
                            )
                        );
                
        $activeSheet->setCellValue('A' . ($inf), "CODIGO");
        $activeSheet->setCellValue('B' . ($inf), "PRODUCTO");
        $activeSheet->setCellValue('C' . ($inf), "FISICO");
        $activeSheet->setCellValue('D' . ($inf), "SALDO SISTEMA");
        $activeSheet->setCellValue('E' . ($inf), "PRECIO");
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(60);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(15);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getStyle('A' . $inf)->applyFromArray($fillCabecera);
        $activeSheet->getStyle('A' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('B' . $inf)->applyFromArray($fillCabecera);
        $activeSheet->getStyle('B' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('C' . $inf)->applyFromArray($fillCabecera);
        $activeSheet->getStyle('C' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('D' . $inf)->applyFromArray($fillCabecera);
        $activeSheet->getStyle('D' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('E' . $inf)->applyFromArray($fillCabecera);
        $activeSheet->getStyle('E' . $inf)->getFont()->setBold(true);
        $inf++;
        for ($i = 0; $i < count($inventarios); $i++, $inf++) {            
            $activeSheet->setCellValue('A' . $inf, $inventarios[$i]['codigo']);
            $activeSheet->setCellValue('B' . $inf, $inventarios[$i]['nombre']);
            $activeSheet->setCellValue('C' . $inf, $inventarios[$i]['fisico']);
            $activeSheet->setCellValue('D' . $inf, $inventarios[$i]['saldosistema']);
            $activeSheet->setCellValue('E' . $inf, $inventarios[$i]['precio']);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteInventario.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    public function actionActualizar($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);        
        $model = $this->loadModel(SeguridadModule::dec($id));
        
        if (isset($_POST['Inventario'])) {
            $fechaHasta = $_POST['Inventario']['fechaHasta'];
            if ($fechaHasta==null){
                echo System::hasErrors('Debe seleccionar una fecha', $model);
                return;
            }
            $idInventario = $_POST['Inventario']['id'];
            $idalmacen= Inventarios::model()->find("t.id=".$idInventario)->idalmacen;
            
            $commandSaldoCero = Yii::app()->almacen->createCommand('update productoinventario SET saldoproducto =0,saldoimporte=0 where idinventario ='.$idInventario)->query();
            $command = Yii::app()->almacen->createCommand('update "'.getGestionSchema().'".productoinventario set saldoproducto = a.saldoproducto, saldoimporte=a.saldoproducto*a.ultimoppp, precio= a.precio from(
                                                        select sum(ingreso)-sum(salida) as saldoproducto, idproducto, p.ultimoppp, p.precio from "'.getGestionSchema().'".productonota pn
                                                        join  "'.getGestionSchema().'".nota n on n.id=pn.idnota and n.idalmacen='.$idalmacen." and pn.eliminado=false
                                                        join producto p on p.id=pn.idproducto and p.eliminado is false
                                                        where pn.fecha::date<='".$fechaHasta."'
                                                        group by idproducto,p.id
                                                        ) a where idinventario=".$idInventario.' and "'.getGestionSchema().'".productoinventario.idproducto=a.idproducto')->query();
            echo System::dataReturn('Actualización exitosa!', array('id' => SeguridadModule::enc($model->id)));
            return;
        }
//        if (Estado::model()->esEstadoInicio($model->idestado)) {
            $this->renderPartial('_actualizarSaldo', array(
                'model' => $model,
                'productoInventario' => Productoinventario::model()->obtenerProductoinventario(SeguridadModule::dec($id)),
            ), false, true);
//        }
    }

}
