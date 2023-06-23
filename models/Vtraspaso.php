<?php
/*
 * Vtraspaso.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 18/05/2016
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (Tue, 17 Mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 
 * This is the model class for table "vtraspaso".
 *
 * The followings are the available columns in table 'vtraspaso':
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property string $estado
 * @property string $tipo
 * @property string $cliente
 * @property string $almacen
 * @property integer $idalmacen
 * @property string $usuario
 * @property integer $idpedido
 * @property boolean $eliminado
 * @property integer $numeropedido
 * @property string $total
 * @property integer $idmoneda
 */
class Vtraspaso extends CActiveRecord
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
            return 'vtraspaso';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id, numero, idalmacen, idpedido, numeropedido, idmoneda', 'numerical', 'integerOnly'=>true),
                    array('estado, cliente, almacen', 'length', 'max'=>50),
                    array('tipo', 'length', 'max'=>10),
                    array('usuario', 'length', 'max'=>30),
                    array('total', 'length', 'max'=>12),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero, fecha, estado, tipo, cliente, almacen, idalmacen, usuario, idpedido, eliminado, numeropedido, total, idmoneda', 'safe', 'on'=>'search'),
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
     * Funcion que retorna el id del modelo
     * @return string
     */
    public function primaryKey() {
        return 'id';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Numero',
                    'fecha' => 'Fecha',
                    'estado' => 'Estado',
                    'tipo' => 'Tipo',
                    'cliente' => 'Cliente',
                    'almacen' => 'Almacen',
                    'idalmacen' => 'Idalmacen',
                    'usuario' => 'Usuario',
                    'idpedido' => 'Idpedido',
                    'eliminado' => 'Eliminado',
                    'numeropedido' => 'Numeropedido',
                    'total' => 'Total',
                    'idmoneda' => 'Idmoneda',
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
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.estado',$this->estado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.tipo',$this->tipo,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.cliente',$this->cliente,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.almacen',$this->almacen,true,'AND','ILIKE');
		$criteria->compare('t.idalmacen',$this->idalmacen);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idpedido',$this->idpedido);
		$criteria->compare('t.numeropedido',$this->numeropedido);
		$criteria->addSearchCondition('t.total',$this->total,true,'AND','ILIKE');
		$criteria->compare('t.idmoneda',$this->idmoneda);

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
     * @return Vtraspaso the static model class
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
		$this->estado=strtoupper($this->estado);
		$this->tipo=strtoupper($this->tipo);
		$this->cliente=strtoupper($this->cliente);
		$this->almacen=strtoupper($this->almacen);
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }


}
