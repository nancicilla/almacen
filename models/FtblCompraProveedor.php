<?php
/*
 * FtblCompraProveedor.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 23/06/2021
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
 
 * This is the model class for table "ftbl_compra_proveedor".
 *
 * The followings are the available columns in table 'ftbl_compra_proveedor':
 * @property integer $id
 * @property integer $codigo
 * @property string $nit
 * @property string $nombre
 * @property string $razonsocial
 * @property string $direccion
 * @property string $telefono
 * @property string $fax
 * @property string $email
 * @property string $web
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 * @property integer $idente
 * @property integer $idtipoproveedor
 * @property string $autorizacion
 * @property integer $iddepartamento
 * @property string $localidad
 * @property boolean $individual
 * @property integer $idcuentaporpagar
 * @property integer $idcuentaanticipo
 * @property string $ordenregimen
 * @property boolean $nacional
 * @property integer $tiempoentrega
 * @property string $factorseguridad
 */
class FtblCompraProveedor extends CActiveRecord
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
            return 'ftbl_compra_proveedor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id, codigo, idente, idtipoproveedor, iddepartamento, idcuentaporpagar, idcuentaanticipo, tiempoentrega', 'numerical', 'integerOnly'=>true),
                    array('nombre, razonsocial, telefono, fax, email, web, localidad', 'length', 'max'=>50),
                    array('usuario, ordenregimen', 'length', 'max'=>30),
                    array('factorseguridad', 'length', 'max'=>10),
                    array('nit, direccion, eliminado, fecha, autorizacion, individual, nacional', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, codigo, nit, nombre, razonsocial, direccion, telefono, fax, email, web, eliminado, usuario, fecha, idente, idtipoproveedor, autorizacion, iddepartamento, localidad, individual, idcuentaporpagar, idcuentaanticipo, ordenregimen, nacional, tiempoentrega, factorseguridad', 'safe', 'on'=>'search'),
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
                    'codigo' => 'Codigo',
                    'nit' => 'Nit',
                    'nombre' => 'Nombre',
                    'razonsocial' => 'Razonsocial',
                    'direccion' => 'Direccion',
                    'telefono' => 'Telefono',
                    'fax' => 'Fax',
                    'email' => 'Email',
                    'web' => 'Web',
                    'eliminado' => 'Eliminado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'idente' => 'Idente',
                    'idtipoproveedor' => 'Idtipoproveedor',
                    'autorizacion' => 'Autorizacion',
                    'iddepartamento' => 'Iddepartamento',
                    'localidad' => 'Localidad',
                    'individual' => 'Individual',
                    'idcuentaporpagar' => 'Idcuentaporpagar',
                    'idcuentaanticipo' => 'Idcuentaanticipo',
                    'ordenregimen' => 'Ordenregimen',
                    'nacional' => 'Nacional',
                    'tiempoentrega' => 'Tiempoentrega',
                    'factorseguridad' => 'Factorseguridad',
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
		$criteria->compare('t.codigo',$this->codigo);
		$criteria->addSearchCondition('t.nit',$this->nit,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.razonsocial',$this->razonsocial,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.direccion',$this->direccion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.telefono',$this->telefono,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fax',$this->fax,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.email',$this->email,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.web',$this->web,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idente',$this->idente);
		$criteria->compare('t.idtipoproveedor',$this->idtipoproveedor);
		$criteria->addSearchCondition('t.autorizacion',$this->autorizacion,true,'AND','ILIKE');
		$criteria->compare('t.iddepartamento',$this->iddepartamento);
		$criteria->addSearchCondition('t.localidad',$this->localidad,true,'AND','ILIKE');
		$criteria->compare('t.individual',$this->individual);
		$criteria->compare('t.idcuentaporpagar',$this->idcuentaporpagar);
		$criteria->compare('t.idcuentaanticipo',$this->idcuentaanticipo);
		$criteria->addSearchCondition('t.ordenregimen',$this->ordenregimen,true,'AND','ILIKE');
		$criteria->compare('t.nacional',$this->nacional);
		$criteria->compare('t.tiempoentrega',$this->tiempoentrega);
		$criteria->addSearchCondition('t.factorseguridad',$this->factorseguridad,true,'AND','ILIKE');

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
     * @return FtblCompraProveedor the static model class
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
		$this->razonsocial=strtoupper($this->razonsocial);
		$this->direccion=strtoupper($this->direccion);
		$this->telefono=strtoupper($this->telefono);
		$this->fax=strtoupper($this->fax);
		$this->email=strtoupper($this->email);
		$this->web=strtoupper($this->web);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->localidad=strtoupper($this->localidad);
		$this->ordenregimen=strtoupper($this->ordenregimen);
        return parent::beforeSave();            
    }


}
