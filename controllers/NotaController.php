<?php

/*
 * NotaController.php
 *
 * Version 0.$Rev: 915 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2018-11-08 16:32:46 -0400 (Thu 08 de Nov de 2018) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class NotaController extends Controller {
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
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Nota;
        $productonota = array();
        $isValidacionExitosa = true;
        $mensajeExito = "Creación exitosa!";
        $mensajeError = "Revise los datos!";

        if (isset($_POST['Nota'])) {
            if (isset($_POST['Productonota'])) {
                $postNota = $_POST['Nota'];
                $productonota = $_POST['Productonota'];
                $model->attributes = $_POST['Nota'];
                $model->numero = $model->generarNumero();
                
                $mensaje = 'La cantidad debe ser mayor a CERO! ';
                $productoNota = $_POST['Productonota'];
               
                $arrayColumnaCantidades = array_column($productoNota, 'cantidad');
                $arrayIdsProdcutos = array_column($productoNota, 'idproducto');
                if(array_sum($arrayColumnaCantidades) == 0)
                {
                    echo System::hasErrors($mensaje);
                    return;
                }
                else
                {
                    for($i = 0; $i < count($arrayColumnaCantidades); $i++)
                    {
                        if($arrayColumnaCantidades[$i] == 0)
                        {
                            echo System::hasErrors($mensaje);
                            return;
                        }
                    }
                }
                $idtipodocumento = '';
                if($postNota['idtipodocumento'] != null)
                $idtipodocumento = Tipodocumento::model()->findByPK($postNota['idtipodocumento'])->idtipo;
                if($idtipodocumento==2)
                for($i = 0; $i < count($arrayIdsProdcutos); $i++)
                {
                    $modelproducto=  Producto::model()->findByPk($arrayIdsProdcutos[$i]);
                    if($modelproducto != null)
                    {
                        //esta variable nos sirve para comprobar la cantidad total de un producto y compararlo con el disponible del muismo
                        $cantidadTotalProducto=0;
                        foreach ($productoNota as $value) {
                            if($value['idproducto']==$modelproducto->id)
                                $cantidadTotalProducto+=$value['cantidad'];
                        }
                        $disponible=$modelproducto->saldo-$modelproducto->reserva;
                        if($cantidadTotalProducto>$disponible){
                            $mensaje="La cantidad es mayor al disponible.";
                        echo System::hasErrors($mensaje);
                        return;}
                    }
                }
                
                if($postNota['idtipodocumento'] != null) {
                    $model->idtipo = Tipodocumento::model()->findByPK($postNota['idtipodocumento'])->idtipo;
                    $model->idtipodocumento = $postNota['idtipodocumento'];
                }
                $numero = $model->numero;
                if ($model->validate()) {
                    $tipo = Tipodocumento::model()->findByPK($model->idtipodocumento)->nombre;
                    $causa = Causa::model()->findByPk($model->idcausa)->nombre;
                    $model->glosa = $tipo.' POR '.$causa.' - '. $postNota['glosa'];
                    
                    $idcuenta = Causa::model()->find('id = '.$postNota['idcausa'])->idcuenta;
                    $model->idcontracuenta = $idcuenta;
                    $model->idalmacen = $postNota['idalmacen'];
                    
                    //las glosas de producto nota debe ser la misma que la glosa de nota si la glosa está vacia
                    for($k=1;$k<=count($productonota);$k++){
                        if($productonota[$k]['glosa']==null)
                                $productonota[$k]['glosa']=$model->glosa;
                    }
                    
                    if ($model->save()) {
                        $arrayParametros = array(
                            'idnota' => $model->id,
                            'productonota' => $productonota,
                            'tipo' => $tipo,
                            'causa' => $causa,
                            'numero' => $numero,
                            'idtipo' => $model->idtipo,
                            'idtipodocumento' => $model->idtipodocumento,
                            'postNota' => $postNota,
                        );
                        Productonota::model()->registrarProductoNota($arrayParametros);
                    } else {
                        echo System::hasErrors($mensajeError, $model);
                        return;
                    }
                } else {
                    $isValidacionExitosa = false;
                }
                
            } else {
                $isValidacionExitosa = false;
                $mensajeError = 'Debe seleccionar por lo menos un producto! ';
            }
            if ($isValidacionExitosa) {
                echo System::dataReturn($mensajeExito, array('id' => SeguridadModule::enc($model->id)));
            } else {
                echo System::hasErrors($mensajeError, $model);
            }
            return;
        }

        $this->renderPartial('create', array(
            'model' => $model,
            'productonota' => $productonota,
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

        if (isset($_POST['Nota'])) {
            $model->attributes = $_POST['Nota'];
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
                ), false, true);
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

        $model = new Nota('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Nota'])) {
            $model->attributes = $_GET['Nota'];
            if (!$model->validate()) {
                $model->search();
                echo System::hasErrorSearch($model);
                return;
            }
        }
        $this->renderPartial('admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Nota the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Nota::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Nota $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nota-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Genera el reporte en formato pdf de las notas de  movimientos de 
     * productos, en caso de contener paginas se muestra una excepción
     */
    public function actionReporteNota($id) {
        $re = new JasperReport('/reports/Almacen/nota', JasperReport::FORMAT_PDF, array(
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
     * Genera el reporte en formato pdf de las notas en lote
     */
    public function actionReporteNotaLote() {

        $re = new JasperReport('/reports/Almacen/notaLote', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Nota::model()->findAll(Yii::app()->session['notaLote']), 'id'),
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
     * Registra y actualiza la información de despacho, solo valido para notas 
     * 
     */
    public function actionDespachar($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->scenario = 'despacho';
        if (isset($_POST['Nota'])) {
            $model->attributes = $_POST['Nota'];
            if ($model->save()) {
                if ($_POST['Nota']['cantidadcaja'] !== '' || $_POST['Nota']['idchofer'] !== '' || $_POST['Nota']['descripcion'] !== '') {
                    $modelSeguimiento = new Seguimiento();
                    if ($_POST['Nota']['cantidadcaja'] === '')
                        $datosCajas = '';
                    else
                        $datosCajas = 'Se despachó ' . $_POST['Nota']['cantidadcaja'] . ' cajas';

                    if ($_POST['Nota']['idchofer'] === '')
                        $datosChofer = '';
                    else
                        $datosChofer = ' chofer ' . Chofer::model()->findByPk($_POST['Nota']['idchofer'])->nombre;

                    $modelSeguimiento->descripcion = $datosCajas . $datosChofer .
                            '. ' . $_POST['Nota']['descripcion'];
                    $modelSeguimiento->tabla='nota';
                    $modelSeguimiento->idtabla=$model->id;
                    if (!$modelSeguimiento->save()) {
                        echo System::hasErrors('Error al registra el despacho! ', $model);
                        return;
                    }
                }
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Error al modificar! ', $model);
                return;
            }
        }

        $this->renderPartial('despacho', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Filtrar productos por nombre
     */
    public function actionSearchProductoNombre() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['Productonota'])) {
            $productoExcluido = $this->getIdProducto($_POST['Productonota']);
        }
        if (isset($_POST['idalmacn'])) {
            $idalm = $_POST['idalmacn'];
        }
        $arrayParametros = array(
            'nombre' => $_POST['nombre'], 
            'productoExcluido' => $productoExcluido, 
            'idprod' => $idprod,
            'idalm' => $idalm
        );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoNombre($arrayParametros),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('name' => 'coduniversal', 'width' => 20),
                array('name' => 'codigo', 'width' => 20),
                array('name' => 'nombre', 'width' => 50),
                array('name' => 'saldo', 'value' => '$data->saldo-$data->reserva', 'width' => 20,),
                array('name' => 'udd', 'typeCol' => 'hidden', 'value' => '$data->idunidad0->simbolo'),
                array('name' => 'disponible', 'typeCol' => 'hidden', 'type' => 'number', 'value' => '$data->saldo-$data->reserva'),
                array('header' => 'Costo', 'name' => 'costo', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
                array('header' => 'Costo', 'name' => 'costoHidden', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
            ),
        ));
    }

    /**
     * Filtrar productos por codigo
     */
    public function actionSearchProductoCodigo() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['Productonota'])) {
            $productoExcluido = $this->getIdProducto($_POST['Productonota']);
        }

        if (isset($_POST['idalmacn'])) {
            $idalm = $_POST['idalmacn'];
        }
        
        $arrayParametros = array(
            'codigo' => $_POST['codigo'],
            'productoExcluido' => $productoExcluido,
            'idprod' => $idprod,
            'idalm' => $idalm
        );

        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoCodigoSinExcluir($arrayParametros),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('name' => 'coduniversal', 'width' => 20),
                array('name' => 'codigo', 'width' => 20),
                array('name' => 'nombre', 'value' => '$data->nombre', 'width' => 50),
                array('name' => 'saldo', 'value' => '$data->saldo-$data->reserva', 'width' => 20,),
                array('name' => 'udd', 'typeCol' => 'hidden', 'value' => '$data->idunidad0->simbolo'),
                array('name' => 'disponible', 'typeCol' => 'hidden', 'type' => 'number', 'value' => '$data->saldo-$data->reserva'),
                array('header' => 'Costo', 'name' => 'costo', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
                array('header' => 'Costo', 'name' => 'costoHidden', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
            ),
        ));
    }
    /**
     * Filtrar productos por nombre, para el grid de traspaso entre almacenes
     */
    public function actionSearchProductoNombre_traspAlmac() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';        
        $idalm = '';
        $nombreProducto=$_POST['nombre'];
        
        if (isset($_POST['ProductosTraspasoOrigen'])) {
            $productoExcluido = $this->getIdProducto($_POST['ProductosTraspasoOrigen']);
        }
        if (isset($_POST['idalmacen'])) {
            $idalm = $_POST['idalmacen'];
        }
        if (isset($_POST['ProductosTraspasoDestino']))
            $productoExcluido = $this->getIdProducto($_POST['ProductosTraspasoDestino']);
        
        $arrayParametros = array(
            'nombre' => $nombreProducto,
            'productoExcluido' => $productoExcluido,
            'idprod' => $idprod,
            'idalm' => $idalm,
        );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoNombre($arrayParametros),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('header' => 'codigo','name' => 'codigo','value'=>'$data->codigo', 'width' => 20),
                array('header' => 'nombre','name' => 'nombre','value'=>'$data->nombre', 'width' => 50),
                //array('name' => 'saldo', 'value' => '$data->saldo-$data->reserva', 'width' => 20,),
                array('name' => 'disponible', 'type' => 'number', 'value' => '$data->saldo-$data->reserva'),
                array('name' => 'udd', 'typeCol' => 'hidden', 'value' => '$data->idunidad0->simbolo'),
                array('header' => 'Costo', 'name' => 'costo', 'value' => '$data->saldo <= 0? $data->ultimoppp : round($data->saldoimporte/$data->saldo, 4)', 'typeCol' => 'hidden', 'type' => 'number(4)'),
                array('header' => 'Costo', 'name' => 'costoHidden', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
            ),
        ));
    }
    
    /**
     * Filtrar productos por codigo para el grid de traspaso entre almacenes
     */
    public function actionSearchProductoCodigo_traspAlmac() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        
        $codigoProducto='';  
        $codigoProducto=$_POST['codigo'];
        
        if (isset($_POST['ProductosTraspasoOrigen'])) {
            $productoExcluido = $this->getIdProducto($_POST['ProductosTraspasoOrigen']);
        }
        if (isset($_POST['idalmacen'])) {
            $idalm = $_POST['idalmacen'];
        }
        if (isset($_POST['ProductosTraspasoDestino']))
            $productoExcluido = $this->getIdProducto($_POST['ProductosTraspasoDestino']);
        
        $arrayParametros = array(
            'codigo' => $codigoProducto,
            'productoExcluido' => $productoExcluido,
            'idprod' => $idprod,
            'idalm' => $idalm,
        );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoCodigoSinExcluir($arrayParametros),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('header' => 'codigo','name' => 'codigo','value'=>'$data->codigo', 'width' => 20),
                array('header' => 'nombre','name' => 'nombre','value'=>'$data->nombre', 'width' => 50),
                //array('name' => 'saldo', 'value' => '$data->saldo-$data->reserva', 'width' => 20,),
                array('name' => 'disponible', 'type' => 'number', 'value' => '$data->saldo-$data->reserva'),
                array('name' => 'udd', 'typeCol' => 'hidden', 'value' => '$data->idunidad0->simbolo'),
                array('header' => 'Costo', 'name' => 'costo', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
                array('header' => 'Costo', 'name' => 'costoHidden', 'value' => '$data->saldo <= 0? $data->ultimoppp : $data->saldoimporte/$data->saldo', 'typeCol' => 'hidden', 'type' => 'number(4)'),
            ),
        ));
    }

    /**
     * Obtiene un array simple con los id de productos que contiene el modelo 
     * Ventapreventaproducto
     * @param Ventapreventaproducto $Productonota
     * @return Array
     */
    public function getIdProducto($Productonota) {
        $idProducto = null;
        for ($i = 1; $i < count($Productonota) + 1; $i++) {
            $idProducto[] = ($Productonota[$i]['idproducto']);
        }
        return $idProducto;
    }
    
    /**
    * Validar si existe saldo suficiente para la cantidad que se desea retirar 
    */
    public function actionValidarCantidad() {
        $idtipo = 0;
        if(isset(Yii::app()->session['idtipodocumento']))
        {
            $idtipodocumento = Yii::app()->session['idtipodocumento'];
            $idtipo = Tipodocumento::model()->findByPk($idtipodocumento)->idtipo;
        }
        
        if($idtipo == Tipo::model()->SALIDA)
        {
            $productonotaborrador = isset($_POST['Productonota']) ? $_POST['Productonota'] : array();
            $tabla = array();
            foreach ($productonotaborrador as $fila) {
                $cantidadTotalProdcutoComun=0;
                /*foreach ($productonotaborrador as $filapr) {
                    if($filapr['idproducto']==$fila['idproducto'])
                    $cantidadTotalProdcutoComun+=$filapr['cantidad'];
                }*/
                $fila['disponible'] = Producto::model()->getSaldoDisponible($fila['idproducto']);
                $fila['validate'] = Producto::model()->isSaldoSuficiente($fila['idproducto'], $fila['cantidad']);
                $tabla[] = $fila;
            }
            echo SGridView::validate($tabla, array('updateCol' => 'disponible'));   
        }
        else
            unset(Yii::app()->session['idtipodocumento']);
    }
    
    public function actionCargarcausa()
    {
        $idtipodocumento = 1;// $_POST['Nota']['idtipodocumento'];
        /*
         * $model->attributes = $_POST['Nota'];
         */
        $data = Causa::model()->findAll(
                    array('order'=>'nombre', 
                          'condition'=>'idtipodocumento=:idtipodocumento', 
                          'params'=>array(':idtipodocumento'=>(int) $idtipodocumento)));

        $data=CHtml::listData($data,'id','nombre');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }
    /**
     * Devuelve la lista de ciudades filtradas por el pais
     */
        
    /*
     * Devuelve la lista de tipos filtradas por el documento
     */
    public function actionDevuelveIdtipo($idtipodocumento)
    {
        if($idtipodocumento != null)
        {
            if(isset(Yii::app()->session['idtipodocumento']))
                unset(Yii::app()->session['idtipodocumento']);
            else
            {
                Yii::app()->session['idtipodocumento'] = $idtipodocumento;
                $resultado = Tipodocumento::model()->findAll(array('order' => 'nombre', 'condition' => "id = ".$idtipodocumento));
                header("Content-type: application/json");
                echo CJSON::encode($resultado);
            }
        }
    }
    
    public function actionVerNota($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $identificador = SeguridadModule::dec($id);
        
        $model = $this->loadModel($identificador);
        
        $fecha = new DateTime($model->fecha);
        $model->fecha = $fecha->format('d-m-Y');
        if($model->idtipodocumento)
            $documento = Tipodocumento::model()->findByPk($model->idtipodocumento);
        else
        {
            $documento = Tipodocumento::model()->findByPk(1);
            $documento->nombre = 'NULO';
        }
        
        if($model->idestado)
            $estado = Estado::model()->findByPk($model->idestado);
        else
        {
            $estado = Estado::model()->findByPk(1);
            $estado->nombre = 'NULO';
        }
        $origen = Origen::model()->findByPk($model->idorigen);
        $productonota = Productonota::model()->obtenerProductoNota($identificador);
        
        $productonotaAux = Productonota::model()->find('idnota='.$model->id);
        if($productonotaAux != null) {
            $producto = Producto::model()->findByPk($productonotaAux->idproducto);
            $almacen = Almacen::model()->findByPk($producto->idalmacen);
        }
        else {
            $almacen = Almacen::model()->findByPk(1);
            $almacen->nombre = 'NULO';
        }
        
        if(isset($_POST['verNota']))
        {
            return;
        }
        
        $this->renderPartial('verNota',array(
            'model' => $model,
            'documento' => $documento,
            'estado' => $estado,
            'origen' => $origen,
            'productonota' => $productonota,
            'almacen' => $almacen,
        ), false, true);
    }
    
    /**
     * Genera el reporte de nota valorada en formato pdf 
     * en caso de contener paginas se muestra una excepción
     */
    public function actionReporteNotaValorada($id) {
        $re = new JasperReport('/reports/Almacen/notaValorada', JasperReport::FORMAT_PDF, array(
            'pId' => SeguridadModule::dec($id),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
            'pFormatoNumeroContabilidad' => Yii::app()->params['formatNumberContabilidad'],
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
     * Genera el reporte en formato pdf de las notas valoradas en lote
     */
    public function actionReporteNotaValoradaLote() {

        $re = new JasperReport('/reports/Almacen/notaValoradaLote', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Nota::model()->findAll(Yii::app()->session['notaLote']), 'id'),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
            'pFormatoNumeroContabilidad' => Yii::app()->params['formatNumberContabilidad'],
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));

        $re->exec();

        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    
    public function actionReporteInformeBajas(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $fechaFin = $_GET['Nota']['fechaFin'];
        $fechaInicio = $_GET['Nota']['fechaInicio'];
        $iddetallenota = $_GET['Nota']['iddetallenota'];
        
        if ($fechaInicio === '') {
            $criteria=new CDbCriteria();            
            $criteria->order = 't.id ASC';               
            $ordenModel=  Orden::model()->find($criteria);
            $fechaInicio = $ordenModel->id0->fecha;
        }
        
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');                
        }
        
        $re = new JasperReport('/reports/Almacen/informeBajas', JasperReport::FORMAT_PDF, array(
            'pUsuario' => Yii::app()->user->getName(),
            'pFechaInicio' => Yii::app()->format->date(strtotime($fechaInicio)),
            'pFechaFin' => Yii::app()->format->date(strtotime($fechaFin)),
            'pIddetallenota' => $iddetallenota,
            'formatNumberProduccion' => Yii::app()->params['formatNumberProduccion'],
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
     * Abre la ventana para escojer las fechas para imprimr el reporte "Informe de Bajas"
     */
    public function actionReporteVentanaInformeBajas(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $notamodel=new Nota;
        $this->renderPartial('reporteVentanaInformeBajas',array(
            'model' => $notamodel
        ), false, true);
    }
    
    public function actionTraspasoEntreAlmacenes(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $productostraspasoorigen=array();
        $productostraspasodestino=array();
        $notamodel=new Nota;
        
        if(isset($_GET['iddocumentoproducto']))
        {
            $iddocumentoproducto = $_GET['iddocumentoproducto'];
            $notamodel->pedidoEspecial = true;
            $modelDocumentoproducto = Documentoproducto::model()->find('id = '.$iddocumentoproducto);
            $modelPedidoespecial = Pedidoespecial::model()->find('id = '.$modelDocumentoproducto->idpedido);
            $notamodel->idalmacendestino = $modelPedidoespecial->idalmacen;
            $productostraspasoorigen = Documentoproducto::model()->obtenerDocumentoproducto($iddocumentoproducto);
            $productostraspasodestino = Documentoproducto::model()->obtenerDocumentoproducto($iddocumentoproducto);
        }
        
        if(isset($_POST['TraspasoEntreAlmacenes'])){
            $idalmacenorigen=$_POST['TraspasoEntreAlmacenes']['idalmacenorigen'];
            $idalmacendestino=$_POST['TraspasoEntreAlmacenes']['idalmacendestino'];
            $glosa=$_POST['TraspasoEntreAlmacenes']['glosa'];
            if(!isset($_POST['ProductosTraspasoOrigen'])){
                echo System::hasErrors("Los productos del almacen de origen no puede estar vacio.", $notamodel); return;
            }
            if(!isset($_POST['ProductosTraspasoDestino'])){
                echo System::hasErrors("Los productos del almacen de destino no puede estar vacio.", $notamodel); return;
            }
            $productosorigen=$_POST['ProductosTraspasoOrigen'];
            $productosdestino=$_POST['ProductosTraspasoDestino'];

            $arrayParametros = array(
                'idalmacenorigen' => $idalmacenorigen,
                'idalmacendestino' => $idalmacendestino,
                'productosorigen' => $productosorigen,
                'productosdestino' => $productosdestino,
                'glosa' => $glosa,
            );
            $errores = Nota::model()->validarTraspasoEntreAlmacenes($arrayParametros);
            
            if($errores['error']){
                echo System::hasErrors($errores['mensaje'], $notamodel); return;
            }
            
            $arrayParametros = array(
                'idalmacenorigen' => $idalmacenorigen,
                'idalmacendestino' => $idalmacendestino,
                'productosorigen' => $productosorigen,
                'productosdestino' => $productosdestino,
                'glosa' => $glosa,
            );
            $erroresSalida = Nota::model()->registroSalidaTraspasoEntreAlmacenes($arrayParametros);
            
            if($erroresSalida['error']){
                echo System::hasErrors($erroresSalida['mensaje'], $notamodel); return;
            }
            
            $arrayParametros = array(
                'idalmacenorigen' => $idalmacenorigen,
                'idalmacendestino' => $idalmacendestino,
                'productosorigen' => $productosorigen,
                'productosdestino' => $productosdestino,
                'glosa' => $glosa,
                'idnota' => $erroresSalida['idnota'],
                'numeroNota' => $erroresSalida['numeroNota'],
            );
            $erroresIngreso = Notaborrador::model()->registroIngresoTraspasoEntreAlmacenes($arrayParametros);
            
            if($erroresIngreso['error']){
                echo System::hasErrors($erroresIngreso['mensaje'], $notamodel); return;
            }
            echo System::dataReturn("Se registró correctamente", array());    
            return;
        }
        
      
        $this->renderPartial('traspasoEntreAlmacenes',array(
            'model' => $notamodel,
            'productostraspasoorigen'=>$productostraspasoorigen,
            'productostraspasodestino'=>$productostraspasodestino,
        ), false, true);
    }

// ---------------------------------------------------------
// ------------------ Busca Codigo de Barra ----------------
// ---------------------------------------------------------
    public function actionBuscacodigoBarra() {
        if (isset($_POST['codigobarra'])) {
            $idalmacen = isset($_POST['idalmacen']) ? $_POST['idalmacen'] : '';
            $productoExcluido = null;

            $model = Producto::model()->find('coduniversal = ' . $_POST['codigobarra'] . ' and idalmacen =' . $_POST['idalmacen']);
            if ($model == null)
                echo 0;
            else {
                $arrayDatosProducto = array(
                    'idproducto' => $model->id,
                    'codigobarra' => $model->coduniversal,
                    'codigo' => $model->codigo,
                    'nombre' => $model->nombre,
                    'udd' => $model->idunidad0->simbolo,
                    'costo' => $model->saldo <= 0? $model->ultimoppp : $model->saldoimporte/$model->saldo,
                    'saldo' => $model->saldo-$model->reserva,
                );
                echo json_encode($arrayDatosProducto);
            }
        }
    }
}