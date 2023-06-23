<?php
/*
 * Traspasoproductotpv.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 01/11/2017
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
 
 * This is the model class for table "traspasoproducto".
 *
 * The followings are the available columns in table 'traspasoproducto':
 * @property integer $id
 * @property string $cantidadsolicitada
 * @property string $cantidadenviada
 * @property string $cantidadrecibida
 * @property integer $idtraspaso
 * @property integer $idproducto
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Traspaso $idtraspaso0
 * @property Producto $idproducto0
 */
class Traspasoproductotpv extends CActiveRecord
{
    public $idunidad;
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
            return 'traspasoproducto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idtraspaso, idproducto', 'required'),
                    array('idtraspaso, idproducto', 'numerical', 'integerOnly'=>true),
                    array('cantidadsolicitada, cantidadenviada, cantidadrecibida', 'length', 'max'=>16),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, cantidadsolicitada, cantidadenviada, cantidadrecibida, idtraspaso, idproducto, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idtraspaso0' => array(self::BELONGS_TO, 'Traspaso', 'idtraspaso'),
                    'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'cantidadsolicitada' => 'Cantidadsolicitada',
                    'cantidadenviada' => 'Cantidadenviada',
                    'cantidadrecibida' => 'Cantidadrecibida',
                    'idtraspaso' => 'Idtraspaso',
                    'idproducto' => 'Idproducto',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
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
		$criteria->addSearchCondition('t.cantidadsolicitada',$this->cantidadsolicitada,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.cantidadenviada',$this->cantidadenviada,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.cantidadrecibida',$this->cantidadrecibida,true,'AND','ILIKE');
		$criteria->compare('t.idtraspaso',$this->idtraspaso);
		$criteria->compare('t.idproducto',$this->idproducto);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
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
     * @return Traspasoproductotpv the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    
    /**
     * Carga en un array los productos de una pedido
     * @param type $idpedido id del registro de la pedido .   
     * @return array detalle de productos.
     */
    public function obtenerTraspasoproducto($idTraspasoproducto) {
        $criteria = new CDbCriteria;
        $criteria->select = 'p.id, p.codigo, p.nombre, t.cantidadenviada, '
                          . 'case when p.saldo <= 0 then p.ultimoppp else round(p.saldoimporte/p.saldo, 4) end as costo';
        $criteria->join = 'inner join general.producto p on t.idproducto = p.id';
        $criteria->compare('t.idtraspaso', $idTraspasoproducto);       

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>false,
            'sort' => array(
                'defaultOrder' => 't.id asc')
        ));
    }

    public function registrarTraspasoProducto($idtraspaso, &$productos) {
        $modelo = new Traspasoproductotpv;
        if ($idtraspaso != Null && isset($productos)) {
            $modelo->idtraspaso = $idtraspaso;
            $cantidad = count($productos);
            foreach ($productos as $value) {
                $dato = $value;
                if ($dato['idproducto'] != Null) {
                    $modelo->idproducto = $dato['idproducto'];
                }
                if ($dato['cantidadsolicitada'] != Null){
                    $modelo->cantidadsolicitada = $dato['cantidadsolicitada'];
                    $modelo->cantidadenviada = $dato['cantidadenviada'];
                }else{
                    $modelo->cantidadsolicitada = 0;
                    $modelo->cantidadenviada = $dato['cantidadenviada'];
                }
                
                if ($modelo->save()) {
                    $modelo = new Traspasoproductotpv;
                    $modelo->idtraspaso = $idtraspaso;
                } else {
                    print_r($modelo->getErrors());
                    return array('error' => true, 'mensaje' => 'No es posible guardar datos de Traspasoproducto... idtraspaso=' . $idtraspaso. ';idproducto=' . $dato['idproducto']);
                }
            }
        }
        return array('error' => false);
    }
    
}
