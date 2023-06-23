<?php

/*
 * Vistanotarecepcion.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 06/10/2016
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

 * This is the model class for table "vistanotarecepcion".
 *
 * The followings are the available columns in table 'vistanotarecepcion':
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property string $tiporecepcion
 * @property string $usuario
 * @property string $usuarioalmacen
 * @property integer $idmotivorecepcion
 * @property string $motivo
 * @property integer $idestado
 * @property string $estado
 * @property integer $idcliente
 * @property string $cliente
 * @property integer $idalmacen
 * @property string $almacen
 */

class Vistanotarecepcion extends CActiveRecord {

    var $ID_ESTADO_RECEPCION_ALMACEN = 12;
    var $NOMBRE_TABLA='NOTARECEPCION';

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function primaryKey() {
        return 'id';
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'vistanotarecepcion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, numero, idmotivorecepcion, idestado, idcliente, idalmacen', 'numerical', 'integerOnly' => true),
            array('tiporecepcion', 'length', 'max' => 15),
            array('usuario, usuarioalmacen', 'length', 'max' => 30),
            array('motivo, estado, cliente, almacen', 'length', 'max' => 50),
            array('fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, numero, fecha, tiporecepcion, usuario, usuarioalmacen, idmotivorecepcion, motivo, idestado, estado, idcliente, cliente, idalmacen, almacen', 'safe', 'on' => 'search'),
        );
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
            'numero' => 'Nº',
            'fecha' => 'Fecha',
            'tiporecepcion' => 'Tipo',
            'idmotivorecepcion' => 'Idmotivorecepcion',
            'motivo' => 'Motivo',
            'idestado' => 'Idestado',
            'estado' => 'Estado',
            'idcliente' => 'Idcliente',
            'cliente' => 'Cliente',
            'idalmacen' => 'Idalmacen',
            'almacen' => 'Almacén',
            'usuario' => 'Usuario',
            'usuarioalmacen' => 'Usuarioalmacen'
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
        $criteria->addSearchCondition('t.tiporecepcion', $this->tiporecepcion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->addCondition("t.usuarioalmacen is null or t.usuarioalmacen=''");
        $criteria->compare('t.idmotivorecepcion', $this->idmotivorecepcion);
        $criteria->addSearchCondition('t.motivo', $this->motivo, true, 'AND', 'ILIKE');
        $criteria->compare('t.idestado', $this->ID_ESTADO_RECEPCION_ALMACEN);
        $criteria->addSearchCondition('t.estado', $this->estado, true, 'AND', 'ILIKE');
        $criteria->compare('t.idcliente', $this->idcliente);
        $criteria->addSearchCondition('t.cliente', $this->cliente, true, 'AND', 'ILIKE');
        $criteria->compare('t.idalmacen', $this->idalmacen);
        $criteria->addSearchCondition('t.almacen', $this->almacen, true, 'AND', 'ILIKE');

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.id desc',
                'attributes' => array(
                    'cliente' => array(
                        'asc' => 'cliente',
                        'desc' => 'cliente DESC',
                    ),
                    'almacen' => array(
                        'asc' => 'almacen',
                        'desc' => 'almacen DESC',
                    ),
                    'motivo' => array(
                        'asc' => 'motivo',
                        'desc' => 'motivo DESC',
                    ),
                    '*',
                ),
            )
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
     * @return Vistanotarecepcion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
