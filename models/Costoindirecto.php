<?php
/*
 * Costoindirecto.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 24/08/2018
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
 
 * This is the model class for table "costoindirecto".
 *
 * The followings are the available columns in table 'costoindirecto':
 * @property integer $id
 * @property string $nombre
 * @property string $factorproduccion
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 * @property string $horastotales
 * @property integer $idcuenta
 * @property double $numtrabplanilla
 * @property double $hrsmesplanilla
 * @property double $consumomesplla
 * @property integer $ordenesproduccionsimultaneas
 * @property integer $numeromaquinas
 * @property integer $numerocuenta
 * @property double $pagomensual
 */
class Costoindirecto extends CActiveRecord
{
    const COSTO_INSUMO = 0;
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
            return 'costoindirecto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idcuenta, ordenesproduccionsimultaneas, numeromaquinas, numerocuenta', 'numerical', 'integerOnly'=>true),
                    array('numtrabplanilla, hrsmesplanilla, consumomesplla, pagomensual', 'numerical'),
                    array('nombre', 'length', 'max'=>50),
                    array('factorproduccion', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('horastotales', 'length', 'max'=>10),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre, factorproduccion, fecha, usuario, eliminado, horastotales, idcuenta, numtrabplanilla, hrsmesplanilla, consumomesplla, ordenesproduccionsimultaneas, numeromaquinas, numerocuenta, pagomensual', 'safe', 'on'=>'search'),
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
                    'nombre' => 'Nombre',
                    'factorproduccion' => 'Factorproduccion',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'horastotales' => 'Horastotales',
                    'idcuenta' => 'Idcuenta',
                    'numtrabplanilla' => 'Numtrabplanilla',
                    'hrsmesplanilla' => 'Hrsmesplanilla',
                    'consumomesplla' => 'Consumomesplla',
                    'ordenesproduccionsimultaneas' => 'Ordenesproduccionsimultaneas',
                    'numeromaquinas' => 'Numeromaquinas',
                    'numerocuenta' => 'Numerocuenta',
                    'pagomensual' => 'Pagomensual',
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
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.factorproduccion',$this->factorproduccion,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horastotales',$this->horastotales,true,'AND','ILIKE');
		$criteria->compare('t.idcuenta',$this->idcuenta);
		$criteria->compare('t.numtrabplanilla',$this->numtrabplanilla);
		$criteria->compare('t.hrsmesplanilla',$this->hrsmesplanilla);
		$criteria->compare('t.consumomesplla',$this->consumomesplla);
		$criteria->compare('t.ordenesproduccionsimultaneas',$this->ordenesproduccionsimultaneas);
		$criteria->compare('t.numeromaquinas',$this->numeromaquinas);
		$criteria->compare('t.numerocuenta',$this->numerocuenta);
		$criteria->compare('t.pagomensual',$this->pagomensual);

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
            return Yii::app()->costos;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Costoindirecto the static model class
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
		$this->nombre=strtoupper($this->nombre);
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }


}
