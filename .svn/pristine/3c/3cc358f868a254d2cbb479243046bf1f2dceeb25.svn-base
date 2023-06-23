<?php
/*
 * FtblCompraOrden.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 19/06/2018
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
 
 * This is the model class for table "ftbl_compra_orden".
 *
 * The followings are the available columns in table 'ftbl_compra_orden':
 * @property integer $id
 * @property integer $numero
 * @property string $observacion
 * @property integer $idcotizacion
 * @property integer $idestado
 * @property string $motivoestado
 * @property string $fechaestado
 * @property string $usuarioestado
 * @property boolean $eliminado
 * @property string $usuario
 * @property string $fecha
 * @property string $total
 * @property integer $idproveedor
 * @property string $acuenta
 * @property integer $idmedio
 * @property integer $idformapago
 * @property integer $idsolicitud
 * @property integer $idtipocompra
 * @property string $iva
 * @property string $it
 * @property string $iue
 * @property string $numerofactura
 * @property string $codcontrol
 * @property integer $idmotivoanulacion
 * @property integer $idnotaborrador
 * @property integer $idnota
 * @property string $observacioncontrol
 * @property boolean $aprobado
 * @property string $fechacontrol
 * @property string $usuariocontrol
 * @property string $fechamuestra
 * @property string $usuariomuestra
 * @property string $liquidototal
 * @property boolean $compradirecta
 * @property integer $idtipoadquisicion
 * @property string $areasolicitante
 * @property string $destino
 * @property boolean $comprasnormales
 * @property boolean $retencionempresa
 * @property string $totalflete
 * @property string $liquidoflete
 * @property string $gastoadicional
 * @property string $costoadicional
 * @property integer $ingreso
 * @property string $pagoproveedor
 * @property boolean $pagoanticipado
 * @property string $montopagado
 * @property integer $idasientointegrado
 * @property string $montofletepagado
 * @property string $montogastoadicionalpagado
 * @property string $usuariorecepcion
 * @property string $fecharecepcion
 * @property integer $idordendiferido
 * @property integer $numeroentrega
 * @property integer $idalmacen
 * @property string $responsable
 * @property integer $idcuenta
 * @property string $fechalimite
 * @property boolean $pagarporpedidoacordado
 * @property integer $idmoneda
 * @property string $tipocambio
 * @property integer $duracion
 * @property string $calificacion
 * @property string $fechacierre
 * @property string $observacioncomprador
 * @property string $fechaconfirmacion
 * @property string $usuarioingresoinicial
 * @property string $fechaingresoinicial
 * @property string $cambios
 * @property string $fechafactura
 * @property string $detallecorreccion
 * @property boolean $sincronizado
 * @property string $usuarioconfirmacion
 * @property string $gestionschemaactive
 * @property string $gestionschemanota
 * @property string $gestionschemaasientointegrado
 * @property string $usuariofinalizacion
 * @property string $fechafinalizacion
 */
class FtblCompraOrden extends CActiveRecord
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
            return 'ftbl_compra_orden';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id, numero, idcotizacion, idestado, idproveedor, idmedio, idformapago, idsolicitud, idtipocompra, idmotivoanulacion, idnotaborrador, idnota, idtipoadquisicion, ingreso, idasientointegrado, idordendiferido, numeroentrega, idalmacen, idcuenta, idmoneda, duracion', 'numerical', 'integerOnly'=>true),
                    array('motivoestado, usuarioestado', 'length', 'max'=>50),
                    array('usuario, codcontrol, usuariocontrol, usuarioconfirmacion', 'length', 'max'=>30),
                    array('total, liquidototal, pagoproveedor, montopagado', 'length', 'max'=>23),
                    array('acuenta', 'length', 'max'=>12),
                    array('iva, it, iue', 'length', 'max'=>5),
                    array('usuariomuestra, areasolicitante, usuariorecepcion, usuarioingresoinicial, usuariofinalizacion', 'length', 'max'=>35),
                    array('totalflete, liquidoflete, gastoadicional, costoadicional', 'length', 'max'=>14),
                    array('montofletepagado, montogastoadicionalpagado, calificacion', 'length', 'max'=>20),
                    array('responsable', 'length', 'max'=>80),
                    array('tipocambio', 'length', 'max'=>10),
                    array('gestionschemaactive, gestionschemanota, gestionschemaasientointegrado', 'length', 'max'=>9),
                    array('observacion, fechaestado, eliminado, fecha, numerofactura, observacioncontrol, aprobado, fechacontrol, fechamuestra, compradirecta, destino, comprasnormales, retencionempresa, pagoanticipado, fecharecepcion, fechalimite, pagarporpedidoacordado, fechacierre, observacioncomprador, fechaconfirmacion, fechaingresoinicial, cambios, fechafactura, detallecorreccion, sincronizado, fechafinalizacion', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero, observacion, idcotizacion, idestado, motivoestado, fechaestado, usuarioestado, eliminado, usuario, fecha, total, idproveedor, acuenta, idmedio, idformapago, idsolicitud, idtipocompra, iva, it, iue, numerofactura, codcontrol, idmotivoanulacion, idnotaborrador, idnota, observacioncontrol, aprobado, fechacontrol, usuariocontrol, fechamuestra, usuariomuestra, liquidototal, compradirecta, idtipoadquisicion, areasolicitante, destino, comprasnormales, retencionempresa, totalflete, liquidoflete, gastoadicional, costoadicional, ingreso, pagoproveedor, pagoanticipado, montopagado, idasientointegrado, montofletepagado, montogastoadicionalpagado, usuariorecepcion, fecharecepcion, idordendiferido, numeroentrega, idalmacen, responsable, idcuenta, fechalimite, pagarporpedidoacordado, idmoneda, tipocambio, duracion, calificacion, fechacierre, observacioncomprador, fechaconfirmacion, usuarioingresoinicial, fechaingresoinicial, cambios, fechafactura, detallecorreccion, sincronizado, usuarioconfirmacion, gestionschemaactive, gestionschemanota, gestionschemaasientointegrado, usuariofinalizacion, fechafinalizacion', 'safe', 'on'=>'search'),
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
                    'numero' => 'Numero',
                    'observacion' => 'Observacion',
                    'idcotizacion' => 'Idcotizacion',
                    'idestado' => 'Idestado',
                    'motivoestado' => 'Motivoestado',
                    'fechaestado' => 'Fechaestado',
                    'usuarioestado' => 'Usuarioestado',
                    'eliminado' => 'Eliminado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'total' => 'Total',
                    'idproveedor' => 'Idproveedor',
                    'acuenta' => 'Acuenta',
                    'idmedio' => 'Idmedio',
                    'idformapago' => 'Idformapago',
                    'idsolicitud' => 'Idsolicitud',
                    'idtipocompra' => 'Idtipocompra',
                    'iva' => 'Iva',
                    'it' => 'It',
                    'iue' => 'Iue',
                    'numerofactura' => 'Numerofactura',
                    'codcontrol' => 'Codcontrol',
                    'idmotivoanulacion' => 'Idmotivoanulacion',
                    'idnotaborrador' => 'Idnotaborrador',
                    'idnota' => 'Idnota',
                    'observacioncontrol' => 'Observacioncontrol',
                    'aprobado' => 'Aprobado',
                    'fechacontrol' => 'Fechacontrol',
                    'usuariocontrol' => 'Usuariocontrol',
                    'fechamuestra' => 'Fechamuestra',
                    'usuariomuestra' => 'Usuariomuestra',
                    'liquidototal' => 'Liquidototal',
                    'compradirecta' => 'Compradirecta',
                    'idtipoadquisicion' => 'Idtipoadquisicion',
                    'areasolicitante' => 'Areasolicitante',
                    'destino' => 'Destino',
                    'comprasnormales' => 'Comprasnormales',
                    'retencionempresa' => 'Retencionempresa',
                    'totalflete' => 'Totalflete',
                    'liquidoflete' => 'Liquidoflete',
                    'gastoadicional' => 'Gastoadicional',
                    'costoadicional' => 'Costoadicional',
                    'ingreso' => 'Ingreso',
                    'pagoproveedor' => 'Pagoproveedor',
                    'pagoanticipado' => 'Pagoanticipado',
                    'montopagado' => 'Montopagado',
                    'idasientointegrado' => 'Idasientointegrado',
                    'montofletepagado' => 'Montofletepagado',
                    'montogastoadicionalpagado' => 'Montogastoadicionalpagado',
                    'usuariorecepcion' => 'Usuariorecepcion',
                    'fecharecepcion' => 'Fecharecepcion',
                    'idordendiferido' => 'Idordendiferido',
                    'numeroentrega' => 'Numeroentrega',
                    'idalmacen' => 'Idalmacen',
                    'responsable' => 'Responsable',
                    'idcuenta' => 'Idcuenta',
                    'fechalimite' => 'Fechalimite',
                    'pagarporpedidoacordado' => 'Pagarporpedidoacordado',
                    'idmoneda' => 'Idmoneda',
                    'tipocambio' => 'Tipocambio',
                    'duracion' => 'Duracion',
                    'calificacion' => 'Calificacion',
                    'fechacierre' => 'Fechacierre',
                    'observacioncomprador' => 'Observacioncomprador',
                    'fechaconfirmacion' => 'Fechaconfirmacion',
                    'usuarioingresoinicial' => 'Usuarioingresoinicial',
                    'fechaingresoinicial' => 'Fechaingresoinicial',
                    'cambios' => 'Cambios',
                    'fechafactura' => 'Fechafactura',
                    'detallecorreccion' => 'Detallecorreccion',
                    'sincronizado' => 'Sincronizado',
                    'usuarioconfirmacion' => 'Usuarioconfirmacion',
                    'gestionschemaactive' => 'Gestionschemaactive',
                    'gestionschemanota' => 'Gestionschemanota',
                    'gestionschemaasientointegrado' => 'Gestionschemaasientointegrado',
                    'usuariofinalizacion' => 'Usuariofinalizacion',
                    'fechafinalizacion' => 'Fechafinalizacion',
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
		$criteria->addSearchCondition('t.observacion',$this->observacion,true,'AND','ILIKE');
		$criteria->compare('t.idcotizacion',$this->idcotizacion);
		$criteria->compare('t.idestado',$this->idestado);
		$criteria->addSearchCondition('t.motivoestado',$this->motivoestado,true,'AND','ILIKE');
		 if ($this->fechaestado != Null) {
		$criteria->addCondition("t.fechaestado::date = '" . $this->fechaestado. "'");
		 }
		$criteria->addSearchCondition('t.usuarioestado',$this->usuarioestado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.total',$this->total,true,'AND','ILIKE');
		$criteria->compare('t.idproveedor',$this->idproveedor);
		$criteria->addSearchCondition('t.acuenta',$this->acuenta,true,'AND','ILIKE');
		$criteria->compare('t.idmedio',$this->idmedio);
		$criteria->compare('t.idformapago',$this->idformapago);
		$criteria->compare('t.idsolicitud',$this->idsolicitud);
		$criteria->compare('t.idtipocompra',$this->idtipocompra);
		$criteria->addSearchCondition('t.iva',$this->iva,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.it',$this->it,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.iue',$this->iue,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.numerofactura',$this->numerofactura,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.codcontrol',$this->codcontrol,true,'AND','ILIKE');
		$criteria->compare('t.idmotivoanulacion',$this->idmotivoanulacion);
		$criteria->compare('t.idnotaborrador',$this->idnotaborrador);
		$criteria->compare('t.idnota',$this->idnota);
		$criteria->addSearchCondition('t.observacioncontrol',$this->observacioncontrol,true,'AND','ILIKE');
		$criteria->compare('t.aprobado',$this->aprobado);
		 if ($this->fechacontrol != Null) {
		$criteria->addCondition("t.fechacontrol::date = '" . $this->fechacontrol. "'");
		 }
		$criteria->addSearchCondition('t.usuariocontrol',$this->usuariocontrol,true,'AND','ILIKE');
		 if ($this->fechamuestra != Null) {
		$criteria->addCondition("t.fechamuestra::date = '" . $this->fechamuestra. "'");
		 }
		$criteria->addSearchCondition('t.usuariomuestra',$this->usuariomuestra,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.liquidototal',$this->liquidototal,true,'AND','ILIKE');
		$criteria->compare('t.compradirecta',$this->compradirecta);
		$criteria->compare('t.idtipoadquisicion',$this->idtipoadquisicion);
		$criteria->addSearchCondition('t.areasolicitante',$this->areasolicitante,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.destino',$this->destino,true,'AND','ILIKE');
		$criteria->compare('t.comprasnormales',$this->comprasnormales);
		$criteria->compare('t.retencionempresa',$this->retencionempresa);
		$criteria->addSearchCondition('t.totalflete',$this->totalflete,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.liquidoflete',$this->liquidoflete,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.gastoadicional',$this->gastoadicional,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.costoadicional',$this->costoadicional,true,'AND','ILIKE');
		$criteria->compare('t.ingreso',$this->ingreso);
		$criteria->addSearchCondition('t.pagoproveedor',$this->pagoproveedor,true,'AND','ILIKE');
		$criteria->compare('t.pagoanticipado',$this->pagoanticipado);
		$criteria->addSearchCondition('t.montopagado',$this->montopagado,true,'AND','ILIKE');
		$criteria->compare('t.idasientointegrado',$this->idasientointegrado);
		$criteria->addSearchCondition('t.montofletepagado',$this->montofletepagado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.montogastoadicionalpagado',$this->montogastoadicionalpagado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuariorecepcion',$this->usuariorecepcion,true,'AND','ILIKE');
		 if ($this->fecharecepcion != Null) {
		$criteria->addCondition("t.fecharecepcion::date = '" . $this->fecharecepcion. "'");
		 }
		$criteria->compare('t.idordendiferido',$this->idordendiferido);
		$criteria->compare('t.numeroentrega',$this->numeroentrega);
		$criteria->compare('t.idalmacen',$this->idalmacen);
		$criteria->addSearchCondition('t.responsable',$this->responsable,true,'AND','ILIKE');
		$criteria->compare('t.idcuenta',$this->idcuenta);
		$criteria->addSearchCondition('t.fechalimite',$this->fechalimite,true,'AND','ILIKE');
		$criteria->compare('t.pagarporpedidoacordado',$this->pagarporpedidoacordado);
		$criteria->compare('t.idmoneda',$this->idmoneda);
		$criteria->addSearchCondition('t.tipocambio',$this->tipocambio,true,'AND','ILIKE');
		$criteria->compare('t.duracion',$this->duracion);
		$criteria->addSearchCondition('t.calificacion',$this->calificacion,true,'AND','ILIKE');
		 if ($this->fechacierre != Null) {
		$criteria->addCondition("t.fechacierre::date = '" . $this->fechacierre. "'");
		 }
		$criteria->addSearchCondition('t.observacioncomprador',$this->observacioncomprador,true,'AND','ILIKE');
		 if ($this->fechaconfirmacion != Null) {
		$criteria->addCondition("t.fechaconfirmacion::date = '" . $this->fechaconfirmacion. "'");
		 }
		$criteria->addSearchCondition('t.usuarioingresoinicial',$this->usuarioingresoinicial,true,'AND','ILIKE');
		 if ($this->fechaingresoinicial != Null) {
		$criteria->addCondition("t.fechaingresoinicial::date = '" . $this->fechaingresoinicial. "'");
		 }
		$criteria->addSearchCondition('t.cambios',$this->cambios,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechafactura',$this->fechafactura,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.detallecorreccion',$this->detallecorreccion,true,'AND','ILIKE');
		$criteria->compare('t.sincronizado',$this->sincronizado);
		$criteria->addSearchCondition('t.usuarioconfirmacion',$this->usuarioconfirmacion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.gestionschemaactive',$this->gestionschemaactive,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.gestionschemanota',$this->gestionschemanota,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.gestionschemaasientointegrado',$this->gestionschemaasientointegrado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuariofinalizacion',$this->usuariofinalizacion,true,'AND','ILIKE');
		 if ($this->fechafinalizacion != Null) {
		$criteria->addCondition("t.fechafinalizacion::date = '" . $this->fechafinalizacion. "'");
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
     * @return FtblCompraOrden the static model class
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
		$this->observacion=strtoupper($this->observacion);
		$this->motivoestado=strtoupper($this->motivoestado);
		$this->usuarioestado=strtoupper($this->usuarioestado);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->codcontrol=strtoupper($this->codcontrol);
		$this->observacioncontrol=strtoupper($this->observacioncontrol);
		$this->usuariocontrol=strtoupper($this->usuariocontrol);
		$this->usuariomuestra=strtoupper($this->usuariomuestra);
		$this->areasolicitante=strtoupper($this->areasolicitante);
		$this->destino=strtoupper($this->destino);
		$this->usuariorecepcion=strtoupper($this->usuariorecepcion);
		$this->responsable=strtoupper($this->responsable);
		$this->calificacion=strtoupper($this->calificacion);
		$this->observacioncomprador=strtoupper($this->observacioncomprador);
		$this->usuarioingresoinicial=strtoupper($this->usuarioingresoinicial);
		$this->usuarioconfirmacion=strtoupper($this->usuarioconfirmacion);
		$this->gestionschemaactive=strtoupper($this->gestionschemaactive);
		$this->gestionschemanota=strtoupper($this->gestionschemanota);
		$this->gestionschemaasientointegrado=strtoupper($this->gestionschemaasientointegrado);
		$this->usuariofinalizacion=strtoupper($this->usuariofinalizacion);
        return parent::beforeSave();            
    }


}
