<?php

/*
 * Productodesviacion.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 01/09/2016
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

 * This is the model class for table "productodesviacion".
 *
 * The followings are the available columns in table 'productodesviacion':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property integer $idalmacen
 * @property boolean $eliminado
 * @property string $inic
 * @property string $actual
 * @property string $prom
 * @property string $variacion
 */

class Productodesviacion extends CActiveRecord {

    public function primaryKey() {
        return 'id';
    }

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
        return 'productodesviacion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, idalmacen', 'numerical', 'integerOnly' => true),
            array('codigo, actual', 'length', 'max' => 12),
            array('nombre', 'length', 'max' => 100),
            array('inic', 'length', 'max' => 10),
            array('eliminado, prom, variacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, nombre, idalmacen, eliminado, inic, actual, prom, variacion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idalmacen0' => array(self::BELONGS_TO, 'Almacen', 'idalmacen'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'idalmacen' => 'Idalmacen',
            'eliminado' => 'Eliminado',
            'inic' => 'Inic',
            'actual' => 'Actual',
            'prom' => 'Prom',
            'variacion' => 'Desviación',
            'idalmacen' => 'Almacén',
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
        $criteria->with = array('idalmacen0');

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('t.idalmacen', $this->idalmacen);
        $criteria->addSearchCondition('t.inic', $this->inic, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.actual', $this->actual, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.prom', $this->prom, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.variacion', $this->variacion, true, 'AND', 'ILIKE');

        Yii::app()->session['reporteProductoDesviacionLote'] = $criteria;

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
     * @return Productodesviacion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }



}
