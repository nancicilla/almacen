<?php
/*
 * CaracteristicasController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 10/06/2023
 *
 * Ultima Actualizacion: $Date: 2015-10-13 09:08:14 -0400 (mar 13 de oct de 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
class CaracteristicasController extends Controller
{
	 /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */
    
    /* 
     * se debe usar este método filters en todos los controladores para permitir
     * filtrar si el usuario tiene acceso a las acciones y controlador o no, 
     */
   
    public function filters()
    {
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
    private function _publicActionsList()
    {
        //en este array deben ir las acciones publicas del modulo, las que se 
        //pueden acceder sin necesitar permisos, por defecto todas las acciones
        //se acceden solo con autorizacion, por eso el array no tiene acciones
        return array(
            '',          
        );
    }
    
    public function accessRules()
    {
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
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Caracteristicas;

        if(isset($_POST['vector'])){
           
                
                if(Caracteristicas::model()->guardarInformacion($_POST['vector'],$_POST['nombre'],$_POST['paraenvase']) ){                       
                    echo System::dataReturn('Creación exitosa!');
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
        ), false, true);
    }
    public function actionRegistrar() {
        if(isset($_POST['vector'])){
           
                
                if(Caracteristicas::model()->guardarInformacion($_POST['vector'],$_POST['nombre'],$_POST['paraenvase']) ){                       
                    echo System::dataReturn('Creación exitosa!');
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ');
                return;
                }
        }
    }
    public function actionActualizar() {
        if(isset($_POST['vector'])){
           
                
                if(Caracteristicas::model()->actualizarInformacion($_POST['vector'],$_POST['id']) ){                       
                    echo System::dataReturn('Actualización exitosa!');
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ');
                return;
                }
        }
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));

        if(isset($_POST['Caracteristicas']))
        {
            $model->attributes=$_POST['Caracteristicas'];
            if($model->save()){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
        ), false, true);
    }
    //
     public function actionActualizarCaracteristica($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        //$id=$_GET['caracteristicas']['id'];
        $id=SeguridadModule::dec($id);
        $model=$this->loadModel($id);
        $lista=Yii::app()->almacen->createCommand("select id,nombre,tipovalor, idcaracteristicapadre,( select count(*) from general.caracteristicas c1 where c1.eliminado=false and c1.idcaracteristicapadre=c.id
										 ) as canthijos from general.caracteristicas c where c.eliminado=false and c.idcaracteristicapadre  in
( (select $id::int as id)union(select  id from general.caracteristicas where eliminado=false and idcaracteristicapadre=$id) ) ")
                                    ->queryAll();

        if(isset($_POST['Caracteristicas']))
        {
            $model->attributes=$_POST['Caracteristicas'];
            if($model->save()){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'lista'=>$lista
        ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
            $this->loadModel(SeguridadModule::dec($id))->safeDelete();
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Caracteristicas('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Caracteristicas'])){
                $model->attributes=$_GET['Caracteristicas'];
                if (!$model->validate()) {
                    echo System::hasErrorSearch($model);
                    return;
                }
        }        

        $this->renderPartial('admin',array(
            'model'=>$model,
        ), false, true);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Caracteristicas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Caracteristicas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Caracteristicas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='caracteristicas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
