<?php

/*
 * Ventaentregadespacho.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 11/02/2016
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

 * This is the model class for table "ventaentregadespacho".
 *
 * The followings are the available columns in table 'ventaentregadespacho':
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property string $estado
 * @property integer $idestado
 * @property string $nombrecliente
 * @property string $almacen
 * @property integer $idalmacen
 * @property string $usuario
 * @property string $fechaentrega
 * @property boolean $despachohabilitado
 * @property boolean $enviado
 * @property boolean $entregado
 * @property boolean $entregaenfabrica
 */

class Ventaentregadespacho extends CActiveRecord {

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
        return 'ventaentregadespacho';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, numero, idestado, idalmacen', 'numerical', 'integerOnly' => true),
            array('estado, almacen', 'length', 'max' => 50),
            array('usuario', 'length', 'max' => 30),
            array('fecha, nombrecliente, fechaentrega, despachohabilitado, enviado, entregado, entregaenfabrica', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, numero, fecha, estado, idestado, nombrecliente, almacen, idalmacen, usuario, fechaentrega, despachohabilitado, enviado, entregado, entregaenfabrica', 'safe', 'on' => 'search'),
        );
    }

    public function primaryKey() {
        return 'id';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'numero' => 'N° Venta',
            'fecha' => 'Fecha',
            'estado' => 'Estado',
            'idestado' => 'Idestado',
            'nombrecliente' => 'Nombrecliente',
            'almacen' => 'Almacen',
            'idalmacen' => 'Idalmacen',
            'usuario' => 'Usuario',
            'fechaentrega' => 'Fechaentrega',
            'despachohabilitado' => 'Despachohabilitado',
            'enviado' => 'Enviado',
            'entregado' => 'Entregado',
            'entregaenfabrica' => 'Entregaenfabrica',
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
        $criteria->compare('t.numero', $this->numero);
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.estado', $this->estado, true, 'AND', 'ILIKE');
        $criteria->compare('t.idestado', $this->idestado);
        $criteria->addSearchCondition('t.nombrecliente', $this->nombrecliente, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.almacen', $this->almacen, true, 'AND', 'ILIKE');
        $criteria->compare('t.idalmacen', $this->idalmacen);
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fechaentrega != Null) {
            $criteria->addCondition("t.fechaentrega::date = '" . $this->fechaentrega . "'");
        }
        $criteria->compare('t.despachohabilitado', $this->despachohabilitado);
        $criteria->compare('t.enviado', $this->enviado);
        $criteria->compare('t.entregado', $this->entregado);
        $criteria->compare('t.entregaenfabrica', $this->entregaenfabrica);

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
        return Yii::app()->venta;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ventaentregadespacho the static model class
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
        if ($this->isNewRecord) {
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        $this->estado = strtoupper($this->estado);
        $this->nombrecliente = strtoupper($this->nombrecliente);
        $this->almacen = strtoupper($this->almacen);
        return parent::beforeSave();
    }

}
