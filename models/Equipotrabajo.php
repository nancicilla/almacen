<?php
/*
 * Equipotrabajo.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 11/06/2023
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
 
 * This is the model class for table "equipotrabajo".
 *
 * The followings are the available columns in table 'equipotrabajo':
 * @property integer $id
 * @property integer $idpersonal
 * @property integer $idproyecto
 * @property boolean $esencargado
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Personal $idpersonal0
 * @property Proyecto $idproyecto0
 */
class Equipotrabajo extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $nombrecompleto;
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
            return 'equipotrabajo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    //array('id', 'required'),
                    array('id, idpersonal, idproyecto', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('esencargado, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idpersonal, idproyecto, esencargado, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idpersonal0' => array(self::BELONGS_TO, 'Personal', 'idpersonal'),
                    'idproyecto0' => array(self::BELONGS_TO, 'Proyecto', 'idproyecto'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idpersonal' => 'Idpersonal',
                    'idproyecto' => 'Idproyecto',
                    'esencargado' => 'Esencargado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
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
		$criteria->compare('t.idpersonal',$this->idpersonal);
		$criteria->compare('t.idproyecto',$this->idproyecto);
		$criteria->compare('t.esencargado',$this->esencargado);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

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
     * @return Equipotrabajo the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
     public function listaPersonal($idproyecto)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idproyecto = ".$idproyecto);
        $criteria->join = "right  JOIN general.personal p  ON p.id= t.idpersonal ";
        $criteria->order = 'p.nombrecompleto asc';
        $criteria->select="t.esencargado, t.idpersonal as id,p.nombrecompleto";
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'p.nombrecompleto asc',
            )
        ));
    }


}
