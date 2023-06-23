<?php

/*
 * Alertatipo.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 18/11/2015
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (Tue, 17 Mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.

 * This is the model class for table "configuracion.alertatipo".
 *
 * The followings are the available columns in table 'configuracion.alertatipo':
 * @property integer $id
 * @property string $nombre
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $refnombre
 * @property integer $idalertanivel
 *
 * The followings are the available model relations:
 * @property Alertanivel $idalertanivel
 */

class Alertatipo extends CActiveRecord {

    public static $PRODUCTO_NO_DISPONIBLE = 1;
    public static $NUEVO_PEDIDO = 2;
    public static $ORDEN_COMPRA_CONFIRMADA = 3;

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
        return 'configuracion.alertatipo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idalertanivel', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 50),
            array('usuario', 'length', 'max' => 30),
            array('refnombre', 'length', 'max' => 2),
            array('fecha, eliminado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, usuario, fecha, eliminado, refnombre, idalertanivel', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idalertanivel0' => array(self::BELONGS_TO, 'Alertanivel', 'idalertanivel'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'refnombre' => 'Refnombre',
            'idalertanivel' => 'Idalertanivel',
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

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.refnombre', $this->refnombre, true, 'AND', 'ILIKE');
        $criteria->compare('t.idalertanivel', $this->idalertanivel);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
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
     * @return Alertatipo the static model class
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
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        $this->refnombre = strtoupper($this->refnombre);
        return parent::beforeSave();
    }

}
