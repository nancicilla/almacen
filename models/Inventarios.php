<?php
/*
 * Inventarios.php
 *
 * Version 0.$Rev: 522 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2016-05-17 08:24:51 -0400 (mar 17 de may de 2016) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "inventarios".
 *
 * The followings are the available columns in table 'inventarios':
 * @property integer $id
 * @property string $descripcion
 * @property string $fechainicio
 * @property string $fechafin
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $idestado
 * @property string $estado
 * @property string $nombre
 * @property integer $idalmacen
 */
class Inventarios extends CActiveRecord {
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        if (Yii::app()->user->getName() == 'invitado') {
            return array(
                'join' => 'inner join almacen a on a.id=' . $this->getTableAlias(false, false) . '.idalmacen',
                'condition' => $this->getTableAlias(false, false) . '.eliminado = false',
            );
        } else {
            return array(
                'join' => 'inner join almacen a on a.id=' . $this->getTableAlias(false, false) . '.idalmacen',
                'condition' => $this->getTableAlias(false, false) .
                '.idalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[])) and '
                . $this->getTableAlias(false, false) . '.eliminado = false',
            );
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inventarios';
    }

    public function primaryKey() {
        return 'id';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, idestado,idalmacen', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 30),
            array('estado, nombre', 'length', 'max' => 20),
            array('descripcion, fechainicio, fechafin, eliminado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, descripcion, fechainicio, fechafin, eliminado, usuario, idestado, estado, nombre', 'safe', 'on' => 'search'),
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
            'descripcion' => 'Descripción',
            'fechainicio' => 'Fechainicio',
            'fechafin' => 'Fechafin',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'idestado' => 'Idestado',
            'estado' => 'Estado',
            'nombre' => 'Nombre',
            'idalmacen' => 'Idalmacen',
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
        $criteria->compare('descripcion', $this->descripcion, true);
        if ($this->fechainicio != Null) {
            $criteria->addCondition("fechainicio::date = '" . $this->fechainicio . "'");
        }
        if ($this->fechafin != Null) {
            $criteria->addCondition("fechafin::date = '" . $this->fechafin . "'");
        }
        $criteria->compare('t.eliminado',0);
        $criteria->compare('usuario', $this->usuario, true);
        $criteria->compare('idestado', $this->idestado);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('t.idalmacen', $this->idalmacen);

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
     * @return Inventarios the static model class
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
        $this->usuario = Yii::app()->user->getName();
        $this->estado = strtoupper($this->estado);
        $this->nombre = strtoupper($this->nombre);
        return parent::beforeSave();
    }

}
