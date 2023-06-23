<?php
/*
 * SolicitudController.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 26/06/2015
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
class SolicitudController extends Controller
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
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Solicitud('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Solicitud'])){
                $model->attributes=$_GET['Solicitud'];
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
	 * @return Solicitud the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Solicitud::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Solicitud $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    /**
     * Genera un reporte de una Solicitud con su detalle
     * @param type $id de la solicitud
     * @throws CrugeException
     */
    public function actionReporteSolicitudDetalle($id) {
        $re = new JasperReport('/reports/Compra/solicitudDetalle', JasperReport::FORMAT_PDF, array(
            'pId' => SeguridadModule::dec($id),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormato' => Yii::app()->params['formatNumberContabilidad'],
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
     * Funcion que genera un reporte con el detalle de solicitud
     * en lote
     * @throws CrugeException
     */
    public function actionReporteSolicitudLote() {
        $re = new JasperReport('/reports/Compra/solicitudLote', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Solicitud::model()->findAll(Yii::app()->session['reporteSolicitudes']), 'id'),
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
}
