<?php
/*
 * ProyectoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 11/06/2023
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
class ProyectoController extends Controller
{
    private $SUB_DIRECTORY = '/proyecto/images/';

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
        
        $model=new Proyecto;

        if(isset($_POST['Proyecto'])){
                $model->attributes=$_POST['Proyecto'];
                if($model->fechafin==''){
                    $model->fechafin=null;
                }
                if($model->fechainicio==''){
                    $model->fechainicio=null;
                }
                if($model->save()){  
                    $idproyecto=Yii::app()->almacen->createCommand
                (" select currval('general.proyecto_id_seq'::regclass)::int")
                                    ->queryScalar();
                            Proyecto::model()->registrarInformacionProyecto($idproyecto ,$_POST['Proyecto']['idcaracteristica'], $_POST['gridEquipo'], $_POST['gridProveedores']);
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'listapersonal'=>array(),
            'listaproveedores'=>array()
        ), false, true);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $id=SeguridadModule::dec($id);
        $model=$this->loadModel($id);
        if($model->fechainicio!==null){
            $model->fechainicio=date ("d-m-Y",strtotime( $model->fechainicio));
        }
        if($model->fechafin!==null){
            $model->fechafin=date ("d-m-Y",strtotime( $model->fechafin));
        }
        $listapersonal= Equipotrabajo::model()->listaPersonal($model->id);
        $listaproveedor= Proveedoreproyecto::model()->listaProveedor($model->id);

        if(isset($_POST['Proyecto']))
        {
            $model->attributes=$_POST['Proyecto'];
            if($model->fechafin==''){
                    $model->fechafin=null;
                }
            if($model->fechainicio==''){
                    $model->fechainicio=null;
                }
            if($model->save()){
                Yii::app()->almacen->createCommand
                ("update equipotrabajo set eliminado=true where idproyecto=".$model->id)
                                    ->execute();
                Yii::app()->almacen->createCommand
                ("update proveedoreproyecto set eliminado=true where idproyecto=".$model->id)
                                    ->execute();
                Proyecto::model()->registrarInformacionProyecto($id,'', $_POST['gridEquipo'], $_POST['gridProveedores']);
                
                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'listapersonal'=>$listapersonal,
            'listaproveedores'=>$listaproveedor
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

        $model=new Proyecto('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Proyecto'])){
                $model->attributes=$_GET['Proyecto'];
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
	 * @return Proyecto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Proyecto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Proyecto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='proyecto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionAsociar($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $id=SeguridadModule::dec($id);
        $model=$this->loadModel($id);
        $lista=Yii::app()->almacen->createCommand("select json_array_elements(informacion)->>'nombre' as nombre,
 (json_array_elements(informacion)->>'tipovalor')::int as tipovalor,
  json_array_elements(informacion)->>'valor' as valor,
   json_array_elements(informacion)->'hijos' as hijos
from historialproyectocaracteristica h where h.id= (select id from historialproyectocaracteristica where eliminado=false and idproyecto=$id order by id desc limit 1) ")
                                    ->queryAll();

        $fotoProyecto = array();
     //falta ver la manera en la que se va a hacer el registro y carga de imagen    
   //array_push($fotoProyecto,array('id'=>$model->id,'archivo'=>'uploads/'.$model->foto));
      
        if(isset($_POST['Proyecto']))
        {
            
            if(true){
                
                //$lista= json_decode($_POST['Proyecto']['nombre']);
                Proyecto::model()->registrarCaracteristicas($id,$_POST['Proyecto']['nombre']) ;    
               // $nombreArchivo=Proyecto::model()->registrarImagen( $fotoPersona, Yii::app()->session['directorioTemporal'],$model->id);
                //$model->foto=$nombreArchivo;
                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }else{
            $this->directorioTemporal();
          //  Proyecto::model()->prepararImagen(SeguridadModule::dec($id), Yii::app()->session['directorioTemporal']);
            //$fotoProyecto=Proyecto::model()->cargarImagen(SeguridadModule::dec($id));
            
        }

        $this->renderPartial('informacion',array(
            'model'=>$model,
            'lista'=>$lista,
            'fotos'=>$fotoProyecto
        ), false, true);
    }
    public function directorioTemporal() {
    
        unset(Yii::app()->session['directorioTemporal']);
        $temporal = new Temporal(AlmacenModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
        Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();

    }
     
        
     
    public function actionImprimirReporte($id) { 
        $id=SeguridadModule::dec($id);
        $model=$this->loadModel($id);
        $lista=Yii::app()->almacen->createCommand("select json_array_elements(informacion)->>'nombre' as nombre,
 (json_array_elements(informacion)->>'tipovalor')::int as tipovalor,
  json_array_elements(informacion)->>'valor' as valor,
   json_array_elements(informacion)->'hijos' as hijos
from historialproyectocaracteristica h where h.id= (select id from historialproyectocaracteristica where eliminado=false and idproyecto=$id order by id desc limit 1) ")
                                    ->queryAll();
        $titulo='FICHA DE PROYECTO DE DISEÑO Y DESARROLLO ';
        $encargado=Yii::app()->almacen->createCommand("select STRING_AGG ( p.nombrecompleto,',' order by p.nombrecompleto ) from general.personal p inner join equipotrabajo e on e.idpersonal=p.id where  e.eliminado=false and e.idproyecto=$id and e.esencargado=true ")
                                           ->queryScalar();
        $equipo=Yii::app()->almacen->createCommand("select STRING_AGG ( p.nombrecompleto,',' order by p.nombrecompleto ) from general.personal p inner join equipotrabajo e on e.idpersonal=p.id where  e.eliminado=false and e.idproyecto=$id and e.esencargado=false ")
                                           ->queryScalar();
        if($model->idcaracteristica0->paraenvase==true)
        {
            $titulo.='DE ENVASES';

        }else{
            $titulo.='DE NUEVOS CHOCOLATES';
        }
        $tamceldaTitulo=5*ceil(strlen($titulo)/43);

        ob_end_clean();
        $pdf = Yii::createComponent('application.extensions.TCPDF.tcpdf', 'P', 'mm',
         array('215.9', '279.4'), true, 'UTF-8');

        //Información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Solur SRL");
        $pdf->SetTitle("ReporteProyecto");
        $pdf->SetSubject("Resumen Ventas Diarias Efectivo");
        
        //Quitamos la cabecera y el pie de página

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //cambiar margenes
        $pdf->SetMargins(20, 20, 15, 20);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 5);
        
        $pdf->startPageGroup();

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        $pdf->setJPEGQuality(100);
        //Inicio del reporte
        $num=0;
        $url= Yii::app()->baseUrl;
        $pdf->AddPage();

    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    // set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);
    $pdf->SetFont('', 'B');
    $pdf->setX($pdf->GetX()+20);
    $yanterior=$pdf->GetY();
    $valor= $pdf->GetY()-$yanterior;
    $pdf->MultiCell(120,5, "REGISTRRO PRDD 001.01 ", 1, 'C', 0,0, '', '', true);
    $pdf->MultiCell(30,0, "VERSION 05 ", 1, 'C', 0,1, '', '', true);
    $pdf->setX($pdf->GetX()+20);
    $pdf->MultiCell(120,$tamceldaTitulo, $titulo, 1, 'C', 0,0, '', '', true);
    $pdf->MultiCell(30, $tamceldaTitulo+(($tamceldaTitulo/5)*1.25), 'V.01.01 ', 1, 'C', 0, 0, '', '', true);

    $pdf->setY($yanterior);
    $pdf->MultiCell(20,$tamceldaTitulo+10,'', 1, 'L', 0, 0, '', '', true);

    // llenado de la informacion del proyecto 
    $pdf->Ln($tamceldaTitulo+12);
    $tamanioLetra = 10;
    $tamanioCelda=5;
    $incremento=1.25;
    $pdf->SetFont('','B',$tamanioLetra);
    $pdf->MultiCell(35, $tamanioCelda, 'Número', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $pdf->MultiCell(135, $tamanioCelda, $model->numero, 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->ln();
    $pdf->SetFont('', 'B',$tamanioLetra);
    $pdf->MultiCell(35, $tamanioCelda, 'Nombre', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $pdf->MultiCell(135, $tamanioCelda, $model->nombre, 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->ln();
    $pdf->SetFont('', 'B',$tamanioLetra);
    $tamcelda=$tamanioCelda*ceil(strlen($encargado)/43)+(ceil(strlen($encargado))/43)/2*$incremento;
    $pdf->MultiCell(35, $tamcelda, 'Encargado', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamcelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $pdf->MultiCell(135, $tamcelda, $encargado, 1, 'L', 0, 0, '', '', true, 0, true, true, $tamcelda, 10);
    $pdf->ln();
    $pdf->SetFont('', 'B',$tamanioLetra);
    if(strlen($equipo)<43){
        $tamcelda=11;
    }else{
        $tamcelda=($tamanioCelda*ceil(strlen($equipo)/43))+1+((ceil(strlen($equipo))/43)/2*$incremento);
    }
    
    $pdf->MultiCell(35, $tamcelda, 'Miembros del Equipo', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamcelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $pdf->MultiCell(135, $tamcelda, $equipo, 1, 'L', 0, 0, '', '', true, 0, true, true, $tamcelda, 10);
    $pdf->ln();
    $pdf->SetFont('', 'B',$tamanioLetra);
    $pdf->MultiCell(35, $tamanioCelda, 'Fecha Inicio', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $pdf->MultiCell(135, $tamanioCelda,date ("d-m-Y",strtotime( $model->fechainicio)), 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->ln();
    $pdf->SetFont('', 'B',$tamanioLetra);
    $pdf->MultiCell(35, $tamanioCelda, 'Fecha Fin', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->SetFont('','',$tamanioLetra);
    $fechafin='';
    if($model->fechafin!==null){
    $fechafin=date ("d-m-Y",strtotime( $model->fechafin));
    }
    $pdf->MultiCell(135, $tamanioCelda,$fechafin, 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->ln(9);
    $pdf->SetFont('', 'B',$tamanioLetra);
    $pdf->MultiCell(35, $tamanioCelda, 'DETALLE', 1, 'C', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->MultiCell(110, $tamanioCelda, 'DESARROLLO', 1, 'C', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->MultiCell(25, $tamanioCelda, 'FIRMA', 1, 'C', 0, 0, '', '', true, 0, true, true, $tamanioCelda, 10);
    $pdf->ln();    
    
    // informacion de las caracteristicas
    $tamanioImagen=50;
    $tamanioFila;
     for($i=0;$i<count($lista);$i++){
        $yanterior=$pdf->GetY();
        if($lista[$i]['hijos']=='[]'){
        // inicio No tiene Hijos
            $pdf->SetFont('', 'B',$tamanioLetra);
            $tamdescripcion=($tamanioCelda*ceil(strlen($lista[$i]['nombre'])/20))+1+((ceil(strlen($lista[$i]['tipovalor']))/20)/2);
               
            if($lista[$i]['tipovalor']=='0'){
                //inicio parte tipo texto
                $tamdesarrollo=($tamanioCelda*ceil(strlen($lista[$i]['valor'])/50))+((ceil(strlen($lista[$i]['valor']))/50)/2);
                $tamanioFila=$tamdescripcion>=$tamdesarrollo?$tamdescripcion:$tamdesarrollo;       

                //fin parte texto
            }else
            {
                    // inicio parte tipo imagen
                    $tamanioFila=$tamdescripcion>=$tamanioImagen?$tamdescripcion:$tamanioImagen;
                    // fin parte tipo imagen

            }
            $pdf->MultiCell(35, $tamanioFila, $lista[$i]['nombre'], 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
            $pdf->SetFont('','',$tamanioLetra);
            $pdf->MultiCell(110, $tamanioFila,$lista[$i]['valor'], 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
            $pdf->MultiCell(25, $tamanioFila, '', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
            $pdf->ln();
    
    
        // fin No tiene Hijos
        }else{
        // inicio Si tiene Hijos
        $cantidadLineas=0;
        $yanterior=$pdf->GetY();
        $pdf->SetFont('', 'B',$tamanioLetra);
        $tamdescripcion=($tamanioCelda*ceil(strlen($lista[$i]['nombre'])/20))+((ceil(strlen($lista[$i]['nombre']))/20)/2);
        $listahijos=json_decode($lista[$i]['hijos'],true);   
        for($h=0;$h<count($listahijos);$h++){
                if($lista[$i]['tipovalor']=='0'){
                    //inicio parte tipo texto
                    $tamdesarrollo=($tamanioCelda*ceil(strlen($listahijos[$h]['valor'].' : '.$listahijos[$h]['nombre'])/60))+((ceil(strlen($listahijos[$h]['valor'].' :'.$listahijos[$h]['nombre']))/60)/2.5);
                    $tamanioFila=$tamdescripcion>=$tamdesarrollo?$tamdescripcion:$tamdesarrollo;       

                    //fin parte texto
                }else
                {
                        // inicio parte tipo imagen
                        $tamanioFila=$tamdescripcion>=$tamanioImagen?$tamdescripcion:$tamanioImagen;
                        // fin parte tipo imagen

                }
                //$pdf->MultiCell(35, $tamanioFila, $lista[$i]['nombre'], 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
                $pdf->setX($pdf->GetX()+35);
                $pdf->SetFont('', '',$tamanioLetra);
                $pdf->MultiCell(110,$tamanioFila, '<b>'.$listahijos[$h]['nombre'].':</b>'.$listahijos[$h]['valor'], 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
                $pdf->MultiCell(25, $tamanioFila, '', 1, 'L', 0, 0, '', '', true, 0, true, true, $tamanioFila, 10);
               
                $pdf->ln();
                $cantidadLineas+=1;

            }
           $yactual=$pdf->GetY();
           $pdf->SetY($yanterior);
           $pdf->SetFont('', 'B',$tamanioLetra);
           $pdf->MultiCell(35, ($yactual-$yanterior), $lista[$i]['nombre'], 1, 'L', 0, 0, '', '', true, 0, true, true, ($yanterior-$yactual), 10);
           $pdf->SetY($yactual);
        // fin Si tiens Hijos

        }

     }
    


    $pdf->Output("ReporteProyecto.pdf", "I");
    mb_internal_encoding('utf-8');
}

}
