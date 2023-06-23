<?php
/*
 * Proyectocaracteristica.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 11/06/2023
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
 
 * This is the model class for table "proyectocaracteristica".
 *
 * The followings are the available columns in table 'proyectocaracteristica':
 * @property integer $id
 * @property integer $idproyecto
 * @property integer $idcaracteristica
 * @property string $valor
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Proyecto $idproyecto0
 * @property Caracteristicas $idcaracteristica0
 */
class Proyectocaracteristica extends CActiveRecord
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
            return 'proyectocaracteristica';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                   // array('id', 'required'),
                    array('id, idproyecto, idcaracteristica', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('valor, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idproyecto, idcaracteristica, valor, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idproyecto0' => array(self::BELONGS_TO, 'Proyecto', 'idproyecto'),
                    'idcaracteristica0' => array(self::BELONGS_TO, 'Caracteristicas', 'idcaracteristica'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idproyecto' => 'Idproyecto',
                    'idcaracteristica' => 'Idcaracteristica',
                    'valor' => 'Valor',
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
		$criteria->compare('t.idproyecto',$this->idproyecto);
		$criteria->compare('t.idcaracteristica',$this->idcaracteristica);
		$criteria->addSearchCondition('t.valor',$this->valor,true,'AND','ILIKE');
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
            return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Proyectocaracteristica the static model class
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
		$this->valor=strtoupper($this->valor);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }


}
