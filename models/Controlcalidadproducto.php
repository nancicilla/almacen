<?php
/*
 * Controlcalidadproducto.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 22/02/2018
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
 
 * This is the model class for table "controlcalidadproducto".
 *
 * The followings are the available columns in table 'controlcalidadproducto':
 * @property integer $id
 * @property string $gestionschema
 * @property string $gestionschemaactive
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 * @property integer $idcontrolcalidad
 * @property string $gestionschemacontrolcalidad
 * @property integer $idproducto
 * @property double $cantidaddevolucion
 * @property double $cantidadbaja
 * @property double $cantidadventa
 * @property double $cantidadreproceso
 * @property double $cantidaddevolucionaceptada
 * @property string $observacion
 */
class Controlcalidadproducto extends CActiveRecord
{
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
            return 'controlcalidadproducto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('gestionschema', 'required'),
                    array('idcontrolcalidad, idproducto', 'numerical', 'integerOnly'=>true),
                    array('cantidaddevolucion, cantidadbaja, cantidadventa, cantidadreproceso, cantidaddevolucionaceptada', 'numerical'),
                    array('gestionschema, gestionschemaactive, gestionschemacontrolcalidad', 'length', 'max'=>9),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado, observacion', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, gestionschema, gestionschemaactive, fecha, usuario, eliminado, idcontrolcalidad, gestionschemacontrolcalidad, idproducto, cantidaddevolucion, cantidadbaja, cantidadventa, cantidadreproceso, cantidaddevolucionaceptada, observacion', 'safe', 'on'=>'search'),
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
                'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'gestionschema' => 'Gestionschema',
                    'gestionschemaactive' => 'Gestionschemaactive',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'idcontrolcalidad' => 'Idcontrolcalidad',
                    'gestionschemacontrolcalidad' => 'Gestionschemacontrolcalidad',
                    'idproducto' => 'Idproducto',
                    'cantidaddevolucion' => 'Cantidaddevolucion',
                    'cantidadbaja' => 'Cantidadbaja',
                    'cantidadventa' => 'Cantidadventa',
                    'cantidadreproceso' => 'Cantidadreproceso',
                    'cantidaddevolucionaceptada' => 'Cantidaddevolucionaceptada',
                    'observacion' => 'Observacion',
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
		$criteria->addSearchCondition('t.gestionschema',$this->gestionschema,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.gestionschemaactive',$this->gestionschemaactive,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idcontrolcalidad',$this->idcontrolcalidad);
		$criteria->addSearchCondition('t.gestionschemacontrolcalidad',$this->gestionschemacontrolcalidad,true,'AND','ILIKE');
		$criteria->compare('t.idproducto',$this->idproducto);
		$criteria->compare('t.cantidaddevolucion',$this->cantidaddevolucion);
		$criteria->compare('t.cantidadbaja',$this->cantidadbaja);
		$criteria->compare('t.cantidadventa',$this->cantidadventa);
		$criteria->compare('t.cantidadreproceso',$this->cantidadreproceso);
		$criteria->compare('t.cantidaddevolucionaceptada',$this->cantidaddevolucionaceptada);
		$criteria->addSearchCondition('t.observacion',$this->observacion,true,'AND','ILIKE');

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
            return Yii::app()->venta;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Controlcalidadproducto the static model class
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
		$this->gestionschema=strtoupper($this->gestionschema);
		$this->gestionschemaactive=strtoupper($this->gestionschemaactive);
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
		$this->gestionschemacontrolcalidad=strtoupper($this->gestionschemacontrolcalidad);
		$this->observacion=strtoupper($this->observacion);
        return parent::beforeSave();            
    }

    public function obtenerProductos($idcontrolcalidad,$controlcalidadschema) {
        
        $criteria = new CDbCriteria;
        $criteria->compare('t.idcontrolcalidad', $idcontrolcalidad);
        $criteria->compare('t.gestionschemacontrolcalidad', $controlcalidadschema);        
        //print_r($idnotarecepcion);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>false,
            'sort' => array(
                'defaultOrder' => 't.gestionschema,t.id asc'
                )
        ));
    }
}
