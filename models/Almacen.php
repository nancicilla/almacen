<?php
/*
 * Almacen.php
 *
 * Version 0.$Rev: 949 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2019-01-25 15:36:21 -0400 (vie, 25 ene 2019) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "almacen".
 *
 * The followings are the available columns in table 'almacen':
 * @property integer $id
 * @property integer $codigo
 * @property string $nombre
 * @property string $fecha
 * @property string $usuario
 * @property integer $idalmacen
 * @property boolean $general
 * @property boolean $vigente
 *
 * The followings are the available model relations:
 * @property Almacen $idalmacen0
 * @property Almacen[] $almacens
 * @property Almacenproducto[] $almacenproductos
 */
class Almacen extends CActiveRecord {
    
    public $fechaInicio;//utilizada para emisión libro mayor
    public $fechaFin;//utilizada para emisión libro mayor
    public $nombreCompletoProducto;//utilizada para emisión libro mayor
    public $idproducto;//utilizada para emisión libro mayor
    public $nombreProducto;//utilizada para emisión libro mayor
    public $general;
    public $vigente;
    public $idcuenta;
    public $cuenta;
    public $detalle;
    public $producto;
    var $idAlmacenProductosEnProceso = 0;
    var $idAlmacenProductosTerminados = 3;
    public $origen;
    const INSUMOS = 1;
    const TERMINADOS = 3;
    
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        if (Yii::app()->user->getName() == 'invitado') {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false and '.$this->getTableAlias(false, false) .
                '.general = false'
            );
        } else {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false and '.$this->getTableAlias(false, false) .
                '.general = false'
                . ' and ' . $this->getTableAlias(false, false) .
                '.id in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[]))',
            );
        }
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'almacen';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigo, nombre', 'required', 'on' => array('insert', 'update')),
            array('codigo, idalmacen', 'numerical', 'integerOnly' => true),
            array('codigo, nombre', 'unique', 'on' => array('insert', 'update'), 'message' => 'El {attribute} ya existe.'),
            array('nombre', 'length', 'max' => 50),
            array('usuario', 'length', 'max' => 30),
            array('general, vigente', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, nombre, fecha, usuario, idalmacen', 'safe', 'on' => 'search'),
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
            'almacens' => array(self::HAS_MANY, 'Almacen', 'idalmacen'),
            'almacenproductos' => array(self::HAS_MANY, 'Almacenproducto', 'idalmacen'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Almacén',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'usuario' => 'Usuario',
            'idalmacen' => 'Almacén Padre',
            'fechaInicio'=> 'Fecha Inicio',
            'fechaFin'=> 'Fecha Fin',
            'general' => 'general',
            'vigente' => 'vigente',
            'origen' => 'Origen',
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

        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.codigo', $this->codigo);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->compare('t.idalmacen', $this->idalmacen);
        if (Yii::app()->getRequest()->getParam('idalmacen') !== null) {
            $criteria->compare('idalmacen0.nombre', $this->idalmacen0->nombre, true);
        }
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc',
            ),
                )
        );
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
     * @return Almacen the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Verifica si el codigo  de un almacen puede ser modificado, para eso no 
     * deben existir productos asociados a el, de ser asi devuelve false
     * @param string $pid id del almacen a verificar
     * @return resultado de la funcion, devuelve true o false
     */
    public function isModificable($pid) {
        $command = Yii::app()->almacen->createCommand("select almacen_es_modificable(:pid)");
        $command->bindValue(":pid", $pid, PDO::PARAM_INT);
        return $command->queryScalar();
    }

    /**
     * Antes de guardar se cambia todas las cadenas a mayúsculas
     */
    public function beforeSave() {
        $this->nombre = strtoupper($this->nombre);
        if ($this->isNewRecord) {
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        $this->general = false;
        $this->vigente = false;
        return parent::beforeSave();
    }

    /**
     * Sentencias entes de ejecutar validacion
     * @return CActiveRecord con la tupla a validarse
     */
    protected function beforeValidate() {
        $this->nombre = strtoupper($this->nombre);
        return parent::beforeValidate();
    }
    
    /**
     * Sentencia a ejecutar antes del la eliminación segura
     */
    protected function beforeSafeDelete(){
        $aux = $this->eliminarAlmacen();
        if ($aux !== 'exito') {
            echo System::messageError($aux);
            return;
        } 
        else {
            return parent::beforeSafeDelete();
        }
    }

    /**
     * devuelve el id encriptado del almacen     
     * @return string Nombre Completo
     */
    protected function getIdEncriptado() {
        return SeguridadModule::enc($this->id);
    }

    /**
     * Verifica dependencias con el almacen
     */
    public function eliminarAlmacen() {
        $command = Yii::app()->almacen->createCommand
                ("select almacen_eliminable(" . $this->getPrimaryKey() . ");");
        return $command->queryScalar();
    }

    /**
     * Hereda los productos del almacen padre 
     */
    public function heredarProductoAlmacenPadre() {
        $command = Yii::app()->almacen->createCommand
                ("select almacen_heredar_productos_padre(" . $this->getPrimaryKey() . ",'" . Yii::app()->user->getName() . "');");
        return $command->queryScalar();
    }
    
    /**
     * Concatena el codigo y nombre del almacen    
     * @return string Nombre Completo
     */
    protected function getNombreCompleto() {
        return $this->nombre . ' (' . $this->codigo . ')';
    }

}
