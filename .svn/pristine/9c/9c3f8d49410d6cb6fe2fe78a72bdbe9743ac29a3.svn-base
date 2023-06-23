<?php
/*
 * Vencimiento.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 18/06/2018
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
 
 * This is the model class for table "vencimiento".
 *
 * The followings are the available columns in table 'vencimiento':
 * @property integer $id
 * @property integer $idcompra
 * @property integer $idproducto
 * @property string $fechavencimiento
 * @property string $cantidad
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 * @property integer $idestado
 * @property string $numerolote
 * @property string $observacion
 */
class Vencimiento extends CActiveRecord
{
    public $codigoproducto;
    public $control;
    public $fechaDesde;
    public $fechaHasta;
    public $numerocompra;
    public $codigobarra;
    
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
            return 'vencimiento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
//                    array('fecha, usuario', 'required'),
                    array('idcompra, idproducto, idestado', 'numerical', 'integerOnly'=>true),
                    array('cantidad', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('fechavencimiento, eliminado, numerolote, observacion', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idcompra, idproducto, fechavencimiento, cantidad, fecha, usuario, eliminado, idestado, numerolote, observacion, codigoproducto, fechaDesde, fechaHasta, numerocompra, codigobarra', 'safe', 'on'=>'search'),
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
                'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
                'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
                'idcompra0' => array(self::BELONGS_TO, 'FtblCompraOrden', array('idcompra'=>'id')),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idcompra' => 'Idcompra',
                    'idproducto' => 'Idproducto',
                    'fechavencimiento' => 'Fecha Vencimiento',
                    'cantidad' => 'Cantidad',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'idestado' => 'Idestado',
                    'numerolote' => 'Nro. Lote',
                    'observacion' => 'Observacion',
                    'codigoproducto' => 'Código/Producto',
                    'numerocompra' => 'Nro. Compra',
                    'codigobarra' => 'Código de Barra',
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
            $criteria->with = array('idproducto0');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.idcompra',$this->idcompra);
                if ($this->numerocompra != Null) {
                    $criteria->join = "inner join ftbl_compra_orden a on t.idcompra = a.id ";
                    $criteria->addCondition("a.numero =".$this->numerocompra);
		}
		$criteria->compare('t.idproducto',$this->idproducto);
		if ($this->fechavencimiento != Null) {
                    $criteria->addCondition("t.fechavencimiento = '" . $this->fechavencimiento. "'");
		 }
		$criteria->addSearchCondition('t.cantidad',$this->cantidad,true,'AND','ILIKE');
		if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idestado',$this->idestado);
		$criteria->addSearchCondition('t.numerolote',$this->numerolote,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.observacion',$this->observacion,true,'AND','ILIKE');
                if ($this->codigoproducto != Null){
                    $criteria->addCondition("idproducto0.codigo ilike '%".$this->codigoproducto."%' or idproducto0.nombre ilike '%".$this->codigoproducto."%'");
                }
                if ($this->codigobarra != Null){
                    $criteria->compare("idproducto0.coduniversal",$this->codigobarra);
                }
                if ($this->fechaDesde != Null) {
                    if ($this->fechaHasta == Null) {
                        $this->fechaHasta = new CDbExpression('NOW()');
                    }
                    $criteria->addCondition("t.fechavencimiento::date BETWEEN '$this->fechaDesde' AND '$this->fechaHasta'");
                }
                if ($this->fechaDesde == Null && $this->fechaHasta!=null ) {
                    $criteria->addCondition("t.fecha::date <= '$this->fechaHasta'");
                }
            Yii::app()->session['reporteProductoVencimiento'] = $criteria;
                
            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 't.fechavencimiento asc',
                        'attributes' => array(
                            'fecha' => array(
                                'asc' => 't.fecha',
                                'desc' => 't.fecha DESC',
                            ),)
                    ),
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
     * @return Vencimiento the static model class
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
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
		$this->numerolote=strtoupper($this->numerolote);
		$this->observacion=strtoupper($this->observacion);
        return parent::beforeSave();            
    }

    public function getDias() {
        if ($this->fechavencimiento!=null){
            return Yii::app()->almacen->createCommand("select  ('".$this->fechavencimiento."'::date - now()::date)")->queryScalar();
        }else{
            return "";
        }
    }
    
    public function getColor(){
        if ($this->fechavencimiento!=null){
            $color = Yii::app()->almacen->createCommand("select obtienecolor('".$this->fechavencimiento."')")->queryScalar();
            return $color;
        }else{
            return "#000";
        }
    }
    
    public function getSaldoLote() {
        return rand(1,$this->cantidad);
    }

    /*
     * Devuelve los productos de nota borrador
     */
    public function obtenerVencimientos($idproducto) {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idproducto = " . $idproducto);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                        'defaultOrder' => 't.idestado desc,t.fechavencimiento asc',
                        'attributes' => array(
                            'fecha' => array(
                                'asc' => 't.fecha',
                                'desc' => 't.fecha DESC',
                            ),)
                    ),
        ));
    }
}
