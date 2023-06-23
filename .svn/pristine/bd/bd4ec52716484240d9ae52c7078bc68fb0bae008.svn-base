<?php

/*
 * ControlseguimientoController.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 15/06/2015
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

class ControlseguimientoController extends Controller {
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
     * Registra el seguimiento a una Nota
     * 
     */
    public function actionRegistrarSeguimientoNota() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $modelSeguimiento = new Seguimiento;

        if (isset($_GET['idNota'])) {
            $modelNota = Nota::model()->findByPk(SeguridadModule::dec($_GET['idNota']));
            $modelSeguimiento->tabla = $modelNota->tableName();
            $modelSeguimiento->idtabla = $modelNota->id;
        }

        if (isset($_POST['Controlseguimiento'])) {
            $modelSeguimiento->attributes = $_POST['Controlseguimiento'];
            $modelSeguimiento->save();
        }

        $this->renderPartial('registrarseguimiento', array(
            'modelSeguimiento' => $modelSeguimiento
                ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        Seguimiento::model()->findByPk(SeguridadModule::dec($id))->safeDelete();
        self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Controlseguimiento('search');
        $model->unsetAttributes();  // clear any default values

        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Controlseguimiento'])) {
            $model->attributes = $_GET['Controlseguimiento'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('admin', array(
            'model' => $model
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Controlseguimiento the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Controlseguimiento::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Controlseguimiento $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'controlseguimiento-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Generar la lista de seguimiento en un reporte PDF
     * @throws CrugeException
     */
    public function actionSeguimientoReporte() {
        $re = new JasperReport('/reports/Almacen/seguimiento', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Controlseguimiento::model()->findAll(Yii::app()->session['reporteSeguimiento2']), 'id'),
            'pUsuario' => Yii::app()->user->getName(),
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
     * Registra un seguimiento a una nota de recepción del modulo de ventas
     * 
     */
    public function actionRegistrarSeguimientoNr() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $modelSeguimiento = new Vseguimiento;

        if (isset($_GET['idNotarecepcion'])) {
            $modelVistaNotaRecepcion = Vistanotarecepcion::model()->findByPk(SeguridadModule::dec($_GET['idNotarecepcion']));
            $modelSeguimiento->tabla = $modelVistaNotaRecepcion->NOMBRE_TABLA;
            $modelSeguimiento->idtabla = $modelVistaNotaRecepcion->id;            
        }

        if (isset($_POST['Controlseguimiento'])) {
            $modelSeguimiento->attributes = $_POST['Controlseguimiento'];
            $modelSeguimiento->save();
        }

        $this->renderPartial('registrarseguimiento', array(
            'modelSeguimiento' => $modelSeguimiento
                ), false, true);
    }

}
