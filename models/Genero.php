<?php
/*
 * Genero.php
 *
 * Version 0.$Rev: 423 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2016-03-31 00:19:18 -0400 (jue 31 de mar de 2016) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "genero".
 *
 * The followings are the available columns in table 'genero':
 * @property integer $id
 * @property string $nombre
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $GENEROGENERAL
 * @property integer $GENEROARCHIVO
 * The followings are the available model relations:
 * @property Caracteristica[] $caracteristicas
 */
class Genero extends CActiveRecord {

    public $GENEROGENERAL = 2;
    public $GENEROARCHIVO = 1;
    
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
    public function tableName() {
        return 'genero';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha', 'required','on' => array('insert', 'update')),
            array('nombre, usuario', 'length', 'max' => 30),
            array('eliminado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, fecha, eliminado, usuario', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'caracteristicas' => array(self::HAS_MANY, 'Caracteristica', 'idgenero'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', $this->nombre, true);
        if ($this->fecha != Null) {
            $criteria->addCondition("fecha::date = '" . $this->fecha . "'");
        }
        $criteria->compare('t.eliminado',0);
        $criteria->compare('usuario', $this->usuario, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Genero the static model class
     */
    public static function model($className = __CLASS__) {
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
        $this->nombre = strtoupper($this->nombre);
        if ($this->isNewRecord) {
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }

}
