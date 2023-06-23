<?php
/*
 * Devoluciontpv.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 29/11/2017
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
 
 * This is the model class for table "devolucion".
 *
 * The followings are the available columns in table 'devolucion':
 * @property integer $id
 * @property integer $numero
 * @property string $glosa
 * @property integer $idestado
 * @property integer $idalmacenorigen
 * @property integer $idalmacendestino
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idalmacen
 * @property integer $idtransaccion
 *
 * The followings are the available model relations:
 * @property Devolucionproducto[] $devolucionproductos
 */
class Devoluciontpv extends CActiveRecord
{
    public $almacenorigen;
    public $disponible;
    public $controlcalidad_;
    // ------------- Variables para productos en Devolucion --------------
    public $idunidad;
    public $saldo;
    public $reserva;
    public $codigo;
    public $nombre;
    public $cantidaddevolucion;
    public $cantidadrecibida;
    public $idproducto;
    public $solicitud;
    public $conforme;
    public $coduniversal;
    // search
    public $fechaDesde;
    public $fechaHasta;
    public $producto;
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
            return 'devolucion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('numero, idestado, idalmacenorigen, idalmacendestino, idalmacen, idtransaccion', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('glosa, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero,fechaDesde,fechaHasta, glosa, idestado,idproducto, idalmacenorigen, idalmacendestino, usuario, fecha, eliminado, idalmacen', 'safe', 'on'=>'search'),
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
                    'devolucionproductos' => array(self::HAS_MANY, 'Devolucionproducto', 'iddevolucion'),
                    'idestado0' => array(self::BELONGS_TO, 'Estadotpv', 'idestado'),
                    'idalmacenorigen0' => array(self::BELONGS_TO, 'Almacen', 'idalmacenorigen'),
                    'idalmacendestino0' => array(self::BELONGS_TO, 'Almacen', 'idalmacendestino'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Número',
                    'glosa' => 'Glosa',
                    'idestado' => 'Estado',
                    'idalmacenorigen' => 'Almacen Orígen',
                    'idalmacendestino' => 'Idalmacendestino',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idalmacen' => 'Idalmacen',
                    'idtransaccion' => 'Idtransaccion',
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
		$criteria->compare('t.numero',$this->numero);
		$criteria->addSearchCondition('t.glosa',$this->glosa,true,'AND','ILIKE');
		$criteria->compare('t.idestado',$this->idestado);
		if ($this->idalmacenorigen != null) {
                    $criteria->compare('t.idalmacenorigen', $this->idalmacenorigen);
                }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
                if($this->idproducto!=null){
                    $ids=-1;
//                    $gestion=  System::getGestionSchema();
                    $q="select dp.iddevolucion from devolucionproducto dp 
                        inner join devolucion t on t.id=dp.iddevolucion
                        where dp.idproducto in (
			select id from general.producto where id=" . $this->idproducto . " or idproductopadre =" . $this->idproducto . "
                        ) and dp.eliminado=false and dp.iddevolucion is not null";
                    echo $q;
                    $tabla = Yii::app()->tpv->createCommand($q)->queryAll();
                    if(sizeof($tabla)!=0){
                        $ids='';
                        foreach($tabla as $fila){
                            $ids.=($ids!=''?',':'').$fila['iddevolucion'];
                        }
                    }
                    if($ids=='')$ids='-1';
                    $criteria->addCondition("t.id in ($ids)");
                }
		if ($this->fechaDesde != Null) {
                    if ($this->fechaHasta == Null) {
                        $this->fechaHasta = new CDbExpression('NOW()');
                    }
                    $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaDesde' AND '$this->fechaHasta'");
                }elseif($this->fechaHasta!=null){
                    $criteria->addCondition("t.fecha::date<='$this->fechaHasta'");
                }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                            'defaultOrder' => 't.numero desc',
                        ),
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->tpv;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Devoluciontpv the static model class
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
		$this->glosa=strtoupper($this->glosa);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }

    /*
     * Método para obtener los productos de una orden
     * @param integer $idordenreceta
     * @return CActiveDataProvider
     */
    public function obtenerProductosDeDevolucion($iddevolucion)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'tp.id,tp.idproducto,p.coduniversal,p.codigo,p.nombre ,u.simbolo as idunidad,'
                          . ' p.saldo, p.reserva, tp.cantidaddevolucion, tp.cantidadrecibida,1 as solicitud,true as conforme';
        $criteria->join = 'inner join devolucionproducto tp on t.id = tp.iddevolucion and tp.eliminado = false
                           inner join general.producto p on p.id = tp.idproducto and p.eliminado = false
                           inner join general.unidad u on u.id = p.idunidad';
      
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = ".$iddevolucion);

        return new CActiveDataProvider(
                $this, 
                array(
                    'pagination' => false,
                    'criteria' => $criteria,
                    'sort'=>array(
                        'defaultOrder'=>'tp.id ASC',
                    ),
                )
        );
    }
    
    public function getIconControlcalidadFinalizado(){        
        return $this->controlcalidad->idestado==Estado::ESTADO_FINALIZADOCC?"<div class=\"controlCalidadOK\" ></div>":"<div class=\"controlCalidadNO\" ></div>";
    }
    
    public function getControlcalidad(){
        if($this->controlcalidad_==null){
            $this->controlcalidad_= Controlcalidadalmacen::model()->findByAttributes(array('iddocumento' => $this->id,'idtipodocumento'=> Tipodocumentotpv::DEVOLUCION_TPV));
        }
        
        return $this->controlcalidad_;
    }
    
    public function cantproducto($idproducto){
        $cantidad=null;
        //return 55.00;
        $gestion=  System::getGestionSchema();
        $q="select cantidadrecibida from devolucionproducto where idproducto in (select id from general.producto where id=$idproducto or idproductopadre =$idproducto) and iddevolucion=$this->id and eliminado=false;";
        
        $command = Yii::app()->tpv->createCommand($q);
        $fila=$command->queryRow();
        $cantidad=$fila['cantidadrecibida'];
        
        if($this->idestado!= Estadotpv::ANULADO){
             $cantidad='<span style="font-weight:bold">'.( number_format($cantidad,2,'.','')).'</span>';
        }
        
        if($this->idestado== Estadotpv::ANULADO){
            $cantidad='<div align="left" style="font-weight:bold; color:#959595">'.( number_format($cantidad,2,'.','')).'</div>';
        }
        
        return $cantidad;
    }
    
    public function getOrigen()
    {
        $command = Yii::app()->tpv->createCommand("
            select nombre from general.almacen  where id=".$this->idalmacenorigen);
        return $command->queryScalar();
    }
}
