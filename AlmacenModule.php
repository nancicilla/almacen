<?php
/*
 * AlmacenModule.php
 *
 * Version 0.$Rev: 783 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2018-03-04 17:43:26 -0400 (Sun 04 de Mar de 2018) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
class AlmacenModule extends CWebModule
{    
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'almacen.models.*',
                        'almacen.models.produccion.models.*',
			'almacen.components.*',
		));
      		$this->layoutPath = Yii::getPathOfAlias('application.modules.almacen.views.layouts');
                $this->layout = 'main';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{			
                        $controller->layout = 'main';
                        // this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
        
        public function afterControllerAction($controller, $action)
	{
		if(parent::afterControllerAction($controller, $action))
		{		
                        $controller->layout = 'main';
                        // this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
       /**
     *
     * Obtener la direccion assets del módulo Almacen            
      * @return string que contiene la ruta de assets
      * 
     * 
     */  
        public function getAssetFolder(){
            return "protected/modules/almacen/assets";
        }
}
