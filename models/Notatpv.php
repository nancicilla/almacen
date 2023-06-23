<?php
/*
 * Notatpv.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 04/11/2017
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
 
 * This is the model class for table "nota".
 *
 * The followings are the available columns in table 'nota':
 * @property integer $id
 * @property integer $numero
 * @property string $glosa
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $idtipo
 * @property string $total
 * @property integer $idestado
 * @property string $descripcion
 * @property integer $iddocumento
 * @property integer $idcontracuenta
 * @property integer $idtipodocumento
 *
 * The followings are the available model relations:
 * @property Estado $idestado0
 */
class Notatpv extends CActiveRecord
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
            return 'nota';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
//                    array('fecha, idtipo', 'required'),
                    array('numero, idtipo, idestado, iddocumento, idcontracuenta, idtipodocumento', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('total', 'length', 'max'=>12),
                    array('glosa, eliminado, descripcion', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero, glosa, fecha, eliminado, usuario, idtipo, total, idestado, descripcion, iddocumento, idcontracuenta, idtipodocumento', 'safe', 'on'=>'search'),
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
                    'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Numero',
                    'glosa' => 'Glosa',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'usuario' => 'Usuario',
                    'idtipo' => 'Idtipo',
                    'total' => 'Total',
                    'idestado' => 'Idestado',
                    'descripcion' => 'Descripcion',
                    'iddocumento' => 'Iddocumento',
                    'idcontracuenta' => 'Idcontracuenta',
                    'idtipodocumento' => 'Idtipodocumento',
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
		$criteria->compare('t.numero',$this->numero);
		$criteria->addSearchCondition('t.glosa',$this->glosa,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idtipo',$this->idtipo);
		$criteria->addSearchCondition('t.total',$this->total,true,'AND','ILIKE');
		$criteria->compare('t.idestado',$this->idestado);
		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');
		$criteria->compare('t.iddocumento',$this->iddocumento);
		$criteria->compare('t.idcontracuenta',$this->idcontracuenta);
		$criteria->compare('t.idtipodocumento',$this->idtipodocumento);

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
            return Yii::app()->tpv;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notatpv the static model class
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
		$this->glosa=strtoupper($this->glosa);
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
		$this->descripcion=strtoupper($this->descripcion);
        return parent::beforeSave();            
    }

    /**
     * Función que genera un numero de orden ya sea consecutivo
     * o que rellena los numeros faltantes
     * @return type
     */
    public function generarNumero() {
        return Yii::app()->tpv->createCommand("SELECT MAX(numero) "
                . "FROM nota where eliminado=false")->queryScalar()+1;
    }
}
