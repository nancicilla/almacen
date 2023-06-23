<?php

/*
 * NotaborradorController.php
 *
 * Version 0.$Rev: 1109 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2022-04-04 13:07:40 -0400 (lun, 04 abr 2022) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class NotaborradorController extends Controller {
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

        $model = new Notaborrador;
        $productonotaborrador = array();
        $isValidacionExitosa = true;
        $mensajeExito = "Creación exitosa!";
        $mensajeError = "Revise los datos!";

        if (isset($_POST['Notaborrador'])) {
            if (isset($_POST['Productonotaborrador'])) {
                $postNota = $_POST['Notaborrador'];
                $productonotaborrador = $_POST['Productonotaborrador'];
                $model->attributes = $_POST['Notaborrador'];
                $model->numero = $model->generarNumero();
                
                $mensaje = 'La cantidad debe ser mayor a CERO! ';
                $productoNotaborrador = $_POST['Productonotaborrador'];
               
                $arrayColumnaCantidades = array_column($productoNotaborrador, 'cantidad');
                $arrayIdsProdcutos = array_column($productoNotaborrador, 'idproducto');
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
                        foreach ($productoNotaborrador as $value) {
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
                    for($k=1;$k<=count($productonotaborrador);$k++){
                        if($productonotaborrador[$k]['glosa']==null)
                                $productonotaborrador[$k]['glosa']=$model->glosa;
                    }
                    
                    if ($model->save()) {
                        $arrayParametros = array(
                            'idnota' => $model->id,
                            'productonotaborrador' => $productonotaborrador,
                            'tipo' => $tipo,
                            'causa' => $causa,
                            'numero' => $numero,
                            'idtipo' => $model->idtipo,
                            'idtipodocumento' => $model->idtipodocumento,
                            'postNota' => $postNota,
                        );
                        Productonotaborrador::model()->registrarProductoNotaborrador($arrayParametros);
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
            'productonotaborrador' => $productonotaborrador,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel(SeguridadModule::dec($id));

        if (isset($_POST['Notaborrador'])) {
            $model->attributes = $_POST['Notaborrador'];
            if ($model->save())
                $this->redirect(array('view', 'id' => SeguridadModule::enc($model->id)));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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

        $model = new Notaborrador('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Notaborrador'])) {
            $model->attributes = $_GET['Notaborrador'];
            if (!$model->validate()) {
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
     * @return Notaborrador the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Notaborrador::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Notaborrador $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'notaborrador-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Genera el reporte en formato pdf de las notas de  movimientos de 
     * productos, en caso de contener paginas se muestra una excepción
     */
    public function actionReporteNotaBorrador($id) {
        $re = new JasperReport('/reports/Almacen/notaBorrador', JasperReport::FORMAT_PDF, array(
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
     * Confirma las nota borrador y genera las notas de ingreso
     * y salida correspondientes, y el comprobante integrado
     * @param integer $id el id de la nota borrador a confirmarse
     */
    public function actionConfirmar($id) {
        $idNotaBorrador = SeguridadModule::dec($id);
        $modeloNotaBorrador = $this->loadModel($idNotaBorrador);
        
        $aux = $modeloNotaBorrador->confirmarNotaBorrador();
        $auxArray = explode(" ", $aux);
        if ($auxArray[0] !== 'exito') {
            echo $aux;
            return;
        } else {
            if ($modeloNotaBorrador->idorigen == Origen::model()->PRODUCCION) {
                //Cambiar el estado de la orden a 'En Proceso', si cumple las siguientes condiciones:
                //El estado de la orden de produccion deb estar en estado iniciado, 
                //La nota borrador generada; iddocumento=id de la orden,idtipo=2 salida, idorigen=4 produccion
                $modeloNotaBorrador->cambiaEstadoOrdenEnProceso();
                
                $modeloNotaBorrador->actualizarPrecioUnitarioOrdenRecetaProducto();
            }
        }
    }
    
    /**
     * Genera el reporte en formato pdf de las notas de borrador en lote
     */
    public function actionReporteNotaBorradorLote() {
        $re = new JasperReport('/reports/Almacen/notaBorradorLote', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Notaborrador::model()->findAll(Yii::app()->session['notaBorradorLote']), 'id'),
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
        $productonotaborrador = isset($_POST['Productonotaborrador']) ? $_POST['Productonotaborrador'] : array();
        $tabla = array();
        foreach ($productonotaborrador as $fila) {
            $fila['disponible'] = Producto::model()->getSaldoDisponible($fila['idproducto']);
            $fila['validate'] = Producto::model()->isSaldoSuficiente($fila['idproducto'], $fila['cantidad']);
            $tabla[] = $fila;
        }
        echo SGridView::validate($tabla, array('updateCol' => 'disponible'));
    }
    
    /*
     * Muestra nota borrador en el admin de notaborrador
     */
    public function actionVerNotaBorrador($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $identificador = SeguridadModule::dec($id);
        
        $model = $this->loadModel($identificador);
        $origen = Origen::model()->findByPk($model->idorigen);
        $productonotaborrador = Productonotaborrador::model()->obtenerProductoNotaBorrador($identificador);
        
        $fecha = new DateTime($model->fecha);
        $model->fecha = $fecha->format('d-m-Y');
        if($model->idtipodocumento != null)
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
        $ProductoNotaBorradorAux = Productonotaborrador::model()->find('idnotaborrador='.$model->id);
        if($ProductoNotaBorradorAux != null) {
            $producto = Producto::model()->findByPk($ProductoNotaBorradorAux->idproducto);
            $almacen = Almacen::model()->findByPk($producto->idalmacen);
        }
        else {
            $almacen = Almacen::model()->findByPk(1);
            $almacen->nombre = 'NULO';
        }
        
        
        if(isset($_POST['Notaborrador']))
        {
            return;
        }

        $this->renderPartial('verNotaBorrador',array(
            'model' => $model,
            'documento' => $documento,
            'estado' => $estado,
            'origen' => $origen,
            'productonotaborrador' => $productonotaborrador,        
            'almacen' => $almacen,
        ), false, true);
    }
            
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
    
    /**
     * Filtrar productos por codigo
     */
    public function actionSearchProductoCodigo() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['Productonotaborrador'])) {
            $productoExcluido = $this->getIdProducto($_POST['Productonotaborrador']);
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
     * Filtrar productos por nombre
     */
    public function actionSearchProductoNombre() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['Productonotaborrador'])) {
            $productoExcluido = $this->getIdProducto($_POST['Productonotaborrador']);
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
    * Validar si existe saldo suficiente para la cantidad que se desea retirar 
    */
    public function actionValidarCantidadCreate() {
        $idtipo = 0;
        if(isset(Yii::app()->session['idtipodocumento']))
        {
            $idtipodocumento = Yii::app()->session['idtipodocumento'];
            $idtipo = Tipodocumento::model()->findByPk($idtipodocumento)->idtipo;
        }
        
        if($idtipo == Tipo::model()->SALIDA)
        {
            $productonotaborrador = isset($_POST['Productonotaborrador']) ? $_POST['Productonotaborrador'] : array();
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
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionConfirmarNotaBorrador($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $identificador = SeguridadModule::dec($id);
        
        $model = $this->loadModel($identificador);
        $origen = Origen::model()->findByPk($model->idorigen);
        $productonotaborrador = Productonotaborrador::model()->obtenerProductoNotaBorrador($identificador);
        
        $fecha = new DateTime($model->fecha);
        $model->fecha = $fecha->format('d-m-Y');
        if($model->idtipodocumento != null)
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
        $ProductoNotaBorradorAux = Productonotaborrador::model()->find('idnotaborrador='.$model->id);
        if($ProductoNotaBorradorAux != null) {
            $producto = Producto::model()->findByPk($ProductoNotaBorradorAux->idproducto);
            $almacen = Almacen::model()->findByPk($producto->idalmacen);
        }
        else {
            $almacen = Almacen::model()->findByPk(1);
            $almacen->nombre = 'NULO';
        }
        
        
        if(isset($_POST['Notaborrador']))
        {
            //$modeloNotaBorrador = $this->loadModel($identificador);

            $modeloNotaBorrador = Notaborrador::model()->find("id=".$identificador);
            $aux = $modeloNotaBorrador->confirmarNotaBorrador();
            $auxArray = explode(" ", $aux);
            if ($auxArray[0] !== 'exito') {
                //echo $aux;
                echo System::hasErrors($aux, $modeloNotaBorrador);
                return;
            } else {
                if ($modeloNotaBorrador->idorigen == Origen::model()->PRODUCCION) {
                    //Cambiar el estado de la orden a 'En Proceso', si cumple las siguientes condiciones:
                    //El estado de la orden de produccion deb estar en estado iniciado, 
                    //La nota borrador generada; iddocumento=id de la orden,idtipo=2 salida, idorigen=4 produccion
                    $modeloNotaBorrador->cambiaEstadoOrdenEnProceso();

                    $modeloNotaBorrador->actualizarPrecioUnitarioOrdenRecetaProducto();
                }
            }
            echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
            return;
        }
        
        $this->renderPartial('confirmarNotaBorrador',array(
            'model' => $model,
            'documento' => $documento,
            'estado' => $estado,
            'origen' => $origen,
            'productonotaborrador' => $productonotaborrador,        
            'almacen' => $almacen,
        ), false, true);
    }

}
