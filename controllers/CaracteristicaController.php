<?php
/*
 * CaracteristicaController.php
 *
 * Version 0.$Rev: 303 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2015-10-29 12:17:17 -0400 (jue 29 de oct de 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
class CaracteristicaController extends Controller {
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

        $model = new Caracteristica('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Caracteristica'])){
            $model->attributes = $_GET['Caracteristica'];
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
     * @return Caracteristica the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Caracteristica::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Caracteristica $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'caracteristica-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Caracteristica;
        if (isset($_GET['idgenero'])) {
            $idgenero = $_GET['idgenero'];
            if ($idgenero == Genero::model()->GENEROGENERAL) {
                $model->idgenero = Genero::model()->GENEROGENERAL;
            } else {
                $model->idgenero = Genero::model()->GENEROARCHIVO;
            }
        }

        if (isset($_POST['Caracteristica'])) {
            $model->attributes = $_POST['Caracteristica'];
            if ($model->save()) {
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos!', $model);
                return;
            }
        }

        $this->renderPartial('create', array(
            'model' => $model
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

        if (isset($_POST['Caracteristica'])) {
            $model->attributes = $_POST['Caracteristica'];
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
     * Acción para search caracteristicas generales padre     
     */
    public function actionGeneralBuscarPadre() {
        $caracteristica = new Informacioncaracteristica();
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $caracteristica->caracteristicaGeneralPadre($_POST['nombrecaracteristica']),
            'columns' => array(array('name' => 'idcaracteristica', 'typeCol' => 'hidden'),
                'nombrecaracteristica', array('name' => 'tienehijo', 'typeCol' => 'hidden'),),
        ));
    }

    /**
     * Acción para search subcaracteristicas generales
     */
    public function actionGeneralBuscarHijo() {
        $caracteristica = new Informacioncaracteristica();
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $caracteristica->caracteristicaGeneralHijo($_POST['nombresubcaracteristica'], $_POST['idcaracteristica']),
            'columns' => array(array('name' => 'idsubcaracteristica', 'typeCol' => 'hidden'),
                'nombresubcaracteristica'),
        ));
    }
    
    /*
     * Accion para el view personalizar
     */
    public function actionPersonalizar()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $caracteristica = Caracteristica::model()
                            ->findAll(array('condition'=>'idcaracteristica is null and idgenero in(1, 2)', 'order'=>'orden asc'));
        
        $this->renderPartial('personalizar',array(
            'caracteristica' => $caracteristica,
        ), false, true);
    }
    
    /*
     * Esta accion se utiliza para actualizar el orden de las caracteristicas.
     * Hace uso desde el view "caracteristica/personalizar.php"
     */
    public function actionMetodoAjax() {
        $this->layout = 'empty';
        if(isset($_POST['caracteristica']))
        {
            $caracteristica = $_POST['caracteristica'];
            $contador = 0;
            for($index = 0; $index < count($caracteristica); $index++)
            {
                $dato = explode("-", $caracteristica[$index]);
                $caract = Caracteristica::model()->findByPk($dato[0]);
                $caract->orden = $dato[1];
                $caract->setScenario('personalizar');
                $caract->save();
            }
        }
    }
}
