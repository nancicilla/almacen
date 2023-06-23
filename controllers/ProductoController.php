<?php
/*
 * ProductoController.php
 *
 * Version 0.$Rev: 1123 $
 *
 * Creacion: 17/03/2015elk
 *e
 * Ultima Actualizacion: $Date: 2022-08-15 15:05:14 -0400 (lun, 15 ago 2022) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class ProductoController extends Controller {
    /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */

    /**
     *
     * @var string  Ruta del subdirectorio dentro de assets donde creará la 
     * carpeta temporal
     */
    private $SUB_DIRECTORY = '/producto/images/';

    /**
     *
     * @var string  nombre del directorio donde se subiran los archivos      
     */
    private $UPLOAD_DIRECTORY = '/uploads';

    /**
     *
     * @var string  nombre del utilizado para subir archivos     
     */
    public $UPLOAD_FILE = '/upload.php';

    /**
     *
     * @var string  nombre del utilizado para eliminar archivos subidos     
     */
    public $DELETE_FILE = '/delete.php';

    /**
     *
     * @var string  nombre del archivo imagen utilizado cuando no cuente con ninguna imagen    
     */
    public $NO_PHOTO_FILE = '/no_photo_small.png';

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
            'ActualizarSaldosimportesProductosAlmacen',
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
        $model = new Producto;
        $no_photo = $this->NO_PHOTO_FILE;
        $productoComplementario = array();        
        $productoCaracteristica = Caracteristica::model()->obtieneCaracteristica(1);
        $productoImagen = array();
        $gridRequisito = array();
        $model->requisito = true;

        if(isset($_POST['Producto']))
        {
            $postProducto = $_POST['Producto'];
            $model->attributes = $postProducto;
            
            if (isset($_POST['Productocaracteristica'])) {
                $productoCaracteristica = $_POST['Productocaracteristica'];
            }
            if (isset($_POST['Productoimagen'])) {
                $productoImagen = $_POST['Productoimagen'];
            }
            if (isset($_POST['productoComplementario'])) {
                $productoComplementario = $_POST['productoComplementario'];
            }

            $model->validate();
            $model->stockmaximo = 0;
            $model->stockminimo = 0;
            $model->stockreposicion = 0;
            $model->puntopedido = 0;
            $model->saldo = 0;
            $model->costo = 0;
            $model->reserva = 0;
            $producto = Almacen::model()->find('codigo = ' . $_POST['Producto']['codigoAlmacen']);
            
            //INICIA historial cambios
            $arraycambios=array();
            $fechacambio = date('Y-m-d H:i:s');
            $usuariocambio = Yii::app()->user->getName();
            if($model->historialcambios!=null)
            { 
                $arraycambios=CJSON::decode($model->historialcambios,true);
                $_POST['Producto']['fechacambio']=$fechacambio;
                $_POST['Producto']['usuario']=$usuariocambio;
                array_push($arraycambios,$_POST['Producto'] );}
            else{
                $_POST['Producto']['fechacambio']=$fechacambio;
                $_POST['Producto']['usuario']=$usuariocambio;
                array_push($arraycambios, $_POST['Producto']);
            }                
            $model->historialcambios=CJSON::encode($arraycambios);
            //FIN historial cambios
            
            if($postProducto['idestadofichatecnica'] != '')
                $model->idestadofichatecnica = $postProducto['idestadofichatecnica'];
            if ($model->save()) 
            {
                if(isset($_POST['Productocaracteristica']))
                    Productocaracteristica::model()->registrarGeneral($model->id, $_POST['Productocaracteristica'], $postProducto['codigoAlmacen']);
//                Productocaracteristica::model()->registrarImagen($model->id, $productoImagen, Yii::app()->session['directorioTemporal']);
                Productoproducto::model()->registrarComplementario($model->id, $productoComplementario);
                $model->registrarHijo($model->id);
                
                // -------------------------------------------------------------
                // -------------------- REGISTRA REQUISITOS --------------------
                // -------------------------------------------------------------
                if($postProducto['requisito'] == 0)
                {
                    if(isset($_POST['gridRequisito']))
                        Requisitoproducto::model()->registrarRequisitoProducto($_POST['gridRequisito'], $model->id, $postProducto['aumentarColumna']);
                }
                // -------------------------------------------------------------
                // -------------------------------------------------------------
                
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                $model->emptyAttributes();
                $productoCaracteristica = array();
                $productoImagen = array();
                $no_photo = $this->NO_PHOTO_FILE;
                $productoComplementario = array();
                
                $this->directorioTemporal();

                return;
            } else {
                echo System::hasErrors('Revise los datos!', $model);
                return;
            }
        } else {
           // $this->directorioTemporal();
        }

        $this->renderPartial('create', array(
            'model' => $model,
            'productoCaracteristica' => $productoCaracteristica,
            'productoImagen' => $productoImagen,
            'productoComplementario' => $productoComplementario,
            'gridRequisito' => $gridRequisito,
        ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $existeImagen = 'false';
        $auxiliar = $this->loadModel(SeguridadModule::dec($id))->isActualizable();
        if ($auxiliar != 'exito') {
            echo System::conditionOpen(false, $auxiliar);
            return;
        } else {
            $model = $this->loadModel(SeguridadModule::dec($id));
            $model->existeRelacionProduccion = false;
            
            $ordenProducto = new WSProducto;
            $respuesta = $ordenProducto->existeRelacionProducto(SeguridadModule::dec($id));
            
            switch ($respuesta) {
                case 1:
                    $model->existeRelacionProduccion = false;
                    break;

                default:
                    $model->existeRelacionProduccion = true;
                    break;
            }
            /*
             * Si es 0 quiere decir que tiene alguna relacion
             * Si es 1 entonces no existe ninguna relacion 
             * Si es -1 entonces ocurrio algún error
             */

            $productoCaracteristica = array();
            $productoImagen = array();
            $productoComplementario = array();
            
            $model->id_producto = $model->id;
            $gridRequisito = Requisitoproducto::model()->mostrarRequisitoProducto($model->id, 0);
            if(count($gridRequisito->getData()) == 0) // NO existen registros
            {
                $gridRequisito = array();
                $model->requisito = true;
            }
            else
            {
                $model->requisito = 0;
                $columnaSegunda = Requisitoproducto::model()->mostrarRequisitoProducto($model->id, 1);
                if(count($columnaSegunda->getData()) > 0)
                    $model->aumentarColumna = true;
                else
                    $model->aumentarColumna = false;
            }
            
            if (isset($_POST['Productocaracteristica'])) {
                $productoCaracteristica = $_POST['Productocaracteristica'];
            } else {
                $productoCaracteristica = Informacionproducto::model()->cargarCaracteristicaGeneral(SeguridadModule::dec($id));
            }

            if (isset($_POST['Productoimagen'])) {
                $productoImagen = $_POST['Productoimagen'];
            } else {
                if (isset($_POST['Producto'])) {
                    $productoImagen = array();
                } else {
                    $productoImagen = Productocaracteristica::model()->cargarCaracteristicaImagen(SeguridadModule::dec($id));
                    if (count($productoImagen) > 0) {
                        $existeImagen = 'true';
                    }
                }
            }

            if (isset($_POST['productoComplementario'])) {
                $productoComplementario = $_POST['productoComplementario'];
            } else {
                $productoComplementario = Productoproducto::model()->productoComplementario(SeguridadModule::dec($id));
            }

            if (isset($_POST['Producto']))
            {
                $postProducto = $_POST['Producto'];
                $model->attributes = $postProducto;
                                
                //INICIA historial cambios
                $arraycambios=array();
                $fechacambio = date('Y-m-d H:i:s');
                $usuariocambio = Yii::app()->user->getName();
                if($model->historialcambios!=null)
                { 
                    $arraycambios=CJSON::decode($model->historialcambios,true);
                    $_POST['Producto']['fechacambio']=$fechacambio;
                    $_POST['Producto']['usuario']=$usuariocambio;
                    array_push($arraycambios,$_POST['Producto'] );}
                else{
                    $_POST['Producto']['fechacambio']=$fechacambio;
                    $_POST['Producto']['usuario']=$usuariocambio;
                    array_push($arraycambios, $_POST['Producto']);
                }                
                $model->historialcambios=CJSON::encode($arraycambios);
                //FIN historial cambios
                
                $model->idestadofichatecnica = $postProducto['idestadofichatecnica'];
                $model->validate();
                if ($model->save()) {
                    Productoproducto::model()->deleteAll('idproducto =' . $model->id);
                    
                    if(isset($_POST['Productocaracteristica']))
                        Productocaracteristica::model()->registrarActualizaGeneral($model->id, $productoCaracteristica, $model->idalmacen);
                    
                    /*
                     * El usuario que esté asignado a la acción de "amparo"
                     * podrá modificar las fotos de las fichas técnicas.
                     */
                    $queryCrugeUserAction = Yii::app()->usuario_web->createCommand("
                            select userid from cruge_authassignment 
                            where userid = ".Yii::app()->user->id." AND itemname = 'editaFotosFichaTecnica' ")->queryScalar();
                    if($queryCrugeUserAction != null)
                        Productocaracteristica::model()->registrarImagen($model->id, $productoImagen, Yii::app()->session['directorioTemporal']);
                    
                    
                    if (isset($_POST['productoComplementario']))
                        Productoproducto::model()->registrarComplementario($model->id, $productoComplementario);

                    $model->actualizarHijo($model->id);
                    
                    // -------------------------------------------------------------
                    // -------------------- REGISTRA REQUISITOS --------------------
                    // -------------------------------------------------------------
                    Requisitoproducto::model()->deleteAll('idproducto = ' . $model->id);
                    if($postProducto['requisito'] == 0)
                    {
                        if(isset($_POST['gridRequisito']))
                            Requisitoproducto::model()->registrarRequisitoProducto($_POST['gridRequisito'], $model->id, $postProducto['aumentarColumna']);
                    }
                    // -------------------------------------------------------------
                    // -------------------------------------------------------------

                    $model->emptyAttributes();
                    $productoCaracteristica = array();
                    $productoImagen = array();
                    $no_photo = $this->NO_PHOTO_FILE;
                    $productoComplementario = array();
//                    $this->directorioTemporal();
//                    if (isset($_POST['Productoimagen'])) {
//                        $productoImagen = $_POST['Productoimagen'];
//                    }
                
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos!', $model);
                    return;
                }
            } else {
                unset(Yii::app()->session['directorioTemporal']);
                //$temporal = new Temporal(AlmacenModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
                //Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();
                //Productocaracteristica::model()->prepararImagen(SeguridadModule::dec($id), Yii::app()->session['directorioTemporal']);
                $modeloFamilia = Familia::model()->informacionFamilia($model->idfamilia);
                $modeloClase = Clase::model()->informacionClase($model->idclase);
                $model->nombreFamilia = $modeloFamilia['nombre'];
                $model->codigoFamilia = $modeloFamilia['codigo'];
                $model->nombreCompletadoFamilia = $modeloFamilia['nombre'];
                
                $model->nombreClase = $modeloClase['nombre'];
                $model->codigoClase = $modeloClase['codigo'];
                $model->nombreCompletadoClase = $modeloClase['nombre'];
                $almacen = Almacen::model()->findByPK($model->idalmacen);
                $model->codigoAlmacen = $almacen->codigo;
            }
            $model->existeImagen = $existeImagen;
            
            $this->renderPartial('update', array(
                'model' => $model,
                'productoCaracteristica' => $productoCaracteristica,
                'productoImagen' => $productoImagen,
                'productoComplementario' => $productoComplementario,
                'gridRequisito' => $gridRequisito,
            ), false, true);
        }
    }

    /**
     * Verifica si un cliente esta bloqueado, Si el cliente ya esta bloqueado retorna la lista de clientes actualizada
     * @param type $id Identificador de cliente
     */
    public function actionEliminar($id) {
        if (!$id) {
            /* $respuestaArray=array("estado"=>-1,"descripcion"=>"No se envió el id del producto al controlador");
              echo CJSON::encode($respuestaArray);
              return; */
            echo System::messageError('No se envió el id del producto al controlador.');
            //self::actionAdmin();  
            return;
        }

        $ordenProducto = new WSProducto;
                
        $respuesta = $ordenProducto->existeRelacionProducto(SeguridadModule::dec($id));//array error:boolean; existe:existe relacion? ; mensaje
        if(!$respuesta['error']){
            if($respuesta['existe']){
                echo System::messageError($respuesta['mensaje']);
            }else{
                $modelProducto = Producto::model()->findByPk(SeguridadModule::dec($id));
                if ($modelProducto->safeDelete()) {
                    echo System::messageConfirm('El producto se eliminó corrrectamente.');
                    self::actionAdmin();
                    return;
                } else {
                    echo System::messageError('Error al eliminar el producto. Modulo Almacen');
                }
            }
        
        }
        else{
            echo System::messageError($respuesta['mensaje']);    
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

        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
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
     * @return Producto the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Producto::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Familia the loaded model
     * @throws CHttpException
     */
    public function loadFamiliaModel($id) {
        $model = Familia::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Producto $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'producto-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Permite utilizar un autocomplete para la busqueda de productos con
     * el nombre de producto concatenado a su codigo, nombreCompletoProducto
     * tiene como parametros de entrada el id del 
     * almacen al cual esta asociado el producto, y el termino que se busca
     */
    public function actionAutocomplete() {
        $idAlmacen = $_GET['idalmacen'];
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);

        if ($request != '') {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*';
            $criteria->condition = "t.eliminado=false and (t.nombre like :valorentrada or t.codigo like :valorentrada)";
            $criteria->addCondition("idalmacen= :value2");
            $criteria->params = array(':valorentrada' => "%$requestMayuscula%", ':value2' => (int) $idAlmacen);
            $criteria->order = "nombre asC";
            $criteria->limit = 10;
            $model = Producto::model()->findAll($criteria);
            $data = array();

            foreach ($model as $get) {
                $data[] = array(
                    'label' => $get->codigo . ' (' . $get->nombre . ')',
                    'value' => $get->codigo . ' (' . $get->nombre . ')',
                    'nombre' => $get->codigo . ' (' . $get->nombre . ')',
                    'id' => $get->id);
            }

            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Muestra los productos y su stock
     */
    public function actionStock() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Producto('searchStock');

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('stock', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Genera el reporte en formato pdf del stock de productos en base a la 
     * vista del cgridview de la interfaz de stock, en caso de que el reporte
     * no tenga paginas se muestra una excepción
     */
    public function actionReporteProductoStock() {
        $re = new JasperReport('/reports/Almacen/productoStock', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['productoreporteStock']), 'id'),
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
            'pProveedor' => Yii::app()->session['proveedorStock'],
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));
        $re->exec();

        if ($re->getPages() > 0 && Yii::app()->session['mostrarReporteProductoStock']) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    
    public function actionStockProd() {
        $re = new JasperReport('/reports/Almacen/stockProducto', JasperReport::FORMAT_PDF, array(    
            'pUsuario' => Yii::app()->user->getName(),
            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));
        $re->exec();

        if ($re->getPages() > 0 && Yii::app()->session['stockProducto']) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    /**
     * Permite utilizar un autocomplete para la busqueda de productos a 
     * partir de su codigo, tiene como parametros de entrada el id del 
     * almacen al cual esta asociado el producto, y el termino que se busca
     */
    public function actionAutocompleteCodigo() {
        $idAlmacen = $_GET['idalmacen'];
        $request = trim($_GET['term']);

        if ($request != '') {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*';
            $criteria->condition = "t.codigo ilike :valorentrada and t.eliminado=false";
            if ($idAlmacen != NULL) {
                $criteria->addCondition("idalmacen=" . (int) $idAlmacen);
            }
            $criteria->params = array(':valorentrada' => "%$request%");
            $criteria->order = "codigo asc";
            $criteria->limit = 15;
            $model = Producto::model()->findAll($criteria);
            $data = array();

            foreach ($model as $get) {
                $data[] = array(
                    'label' => $get->codigo,
                    'value' => $get->codigo,
                    'nombre' => $get->codigo,
                    'id' => $get->id);
            }

            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Permite utilizar un autocomplete para la busqueda de productos a 
     * partir del nombre, tiene como parametros de entrada el id del 
     * almacen al cual esta asociado el producto, y el termino que se busca
     */
    public function actionAutocompleteNombre() {
        $idAlmacen = $_GET['idalmacen'];
        $request = trim($_GET['term']);

        if ($request != '') {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*';
            $criteria->condition = "t.nombre ilike :valorentrada and t.eliminado=false";
            if ($idAlmacen != NULL) {
                $criteria->addCondition("idalmacen=" . (int) $idAlmacen);
            }
            $criteria->params = array(':valorentrada' => "%$request%");
            $criteria->order = "nombre asC";
            $criteria->limit = 15;
            $model = Producto::model()->findAll($criteria);
            $data = array();

            foreach ($model as $get) {
                $data[] = array(
                    'label' => $get->nombre,
                    'value' => $get->nombre,
                    'nombre' => $get->nombre,
                    'id' => $get->id);
            }

            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Genera el reporte en detalle del producto
     */
    public function actionReporteProductoDetalle($id, $desdeSolicitud = false)
    {
        // $desdeSolicitud == true      (ENVIA LOS IDS DESDE EL MODULO DE COMPRAS ==> [SOLICITUD] )
        $pIds = $desdeSolicitud == true? $id : SeguridadModule::dec($id);
        
        //$re = new JasperReport('/reports/Almacen/productoDetalle', JasperReport::FORMAT_PDF, array(
        $re = new JasperReport('/reports/Almacen/productoDetallado', JasperReport::FORMAT_PDF, array(
            'pIds' => $pIds,
            'pRuta' => 'ftp://' . Yii::app()->ftp->host . '/' . Yii::app()->ftp->folder . '/' . Productocaracteristica::model()->tableName() . '/',
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
     * Crea un directorio temporal
     */
    public function directorioTemporal() {
        unset(Yii::app()->session['directorioTemporal']);
        $temporal = new Temporal(AlmacenModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
        Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();
    }

    /**
     * Genera el reporte en formato pdf de los productos en lote
     */
    public function actionReporteProductoLote()
    {
        $txt = SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['reporteProductoLote']), 'id');
        $txt = str_replace("{", "", $txt);
        $txt = str_replace("}", "", $txt);
        
        $re = new JasperReport('/reports/Almacen/productoDetallado', JasperReport::FORMAT_PDF, array(
            'pIds' => $txt,
            'pUsuario' => Yii::app()->user->getName(),
            'pRuta' => 'ftp://' . Yii::app()->ftp->host . '/' . Yii::app()->ftp->folder . '/' . Productocaracteristica::model()->tableName() . '/',
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
     * Genera el reporte en formato pdf el listado de productos del gridview
     */
    public function actionReporteProductoLista() {
        $re = new JasperReport('/reports/Almacen/productoLista', JasperReport::FORMAT_PDF, array(
            'pIds' => SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['reporteProductoLote']), 'id'),
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
     * Validar si es caracteristica padre, debe seleccionar un hijo
     *  OBLIGATORIAMENTE
     */
    /*public function actionValidarSubCaracteristica() {
        $productoCaracteristica = isset($_POST['Productocaracteristica']) ? $_POST['Productocaracteristica'] : array();
        $tabla = array();
        foreach ($productoCaracteristica as $fila) {
            if (Caracteristica::model()->tieneHijo($fila['idcaracteristica']) && ($fila['nombresubcaracteristica'] == '')) {
                $fila['validate'] = false;
            } else {
                $fila['validate'] = true;
            }
            $tabla[] = $fila;
        }
        echo SGridView::validate($tabla, array());
    }*/

    /**
     * Validar si no es caracteristica padre debe introducir 
     * un valor OBLIGATORIAMENTE
     */
    /*public function actionValidarValor() {
        $productoCaracteristica = isset($_POST['Productocaracteristica']) ? $_POST['Productocaracteristica'] : array();
        $tabla = array();
        foreach ($productoCaracteristica as $fila) {
            if (Caracteristica::model()->tieneHijo($fila['idcaracteristica'])) {
                $fila['validate'] = true;
            } else if ($fila['valor'] == "") {
                $fila['validate'] = false;
            } else {
                $fila['validate'] = true;
            }
            $tabla[] = $fila;
        }
        echo SGridView::validate($tabla, array());
    }*/

    /**
     * Filtrar productos por nombre
     */
    public function actionSearchProductoNombre() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['productoComplementario'])) {
            $productoExcluido = $this->getIdProducto($_POST['productoComplementario']);
        }
        if ($_POST['noidproducto'] !== '') {
            $idprod = SeguridadModule::dec($_POST['noidproducto']);
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
                array('name' => 'codigo', 'width' => 10),
                array('name' => 'nombre', 'width' => 50),
                array('name' => 'almacen', 'value' => '$data->idalmacen0->nombre', 'width' => 10),
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
        if (isset($_POST['productoComplementario'])) {
            $productoExcluido = $this->getIdProducto($_POST['productoComplementario']);
        }
        if ($_POST['noidproducto'] !== '') {
            $idprod = SeguridadModule::dec($_POST['noidproducto']);
        }
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoCodigo($_POST['codigo'], $productoExcluido, $idprod, $idalm),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('name' => 'codigo', 'width' => 10),
                array('name' => 'nombre', 'width' => 50),
                array('name' => 'almacen', 'value' => '$data->idalmacen0->nombre', 'width' => 10),
            ),
        ));
    }

    /**
     * Validar si es caracteristica padre, debe seleccionar un hijo
     *  OBLIGATORIAMENTE
     */
    public function actionValidarCantidad() {
        $productoNota = isset($_POST['Productonota']) ? $_POST['Productonota'] : array();
        $tabla = array();
        foreach ($productoNota as $fila) {
            if (Producto::model()->findByPK($fila['idproducto'])->saldo >= $fila['cantidad']) {
                $fila['validate'] = true;
            } else {
                $fila['validate'] = false;
            }
            $tabla[] = $fila;
        }
        echo SGridView::validate($tabla, array());
    }

    /**
     * Obtiene un array simple con los id de productos que contiene el modelo 
     * productoproducto
     * @param Productoproducto $Productoproducto
     * @return Array
     */
    public function getIdProducto($Productoproducto) {
        $idProducto = null;
        for ($i = 1; $i < count($Productoproducto) + 1; $i++) {
            $idProducto[] = ($Productoproducto[$i]['idcomplementario']);
        }
        return $idProducto;
    }

    /**
     * Funcion que carga la pantalla de asignacion de saldos y punto de pedido
     */
    public function actionAsignacionSaldos() {
        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $this->renderPartial('asignacionSaldos', array(
            'model' => $model,
                ), false, true);
    }
    
    /**
     * Funcion que carga la pantalla de asignacion de saldo y saldo importe
     */
    public function actionAsignacionSaldoImporte() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $this->renderPartial('asignacionSaldoImporte', array(
            'model' => $model,
        ), false, true);
    }

    /**
     * Funcion que actualiza los saldos y puntos de pedido del producto
     */
    public function actionActualizarSaldos() {
        if (isset($_POST['id'])) {
            $model = Producto::model()->findByPk($_POST['id']);
            $model->setScenario('actualizarSaldos');
            $model->stockminimo = str_replace(",", "", $_POST['stockminimo']);
            $model->stockmaximo = str_replace(",", "", $_POST['stockmaximo']);
            if ($_POST['puntopedido'] !== '') {
                $model->puntopedido = str_replace(",", "", $_POST['puntopedido']);
            } else {
                $model->puntopedido = null;
            }
            if ($model->save()) {
                self::actionAdmin();
            } else {
                echo System::messageError('No se actualizó correctamente!');
                return;
            }
        }
    }
    
    /**
     * Funcion que actualiza los saldos y puntos de pedido del producto
     */
    public function actionActualizarSaldoImporte() {
        if (isset($_POST['id'])) {
            $model = Producto::model()->findByPk($_POST['id']);
            $model->setScenario('actualizarSaldoimporte');
            $model->saldo = str_replace(",", "", $_POST['saldo']);
            $model->saldoimporte = str_replace(",", "", $_POST['saldoimporte']);
            if ($model->save()) {
                self::actionAdmin();
            } else {
                echo System::messageError('No se actualizó correctamente!');
                return;
            }
        }
    }

    /**
     * Permite utilizar un autocomplete para la busqueda de productos para la
     * ventana del libro de almacenes, el nombre de producto concatenado a su
     * codigo, nombreCompletoProducto tiene como parametros de entrada el id del 
     * almacen al cual esta asociado el producto, y el termino que se busca
     */
    public function actionAutocompleteLibroMayor() {
        $idAlmacen = $_GET['idalmacen'];
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);

        if ($request != '') {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*';
            $criteria->condition = "t.eliminado=false and (t.nombre like :valorentrada or t.codigo like :valorentrada)";
            if ($idAlmacen !== '') {
                $criteria->addCondition("idalmacen= " . SeguridadModule::dec($idAlmacen));
            }
            $criteria->params = array(':valorentrada' => "%$requestMayuscula%");
            $criteria->order = "nombre asC";
            $criteria->limit = 10;
            $model = Producto::model()->findAll($criteria);
            $data = array();

            foreach ($model as $get) {
                $data[] = array(
                    'label' => $get->codigo . ' (' . $get->nombre . ')',
                    'value' => $get->codigo . ' (' . $get->nombre . ')',
                    'nombre' => $get->codigo . ' (' . $get->nombre . ')',
                    'id' => $get->id);
            }

            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }

    /**
     * Funcion que carga la pantalla para seleccionar los productos para
     * inventariar
     */
    public function actionInventariarProducto() {
        $model = new Producto('inventariar');
        $model->unsetAttributes();  // clear any default values

        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $this->renderPartial('inventariar', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Función que cambia el estado de inventariar (true o false) 
     * de la tabla producto 
     * @param type $id    
     */
    public function actionInventariar() {
        $model = $this->loadModel($_GET['idproducto']);
        $model->setScenario('inventariar');
        $model->inventariar = $_GET['bandera'];
        if ($model->save()) {
            echo System::messageConfirm('');
            return;
        } else {
            echo System::messageConfirm('Error en el proceso');
            return;
        }
    }
    /**
     * Funcion que carga la pantalla de asignacion costo
     */
    public function actionAsignacionCosto() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $this->renderPartial('asignacioncosto', array(
            'model' => $model,
        ), false, true);
    }
    
   /**
     * Funcion que actualiza los costos del producto
     */
    public function actionActualizarCosto() {
        if (isset($_POST['id'])) {
            $model = Producto::model()->findByPk($_POST['id']);
            $model->setScenario('actualizarCosto');
            $model->ultimoppp = str_replace(",", "", $_POST['ultimoppp']);
            if ($model->save()) {
                echo $model->ultimoppp;
            } else {
                echo System::messageError('No se actualizó correctamente!');
                return;
            }
        }
    }
    /**
     * Reporte de los consumos de producto por meses sin tomar en cuenta las bajas
     */
    public function actionReporteConsumoPromedioMeses(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $idProducto = $_GET['Producto']['id'];
        
        $fechaFin = $_GET['Producto']['fechaFin'];
        $fechaInicio = $_GET['Producto']['fechaInicio'];
        
        if ($fechaInicio === '') {
            $criteria=new CDbCriteria();            
            $criteria->order = 't.id ASC';               
            $ordenModel=  Orden::model()->find($criteria);
            $fechaInicio = $ordenModel->id0->fecha;
        }
        
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');                
        }
        
        $re = new JasperReport('/reports/Almacen/informeConsumoPromedioMeses', JasperReport::FORMAT_PDF, array(
            'pUsuario' => Yii::app()->user->getName(),
            'idProducto'=>$idProducto,
            'pFechaInicio' => Yii::app()->format->date(strtotime($fechaInicio)),
            'pFechaFin' => Yii::app()->format->date(strtotime($fechaFin)),
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
     * Abre la ventana para escojer las fechas para imprimr el reporte "Consumo Promedio productos"
     */
    public function actionReporteConsumoPromedioProductos(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $productomodel=new Producto;
        $this->renderPartial('reporteVentanaConsumoMeses',array(
            'model' => $productomodel
        ), false, true);
    }
    
    /**
     * Funcion de autocompletar un campo textfield de producto, para el reporte Consumo Promedio por meses
     */
    public function actionAutocompleteProductoReporteConsumos() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $criteria = new CDbCriteria();
            $criteria->select = 't.*, al.nombre as nombrealmacen ';
            $criteria->join = "INNER JOIN almacen al ON al.id = t.idalmacen";
            //$criteria->addCondition("al.id IN (1,2,12)");
            $criteria->addCondition("al.idalmacen IS NULL");
            $criteria->addCondition("UPPER(t.nombre) LIKE '%$requestMayuscula%'");
            $criteria->limit=10;
            $model = Producto::model()->findAll($criteria);
            $data = array();
            foreach ($model as $get) {
                $formato = '%s';
                $data[] = array(
                    'label' => sprintf($formato, $get->nombre).' ('.$get->nombrealmacen.')',
                    'value' => $get->nombre,
                    'id' => $get->id,
                    'codigo' => $get->codigo);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    /**
     * Funcion de autocompletar un campo textfield de producto, para el reporte Consumo Promedio por meses
     */
    public function actionAutocompleteProductoCodReporteConsumos() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $criteria = new CDbCriteria();
            $criteria->select = 't.*, al.nombre as nombrealmacen ';
            $criteria->join = "INNER JOIN almacen al ON al.id = t.idalmacen";
            //$criteria->addCondition("al.id IN (1,2,12)");
            $criteria->addCondition("al.idalmacen IS NULL");
            $criteria->addCondition("UPPER(t.codigo) LIKE '$requestMayuscula%'");
            $criteria->limit=10;
            $model = Producto::model()->findAll($criteria);
            $data = array();
            foreach ($model as $get) {
                $formato = '%s';
                $data[] = array(
                    'label' => sprintf($formato, $get->codigo).' ('.$get->nombrealmacen.')',
                    'value' => $get->codigo,
                    'id' => $get->id,
                    'codigo' => $get->codigo,
                    'nombre' => $get->nombre);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    
    public function actionInventariarPorAlmacen() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Producto;
        $model->scenario = 'inventariar';
        $model->idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : 'null';
        $productosinventariar = $model->inventariar();
        $this->renderPartial('inventariarporalm', array(
            'model' => $model,
            'productosinventariar' => $productosinventariar
        ), false, true);
    }
    
    public function actionLoadProductosInventariarCodigo() {
        $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
        $idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : null;
        if ($codigo == null)
            $productosinventariar = array();
        else
            $productosinventariar = Producto::model()->obtenerProductos($codigo, 'codigo', $idalmacen);

        $this->renderPartial('_productos', array(
            'productosinventariar' => $productosinventariar,
        ), false, true);
    }
    
    public function actionLoadProductosInventariarNombre() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : null;
        if ($nombre == null)
            $productosinventariar = array();
        else
            $productosinventariar = Producto::model()->obtenerProductos($nombre, 'nombre', $idalmacen);

        $this->renderPartial('_productos', array(
            'productosinventariar' => $productosinventariar,
        ), false, true);
    }    
    
    public function actionQuitarSeleccion() {
        $idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : null;
        if ($idalmacen == null) {
            echo System::messageError('No se pudo quitar la selección de productos');
            return;
        } else {
            Producto::model()->updateAll(
                array(
                    'inventariar' => false
                ),
                'idalmacen=:idalmacen and inventariar is true and eliminado=false',
                array(':idalmacen' => $idalmacen)
            );
        }
    }
    
    public function actionSeleccionarTodos() {
        $idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : null;
        if ($idalmacen == null) {
            echo System::messageError('No se pudo seleccionar todos los productos');
            return;
        } else {
            Producto::model()->updateAll(
                array(
                    'inventariar' => true
                ), 'idalmacen=:idalmacen and inventariar is false and eliminado=false', array(':idalmacen' => $idalmacen)
            );
        }
    }
    
    public function actionLoadCaracteristicas()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        
        $form = $this->beginWidget('CActiveForm', array(), false);
        $idAlmacen = isset($_GET['idAlmacen']) ? $_GET['idAlmacen'] : null;

        $productoCaracteristica = Caracteristica::model()->obtieneCaracteristica($idAlmacen);
        $model = new Producto();
        $model->scenario = 'insert';
        
        $this->renderPartial('_caracteristicasDetalle',array(
            'form' => $form,
            'productoCaracteristica' => $productoCaracteristica,
            'model' => $model,
        ), false, true);
    }
    
    public function actionArbolMovimientoOrdenesProduccion(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        header('Content-Type: application/json');
        ini_set('memory_limit', '1024M');
        set_time_limit(10000);
        
        $codprod=$_GET["codigoproductokdm"];
        
        $data = array(
            array(
                "key"=>0,
                "keylist"=>0,
                "txt"=>$codprod,
                )
        );//2CHOSMA001,2CHOLES001,2CHOAMG001,,2CHOSAB001,
        //id de prodcuto
        $idproducto = Producto::model()->getIdProducto($codprod,2);
        //obtenemos la fecha de la primera entrega
        $fechaInicio = Producto::model()->getFechaPrimerIngresoEncontrado("2016-07-01 07:00:02.0",$idproducto);
        Producto::model()->getArbolPrincipal($fechaInicio,$data,0,$idproducto,1);
                
        echo CJSON::encode($data);
    }
    
    public function actionRamificarArbolMovimientoOrdenesProduccion(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        header('Content-Type: application/json');
        ini_set('memory_limit', '1024M');
        set_time_limit(10000);
        $data = array(           
        );
        
        $codprod=$_GET["codigoproductokdm"];
        
        //$idproductokdm = Producto::model()->getIdProducto($codprod,2);
        
        //id de prodcuto
        $idproducto = $_POST['idproducto'];
        //obtenemos la fecha de la primera entrega
        
        $fechaInicio = $_POST['fechacierre'];
        
        $key = $_POST['key'];
        $keylist = $_POST['keylist'];
        if(isset($_POST['costoconfirmado'])){
            $sop=strpos($_POST['glosa'], ''.$codprod)!==false?true:false;
            if($_POST['costoconfirmado']==true && $sop==false)
            Producto::model()->getArbolRamificado($fechaInicio,$data,$keylist,$idproducto,1);
        } 
        echo CJSON::encode($data);
    }
    
    public function actionActualizarKardexProducto(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        
        $producto = new Producto;
        
        $this->renderPartial('actualizarKardex',array(
            'model' => $producto,
        ), false, true);
    }
    /**
     * Cambia el kardex de un movimiento en el almacen. Se envia datos del movimento por post
     */
    public function actionAjustarMovimientoAlmacen(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        header('Content-Type: application/json');
        ini_set('memory_limit', '1024M');
        set_time_limit(10000);
        $data = array();
        
        $nuevocosto = 0;
        //id de prodcuto
        if(isset($_POST['nuevocosto']))
            $nuevocosto = $_POST['nuevocosto'];
        
        $respuestaAjusteKardex = Producto::model()->ajustaMovimientoKardexAlmacen($nuevocosto,$_POST['key'],$_POST['idproductonota'],$_POST['fechamovimiento']);
        //if($_POST['sop']===true)
        //    $respuestaAjusteOrdenProduccion = Producto::model()->ajustarCostoOrdenProduccion($_POST['idop']);//idop : idOrdenProduccion
        
        if($respuestaAjusteKardex["error"]===true){
            $data=$respuestaAjusteKardex;
        }else{
            
            $data=$respuestaAjusteKardex;
        }
        
        //una de las variables que se retornará será el nuevo costo del producto
        echo CJSON::encode($data);
    }
    
    public function actionActualizarSaldosimportesProductosAlmacen(){
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        header('Content-Type: application/json');
        $arrayidsProductos=array_unique($_POST["idsproductos"]);
        
        foreach ($arrayidsProductos as $value) {
            $productoModel = Producto::model()->findByPk($value);
            $productoModel->actualizarSaldosProductoMK();
        }
        echo CJSON::encode(array("mensaje"=>"terminó"));
    }
    
    // ---------------------------- KARDEX DETALLADA ---------------------------
    public function actionAdminDetallado() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('adminDetallado', array(
            'model' => $model,
                ), false, true);
    }
    
    public function actionMovimientos($id)
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $idProducto = SeguridadModule::dec($id);
        $model = $this->loadModel($idProducto);
        $productonota = Productonota::model()->getProductoNotaDetallado($idProducto, '', '', '');
//        print_r($productonota);return;
        $this->renderPartial('_movimientoProducto', array(
            'model' => $model,
            'productonota' => $productonota,
        ), false, true);
    }
    
    public function actionLoadProductoNota()
    {
        $idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : null;
        $fechaInicio= isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;
        $movimiento = isset($_GET['movimiento']) ? $_GET['movimiento'] : null;

        if($idproducto == null && $fechaInicio == null && $fechaFin == null)
            $productonota = array();
        else
            $productonota = Productonota::model()->getProductoNotaDetallado($idproducto, $fechaInicio, $fechaFin, $movimiento);
            
        $this->renderPartial('_valoradoProductonotaDetallado',array(
            'productonota' => $productonota,
        ), false, true);
    }
    
    public function actionCorregirMovimiento()
    {
        if(isset($_GET['idnota']))
        {
            $idnota = $_GET['idnota'];
            $saldoCantidadCorrecto = $_GET['saldoCantidadCorrecto'];
            $saldoImporteCorrecto = $_GET['saldoImporteCorrecto'];
            $model = Productonota::model()->find('id = '.$idnota);
            $resultado = 0;
            
            if($model != null)
            {
                if($model->saldo != $saldoCantidadCorrecto && $model->saldoimporte != $saldoImporteCorrecto)
                    $resultado = Productonota::model()->updateAll(
                        array(
                            'saldo' => $saldoCantidadCorrecto,
                            'saldoimporte' => $saldoImporteCorrecto
                        ), 'id=:id', array(':id' => $idnota)
                    );
                else
                {
                    if($model->saldo != $saldoCantidadCorrecto)
                        $resultado = Productonota::model()->updateAll(
                            array(
                                'saldo' => $saldoCantidadCorrecto,
                            ), 'id=:id', array(':id' => $idnota)
                        );
                    if($model->saldoimporte != $saldoImporteCorrecto)
                        $resultado = Productonota::model()->updateAll(
                            array(
                                'saldoimporte' => $saldoImporteCorrecto
                            ), 'id=:id', array(':id' => $idnota)
                        );
                }
                
                $arrayResultado = Productonota::model()->movimientoProducto($model->idproducto);
                $contadorSaldoCantidadError = $arrayResultado['contadorSaldoCantidadError'];
                $contadorSaldoCantidadNegativos = $arrayResultado['contadorSaldoCantidadNegativos'];
                $contadorSaldoImporteError = $arrayResultado['contadorSaldoImporteError'];
                $contadorSaldoImporteNegativos = $arrayResultado['contadorSaldoImporteNegativos'];
                echo $resultado.'*'.
                     $contadorSaldoCantidadError.'*'.$contadorSaldoCantidadNegativos.'*'.
                     $contadorSaldoImporteError.'*'.$contadorSaldoImporteNegativos;
            }
        }
    }
    
    public function actionCorregirVariosMovimientos()
    {
        if(isset($_GET['idProducto']) && isset($_GET['idNota']))
        {
            $idProducto = $_GET['idProducto'];
            $idNota = $_GET['idNota'];
            $command = Yii::app()->almacen->createCommand('select "'.getGestionSchema().'".reprocesa_oficial('.$idProducto.', '.$idNota.')');
            $command->queryScalar();
            
            $arrayResultado = Productonota::model()->movimientoProducto($idProducto);
            $contadorSaldoCantidadError = $arrayResultado['contadorSaldoCantidadError'];
            $contadorSaldoImporteError = $arrayResultado['contadorSaldoImporteError'];
            echo $contadorSaldoCantidadError.'*'.$contadorSaldoImporteError;
        }
    }
    
    public function actionCambiarMovimiento()
    {
        if(isset($_GET['idProducto']) && isset($_GET['idNota']))
        {
            $idProducto = $_GET['idProducto'];
            $idNota = $_GET['idNota'];
            $ingreso = $_GET['ingreso'];
            $salida = $_GET['salida'];
            $debe = $_GET['debe'];
            $haber = $_GET['haber'];

            $modelo = Productonota::model()
                        ->find(
                                'idproducto = '.$idProducto.' AND '.
                                'idnota = '.$idNota
                            );
            $modelo->scenario = 'cambiarMovimiento';
            $modelo->ingreso = $ingreso;
            $modelo->salida = $salida;
            $modelo->ingresoimporte = $debe;
            $modelo->salidaimporte = $haber;
            $modelo->importefijo = true;
            
            if($modelo->save())
            {
                $command = Yii::app()->almacen->createCommand('select "'.getGestionSchema().'".reprocesa_oficial('.$idProducto.', '.$idNota.')');
                $command->queryScalar();
                echo 1;
            }
            else
                print_r($modelo->getErrors());
            return;
        }
    }
    
    /**
     * Función para realizar el autocomplete del producto
     * por el parametro de código
     */
    public function actionAutocompletarCodigo() {
        $productoExcluido = null;
        if (isset($_GET['idalmacen']))
            $idalmacen = $_GET['idalmacen'];
        if (isset($_POST['codigo']))
            $codigo = $_POST['codigo'];
        
        if (isset($_POST['productoInventario']))
            $productoExcluido = $this->getIdProductoInventario($_POST['productoInventario']);

        if ($codigo != Null) {
            echo SGridView::widget('TGridViewList', array(
                'dataProvider' => Producto::model()->buscarProductoCodigo($productoExcluido, $idalmacen, $codigo),
                'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                    array('name' => 'codigo', 'width' => 10),
                    array('name' => 'nombre', 'width' => 50),
                    array('name' => 'udd', 'value' => '$data->idunidad0->simbolo','typeCol' => 'hidden')
                ),
            ));
        }
    }
    
    /**
     * Función para realizar el autocomplete del producto
     * por el parametro de código
     */
    public function actionAutocompletarNombre() {
        $productoExcluido = null;
        if (isset($_GET['idalmacen']))
            $idalmacen = $_GET['idalmacen'];
        if (isset($_POST['nombre']))
            $nombre = $_POST['nombre'];

        if (isset($_POST['productoInventario']))
            $productoExcluido = $this->getIdProductoInventario($_POST['productoInventario']);

        if ($nombre != Null) {
            echo SGridView::widget('TGridViewList', array(
                'dataProvider' => Producto::model()->buscarProductoNombre($productoExcluido, $idalmacen, $nombre),
                'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                    array('name' => 'codigo', 'width' => 10),
                    array('name' => 'nombre', 'width' => 50),
                    array('name' => 'udd', 'value' => '$data->idunidad0->simbolo', 'typeCol' => 'hidden')
                ),
            ));
        }
    }

    /**
     * Obtiene un array simple con los id de productos que contiene el
     * grid Pedidoproducto
     * @param Pedidoproducto $pedidoproducto
     * @return Array
     */
    public function getIdProductoInventario($pedidoproducto) {
        $idProducto = null;
        for ($i = 1; $i < count($pedidoproducto) + 1; $i++) {
            $idProducto[] = ($pedidoproducto[$i]['id']);
        }
        return $idProducto;
    }
    
    public function actionReporteAsignacionConsumos()
    {
        $txt = SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['reporteAsignacionConsumos']), 'id');
        $txt = str_replace("{", "", $txt);
        $txt = str_replace("}", "", $txt);

        $re = new JasperReport('/reports/Almacen/consumos', JasperReport::FORMAT_PDF, array(
            'pIds' => $txt,
            'pUsuario' => Yii::app()->user->getName(),
            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
        ));

        $re->exec();

        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas. ', 483);
        }
    }
    
    
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    public function actionMostrarRequisitos()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false,'bootbox.min.js' => false);
        $model = new Producto;
        $gridRequisito = array();
        
        if($_GET['idproducto'] > 0)
            $gridRequisito = Requisitoproducto::model()->mostrarRequisitoProducto($_GET['idproducto'], 0);
        
        if(isset($_GET['requisito']))
        {
            $aumentarColumna = $_GET['aumentarColumna'];
            $model->requisito = $_GET['requisito'];
            $model->aumentarColumna = $aumentarColumna;
        }
        
        $this->renderPartial('_requisitoDetalle',array(
            'gridRequisito' => $gridRequisito,
            'model' => $model,
        ), false, true);
    }
    
    public function actionBuscarRequisito()
    {
        $datos = Requisito::model()->searchRequisito($_POST['nombre']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array(
                    'id' => '0',
                    'nombre' => $_POST['nombre']
                ));

        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'id', 'typeCol' => 'hidden'),
                array('name' => 'nombre', 'value' => '$data->nombre'),
            ),
        ));
    }
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    public function actionBuscarProductoNombre() {
        $itemExcluido = null;
        $idalmacendestino = '';
        if (isset($_POST['gridTraspasoproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridTraspasoproducto']);
        }
        if (isset($_POST['gridDevolucionproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridDevolucionproducto']);
        }
        if (isset($_POST['idalmacendestino'])) {
            $idalmacendestino = $_POST['idalmacendestino'];
        }
        if (isset($_POST['idalmacenorigen'])) {
            $idalmacenorigen = $_POST['idalmacenorigen'];
        }
        if ($idalmacendestino != ''){
            $this->mostrarProducto($_POST['nombre'], $itemExcluido, $idalmacenorigen, $idalmacendestino, false);
        }
    }
    public function actionBuscarProductoCodigo() {
        $itemExcluido = null;
        $idalmacendestino = '';
        if (isset($_POST['gridTraspasoproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridTraspasoproducto']);
        }
        if (isset($_POST['gridDevolucionproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridDevolucionproducto']);
        }
        if (isset($_POST['idalmacendestino'])) {
            $idalmacendestino = $_POST['idalmacendestino'];
        }
        if (isset($_POST['idalmacenorigen'])) {
            $idalmacenorigen = $_POST['idalmacenorigen'];
        }
        if ($idalmacendestino != ''){
            $this->mostrarProducto($_POST['codigo'], $itemExcluido, $idalmacenorigen, $idalmacendestino, true);
        }
    }
    private function mostrarProducto($valor, $itemExcluido, $idalmacenorigen, $idalmacendestino, $boolCodigo){
        echo SGridView::widget('TGridViewList', array(
                'dataProvider' => Producto::model()->searchProductoTpv($valor, $itemExcluido, $idalmacenorigen, $idalmacendestino,$boolCodigo),
                'columns' => array(
                    array('name' => 'id', 'typeCol' => 'hidden'),
                    array('name' => 'idproducto', 'typeCol' => 'hidden', 'value' => '$data->id'),
                    array('name' => 'codigobarra', 'typeCol' => 'hidden', 'value' => '$data->coduniversal'),
                    array('name' => 'codigo', 'value' => '$data->codigo','width' => 15),
                    array('name' => 'nombre', 'value' => '$data->nombre','width' => 40),
                    array('name' => 'idunidad', 'value' => '$data->idunidad0->simbolo', 'width' => 6),
                    array('name' => 'saldo', 'value' => '$data->saldo', 'width' => 13),
                    array('name' => 'precio', 'value' => '$data->precio', 'width' => 13),
                    array('name' => 'reserva', 'value' => '$data->reserva', 'width' => 13),
                    array('name' => 'saldoDisponible', 'value' => '$data->saldo - $data->reserva', 'typeCol' => 'hidden'),
                    array('name' => 'permitirdecimal', 'value' => '$data->permitirdecimal?1:0', 'typeCol' => 'hidden'),
                ),
            ));
    }
    
    public function actionBuscar_ProductoCodigo() {
        $itemExcluido = null;
        if(isset($_POST['gridTemporadaproducto']))
            $itemExcluido = $this->getIdItem($_POST['gridTemporadaproducto']);
        
        $dato = '';
        if(isset($_POST['codigo']))
            $dato = $_POST['codigo'];
        else if(isset($_POST['nombre']))
            $dato = $_POST['nombre'];
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => Producto::model()->searchProductos($dato, $itemExcluido),
            'columns' => array(
                array('name' => 'idproducto', 'typeCol' => 'hidden', 'value' => '$data->id'),
                array('name' => 'codigo', 'value' => '$data->codigo','width' => 15),
                array('name' => 'nombre', 'value' => '$data->nombre','width' => 40),
                array('name' => 'idunidad', 'header' => 'Udd', 'value' => '$data->idunidad0->simbolo', 'width' => 6),
                array('name' => 'ventatpvHidden', 'typeCol' => 'hidden', 'value' => '$data->ventatpv'),
            ),
        ));
    }
    
    /**
     * Función que obtiene los id de producto
     * @param type $item
     * @return type
     */
    public function getIdItem($item) {
        $idItem = null;
        for ($i = 1; $i < count($item) + 1; $i++) {
            $idItem[$i] = ($item[$i]['idproducto']);
        }

        return $idItem;
    }
    
    /**
     * Genera el reporte en formato pdf del stock de productos en base a la 
     * vista del cgridview de la interfaz de stock, en caso de que el reporte
     * no tenga paginas se muestra una excepción
     */
    public function actionReporteProductoStockExcel() {
//        $re = new JasperReport('/reports/Almacen/productoStock', JasperReport::FORMAT_PDF, array(
//            'pIds' => SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['productoreporteStock']), 'id'),
//            'pUsuario' => Yii::app()->user->getName(),
//            'pFormatoNumero' => Yii::app()->params['formatNumberAlm'],
//            'pProveedor' => Yii::app()->session['proveedorStock'],
//            'REPORT_LOCALE' => Yii::app()->params['appLocale'],
//        ));
//        $re->exec();
//
//        if ($re->getPages() > 0 && Yii::app()->session['mostrarReporteProductoStock']) {
//            echo $re->toPDF();
//        } else {
//            throw new CrugeException('El reporte no tiene páginas.', 483);
//        }
        ini_set('memory_limit', '-1');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.PHPExcel.Classes.PHPExcel', true);
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("SOLAR SRL")
                ->setLastModifiedBy("SOLAR SRL")
                ->setTitle("Stock de Productos")
                ->setSubject("Stock de Productos")
                ->setDescription("Reporte de stock de productos")
                ->setKeywords("Reporte Stock de Productos/SOLUR SRL")
                ->setCategory("ALMACEN");

        // ----- Cabecera del documento
        $inf = 1;
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->getRowDimension($inf)->setRowHeight(25);
        $activeSheet->mergeCells('A' . ($inf) . ':F' . ($inf));
        $activeSheet->setCellValue('A' . ($inf), "STOCK DE PRODUCTOS");
        $activeSheet->getStyle("A" . $inf . ":F" . $inf)->applyFromArray(
            array(
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
            )
        );

        $inf = 2;
        $activeSheet->getRowDimension($inf)->setRowHeight(25);
        $activeSheet->setCellValue('A' . ($inf), "ALMACEN:");
        $activeSheet->setCellValue('B' . ($inf), Yii::app()->session['almacen']);
        if (Yii::app()->session['proveedorStock'] != Null) {
            $activeSheet->setCellValue('D' . ($inf), "PROVEEDOR:");
            $activeSheet->mergeCells('E' . ($inf) . ':F' . ($inf));
            $activeSheet->setCellValue('E' . ($inf), strtoupper(Yii::app()->session['proveedorStock']));
        }
        
        $inf = 3;
        $activeSheet->getRowDimension($inf)->setRowHeight(25);
        $activeSheet->setCellValue('A' . ($inf), "CODIGO");
        $activeSheet->setCellValue('B' . ($inf), "NOMBRE");
        $activeSheet->setCellValue('C' . ($inf), "UDD");
        $activeSheet->setCellValue('D' . ($inf), "STOCK");
        $activeSheet->setCellValue('E' . ($inf), "RESERVA");
        $activeSheet->setCellValue('F' . ($inf), "DISPONIBLE");
        

        // ancho de las columnas
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(60);
        $activeSheet->getColumnDimension('C')->setWidth(10);
        $activeSheet->getColumnDimension('D')->setWidth(15);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(15);

        $ids = SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['productoreporteStock']), 'id');
        $stock = Producto::model()->obtieneStockProductos($ids);
        $inf = 4;

        for ($i = 0; $i < count($stock); $i++, $inf++) {
            $activeSheet->setCellValue('A' . $inf, $stock[$i]['codigo']);
            $activeSheet->setCellValue('B' . $inf, $stock[$i]['nombre']);
            $activeSheet->setCellValue('C' . $inf, $stock[$i]['simbolo']);
            $activeSheet->setCellValue('D' . $inf, $stock[$i]['saldo']);
            $activeSheet->setCellValue('E' . $inf, $stock[$i]['reserva']);
            $activeSheet->setCellValue('F' . $inf, $stock[$i]['disponible']);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('F' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Stock de Productos.xlsx"');
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
    
    /*
     * Busca productos por codigo
     */
    public function actionBuscarCodigoProductoExcluidos() {
        $producto = new Producto;
        $productoExcluida = null;
        
        if(isset($_POST['idproductoorden'])){
            $productoExcluida[]= $_POST['idproductoorden'];
        }
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchCodigoProductoExcluida($_POST['codigo'], $productoExcluida),
            'columns' => array(
                array(
                    'name' => 'idproducto',
                    'value' => '$data->id',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'simbolo',
                    'value' => '$data->simbolo',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'entero',
                    'value' => '$data->entero',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'ultimoppp',
                    'value' => '$data->ultimoppp',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'codigo',
                    'width' =>20 
                    //'typeCol' => 'hidden'
                ),
                 array(
                    'name' => 'nombre',
                    'width' =>60
                    //'typeCol' => 'hidden'
                ),              
                array(
                    'name' => 'saldoDisponible',
                    'width' =>20,
                    'value' => '$data->saldo-$data->reserva',
                    'header'=>'Saldo Disponible',
                    'type'=>'number(8)'
                    //'typeCol' => 'hidden'
                ),
                
            )
        ));
    }
    
    public function actionBuscarNombreProductoExcluidos() {
        $producto = new Producto;
        $productoExcluida = null;
        
        if(isset($_POST['idproductoorden'])){
            $productoExcluida[]= $_POST['idproductoorden'];
        }      
     
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchNombreProductoExcluida($_POST['nombreproducto'], $productoExcluida),
            'columns' => array(
                array(
                    'name' => 'idproducto',
                    'value' => '$data->id',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'simbolo',
                    'value' => '$data->simbolo',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'entero',
                    'value' => '$data->entero',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'saldoDisponible',
                    'value' => '$data->saldo-$data->reserva',
                    'typeCol' => 'hidden'
                ),
                array(
                    'name' => 'ultimoppp',
                    'value' => '$data->ultimoppp',
                    'typeCol' => 'hidden'
                ),
                'codigo',
                'nombre'
            )
        ));
    }
    
    /**
     * Función que autocompleta el codigo y nombre de producto en un textfield
     */
    public function actionAutocompleteCodigoNombre() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $cantidadDigitos =  strlen($request);
            if ($cantidadDigitos>=3){
                $model = Producto::model()->findProductoExcluido($requestMayuscula,isset($_GET['idalmacen'])?$_GET['idalmacen']:null);
                $data = array();
                foreach ($model as $get) {
                    $data[] = array(
                        'id' => $get->id,
                        'value' => '('.$get->codigo.') '.$get->nombre,
                        'nombre' => $get->nombre,
                        'simbolo' => $get->simbolo,
                    );
                }
                $this->layout = 'empty';
                echo CJSON::encode($data);
            }
        }
    }
    
    
    
    // -------------------------------------------------------------------------
    // ------------------- [ Agrupación de productos "TPV" ] -------------------
    // -------------------------------------------------------------------------
    public function actionAdminAgrupacion() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = new Producto('searchAgrupacion');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }
        
        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }
        
        $this->renderPartial('_agrupacionAdmin', array(
            'model' => $model
        ), false, true);
    }
    public function actionAgrupacionProductoCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = new Producto;
        $model->scenario = 'registraAgrupacion';
        $gridAgrupacionproducto = array();
        
        if(isset($_POST['Agrupacion']))
        {
            $postAgrupacion = $_POST['Agrupacion'];
            $model->producto = $postAgrupacion['producto'];
            
            if($model->validate())
            {
                if(!isset($_POST['gridAgrupacionproducto']))
                {
                    echo System::hasErrors('La lista de productos NO contiene productos! ');
                    return;
                }
                $gridAgrupacionproducto = $_POST['gridAgrupacionproducto'];
                
                for($i = 1; $i <= count($gridAgrupacionproducto); $i++)
                {
                    $idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                    if($idproducto > 0)
                    {
                        $modelo = new Agrupacionproducto;
                        $modelo->idproductogrupo = $postAgrupacion['idproductogrupo'];
                        $modelo->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
                        $modelo->idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                        $modelo->save();
                    }
                }
                $modelProducto = Producto::model()->find('id = '.$postAgrupacion['idproductogrupo']);
                $modelProducto->scenario = 'actualizaProductoGrupo';
                $modelProducto->grupo = true;
                $modelProducto->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
                $modelProducto->save();
                
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }
        
        $this->renderPartial('_agrupacionForm', array(
            'model' => $model,
            'gridAgrupacionproducto' => $gridAgrupacionproducto,
        ), false, true);
    }
    public function actionAgrupacionProductoUpdate($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->scenario = 'actualizaAgrupacion';
        $gridAgrupacionproducto = Agrupacionproducto::model()->obtenerProductosHijos($model->id);
        $model->producto = '('.$model->codigo.') '.$model->nombre;
        $model->idproductogrupo = $model->id;
        $model->pesopromedio = $model->pesopromedio;
        
        if(isset($_POST['Agrupacion']))
        {   
            $postAgrupacion = $_POST['Agrupacion'];
            
            if(!isset($_POST['gridAgrupacionproducto']))
            {
                echo System::hasErrors('La lista de productos NO contiene productos! ');
                return;
            }
            $gridAgrupacionproducto = $_POST['gridAgrupacionproducto'];
            
            Agrupacionproducto::model()->deleteAll('idproductogrupo = '.$postAgrupacion['idproductogrupo']);
            for($i = 1; $i <= count($gridAgrupacionproducto); $i++)
            {
                $idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                if($idproducto > 0)
                {
                    $modelo = new Agrupacionproducto;
                    $modelo->idproductogrupo = $postAgrupacion['idproductogrupo'];
                    $modelo->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
                    $modelo->idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                    $modelo->save();
                }
            }
            $modelProducto = Producto::model()->find('id = '.$postAgrupacion['idproductogrupo']);
            $modelProducto->scenario = 'actualizaProductoGrupo';
            $modelProducto->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
            $modelProducto->save();
            
            echo System::dataReturn('Creación exitosa!');
            return;
        }
        
        $this->renderPartial('_agrupacionForm', array(
            'model' => $model,
            'gridAgrupacionproducto' => $gridAgrupacionproducto,
        ), false, true);
    }
    public function actionAutocompleteProductoPadre() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if($request != '') {
            $model = Producto::model()->muestraProductoPadre($requestMayuscula);
            $data = array();
            foreach($model as $get) {
                $data[] = array(
                    'id' => $get->id,
                    'value' => '('.$get->codigo.') '.$get->nombre,
                    'precio' => $get->precio,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    public function actionBuscarProductoCodigoNombre() {
        $itemExcluido = null;
        if(!isset($_POST['precio']))
        {
            echo 'El precio del producto Grupo No existe! ';
            return;
        }
        if($_POST['precio'] == '')
        {
            echo 'El precio del producto Grupo No existe! ';
            return;
        }
        if(isset($_POST['gridAgrupacionproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridAgrupacionproducto']);
        }
        $valor = isset($_POST['codigo'])? $_POST['codigo'] : $_POST['nombre'];
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => Producto::model()->searchProductoAgrupacion($valor, $itemExcluido, $_POST['precio'], $_POST['idproductoPadre']),
            'columns' => array(
                array('name' => 'idproducto', 'typeCol' => 'hidden', 'value' => '$data->id'),
                array('name' => 'codigo', 'value' => '$data->codigo','width' => 20),
                array('name' => 'nombre', 'value' => '$data->nombre','width' => 64),
                array('header' => 'Udd', 'name' => 'unidad', 'value' => '$data->idunidad0->simbolo', 'width' => 8),
                array('name' => 'precio', 'value' => '$data->precio', 'width' => 8),
            ),
        ));
    }
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    public function actionBuscarProductoCodigoNombreReproceso() {
        $itemExcluido = null;
        if(isset($_POST['gridProducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridProducto']);
        }
        $valor = isset($_POST['codigo'])? $_POST['codigo'] : $_POST['nombre'];
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => Producto::model()->searchProductoReproceso($valor, $itemExcluido, $_POST['idproductoPadre']),
            'columns' => array(
                array('name' => 'idproducto', 'typeCol' => 'hidden', 'value' => '$data->id'),
                array('name' => 'codigo', 'value' => '$data->codigo','width' => 20),
                array('name' => 'nombre', 'value' => '$data->nombre','width' => 64),
                array('header' => 'Udd', 'name' => 'unidad', 'value' => '$data->idunidad0->simbolo', 'width' => 8),
                array('name' => 'precio', 'value' => '$data->precio', 'width' => 8),
            ),
        ));
    }
    
    public function actionDescargarExcelConsumo() {
        

        
        if (!isset($_GET['Producto'])) {
            throw new CrugeException('No se enviaron parámetros a la accion actionReporteIndicadores.', 483);
        }
        $idProducto = $_GET['Producto']['id'];
        
        $fechaFin = $_GET['Producto']['fechaFin'];
        $fechaInicio = $_GET['Producto']['fechaInicio'];
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $gestionModel = Gestion::model()->find($criteria);
            $fechaInicio = $gestionModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }
        
        $command = Yii::app()->almacen->createCommand("select codigo,nombre,sum,anio,mes,nmes 
                from consumomesesperiodo(".$idProducto.",'".$fechaInicio."'::Date,'".$fechaFin."'::date) ORDER BY codigo,anio,nmes")->queryAll();
        
        ini_set('memory_limit', '-1');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SOLUR SRL")
                ->setLastModifiedBy("SOLUR SRL")
                ->setTitle("Reporte Diferencias")
                ->setSubject("Reporte Diferencias")
                ->setDescription("Reportes para gerencia")
                ->setKeywords("Reporte Gerencial/SOLUR SRL")
                ->setCategory("VENTAS");


        $inf = 1;
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $fillTitulo = array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        );
        $fillPie = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                    'color' => array('rgb' => '000000')
                                ),
                                'bottom' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                    'color' => array('rgb' => '000000')
                                ),
                            ),
                        );
        $activeSheet->setCellValue('A' . ($inf), "CODIGO");
        $activeSheet->setCellValue('B' . ($inf), $command[0]['codigo']);
        $activeSheet->getStyle('A' . $inf)->applyFromArray($fillTitulo);
        $activeSheet->getStyle('A' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('B' . $inf)->applyFromArray($fillTitulo);
                $inf++;
        $activeSheet->setCellValue('A' . ($inf), "NOMBRE");
        $activeSheet->setCellValue('B' . ($inf), $command[0]['nombre']);
        $activeSheet->getStyle('A' . $inf)->applyFromArray($fillTitulo);
        $activeSheet->getStyle('A' . $inf)->getFont()->setBold(true);
        $activeSheet->getStyle('B' . $inf)->applyFromArray($fillTitulo);
        $inf++;
        $inf++;
        $activeSheet->setCellValue('B' . ($inf), "MES");
        $activeSheet->setCellValue('C' . ($inf), "AÑO");
        $activeSheet->setCellValue('D' . ($inf), "SUMA");
        $total=0;
        for ($i = 0; $i < count($command); $i++, $inf++) {            
            $activeSheet->setCellValue('B' . $inf, $command[$i]['mes']);
            $activeSheet->setCellValue('C' . $inf, $command[$i]['anio']);
            $activeSheet->setCellValue('D' . $inf, $command[$i]['sum']);
            $total+=$command[$i]['sum'];
            $objPHPExcel->getActiveSheet()->getStyle('D' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
        }
        $inf++;
        $activeSheet->setCellValue('B' . ($inf), "PROMEDIO");
        $activeSheet->setCellValue('D' . $inf, $total/ count($command));
        $objPHPExcel->getActiveSheet()->getStyle('D' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('B' . $inf)->applyFromArray($fillPie);
        $activeSheet->getStyle('C' . $inf)->applyFromArray($fillPie);
        $activeSheet->getStyle('D' . $inf)->applyFromArray($fillPie);
//        return;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteDiferencias_'.$fechaInicio.'-'.$fechaFin.'.xlsx"');
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
    
    public function actionReporteAsignacionConsumosSolicitud()
    {
        $txt = SWUtil::aRtoArrayReport(Producto::model()->findAll(Yii::app()->session['reporteAsignacionConsumos']), 'id');

        $command = Yii::app()->almacen->createCommand("select p.codigo, p.nombre, u.simbolo, a.nombre as almacen,
	(select consumoactual(p.id)) as stockinicial,
	consumohistorico as stockminimo,
	(select consumomaximo(p.id)) as stockmaximo,
	p.saldo,(p.tiempoentrega::numeric/30) as tiempoentrega,
	case when
	case when consumohistorico = null or consumohistorico = 0 then 0
	else round(p.saldo/consumohistorico, 3) end <= 4
	then 1 else 0 end as verificaduracionasignacionconsumo,

	case when
	case when consumohistorico = null or consumohistorico = 0 then 0
	else round(p.saldo/consumohistorico, 3) end <= 4
	then
	    case when (consumohistorico = null or consumohistorico = 0) then null
	    else round(p.saldo/consumohistorico, 3) end
	else round(p.saldo/consumohistorico, 3) end as duracion,
        
        case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1
        ) then
        (select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1)
        else (case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id) order by idproducto asc,1 desc limit 1)  then
         (select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1) else null end) end as numerosolicitud,
        
        case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1
        ) then
        (select s.fecha::date from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1)
        else (case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id) order by idproducto asc,1 desc limit 1)  then
         (select s.fecha::date from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1) else null end) end as fechasolicitud,

        case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1
        ) then
        (null)
        else (case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id) order by idproducto asc,1 desc limit 1)  then
         (select o.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1) else null end) end as numeroorden,
        
        case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1
        ) then
        (null)
        else (case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id) order by idproducto asc,1 desc limit 1)  then
         (select o.fecha::date from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1) else null end) end as fechaorden,
        
        case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        where s.idestado =5 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1
        ) then
        (null)
        else (case when exists (
        select s.numero from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id) order by idproducto asc,1 desc limit 1)  then
         (select s.fechalimite::date from ftbl_compra_solicitud s
        join ftbl_compra_solicituditem si on s.id=si.idsolicitud
        join ftbl_compra_item i on si.iditem=i.id
        join ftbl_compra_orden o on o.idsolicitud=s.id and o.idestado not in (4,14,2)
        join ftbl_compra_ordenitem oi on oi.idorden=o.id and si.iditem=oi.iditem
        where s.idestado =7 and i.idproducto in (p.id)order by idproducto asc,1 desc limit 1) else null end) end as fechalimite,

        e.razonsocial as fabrica, e.nit as nit_fabrica, e.telefono, e.fax, e.email, e.pagina
        from 	configuracion.empresa e,
	producto p inner join unidad u on p.idunidad = u.id
	inner join almacen a on p.idalmacen = a.id
        where p.eliminado is false and p.id in (select unnest('".$txt."'::integer[]))
        order by p.codigo asc, a.nombre asc")->queryAll();
        
        ini_set('memory_limit', '-1');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SOLUR SRL")
                ->setLastModifiedBy("SOLUR SRL")
                ->setTitle("Reporte Diferencias")
                ->setSubject("Reporte Diferencias")
                ->setDescription("Reportes para gerencia")
                ->setKeywords("Reporte Gerencial/SOLUR SRL")
                ->setCategory("VENTAS");

        $inf = 1;
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $fontTitulo= array(
                            'font'  => array(
                                'bold'  => true,
                                'color' => array('rgb' => '000000'),
                                'size'  => 7,
                                'name'  => 'Verdana'
                            )
                        );
        $fontCuerpo= array(
                            'font'  => array(
                                'bold'  => false,
                                'color' => array('rgb' => '000000'),
                                'size'  => 10,
                                'name'  => 'Verdana'
                            )
                        );
        $fillTitulo = array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
//                            'fill' => array(
//                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                                'color' => array('rgb' => 'E7EBDA')
//                            )
                        );
        $fillPie = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                    'color' => array('rgb' => '000000')
                                ),
                                'bottom' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                    'color' => array('rgb' => '000000')
                                ),
                            ),
                        );
        $formatDate = 'dd/mm/yyyy';
        //$formatDateTime = PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME;
        $activeSheet->setCellValue('A'.($inf),"CODIGO");
        $activeSheet->setCellValue('B'.($inf),"NOMBRE");
        $activeSheet->setCellValue('C'.($inf),"UNIDAD");
        $activeSheet->setCellValue('D'.($inf),"ALMACEN");
        $activeSheet->setCellValue('E'.($inf),"CONSUMO\nACTUAL\n(PROM. 3 MESES)");
        $activeSheet->setCellValue('F'.($inf),"CONSUMO\nHISTORICO\n(GESTION ANTERIOR)");
        $activeSheet->setCellValue('G'.($inf),"CONSUMO\nMAXIMO\n(GESTION ANTERIOR)");
        $activeSheet->setCellValue('H'.($inf),"SALDO");
        $activeSheet->setCellValue('I'.($inf),"TIEMPO \nREPOSICION\n(MESES)");
        $activeSheet->setCellValue('J'.($inf),"TIEMPO\nDURACION\n(MESES)");
        $activeSheet->setCellValue('K'.($inf),"FECHA\nSOLICITUD");
        $activeSheet->setCellValue('L'.($inf),"NRO\nSOLICITUD");
        $activeSheet->setCellValue('M'.($inf),"FECHA\nORDEN");
        $activeSheet->setCellValue('N'.($inf),"NRO\nORDEN");
        $activeSheet->setCellValue('O'.($inf),"FECHA\nLIMITE");
        $activeSheet->setCellValue('P'.($inf),"OBSERVACION");
        
        $activeSheet->getColumnDimension('A')->setWidth(11);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(7);
        $activeSheet->getColumnDimension('D')->setWidth(9);
        $activeSheet->getColumnDimension('E')->setWidth(13);
        $activeSheet->getColumnDimension('F')->setWidth(13);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(13);
        $activeSheet->getColumnDimension('K')->setWidth(13);
        $activeSheet->getColumnDimension('L')->setWidth(13);
        $activeSheet->getColumnDimension('M')->setWidth(13);
        $activeSheet->getColumnDimension('N')->setWidth(9);
        $activeSheet->getColumnDimension('O')->setWidth(13);
        $activeSheet->getColumnDimension('P')->setWidth(12);
        $activeSheet->getStyle("A" . $inf . ":" . "P" . $inf)->getAlignment()->setWrapText(true);
        $activeSheet->getStyle("A" . $inf . ":" . "P" . $inf)->applyFromArray($fontTitulo);
        $activeSheet->getStyle("A" . $inf . ":" . "P" . $inf)->applyFromArray($fillCabecera);
        $inf++;

        for ($i = 0; $i < count($command); $i++, $inf++) {            
            $activeSheet->setCellValue('A' . $inf, $command[$i]['codigo']);
            $activeSheet->setCellValue('B' . $inf, $command[$i]['nombre']);
            $activeSheet->setCellValue('C' . $inf, $command[$i]['simbolo']);
            $activeSheet->setCellValue('D' . $inf, $command[$i]['almacen']);
            $activeSheet->setCellValue('E' . $inf, $command[$i]['stockinicial']);
            $activeSheet->setCellValue('F' . $inf, $command[$i]['stockminimo']);
            $activeSheet->setCellValue('G' . $inf, $command[$i]['stockmaximo']);
            $activeSheet->setCellValue('H' . $inf, $command[$i]['saldo']);
            $activeSheet->setCellValue('I' . $inf, $command[$i]['tiempoentrega']);
            $activeSheet->setCellValue('J' . $inf, $command[$i]['duracion']);
            $activeSheet->setCellValue('K' . $inf, $command[$i]['fechasolicitud']!=null?PHPExcel_Shared_Date::PHPToExcel( $command[$i]['fechasolicitud'] ):'');
            $activeSheet->setCellValue('L' . $inf, $command[$i]['numerosolicitud']);
            $activeSheet->setCellValue('M' . $inf, $command[$i]['fechaorden']!=null?PHPExcel_Shared_Date::PHPToExcel( $command[$i]['fechaorden'] ):'');
            $activeSheet->setCellValue('N' . $inf, $command[$i]['numeroorden']);
            $activeSheet->setCellValue('O' . $inf, $command[$i]['fechalimite']!=null?PHPExcel_Shared_Date::PHPToExcel( $command[$i]['fechalimite'] ):'');
            
            $objPHPExcel->getActiveSheet()->getStyle('E' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('F' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('G' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('H' . $inf)->getNumberFormat()->setFormatCode('#,##0.0000');
            $objPHPExcel->getActiveSheet()->getStyle('I' . $inf)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('J' . $inf)->getNumberFormat()->setFormatCode('#,##0.000');
            $objPHPExcel->getActiveSheet()->getStyle('k' . $inf)->getNumberFormat()->setFormatCode($formatDate);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $inf)->getNumberFormat()->setFormatCode($formatDate);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $inf)->getNumberFormat()->setFormatCode($formatDate);
            $activeSheet->getStyle("A" . $inf . ":" . "P" . $inf)->applyFromArray($fontCuerpo);
            //$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $i)->getNumberFormat()->setFormatCode($format);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteAsignacionConsumo.xlsx"');
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

    public function actionReportestockminimo() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Producto;
        $productoStock = array();
        
        $this->renderPartial('stockminimo', array(
            'model' => $model,
            'productoStock' => $productoStock,
                ), false, true);
    }
    
    public function actionReportestockminimoPDF() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        if (!isset($_GET['Producto'])) {
            throw new CrugeException('No se enviaron parámetros a la accion actionReporteIndicadores.', 483);
        }
        $fechaFin = $_GET['Producto']['fechaFin'];
        $fechaInicio = $_GET['Producto']['fechaInicio'];
        $grupoProducto =$_GET['Producto']['grupoproducto'];
        $tipoMovimiento=$_GET['Producto']['tipomovimiento'];
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $ordenModel = Gestion::model()->find($criteria);
            $fechaInicio = $ordenModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }
        if ($grupoProducto == 1){
            $idProducto=0;
            $producto= '';
            $idproveedor=0;
            $proveedor='';
            $idFamilia = 0;
            $familia='';
        }
        if ($grupoProducto == 2){
            $idproveedor = $_GET['Producto']['idproveedor']==''?0:$_GET['Producto']['idproveedor'];
            $proveedor = FtblCompraProveedor::model()->find('id='.$idproveedor)->nombre;
            $idFamilia = 0;
            $familia='';
            $idProducto = 0;
            $producto= '';
        }
        if ($grupoProducto == 3){
            $idFamilia = $_GET['Producto']['idfamilia']==''?0:$_GET['Producto']['idfamilia'];
            $familia= Familia::model()->find('id= '.$idFamilia)->nombre;
            $idproveedor=0;
            $proveedor='';
            $idProducto = 0;
            $producto= '';
        }
        if ($grupoProducto == 4){
            $idProducto = $_GET['Producto']['idproductoindividual']==''?0:$_GET['Producto']['idproductoindividual'];
            $producto= Producto::model()->find('id= '.$idProducto)->nombre;
            $idproveedor=0;
            $proveedor='';
            $idFamilia = 0;
            $familia='';
        }
        
        $idAlmacen = $_GET['Producto']['almacen'] == '' ? 0 : $_GET['Producto']['almacen'];
        $almacen = $idAlmacen != 0 ? Almacen::model()->find('id=' . $idAlmacen)->nombre : 'TODOS LOS ALMACENES';
        
        $re = new JasperReport('/reports/Almacen/stockminimo', JasperReport::FORMAT_PDF, array(
            'pUsuario' => Yii::app()->user->getName(),
            'pFechaDesde' => Yii::app()->format->date(strtotime($fechaInicio)),
            'pFechaHasta' => Yii::app()->format->date(strtotime($fechaFin)),
            'pIdProveedor' => $idproveedor,
            'pIdAlmacen' => $idAlmacen,
            'pIdProducto' => $idProducto,
            'pNombreAlmacen' => $almacen,
            'pNombreProveedor' => $proveedor,
            'pNombreProducto' => $producto,
            'pTipoMovimiento' => $tipoMovimiento,
            'pIdFamilia' => $idFamilia,
            'pFamilia' => $familia,
            'pGrupoProducto' => $grupoProducto,
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
	
    public function actionAutocompleteProveedor() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = FtblCompraProveedor::model()->findAll(array("condition" => "nombre like '%$requestMayuscula%'", "order" => "nombre"));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'label' => $get->nombre,
                    'value' => $get->nombre,
                    'nombre' => $get->nombre,
                    'id' => $get->id);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    
    public function actionAutocompleteProductoStock() {
        $request = trim($_GET['term']);
        $idalmacen = $_GET['idalmacen'];
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Producto::model()->findAll(array("condition" => "idalmacen=".$idalmacen." and (nombre ilike '%$requestMayuscula%' or codigo ilike '%$requestMayuscula%')", "order" => "nombre"));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'label' => "(".$get->codigo.") - ".$get->nombre,
                    'value' => $get->nombre,
                    'id' => $get->id);
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    public function actionAsignarStockMinimo(){
        
        $fechaFin = $_GET['fechaFin'];
        $fechaInicio = $_GET['fechaInicio'];
        $grupoProducto =$_GET['grupoproducto'];
        $tipoMovimiento=$_GET['tipomovimiento'];
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $ordenModel = Gestion::model()->find($criteria);
            $fechaInicio = $ordenModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }
        if ($grupoProducto == 1){
            $idproveedor=0;
            $idFamilia = 0;
            $idProducto = 0;
        }
        if ($grupoProducto == 2){
            $idproveedor = $_GET['idproveedor']==''?0:$_GET['idproveedor'];
            $idFamilia = 0;
            $idProducto = 0;
        }
        if ($grupoProducto == 3){
            $idFamilia = $_GET['idfamilia']==''?0:$_GET['idfamilia'];
            $idproveedor=0;
            $idProducto = 0;
        }
        if ($grupoProducto == 4){
            $idProducto = $_GET['idproductoindividual']==''?0:$_GET['idproductoindividual'];
            $idproveedor=0;
            $idFamilia = 0;
        }
        $idAlmacen = $_GET['idalmacen'] == '' ? 0 : $_GET['idalmacen'];
        $productosRepetidos = Yii::app()->almacen->createCommand("with x as (select count(id),id,codigo,string_agg(proveedor,',') as nombre 
            from reportestockminimo_parametros(".$idProducto.",'".$fechaInicio."','".$fechaFin."',".$idAlmacen.",".$idFamilia.",".$idProducto.",".$tipoMovimiento.",".$grupoProducto.")
            group by id,codigo) select * from x where count>1")->queryAll();
        if (count($productosRepetidos)>0){
            $response = array('error'=>1, 'productos'=>$productosRepetidos);
        }else{
            $productoStock = Yii::app()->almacen->createCommand("select * 
            from reportestockminimo_parametros(".$idProducto.",'".$fechaInicio."','".$fechaFin."',".$idAlmacen.",".$idFamilia.",".$idProducto.",".$tipoMovimiento.",".$grupoProducto.",true)
            ")->queryAll();
            if (count($productoStock)>0){
                $productos = '';
                $cantProducto=0;
                foreach ($productoStock as $dato):
                    $producto = Producto::model()->find("id=".$dato['id']);
                    $producto->scenario='stockminimo';
                    $producto->stock_minimo=$dato['stockminimo'];
                    $producto->stock_minimoredondeado=ceil($dato['stockminimo']);
                    $producto->stock_minimoajustado=round($dato['stockminimo']*$dato['factorseguridad'],4);
                    $error =0;
                    //--- PARAMETROS ENVIO NOTIFICACION
                    if ($producto->saldo<=$dato['stockminimo']){
                        $productos = $productos . '<p style="color:red"><b>['.$producto->codigo."] - ".$producto->nombre."</b><br/>";
                        $cantProducto++;
                    }
                    //----------
                    //------INICIA historial cambios
                    $arraycambios=array();
                    $fechacambio = date('Y-m-d H:i:s');
                    $usuariocambio = Yii::app()->user->getName();
                    if($producto->historialcambios!=null){ 
                        $arraycambios=CJSON::decode($producto->historialcambios,true);
                        $productocambio = array();
                        $productocambio['admitedescuento']=$producto->admitedescuento?1:0;
                        $productocambio['aumentarColumna']=0;
                        $productocambio['codigo']=$producto->codigo;
                        $productocambio['codigoAlmacen']=$producto->idalmacen;
                        $productocambio['codigoClase']=$producto->idclase0->codigo;
                        $productocambio['codigoFamilia']=$producto->idfamilia0->codigo;;
                        $productocambio['coduniversal']=$producto->coduniversal;
                        $productocambio['idclase']=$producto->idclase;
                        $productocambio['existeImagen']=true;
                        $productocambio['idestadofichatecnica']='';
                        $productocambio['idfamilia']=$producto->idfamilia;
                        $productocambio['idunidad']=$producto->idunidad;
                        $productocambio['idunidadpresentacion']=$producto->idunidadpresentacion;
                        $productocambio['id_producto']=$producto->id;
                        $productocambio['lineatabu']=$producto->lineatabu?1:0;
                        $productocambio['nombre']=$producto->nombre;
                        $productocambio['nombreClase']=$producto->idclase0->nombre;
                        $productocambio['nombreCompletadoClase']=$producto->idclase0->nombre;
                        $productocambio['nombreCompletadoFamilia']=$producto->idfamilia0->nombre;
                        $productocambio['nombreFamilia']=$producto->idfamilia0->nombre;
                        $productocambio['nombresenasag']=$producto->nombresenasag;
                        $productocambio['ventatpv']=$producto->ventatpv?1:0;
                        $productocambio['precio']=$producto->precio;
                        $productocambio['fechacambio']=$fechacambio;
                        $productocambio['stock_minimo']=$producto->stock_minimo;
                        $productocambio['stock_minimoajustado']=$producto->stock_minimoajustado;
                        $productocambio['stock_minimoredondeado']=$producto->stock_minimoredondeado;
                        $productocambio['usuario']=$usuariocambio;
                        array_push($arraycambios,$productocambio );   
                    }else{
                        $producto->fechacambio=$fechacambio;
                        $producto->usuario=$usuariocambio;
                        array_push($arraycambios, $producto);
                    }
                    $producto->historialcambios=CJSON::encode($arraycambios);
                    //-----FIN historial cambios
                    if(!$producto->save()){
                        $error++;
                    }
                    if($error>0){
                        $response = array('error'=>3, 'message'=>'ERROR AL ACTUALIZAR PRODUCTOS');
                    }else{
                        $response = array('error'=>0, 'message' => 'ACTUALIZACION DE STOCKS MINIMOS CORRECTO');
                    }
                endforeach;
                if ($cantProducto>0){
                    $productos= $productos."</p>";
                    $parametrosNotificacion=array('idtiponotificacion'=>1,
                           'productos'=>$productos
                          );
                    self::envioNotificacion($parametrosNotificacion);
                }
            }else{
                $response = array('error'=>2, 'message'=>'NO EXISTEN PRODUCTOS');
            }
        }
        //$stockminimo = Yii::app()->almacen->createCommand("select * from reportestockminimo_parametros(0,'22-04-2021','23-07-2021',1,0,5590,0,4)")->queryAll();
        
        echo json_encode($response);
    }
    
    public function envioNotificacion($parametros) {
        $idtiponotificacion = $parametros['idtiponotificacion'];
        $productos = $parametros['productos'];

        //-------------------- INICIO configuracion para envio de email ----------------
        $SM = Yii::app()->swiftmailer;
        // Get config
        $mailHost = 'mail.chocolatesparati.net';
        $mailPort = 465; // Optional
        // New transport
        $Transport = $SM->smtpTransport($mailHost, $mailPort)
                ->setUsername('notificacion@chocolatesparati.net')
                ->setPassword('Solur2021*')
                ->setEncryption('ssl');
        // Mailer
        $Mailer = $SM->mailer($Transport);
        //------------------------------------------------------------------------------
        // New message
        $notificacion = TipoNotificacion::model()->find("id=1");
        $mensaje  = $notificacion->mensaje."<br>".$productos;
        $usuarioNotificacion = TipoNotificacionUsuario::model()->findAll("idtiponotificacion=".$notificacion->id);
        $correos = array();
        foreach ($usuarioNotificacion as $usuario):
            $correos[ $usuario->idusuarionotificacion0->email] = $usuario->idusuarionotificacion0->nombre_usuario ;
        endforeach;

        $Message = $SM
                ->newMessage($notificacion->nombre)
                ->setFrom(array('notificacion@chocolatesparati.net' => 'Notificacion'))
                ->setTo($correos)
//                    ->addPart($content, 'text/html')
                ->setBody($mensaje,'text/html');

        // Send mail
        $result = $Mailer->send($Message);

    }
    
    /*
     * Filtra todos los datos de la tabla "productoStock"
     */
    public function actionLoadProductoStock()
    {
        $fechaFin = $_GET['fechaFin'];
        $fechaInicio = $_GET['fechaInicio'];
        $grupoProducto =$_GET['grupoproducto'];
        $tipoMovimiento=$_GET['tipomovimiento'];
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $ordenModel = Gestion::model()->find($criteria);
            $fechaInicio = $ordenModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }
        if ($grupoProducto == 1){
            $idproveedor=0;
            $idFamilia = 0;
            $idProducto = 0;
        }
        if ($grupoProducto == 2){
            $idproveedor = $_GET['idproveedor']==''?0:$_GET['idproveedor'];
            $idFamilia = 0;
            $idProducto = 0;
        }
        if ($grupoProducto == 3){
            $idFamilia = $_GET['idfamilia']==''?0:$_GET['idfamilia'];
            $idproveedor=0;
            $idProducto = 0;
        }
        if ($grupoProducto == 4){
            $idProducto = $_GET['idproductoindividual']==''?0:$_GET['idproductoindividual'];
            $idproveedor=0;
            $idFamilia = 0;
        }
        $idAlmacen = $_GET['idalmacen'] == '' ? 0 : $_GET['idalmacen'];

        if($idAlmacen == 0 && $fechaInicio == null && $fechaFin == null){
            $productoStock = array();
        } else {
            $productoStock = Yii::app()->almacen->createCommand("select *,case when proveedor is null then 0 else 1 end as tieneproveedor, factorseguridad*stockminimo as stockajustado,ceil(stockminimo) as stockredondeado
            from reportestockminimo_parametros(".$idproveedor.",'".$fechaInicio."','".$fechaFin."',".$idAlmacen.",".$idFamilia.",".$idProducto.",".$tipoMovimiento.",".$grupoProducto.")
             order by codigo")->queryAll();
        }
        $this->renderPartial('_productoStock',array(
            'productoStock' => $productoStock,
        ), false, true);
    }
    
    public function actionSolicitudtockminimo() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Producto;
        $productoStock = array();
        
        $this->renderPartial('generarSolicitud', array(
            'model' => $model,
            'productoStock' => $productoStock,
                ), false, true);
    }
    
    /*
     * Filtra todos los datos de la tabla "productoStock"
     */
    public function actionLoadProductoStockSolicitud() {
        $fechaFin = $_GET['fechaFin'];
        $fechaInicio = $_GET['fechaInicio'];
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $ordenModel = Gestion::model()->find($criteria);
            $fechaInicio = $ordenModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }
        
        $idAlmacen = $_GET['idalmacen'] == '' ? 0 : $_GET['idalmacen'];

        if($idAlmacen == 0 && $fechaInicio == null && $fechaFin == null){
            $productoStock = array();
        } else {
            $productoStock = Yii::app()->almacen->createCommand("select *
            from stockminimo_parametros_solicitud('".$fechaInicio."','".$fechaFin."',".$idAlmacen.") order by codigo
            ")->queryAll();
        }
        $this->renderPartial('_productoStocksolicitud',array(
            'productoStock' => $productoStock,
        ), false, true);
    }
    
    public function actionGenerarSolicitud(){
        
        $fechaFin = $_GET['fechaFin'];
        $fechaInicio = $_GET['fechaInicio'];
        
        if ($fechaInicio === '') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';
            $ordenModel = Gestion::model()->find($criteria);
            $fechaInicio = $ordenModel->inicio;
        }
        if ($fechaFin === '') {
            $fechaFin = date('Y-m-d');
        }

        $idAlmacen = $_GET['idalmacen'] == '' ? 0 : $_GET['idalmacen'];
        
        $productoStock = Yii::app()->almacen->createCommand("select id
        from stockminimo_parametros_solicitud('".$fechaInicio."','".$fechaFin."',".$idAlmacen.") where solicitud =1 order by codigo
        ")->queryAll();//(select unnest('".$txt."'::integer[]))
        
        if (count($productoStock)>0){
            $idproductos = implode(",",$productoStock);
            $idproveedores = Yii::app()->almacen->createCommand("select idproveedor from producto where is in (select unnest('".$idproductos."'::integer[])) group by idproveedor")->queryAll();
            if (!empty($idproveedores)){
                foreach ($idproveedores as $proveedor):
                    $productoProveedor = Yii::app()->almacen->createCommand("select id from producto where is in (select unnest('".$idproductos."'::integer[])) and idproveedor=".$proveedor['idproveedor'])->queryAll();
                    $idproductosProveedor =implode(",",$productoProveedor);
                    $maxTiempo = Yii::app()->almacen->createCommand("select max(tiempoentrega) from producto where is in (select unnest('".$idproductos."'::integer[])) and idproveedor=".$proveedor['idproveedor'])->queryAll();
                    $registro = Yii::app()->compra->createCommand("select registrosolicitud(".$proveedor['idproveedor'].",'".$idproductosProveedor."',".$maxTiempo.",'".Yii::app()->user->getName()."','".System::getNameLastSchema()."')")->queryExecute();
                endforeach;
            }
            
            //$productos = SWUtil::aRtoArrayReport(Producto::model()->findAll('id in ('.$idproductos.')'),'id');
            
            foreach ($productoStock as $dato):
                $producto = Producto::model()->find("id=".$dato['id']);
                $producto->scenario='stockminimo';
                $producto->stock_minimo=$dato['stockminimo'];
                $producto->stock_minimoredondeado=ceil($dato['stockminimo']);
                $producto->stock_minimoajustado=round($dato['stockminimo']*$dato['factorseguridad'],4);
                $error =0;
                //--- PARAMETROS ENVIO NOTIFICACION
                if ($producto->saldo<=$dato['stockminimo']){
                    $productos = $productos . '<p style="color:red"><b>['.$producto->codigo."] - ".$producto->nombre."</b><br/>";
                    $cantProducto++;
                }
                
                if(!$producto->save()){
                    $error++;
                }
                if($error>0){
                    $response = array('error'=>3, 'message'=>'ERROR AL ACTUALIZAR PRODUCTOS');
                }else{
                    $response = array('error'=>0, 'message' => 'ACTUALIZACION DE STOCKS MINIMOS CORRECTO');
                }
            endforeach;
            if ($cantProducto>0){
                $productos= $productos."</p>";
                $parametrosNotificacion=array('idtiponotificacion'=>1,
                       'productos'=>$productos
                      );
                self::envioNotificacion($parametrosNotificacion);
            }
        }else{
            $response = array('error'=>2, 'message'=>'NO EXISTEN PRODUCTOS');
        }
        //$stockminimo = Yii::app()->almacen->createCommand("select * from reportestockminimo_parametros(0,'22-04-2021','23-07-2021',1,0,5590,0,4)")->queryAll();
        
        echo json_encode($response);
    }
}