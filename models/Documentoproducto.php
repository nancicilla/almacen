<?php
/*
 * Documentoproducto.php
 *
 * Version 0.$Rev: 900 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2017-01-09 08:27:49 -0400 (Mon, 09 Jan 2017) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "documentoproducto".
 *
 * The followings are the available columns in table 'documentoproducto':
 * @property string $cantidad
 * @property string $precio
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 * @property integer $idpedido
 * @property integer $idventa
 * @property integer $idproducto
 *
 * The followings are the available model relations:
 * @property Pedido $idpedido0
 * @property Producto $idproducto0
 * @property Venta $idventa0
 */
class Documentoproducto extends CActiveRecord {
    public $codigo;
    public $nombre;
    public $costo;
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
        return 'documentoproducto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
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
        );
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
     * @return Documentoproducto the static model class
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
        if($this->isNewRecord){
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }
    
    /**
     * Carga en un array los productos de una pedido
     * @param type $idpedido id del registro de la pedido .   
     * @return array detalle de productos.
     */
    public function obtenerDocumentoproducto($iddocumentoproducto) {
        $criteria = new CDbCriteria;
        $criteria->select = 'p.id, p.codigo, p.nombre, t.cantidad, '
                          . 'case when p.saldo <= 0 then p.ultimoppp else round(p.saldoimporte/p.saldo, 4) end as costo';
        $criteria->join = 'inner join producto p on t.idproducto = p.id';
        $criteria->compare('t.id', $iddocumentoproducto);       

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>false,
            'sort' => array(
                'defaultOrder' => 't.id asc')
        ));
    }

}
