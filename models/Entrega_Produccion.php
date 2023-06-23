<?php
/*
 * Entrega_Produccion.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 16/04/2016
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
 
 * This is the model class for table "entrega".
 *
 * The followings are the available columns in table 'entrega':
 * @property integer $id
 * @property integer $numero
 * @property double $cantidad
 * @property double $porcentaje
 * @property integer $idorden
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 * @property string $duracion
 * @property integer $idproductoresidual
 * @property integer $idproductonota
 *
 * The followings are the available model relations:
 * @property Orden $idorden0
 */
class Entrega_Produccion extends CActiveRecord
{
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
            return 'entrega';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('numero, idorden, idproductoresidual, idproductonota', 'numerical', 'integerOnly'=>true),
                    array('cantidad, porcentaje', 'numerical'),
                    array('usuario', 'length', 'max'=>30),
                    array('duracion', 'length', 'max'=>12),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero, cantidad, porcentaje, idorden, fecha, usuario, eliminado, duracion, idproductoresidual, idproductonota', 'safe', 'on'=>'search'),
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
                    'idorden0' => array(self::BELONGS_TO, 'Orden', 'idorden'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Numero',
                    'cantidad' => 'Cantidad',
                    'porcentaje' => 'Porcentaje',
                    'idorden' => 'Idorden',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'duracion' => 'Duracion',
                    'idproductoresidual' => 'Idproductoresidual',
                    'idproductonota' => 'Idproductonota',
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
		$criteria->compare('t.cantidad',$this->cantidad);
		$criteria->compare('t.porcentaje',$this->porcentaje);
		$criteria->compare('t.idorden',$this->idorden);
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.duracion',$this->duracion,true,'AND','ILIKE');
		$criteria->compare('t.idproductoresidual',$this->idproductoresidual);
		$criteria->compare('t.idproductonota',$this->idproductonota);

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
            return Yii::app()->produccion;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Entrega_Produccion the static model class
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
        return parent::beforeSave();            
    }


}
