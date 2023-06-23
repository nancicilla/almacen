<?php
/*
 * Familia.php
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
 * This is the model class for table "familia".
 *
 * The followings are the available columns in table 'familia':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $fecha
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Producto[] $productos
 */
class Familia extends CActiveRecord {
    
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
        return 'familia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigo,nombre', 'required','on' => array('insert', 'update')),
            array('codigo,nombre', 'unique','on' => array('insert', 'update')),
            array('codigo', 'length', 'min' => 3,'on' => array('insert', 'update')),
            array('codigo', 'length', 'max' => 3),
            array('nombre, usuario', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, nombre, fecha, usuario', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productos' => array(self::HAS_MANY, 'Producto', 'idfamilia'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
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
        $criteria->compare('t.eliminado',0);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc'
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
     * @return Familia the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Sentencias entes de ejecutar metodo save
     * @return CActiveRecord con la tupla a insertarse
     */
    protected function beforeSave() {
        $this->codigo = strtoupper($this->codigo);
        $this->nombre = strtoupper($this->nombre);
        if ($this->isNewRecord) {
            $this->usuario = Yii::app()->user->getName();
            $this->fecha = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    /**
     * Sentencias entes de ejecutar metodo delete
     * @return CActiveRecord con la tupla a eliminarse
     */
    protected function beforeSafeDelete() {
        if ($this->tieneProducto()) {
            echo System::messageError('La familia no puede ser eliminada,'
                    . ' productos dependen de ella.');
            return;
        } else {
            return parent::beforeSafeDelete();
        }
    }

    /**
     * Sentencias entes de ejecutar validacion
     * @return CActiveRecord con la tupla a validarse
     */
    protected function beforeValidate() {
        $this->codigo = strtoupper($this->codigo);
        $this->nombre = strtoupper($this->nombre);
        return parent::beforeValidate();
    }

    /**
     * Verifica si una familia es utilizada por algún producto
     * @return 0 o 1 si existe o no
     */
    public function tieneProducto() {
        $retorno = 0;

        if ($this->id != "") {
            $retorno = Producto::model()->exists('idfamilia=' . $this->id);
        }
        return $retorno;
    }

    /**
     * Obtiene la informacion de una familia
     * @param id Id de la familia a consultar
     * @return modelo con los datos necesarios
     */
    public function informacionFamilia($id) {

        $criteria = new CDbCriteria;
        $criteria->select = 'id,codigo,nombre';
        $criteria->condition = 'id = ' . $id;

        $modeloTemporal = Familia::model()->find($criteria);
        return $modeloTemporal;
    }

}