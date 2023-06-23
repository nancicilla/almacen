<?php
/*
 * Controlcalidadalmacen.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 17/01/2019
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
 
 * This is the model class for table "controlcalidad".
 *
 * The followings are the available columns in table 'controlcalidad':
 * @property integer $id
 * @property string $codigodocumento
 * @property integer $iddocumento
 * @property integer $idtipodocumento
 * @property integer $idestado
 * @property integer $idcliente
 * @property string $razonnofinalizado
 * @property boolean $aceptada
 * @property string $usuariofinalizado
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 */
class Controlcalidadalmacen extends CActiveRecord
{
    public $estado;
    public $idproducto;
    public $producto;
    public $idrecuperacion;
    public $coduniversal;
    public $codigo;
    public $nombre;
    public $idunidad;
    public $cantidaddevolucion;
    public $cantidadregistrada;
    public $cantidadaceptada;
    public $cantidadbaja;
    public $observacion;
    public $obs;
    public $documento_;
    public static $modelProductos=array(//idtipodocumento=>modelproductos
                                        111=>'Documentoproducto',
                                        126=>'Solicituddevolucionproducto',
                                        233=>'Devolucionproductotpv'
                                  );
    public static $modelDocumento=array(//idtipodocumento=>model
                                        111=>'Consignacion',
                                        126=>'Solicituddevolucion',
                                        233=>'Devoluciontpv'
                                  );
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'controlcalidad';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('iddocumento, idtipodocumento, idestado, idcliente', 'numerical', 'integerOnly'=>true),
                    array('codigodocumento', 'length', 'max'=>50),
                    array('usuariofinalizado, usuario', 'length', 'max'=>30),
                    array('razonnofinalizado,usuariocontrolcalidad, aceptada, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, codigodocumento, iddocumento, idtipodocumento, idestado, idcliente, razonnofinalizado, aceptada, usuariofinalizado, fecha, usuario, eliminado, idproducto', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'idtipodocumento0' => array(self::BELONGS_TO, 'Tipodocumento', 'idtipodocumento'),
                'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
                'idcliente0' => array(self::BELONGS_TO,'Cliente','idcliente'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'codigodocumento' => 'Nro. Documento',
                    'iddocumento' => 'Iddocumento',
                    'idtipodocumento' => 'Idtipodocumento',
                    'idestado' => 'Estado',
                    'idcliente' => 'Cliente',
                    'razonnofinalizado' => 'Razonnofinalizado',
                    'aceptada' => 'Aceptada',
                    'usuariofinalizado' => 'Usuariofinalizado',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'recepcion' => 'Recepción',
                    'codigodoc' => 'Código Doc.',
            );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->addSearchCondition('t.codigodocumento',$this->codigodocumento,true,'AND','ILIKE');
		$criteria->compare('t.iddocumento',$this->iddocumento);
		$criteria->compare('t.idtipodocumento',$this->idtipodocumento);
		$criteria->compare('t.idestado',$this->idestado);
		$criteria->compare('t.idcliente',$this->idcliente);
		$criteria->addSearchCondition('t.razonnofinalizado',$this->razonnofinalizado,true,'AND','ILIKE');
		$criteria->compare('t.aceptada',$this->aceptada);
		$criteria->addSearchCondition('t.usuariofinalizado',$this->usuariofinalizado,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
                if($this->idproducto!=null){
                    $ids=-1;
//                    $gestion=  System::getGestionSchema();
                    $q='select dp.idcontrolcalidad from "'.getGestionSchema().'".controlcalidadproducto dp 
                        inner join "'.getGestionSchema().'".controlcalidad t on t.id=dp.idcontrolcalidad
                        where idproducto='.$this->idproducto." and dp.eliminado=false and dp.idcontrolcalidad is not null";
                    echo $q;
                    $tabla = Yii::app()->almacen->createCommand($q)->queryAll();
                    if(sizeof($tabla)!=0){
                        $ids='';
                        foreach($tabla as $fila){
                            $ids.=($ids!=''?',':'').$fila['idcontrolcalidad'];
                        }
                    }
                    if($ids=='')$ids='-1';
                    $criteria->addCondition("t.id in ($ids)");
                }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array('defaultOrder' => 't.id desc',
                    )
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Controlcalidadalmacen the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }


    /**
     *
     * Sentencias entes de ejecutar metodo save
     * Antes de guardar se cambia todos los campos  de tipo character
     * varying y text a mayúsculas
     * Si existe el campo fecha, este toma el valor de la fecha actual antes
     * de almacenarse
     * Si existe el campo usuario, toma el valor del usuario actual antes de
     * almacenarse
     * 
     */
    public function beforeSave() {
		$this->codigodocumento=strtoupper($this->codigodocumento);
		$this->razonnofinalizado=strtoupper($this->razonnofinalizado);
		$this->usuariofinalizado=$this->usuariofinalizado;
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();
    }

    public function getDocumento(){
        if($this->documento_==null){
            $modelName= self::$modelDocumento[$this->idtipodocumento];
            eval('$documento='.$modelName.'::model();');
            $this->documento_=$documento->findByAttributes(array('id' => $this->iddocumento));
        }
        return $this->documento_;
    }
    
    public function getCodigodoc(){
        if ($this->idtipodocumento== Tipodocumento::DEVOLUCION_TPV){
            $almacen= Yii::app()->almacen->createCommand('select nombre from almacen where id='.$this->idcliente)->queryScalar();
            $codigoDoc=($this->idtipodocumento0!=null?$this->idtipodocumento0->nombre:'').' N° '.
               (isset($this->codigodocumento)?$this->codigodocumento:'').' '.
               (isset($this->idcliente)?$almacen:'');
        }else{
            $codigoDoc=($this->idtipodocumento0!=null?$this->idtipodocumento0->nombre:'').' N° '.
               (isset($this->codigodocumento)?$this->codigodocumento:'').' '.
               (isset($this->idcliente)?$this->idcliente0->nombre:'');
        }
        return $codigoDoc;
    }
    
    public function getRecepcion(){
        $recepcionado= Recepcioncontrolcalidad::model()->findAll('idcontrolcalidad='.$this->id,array('order'=>'id asc'));
        if (count($recepcionado)>0){
            foreach ($recepcionado as $data):
                $idestado=$data['idestado'];
            endforeach;
            if (Estado::ESTADO_RECEPCIONADO==$idestado){
                $label='success';
            }else{
                $label='important';
            }
            return '<span style=\'color: white\' class=\'label label-'.$label.'\'>'.Estado::model()->find('id='.$idestado)->nombre.'</span>';
        }else{
            return '<span style=\'color: white\' class=\'label label-warning\'>SIN RECEPCION</span>';
        }
    }
    
    public function obtenerControlCalidadProductos($id) {
        $criteria = new CDbCriteria;
        $criteria->select = 'tp.id,tp.idproducto,p.coduniversal,p.codigo,p.nombre ,u.simbolo as idunidad,'
                . ' p.saldo, p.reserva, tp.cantidaddevolucion,tp.cantidadbaja,tp.cantidadaceptada,tp.observacion,tp.idrecuperacion';
        $criteria->join = 'inner join "'.getGestionSchema().'".controlcalidadproducto tp on t.id = tp.idcontrolcalidad and tp.eliminado = false
                           inner join producto p on p.id = tp.idproducto and p.eliminado = false
                           inner join unidad u on u.id = p.idunidad';
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = " . $id);

        return new CActiveDataProvider(
                $this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'tp.id ASC',
            ),
                )
        );
    }
    
    public function registrarWSAlmacen(){
//        $modelName= self::$modelProductos[$this->idtipodocumento];
//        eval('$documento='.$modelName.'::model();');
        $productosSolicituddevolucion = Controlcalidadproductoalmacen::model()->obtenerProductos($this->id);
        $productos=$productosSolicituddevolucion->getData();
        
        $modelRegistro= self::$modelDocumento[$this->idtipodocumento];
        eval('$documento='.$modelRegistro.'::model();');
        $mDocumento = $documento->find('id='.$this->iddocumento);
        
        switch ($this->idtipodocumento) {
            case Tipodocumento::SOLICITUDDEVOLUCION:
                $cuentacosto=$mDocumento->idcliente0->idcuentacosto;
                $idalmacen=$mDocumento->idalmacen;
                $agencia='';
                break;
            case Tipodocumento::CONSIGNACION:
                $cuentacosto=$mDocumento->idcliente0->idcuentacosto;
                $idalmacen=$mDocumento->idalmacen;
                $agencia='';
                break;
            case Tipodocumento::DEVOLUCION_TPV:
                $cuentacosto = Yii::app()->almacen->createCommand("select idcuenta from almacen where id = ". $mDocumento->idalmacenorigen)->queryScalar();
                $idalmacen=$mDocumento->idalmacendestino;
                $agencia = Yii::app()->almacen->createCommand("select nombre from almacen where id = ". $mDocumento->idalmacenorigen)->queryScalar();
                break;
        }
        $dataProductosIngreso=array();
        $dataProductosBaja=array();
        $totalImporteIngreso=0;
        $totalImporteBaja=0;     
        
        foreach($productos as $nProducto){//$producto model notarecepcionproducto  
            $ppp=$nProducto->idproducto0->ppp;
            $ingresoimporte=$nProducto->cantidaddevolucion*$ppp;
            $dataProductosIngreso[]=array('idproducto'=>$nProducto->idproducto,
                                           'ingresoimporte'=>$ingresoimporte,
                                           'ingreso'=>$nProducto->cantidaddevolucion,
                                          );
            $totalImporteIngreso+=$ingresoimporte;
            if($nProducto->cantidadbaja>0){
                $salidaimporte=$nProducto->cantidadbaja*$ppp;
                $dataProductosBaja[]=array('idproducto'=>$nProducto->idproducto,
                                            'salidaimporte'=>$salidaimporte,
                                            'salida'=>$nProducto->cantidadbaja
                                           );
                $totalImporteIngreso+=$salidaimporte;
            }
        }
        $dataServices=array('nota'=>array('glosa'=>'',
                                       'total'=>$totalImporteIngreso,
                                       'iddocumento'=>$mDocumento->id,
                                       'idtipodocumento'=>$this->idtipodocumento,
                                       'numero'=>$mDocumento->numero,
                                       'idalmacen'=>$idalmacen,
                                       'idcontracuenta'=>$cuentacosto,//cuenta ingreso en almacen 476
                                       'agencia'=>$agencia
                                 ),
                             'productos'=>$dataProductosIngreso,
                             'usuario'=>Yii::app()->user->getName()
                            );
        $WSNota = new Nota;   
        $response = $WSNota ->registrarSolicitudDevolucionIngreso($dataServices);

        //SET INTEGRACION
//        $modelIntegracion=new Integracion;
//        $modelIntegracion->idsolicituddevolucion=$this->id; 
//        $modelIntegracion->idnota=$response['dataReturn']['idnota'];
//        $modelIntegracion->tiponota='INGRESO.SOLICITUD';
//        $modelIntegracion->idtipointegracion = Tipointegracion::INGRESO_SOLICITUDDEVOLUCION;
//        $modelIntegracion->save();
        if(sizeof($dataProductosBaja)>0){
            $dataServices=array('nota'=>array('glosa'=>'',
                                          'total'=>$totalImporteBaja,
                                          'iddocumento'=>$mDocumento->id,
                                          'idtipodocumento'=>$this->idtipodocumento,
                                          'numero'=>$mDocumento->numero,
                                          'idalmacen'=>$idalmacen,
                                          'idcontracuenta'=> FtblMoodleCuentasespeciales::CUENTA_BAJA,//cuenta baja  almacen terminados
                                          'agencia'=>$agencia
                                    ),
                                'productos'=>$dataProductosBaja,
                                'usuario'=>Yii::app()->user->getName()
                               );
            $WSNota = new Nota;                        
            $response = $WSNota ->registrarSolicitudSalidaBaja($dataServices);
           //SET INTEGRACION
//            $modelIntegracion=new Integracion;
//            $modelIntegracion->idnotarecepcion=$this->id; 
//            $modelIntegracion->idnota=$response['dataReturn']['idnota'];
//            $modelIntegracion->tiponota='BAJA.SOLICITUD';
//            $modelIntegracion->idtipointegracion = Tipointegracion::BAJA_SOLICITUDDEVOLUCION;
//            $modelIntegracion->save();
        }
        foreach ($productos as $producto):
            if(($producto->idrecuperacion != null) && ($producto->idrecuperacion != -1)){
                $modelRecuperacion = Recuperacion::model()->find('id='.$producto->idrecuperacion);
                Yii::app()->almacen->createCommand('select insertar_salidarecuperacion('.$modelRecuperacion->id.')')->queryScalar();
            }
        endforeach;
    }
    
    public function registrarWSAlmacenBaja(){
//        $modelName= self::$modelProductos[$this->idtipodocumento];
//        eval('$documento='.$modelName.'::model();');
        $productosSolicituddevolucion = Controlcalidadproductoalmacen::model()->obtenerProductos($this->id);
        $productos=$productosSolicituddevolucion->getData();
        
        $modelRegistro= self::$modelDocumento[$this->idtipodocumento];
        eval('$documento='.$modelRegistro.'::model();');
        $mDocumento = $documento->find('id='.$this->iddocumento);
        
        $dataProductosIngreso=array();
        $dataProductosBaja=array();
        $totalImporteIngreso=0;
        $totalImporteBaja=0;        
        foreach($productos as $nProducto){//$producto model notarecepcionproducto  
            $ppp=$nProducto->idproducto0->ppp;
            $ingresoimporte=$nProducto->cantidaddevolucion*$ppp;
            $dataProductosIngreso[]=array('idproducto'=>$nProducto->idproducto,
                                           'ingresoimporte'=>$ingresoimporte,
                                           'ingreso'=>$nProducto->cantidaddevolucion,
                                          );
            $totalImporteIngreso+=$ingresoimporte;
            $salidaimporte=$nProducto->cantidadbaja*$ppp;
            $dataProductosBaja[]=array('idproducto'=>$nProducto->idproducto,
                                            'salidaimporte'=>$salidaimporte,
                                            'salida'=>$nProducto->cantidaddevolucion
                                          );
            $totalImporteIngreso+=$salidaimporte;
        }
        $dataServices=array('nota'=>array('glosa'=>'',
                                       'total'=>$totalImporteIngreso,
                                       'iddocumento'=>$mDocumento->id,
                                       'numero'=>$mDocumento->numero,
                                       'idalmacen'=>$mDocumento->idalmacen,
                                       'idcontracuenta'=>$mDocumento->idcliente0->idcuentacosto//cuenta ingreso en almacen 476
                                 ),
                             'productos'=>$dataProductosIngreso,
                             'usuario'=>Yii::app()->user->getName()
                            );
        $WSNota = new Nota;   
        $response = $WSNota ->registrarSolicitudDevolucionIngreso($dataServices);

        //SET INTEGRACION
//        $modelIntegracion=new Integracion;
//        $modelIntegracion->idnotarecepcion=$this->id; 
//        $modelIntegracion->idnota=$response['dataReturn']['idnota'];
//        $modelIntegracion->tiponota='INGRESO.SOLICITUD';
//        $modelIntegracion->idtipointegracion = Tipointegracion::INGRESO_SOLICITUDDEVOLUCION;
//        $modelIntegracion->save();
            $dataServices=array('nota'=>array('glosa'=>'',
                                          'total'=>$totalImporteBaja,
                                          'iddocumento'=>$mDocumento->id,
                                          'numero'=>$mDocumento->numero,
                                          'idalmacen'=>$mDocumento->idalmacen,
                                          'idcontracuenta'=> FtblMoodleCuentasespeciales::CUENTA_BAJA,//cuenta baja  almacen terminados
                                    ),
                                'productos'=>$dataProductosBaja,
                                'usuario'=>Yii::app()->user->getName()
                               );
            $WSNota = new Nota;                        
            $response = $WSNota ->registrarSolicitudSalidaBaja($dataServices);
           //SET INTEGRACION
//            $modelIntegracion=new Integracion;
//            $modelIntegracion->idnotarecepcion=$this->id; 
//            $modelIntegracion->idnota=$response['dataReturn']['idnota'];
//            $modelIntegracion->tiponota='BAJA.SOLICITUD';
//            $modelIntegracion->idtipointegracion = Tipointegracion::BAJA_SOLICITUDDEVOLUCION;
//            $modelIntegracion->save();
    }
    
    public function getRecuperada(){
        $modelCCP = Controlcalidadproductoalmacen::model()->findAll('idcontrolcalidad='.$this->id);
        $sinrecuperar=0;
        foreach ($modelCCP as $ccp):
            if($ccp->idrecuperacion==null){
                $sinrecuperar++;
            }
        endforeach;
        if($sinrecuperar>0){
            return 0;
        }else{
            return 1;
        }
    }
    
    public function cantproducto($idproducto){
        $cantidad=null;
        //return 55.00;
        $gestion=  System::getGestionSchema();
        $q='select cantidaddevolucion from "'.getGestionSchema().'".controlcalidadproducto where idproducto='.$idproducto.' and idcontrolcalidad='.$this->id.' and eliminado=false;';
        
        $command = Yii::app()->almacen->createCommand($q);
        $fila=$command->queryRow();
        $cantidad=$fila['cantidaddevolucion'];
        
        if($this->idestado!= Estado::ESTADO_FINALIZADOCC){
             $cantidad='<span style="font-weight:bold">'.( number_format($cantidad,2,'.','')).'</span>';
        }
        
        if($this->idestado== Estado::ESTADO_FINALIZADOCC){
            $cantidad='<div align="left" style="font-weight:bold; color:#959595">'.( number_format($cantidad,2,'.','')).'</div>';
        }
        
        return $cantidad;
    }
}
