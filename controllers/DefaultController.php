<?php
/*
 * DefaultController.php
 *
 * Version 0.$Rev: 829 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2018-06-27 16:54:40 -0400 (Wed 27 de Jun de 2018) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
class DefaultController extends Controller
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
	public function actionIndex()
	{
            $model = Yii::app()->almacen->createCommand('select * from alertasdashboard()')->queryAll();
            $vencimientosnulos = Yii::app()->almacen->createCommand('select * from vencimientonulo()')->queryAll();
            $cantidadvencimientosnulos = Yii::app()->almacen->createCommand('select * from cantidadvencimientonulo()')->queryAll();
            $lotesvencidos = Yii::app()->almacen->createCommand('select * from lotesvencidos()')->queryScalar();
            $this->render('index',array('model'=>$model,'lotesvencidos'=>$lotesvencidos,'vencimientosnulos'=>$vencimientosnulos,'cantidadvencimientosnulos'=>$cantidadvencimientosnulos));
	}
}
