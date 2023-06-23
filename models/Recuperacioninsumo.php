<?php
/*
 * Recuperacioninsumo.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/04/2019
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
 
 * This is the model class for table "recuperacioninsumo".
 *
 * The followings are the available columns in table 'recuperacioninsumo':
 * @property integer $id
 * @property integer $idrecuperacion
 * @property integer $idproducto
 * @property string $cantidad
 * @property boolean $aceptado
 * @property boolean $reproceso
 * @property boolean $eliminado
 * @property string $fecha
 * @property string $usuario
 */
class Recuperacioninsumo extends CActiveRecord
{
    public $codigo;
    public $nombre;
    public $simbolo;
    public $cantidaddevolucion;
    public $conforme;
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
    public function tableName()
    {
            return 'recuperacioninsumo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idrecuperacion, idproducto', 'numerical', 'integerOnly'=>true),
                    array('cantidad, cantidadreceta', 'length', 'max'=>10),
                    array('usuario', 'length', 'max'=>30),
                    array('aceptado, reproceso, eliminado, fecha', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idrecuperacion, idproducto, cantidad, aceptado, reproceso, eliminado, fecha, usuario', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idrecuperacion' => 'Idrecuperacion',
                    'idproducto' => 'Idproducto',
                    'cantidad' => 'Cantidad',
                    'aceptado' => 'Aceptado',
                    'reproceso' => 'Reproceso',
                    'eliminado' => 'Eliminado',
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
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.idrecuperacion',$this->idrecuperacion);
		$criteria->compare('t.idproducto',$this->idproducto);
		$criteria->addSearchCondition('t.cantidad',$this->cantidad,true,'AND','ILIKE');
		$criteria->compare('t.aceptado',$this->aceptado);
		$criteria->compare('t.reproceso',$this->reproceso);
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Recuperacioninsumo the static model class
     */
    public static function model($className=__CLASS__)
    {
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
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }

    public function obtenerInsumos($idrecuperacion){
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,p.id as idproducto, p.codigo, p.nombre,t.cantidadreceta, t.cantidad,u.simbolo,case when t.aceptado then 1 else 0 end as conforme';
        $criteria->join = 'inner join producto p on t.idproducto = p.id
                           inner join unidad u on u.id=p.idunidad';
        $criteria->compare('t.idrecuperacion', $idrecuperacion);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>false,
            'sort' => array(
                'defaultOrder' => 't.id asc'
                )
        ));
    }

}
