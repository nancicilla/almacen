<?php
/*
 * Vseguimiento.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 12/10/2016
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
 
 * This is the model class for table "vseguimiento".
 *
 * The followings are the available columns in table 'vseguimiento':
 * @property string $descripcion
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 * @property string $tabla
 * @property integer $idtabla
 * @property integer $idcomunicacion
 * @property integer $id
 * @property integer $idcliente
 */
class Vseguimiento extends CActiveRecord
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
            return 'vseguimiento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idtabla, idcomunicacion, id, idcliente', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('tabla', 'length', 'max'=>20),
                    array('descripcion, eliminado, fecha', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('descripcion, eliminado, usuario, fecha, tabla, idtabla, idcomunicacion, id, idcliente', 'safe', 'on'=>'search'),
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
                    'descripcion' => 'Descripcion',
                    'eliminado' => 'Eliminado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'tabla' => 'Tabla',
                    'idtabla' => 'Idtabla',
                    'idcomunicacion' => 'Idcomunicacion',
                    'id' => 'ID',
                    'idcliente' => 'Idcliente',
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

		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.tabla',$this->tabla,true,'AND','ILIKE');
		$criteria->compare('t.idtabla',$this->idtabla);
		$criteria->compare('t.idcomunicacion',$this->idcomunicacion);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.idcliente',$this->idcliente);

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
            return Yii::app()->venta;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Vseguimiento the static model class
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
		$this->descripcion=strtoupper($this->descripcion);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->tabla=strtoupper($this->tabla);
        return parent::beforeSave();            
    }


}
