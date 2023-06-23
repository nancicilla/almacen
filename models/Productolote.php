<?php
/*
 * Productolote.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 19/06/2018
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
 
 * This is the model class for table "productolote".
 *
 * The followings are the available columns in table 'productolote':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $saldo
 */
class Productolote extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'productolote';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id', 'numerical', 'integerOnly'=>true),
                    array('codigo', 'length', 'max'=>12),
                    array('nombre', 'length', 'max'=>100),
                    array('saldo', 'length', 'max'=>14),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, coduniversal, codigo, nombre, saldo', 'safe', 'on'=>'search'),
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
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'coduniversal' => 'Código de Barra',
                    'codigo' => 'Código',
                    'nombre' => 'Producto',
                    'saldo' => 'Saldo',
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
                if ($this->coduniversal != Null){
                    $criteria->compare("t.coduniversal",$this->coduniversal);
                }
		$criteria->addSearchCondition('t.codigo',$this->codigo,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.saldo',$this->saldo,true,'AND','ILIKE');

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 't.codigo asc',
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
     * @return Productolote the static model class
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
		$this->codigo=strtoupper($this->codigo);
		$this->nombre=strtoupper($this->nombre);
        return parent::beforeSave();            
    }


}
