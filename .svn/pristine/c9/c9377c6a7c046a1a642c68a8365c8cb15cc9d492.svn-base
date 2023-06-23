<?php

/*
 * Solicitud.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 26/06/2015
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

 * This is the model class for table "solicitud".
 *
 * The followings are the available columns in table 'solicitud':
 * @property integer $id
 * @property string $descripcion
 * @property string $solicitante
 * @property integer $numero
 * @property string $fechalimite
 * @property integer $idestado
 * @property string $motivoestado
 * @property string $fechaestado
 * @property string $usuarioestado
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Solicituditem[] $solicituditems
 */

class Solicitud extends CActiveRecord {

    public $fechaInicio;
    public $fechaFin;

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false and '.
            $this->getTableAlias(false, false) .
            ".usuario = '".Yii::app()->user->getName()."'",
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'solicitud';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idestado', 'numerical', 'integerOnly' => true),
            array('solicitante, motivoestado, usuarioestado', 'length', 'max' => 50),
            array('usuario', 'length', 'max' => 30),
            array('descripcion, fechalimite, fechaestado, eliminado, fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('descripcion, solicitante, numero, fechaInicio, fechaFin, fechalimite, idestado', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'descripcion' => 'Descripción',
            'solicitante' => 'Solicitante',
            'numero' => 'Nº',
            'fechalimite' => 'Fecha limite',
            'idestado' => 'Estado',
            'motivoestado' => 'Motivoestado',
            'fechaestado' => 'Fechaestado',
            'usuarioestado' => 'Usuarioestado',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'fechaInicio' => 'Fecha desde',
            'fechaFin' => 'Fecha hasta',
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

        if ($this->numero != Null) {
            $criteria->addCondition("t.numero::text ilike '%" . $this->numero . "%'");
        }
        if ($this->descripcion != Null) {
            $criteria->addCondition("t.descripcion ilike '%" . $this->descripcion . "%'");
        }
        if ($this->fecha != Null) {
            $criteria->addCondition("fecha::date = '" . $this->fecha . "'");
        }
        if ($this->fechaInicio != Null && $this->fechaFin == Null) {
            $this->fechaFin = new CDbExpression('NOW()');
            $criteria->addCondition("t.fecha::date BETWEEN ' $this->fechaInicio ' AND ' $this->fechaFin ' ");
        }
        if ($this->fechaInicio == Null && $this->fechaFin != Null) {
            $criteria->addCondition("t.fecha::date <= ' $this->fechaFin '");
        }
        if ($this->fechaInicio != Null && $this->fechaFin != Null) {
            $criteria->addCondition("t.fecha::date BETWEEN '" . $this->fechaInicio . "' AND '" . $this->fechaFin . "' ");
        }
        $criteria->compare('idestado', $this->idestado);

        Yii::app()->session['reporteSolicitudes'] = $criteria;

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.numero desc',
            )
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->compra;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Solicitud the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
