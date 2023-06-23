<?php

/*
 * OrdenController.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 14/10/2015
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (mar, 17 mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class OrdenController extends Controller {
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
     */
    public function actionCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Orden;

        if (isset($_POST['Orden'])) {
            $model->attributes = $_POST['Orden'];
            if ($model->save()) {
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Error al crear! ', $model);
                return;
            }
        }

        $this->renderPartial('create', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));

        if (isset($_POST['Orden'])) {
            $model->attributes = $_POST['Orden'];
            if ($model->save()) {
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Error al modificar! ', $model);
                return;
            }
        }

        $this->renderPartial('update', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Deletes safely a particular model.
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

        $model = new Orden('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Orden'])) {
            $model->attributes = $_GET['Orden'];
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
     * @return Orden the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Orden::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orden $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orden-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Funcion de autocompletar un campo textfield de producto
     */
    public function actionAutocompleteProducto() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $criteria = new CDbCriteria();
            $criteria->join = "INNER JOIN almacen al ON al.id = t.idalmacen";

            $criteria->addCondition("al.idalmacen IS NULL");
            $criteria->addCondition("UPPER(t.nombre) LIKE '%$requestMayuscula%'");
            $model = Producto::model()->findAll($criteria);

            //$model = Producto::model()->findAll(array('condition' => "nombre like '%$requestMayuscula%'", 'order' => 'nombre'));
            $data = array();
            foreach ($model as $get) {
                $formato = '%s';
                $data[] = array(
                    'label' => sprintf($formato, $get->nombre),
                    'value' => $get->nombre,
                    'id' => $get->id);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Funcion de autocompletar un campo textfield de orden y seguimiento
     */
    public function actionAutocompleteIngrediente() {

        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $criteria = new CDbCriteria();
            $criteria->join = "INNER JOIN almacen al ON al.id = t.idalmacen";

            $criteria->addCondition("al.idalmacen IS NULL");
            $criteria->addCondition("upper(t.codigo) LIKE '%$requestMayuscula%' OR upper(t.nombre) LIKE '%$requestMayuscula%'");
            $model = Producto::model()->findAll($criteria);

            //$model = Producto::model()->findAll(array('condition' => "nombre like '%$requestMayuscula%'", 'order' => 'nombre'));
            $data = array();
            foreach ($model as $get) {
                $formato = '%s - %s';
                $data[] = array(
                    'label' => sprintf($formato, $get->codigo, $get->nombre),
                    'value' => $get->nombre,
                    'id' => $get->id);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Genera un reporte de una orden, solo insumos.
     * @param type $id de la orden
     * @throws CrugeException
     */
    public function actionReporteOrdenSimple($id) {
        $txt = SeguridadModule::dec($id);

        $re = new JasperReport('/reports/Produccion/ordenSimple', JasperReport::FORMAT_PDF, array(
            'pIds' => $txt,
            'pUsuario' => Yii::app()->user->getName(),
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
     * Genera un reporte de una orden con su seguimiento
     * @param type $id de la orden
     * @throws CrugeException
     */
    public function actionReporteOrden($id) {

        $txt = SeguridadModule::dec($id);

        $re = new JasperReport('/reports/Produccion/orden', JasperReport::FORMAT_PDF, array(
            'pIds' => $txt,
            'pUsuario' => Yii::app()->user->getName(),
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
     * Metodo para reporte Orden en lote
     * 
     */
    public function actionReporteOrdenLote() {
        $txt =SWUtil::aRtoArrayReport(Orden::model()->findAll(Yii::app()->session['reporteOrdenLoteAlm']),'id');
        $txt =str_replace("{", "", $txt);
        $txt =str_replace("}", "", $txt);
               
        $re = new JasperReport('/reports/Produccion/ordenLote', JasperReport::FORMAT_PDF, array(

            'pIds' => $txt,            
            'pUsuario' => Yii::app()->user->getName(),
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
    
}
