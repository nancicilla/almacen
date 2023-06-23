<?php
/*
 * Cliente.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 04/02/2019
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
 
 * This is the model class for table "general.cliente".
 *
 * The followings are the available columns in table 'general.cliente':
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
 * @property integer $idtipocliente
 * @property boolean $bloqueado
 * @property string $descuento
 * @property integer $iddepartamento
 * @property string $localidad
 * @property boolean $individual
 * @property integer $tiempocredito
 * @property integer $idmotivo
 * @property integer $idlocalidad
 * @property string $clasetipo
 * @property string $fecharegistro
 * @property string $husuarios
 * @property boolean $operador
 * @property integer $idclienteoperador
 * @property string $montolimitecredito
 * @property integer $idmonedacredito
 * @property integer $idclientegrupo
 * @property integer $idcuenta
 * @property integer $idcuentacosto
 * @property integer $idcuentaventa
 * @property integer $idcuentadescuento
 * @property integer $codigoeq
 * @property integer $codigoeq0
 * @property boolean $habilitarventatpv
 * @property boolean $admitesubcliente
 * @property integer $idmodoventa
 * @property integer $teclasinfactura
 *
 * The followings are the available model relations:
 * @property Hojaprecio[] $hojaprecios
 * @property Clientegrupo $idclientegrupo
 * @property Cliente $idclienteoperador
 * @property Cliente[] $clientes
 * @property Localidad $idlocalidad
 * @property Tipocliente $idtipocliente
 * @property Motivo $idmotivo
 * @property Clientecaracteristica[] $clientecaracteristicas
 * @property Contacto[] $contactos
 */
class Cliente extends CActiveRecord
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
            return 'general.cliente';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id, codigo, idtipocliente', 'required'),
                    array('id, codigo, idtipocliente, iddepartamento, tiempocredito, idmotivo, idlocalidad, idclienteoperador, idmonedacredito, idclientegrupo, idcuenta, idcuentacosto, idcuentaventa, idcuentadescuento, codigoeq, codigoeq0, idmodoventa, teclasinfactura', 'numerical', 'integerOnly'=>true),
                    array('nombre, razonsocial, telefono, fax, email, web', 'length', 'max'=>50),
                    array('direccion', 'length', 'max'=>100),
                    array('usuario', 'length', 'max'=>30),
                    array('descuento', 'length', 'max'=>5),
                    array('localidad', 'length', 'max'=>120),
                    array('montolimitecredito', 'length', 'max'=>12),
                    array('nit, eliminado, fecha, bloqueado, individual, clasetipo, fecharegistro, husuarios, operador, habilitarventatpv, admitesubcliente', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, codigo, nit, nombre, razonsocial, direccion, telefono, fax, email, web, eliminado, usuario, fecha, idtipocliente, bloqueado, descuento, iddepartamento, localidad, individual, tiempocredito, idmotivo, idlocalidad, clasetipo, fecharegistro, husuarios, operador, idclienteoperador, montolimitecredito, idmonedacredito, idclientegrupo, idcuenta, idcuentacosto, idcuentaventa, idcuentadescuento, codigoeq, codigoeq0, habilitarventatpv, admitesubcliente, idmodoventa, teclasinfactura', 'safe', 'on'=>'search'),
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
                    'hojaprecios' => array(self::HAS_MANY, 'Hojaprecio', 'idcliente'),
                    'idclientegrupo' => array(self::BELONGS_TO, 'Clientegrupo', 'idclientegrupo'),
                    'idclienteoperador' => array(self::BELONGS_TO, 'Cliente', 'idclienteoperador'),
                    'clientes' => array(self::HAS_MANY, 'Cliente', 'idclienteoperador'),
                    'idlocalidad' => array(self::BELONGS_TO, 'Localidad', 'idlocalidad'),
                    'idtipocliente' => array(self::BELONGS_TO, 'Tipocliente', 'idtipocliente'),
                    'idmotivo' => array(self::BELONGS_TO, 'Motivo', 'idmotivo'),
                    'clientecaracteristicas' => array(self::HAS_MANY, 'Clientecaracteristica', 'idcliente'),
                    'contactos' => array(self::HAS_MANY, 'Contacto', 'idcliente'),
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
                    'idtipocliente' => 'Idtipocliente',
                    'bloqueado' => 'Bloqueado',
                    'descuento' => 'Descuento',
                    'iddepartamento' => 'Iddepartamento',
                    'localidad' => 'Localidad',
                    'individual' => 'Individual',
                    'tiempocredito' => 'Tiempocredito',
                    'idmotivo' => 'BLOQUEO >> id motivo ',
                    'idlocalidad' => 'Idlocalidad',
                    'clasetipo' => 'PERSONAL / EMPRESA / GRUPAL(GRUPAL=>VARIOS clientes-eventual asocia a una cuenta)',
                    'fecharegistro' => 'Fecharegistro',
                    'husuarios' => 'historial usuarios >registro datos',
                    'operador' => 'Operador',
                    'idclienteoperador' => 'Idclienteoperador',
                    'montolimitecredito' => 'Montolimitecredito',
                    'idmonedacredito' => 'Idmonedacredito',
                    'idclientegrupo' => 'Idclientegrupo',
                    'idcuenta' => 'Idcuenta',
                    'idcuentacosto' => 'Idcuentacosto',
                    'idcuentaventa' => 'Idcuentaventa',
                    'idcuentadescuento' => 'Idcuentadescuento',
                    'codigoeq' => 'TRANSICION:codigo equivalente de sistema anterior',
                    'codigoeq0' => 'registro duplicado en sistema anterior',
                    'habilitarventatpv' => 'Habilitarventatpv',
                    'admitesubcliente' => 'Admitesubcliente',
                    'idmodoventa' => 'Idmodoventa',
                    'teclasinfactura' => 'Teclasinfactura',
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
		$criteria->compare('t.idtipocliente',$this->idtipocliente);
		$criteria->compare('t.bloqueado',$this->bloqueado);
		$criteria->addSearchCondition('t.descuento',$this->descuento,true,'AND','ILIKE');
		$criteria->compare('t.iddepartamento',$this->iddepartamento);
		$criteria->addSearchCondition('t.localidad',$this->localidad,true,'AND','ILIKE');
		$criteria->compare('t.individual',$this->individual);
		$criteria->compare('t.tiempocredito',$this->tiempocredito);
		$criteria->compare('t.idmotivo',$this->idmotivo);
		$criteria->compare('t.idlocalidad',$this->idlocalidad);
		$criteria->addSearchCondition('t.clasetipo',$this->clasetipo,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fecharegistro',$this->fecharegistro,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.husuarios',$this->husuarios,true,'AND','ILIKE');
		$criteria->compare('t.operador',$this->operador);
		$criteria->compare('t.idclienteoperador',$this->idclienteoperador);
		$criteria->addSearchCondition('t.montolimitecredito',$this->montolimitecredito,true,'AND','ILIKE');
		$criteria->compare('t.idmonedacredito',$this->idmonedacredito);
		$criteria->compare('t.idclientegrupo',$this->idclientegrupo);
		$criteria->compare('t.idcuenta',$this->idcuenta);
		$criteria->compare('t.idcuentacosto',$this->idcuentacosto);
		$criteria->compare('t.idcuentaventa',$this->idcuentaventa);
		$criteria->compare('t.idcuentadescuento',$this->idcuentadescuento);
		$criteria->compare('t.codigoeq',$this->codigoeq);
		$criteria->compare('t.codigoeq0',$this->codigoeq0);
		$criteria->compare('t.habilitarventatpv',$this->habilitarventatpv);
		$criteria->compare('t.admitesubcliente',$this->admitesubcliente);
		$criteria->compare('t.idmodoventa',$this->idmodoventa);
		$criteria->compare('t.teclasinfactura',$this->teclasinfactura);

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
     * @return Cliente the static model class
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
		$this->clasetipo=strtoupper($this->clasetipo);
		$this->husuarios=strtoupper($this->husuarios);
        return parent::beforeSave();            
    }


}
