<?php

/*
 * Ordentrabajo.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 22/08/2018
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

 * This is the model class for table "ordentrabajo".
 *
 * The followings are the available columns in table 'ordentrabajo':
 * @property integer $id
 * @property integer $numero
 * @property integer $idestado
 * @property integer $idproducto
 * @property string $descripcion
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 * @property string $descripcionanulacion
 * @property string $fechaanulacion
 * @property string $usuarioanulacion
 */

class Ordentrabajo extends CActiveRecord {

    public $producto;
    public $simbolo;
    public $cantidad;
    public $costotrabajo;
    public $observacionentrega;
    public $gastounitario;
    public $total;
    public $fechaInicio;
    public $fechaFin;
    public $codigo;
    public $idingrediente;
    public $ingrediente;

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false'
//            . ' and ' . $this->getTableAlias(false, false) .
//            '.idalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[]))',
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ordentrabajo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cantidadproducir, descripcion, responsable, fechalimite, idproducto, producto', 'required', 'on' => 'insert'),
            array('numero, idestado, idproducto', 'numerical', 'integerOnly' => true),
            array('usuario, usuarioanulacion', 'length', 'max' => 30),
            array('descripcion, eliminado, fecha, costounitario, totalproducido, descripcionanulacion, fechaanulacion, cantidadproducir,fechalimite,responsable', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, numero, idestado, idproducto, descripcion, eliminado, usuario, fecha,fechaInicio,fechaFin, descripcionanulacion, fechaanulacion, usuarioanulacion,fechalimite,responsable,codigo,idingrediente', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'numero' => 'Nº',
            'idestado' => 'Idestado',
            'idproducto' => 'Producto',
            'descripcion' => 'Descripcion',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'descripcionanulacion' => 'Descripcionanulacion',
            'fechaanulacion' => 'Fechaanulacion',
            'usuarioanulacion' => 'Usuarioanulacion',
            'cantidadproducir' => 'Cant. Producir',
            'responsable' => 'Responsable',
            'fechalimite' => 'Fecha Limite',
            'idingrediente' => 'Ingrediente'
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
        $criteria->with = array('idproducto0');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.numero', $this->numero);
        $criteria->compare('t.idestado', $this->idestado);
        if ($this->codigo != Null)
            $criteria->addCondition("upper(idproducto0.codigo) LIKE '" . strtoupper($this->codigo) . "%'");
        $criteria->compare('t.idproducto', $this->idproducto);
        if ($this->idingrediente != Null) {
            //$modelProducto = Producto::model()->find('id='.$this->idingrediente);
            $criteria->join = 'INNER JOIN ordentrabajoinsumo o ON o.idordentrabajo=t.id';
            $criteria->addCondition('o.idproducto='.$this->idingrediente);
        }
        $criteria->addSearchCondition('t.descripcion', $this->descripcion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
//        if ($this->fecha != Null) {
//            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
//        }
//        
//        if ($this->fechaInicio != Null) {
//            if ($this->fechaFin == Null) {
//                $this->fechaFin = new CDbExpression('NOW()');
//            }
//            $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaInicio' AND '$this->fechaFin'");
//        }elseif($this->fechaFin!=null){
//            $criteria->addCondition("t.fecha::date<='$this->fechaFin'");
//        }
        $casoCriteria = ($this->fechaInicio != Null && $this->fechaFin != Null) * 1 +
                ($this->fechaInicio != Null && $this->fechaFin == Null) * 2 +
                ($this->fechaInicio == Null && $this->fechaFin != Null) * 3;
        switch ($casoCriteria) {
            case 1:
                $criteria->addBetweenCondition("t.fecha::date", $this->fechaInicio, $this->fechaFin);
                break;
            case 2:
                $criteria->addCondition("t.fecha::date >= '" . $this->fechaInicio . "'");
                break;
            case 3:
                $criteria->addCondition("t.fecha::date <= '" . $this->fechaFin . "'");
                break;
            default :
        }
        
        $criteria->addSearchCondition('t.descripcionanulacion', $this->descripcionanulacion, true, 'AND', 'ILIKE');
        if ($this->fechaanulacion != Null) {
            $criteria->addCondition("t.fechaanulacion::date = '" . $this->fechaanulacion . "'");
        }
        $criteria->addSearchCondition('t.usuarioanulacion', $this->usuarioanulacion, true, 'AND', 'ILIKE');

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.numero desc',
                'attributes' => array(
                    'fecha' => array(
                        'asc' => 't.fecha',
                        'desc' => 't.fecha DESC',
                    ),
                ),
            )
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
     * @return Ordentrabajo the static model class
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
        $this->descripcion = strtoupper($this->descripcion);
        $this->responsable = strtoupper($this->responsable);
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        $this->descripcionanulacion = strtoupper($this->descripcionanulacion);
        $this->usuarioanulacion = strtoupper($this->usuarioanulacion);
        return parent::beforeSave();
    }

    public function findResponsable($param) {
        $criteria = new CDbCriteria;
        $criteria->select = 'responsable';
        $criteria->addSearchCondition('t.responsable', $param, true, 'AND', 'ILIKE');
        //$criteria->addCondition("t.responsable ilike '%".$param."%'");
        $criteria->distinct = true;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 't.responsable asc')
        ));
    }

    public function getDias() {
        $dias = Yii::app()->almacen->createCommand("select  ('" . $this->fechalimite . "'::date - now()::date)")->queryScalar();
        if ($this->fechalimite != null) {
            return $dias < 3;
        } else {
            return "";
        }
    }

}
