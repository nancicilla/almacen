<?php
/*
 * Consignacion.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 02/10/2019
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
 
 * This is the model class for table "consignacion".
 *
 * The followings are the available columns in table 'consignacion':
 * @property integer $id
 * @property string $gestionschema
 * @property string $gestionschemaactive
 * @property string $gestionschemadocumento
 * @property string $codigohistorial
 * @property integer $numero
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idestado
 * @property integer $idcliente
 * @property integer $idmoneda
 * @property string $tc
 * @property string $descuento
 * @property string $total
 * @property string $totalconsignacion
 * @property string $totalcobroadicional
 * @property integer $idalmacen
 * @property string $nombrecliente
 * @property string $nit
 * @property string $razonsocial
 * @property string $glosa
 * @property integer $idclienteoperador
 * @property integer $idenvio
 * @property string $gestionschemaenvio
 * @property string $sysnote
 * @property string $obs
 * @property boolean $tabu
 * @property string $ordencompra
 * @property string $montoacuenta
 * @property double $montoareembolsar
 * @property double $montoreembolsado
 * @property double $montoacuentacobrado
 * @property integer $idpedido
 * @property string $gestionschemapedido
 * @property integer $del
 * @property integer $iddespachorecojo
 * @property integer $idnota
 * @property string $usuarioalmacen
 * @property string $usuariodevolucion
 * @property string $usuariocantidadaceptada
 * @property integer $idnotadevolucion
 */
class Consignacion extends CActiveRecord
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
            return 'consignacion';
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
                    array('numero, idestado, idcliente, idmoneda, idalmacen, idclienteoperador, idenvio, idpedido, del, iddespachorecojo, idnota, idnotadevolucion', 'numerical', 'integerOnly'=>true),
                    array('montoareembolsar, montoreembolsado, montoacuentacobrado', 'numerical'),
                    array('gestionschema, gestionschemaactive, gestionschemadocumento, gestionschemaenvio, gestionschemapedido', 'length', 'max'=>9),
                    array('codigohistorial, ordencompra', 'length', 'max'=>20),
                    array('usuario', 'length', 'max'=>30),
                    array('tc, total, totalconsignacion, totalcobroadicional, montoacuenta', 'length', 'max'=>12),
                    array('descuento', 'length', 'max'=>5),
                    array('fecha, eliminado, nombrecliente, nit, razonsocial, glosa, sysnote, obs, tabu, usuarioalmacen, usuariodevolucion, usuariocantidadaceptada', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, gestionschema, gestionschemaactive, gestionschemadocumento, codigohistorial, numero, usuario, fecha, eliminado, idestado, idcliente, idmoneda, tc, descuento, total, totalconsignacion, totalcobroadicional, idalmacen, nombrecliente, nit, razonsocial, glosa, idclienteoperador, idenvio, gestionschemaenvio, sysnote, obs, tabu, ordencompra, montoacuenta, montoareembolsar, montoreembolsado, montoacuentacobrado, idpedido, gestionschemapedido, del, iddespachorecojo, idnota, usuarioalmacen, usuariodevolucion, usuariocantidadaceptada, idnotadevolucion', 'safe', 'on'=>'search'),
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
                'idcliente0' => array(self::BELONGS_TO, 'Cliente', 'idcliente'),
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
                    'gestionschemadocumento' => 'Gestionschemadocumento',
                    'codigohistorial' => 'Codigohistorial',
                    'numero' => 'Numero',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idestado' => 'Idestado',
                    'idcliente' => 'Idcliente',
                    'idmoneda' => 'Idmoneda',
                    'tc' => 'Tc',
                    'descuento' => 'Descuento',
                    'total' => 'Total',
                    'totalconsignacion' => 'Totalconsignacion',
                    'totalcobroadicional' => 'Totalcobroadicional',
                    'idalmacen' => 'Idalmacen',
                    'nombrecliente' => 'Nombrecliente',
                    'nit' => 'Nit',
                    'razonsocial' => 'Razonsocial',
                    'glosa' => 'Glosa',
                    'idclienteoperador' => 'Idclienteoperador',
                    'idenvio' => 'Idenvio',
                    'gestionschemaenvio' => 'Gestionschemaenvio',
                    'sysnote' => 'Sysnote',
                    'obs' => 'Obs',
                    'tabu' => 'Tabu',
                    'ordencompra' => 'Ordencompra',
                    'montoacuenta' => 'Montoacuenta',
                    'montoareembolsar' => 'Montoareembolsar',
                    'montoreembolsado' => 'Montoreembolsado',
                    'montoacuentacobrado' => 'Montoacuentacobrado',
                    'idpedido' => 'Idpedido',
                    'gestionschemapedido' => 'Gestionschemapedido',
                    'del' => 'Del',
                    'iddespachorecojo' => 'Iddespachorecojo',
                    'idnota' => 'Idnota',
                    'usuarioalmacen' => 'Usuarioalmacen',
                    'usuariodevolucion' => 'Usuariodevolucion',
                    'usuariocantidadaceptada' => 'Usuariocantidadaceptada',
                    'idnotadevolucion' => 'Idnotadevolucion',
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
		$criteria->addSearchCondition('t.gestionschemadocumento',$this->gestionschemadocumento,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.codigohistorial',$this->codigohistorial,true,'AND','ILIKE');
		$criteria->compare('t.numero',$this->numero);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idestado',$this->idestado);
		$criteria->compare('t.idcliente',$this->idcliente);
		$criteria->compare('t.idmoneda',$this->idmoneda);
		$criteria->addSearchCondition('t.tc',$this->tc,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.descuento',$this->descuento,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.total',$this->total,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.totalconsignacion',$this->totalconsignacion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.totalcobroadicional',$this->totalcobroadicional,true,'AND','ILIKE');
		$criteria->compare('t.idalmacen',$this->idalmacen);
		$criteria->addSearchCondition('t.nombrecliente',$this->nombrecliente,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nit',$this->nit,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.razonsocial',$this->razonsocial,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.glosa',$this->glosa,true,'AND','ILIKE');
		$criteria->compare('t.idclienteoperador',$this->idclienteoperador);
		$criteria->compare('t.idenvio',$this->idenvio);
		$criteria->addSearchCondition('t.gestionschemaenvio',$this->gestionschemaenvio,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.sysnote',$this->sysnote,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.obs',$this->obs,true,'AND','ILIKE');
		$criteria->compare('t.tabu',$this->tabu);
		$criteria->addSearchCondition('t.ordencompra',$this->ordencompra,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.montoacuenta',$this->montoacuenta,true,'AND','ILIKE');
		$criteria->compare('t.montoareembolsar',$this->montoareembolsar);
		$criteria->compare('t.montoreembolsado',$this->montoreembolsado);
		$criteria->compare('t.montoacuentacobrado',$this->montoacuentacobrado);
		$criteria->compare('t.idpedido',$this->idpedido);
		$criteria->addSearchCondition('t.gestionschemapedido',$this->gestionschemapedido,true,'AND','ILIKE');
		$criteria->compare('t.del',$this->del);
		$criteria->compare('t.iddespachorecojo',$this->iddespachorecojo);
		$criteria->compare('t.idnota',$this->idnota);
		$criteria->addSearchCondition('t.usuarioalmacen',$this->usuarioalmacen,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuariodevolucion',$this->usuariodevolucion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuariocantidadaceptada',$this->usuariocantidadaceptada,true,'AND','ILIKE');
		$criteria->compare('t.idnotadevolucion',$this->idnotadevolucion);

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
     * @return Consignacion the static model class
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
		$this->gestionschemadocumento=strtoupper($this->gestionschemadocumento);
		$this->codigohistorial=strtoupper($this->codigohistorial);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->nombrecliente=strtoupper($this->nombrecliente);
		$this->razonsocial=strtoupper($this->razonsocial);
		$this->glosa=strtoupper($this->glosa);
		$this->gestionschemaenvio=strtoupper($this->gestionschemaenvio);
		$this->sysnote=strtoupper($this->sysnote);
		$this->obs=strtoupper($this->obs);
		$this->ordencompra=strtoupper($this->ordencompra);
		$this->gestionschemapedido=strtoupper($this->gestionschemapedido);
		$this->usuarioalmacen=strtoupper($this->usuarioalmacen);
		$this->usuariodevolucion=strtoupper($this->usuariodevolucion);
		$this->usuariocantidadaceptada=strtoupper($this->usuariocantidadaceptada);
        return parent::beforeSave();            
    }


}
