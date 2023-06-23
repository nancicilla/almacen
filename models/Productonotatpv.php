<?php
/*
 * Productonotatpv.php
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
 
 * This is the model class for table "productonota".
 *
 * The followings are the available columns in table 'productonota':
 * @property string $glosa
 * @property string $costo
 * @property string $ingreso
 * @property string $salida
 * @property string $saldo
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idproducto
 * @property integer $idnota
 * @property string $usuario
 * @property string $id
 * @property string $ingresoimporte
 * @property string $salidaimporte
 * @property string $saldoimporte
 */
class Productonotatpv extends CActiveRecord
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
            return 'productonota';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idproducto, idnota', 'required'),
                    array('idproducto, idnota', 'numerical', 'integerOnly'=>true),
                    array('costo, ingreso, salida, saldo', 'length', 'max'=>14),
                    array('usuario', 'length', 'max'=>30),
                    array('ingresoimporte, salidaimporte, saldoimporte', 'length', 'max'=>15),
                    array('glosa, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('glosa, costo, ingreso, salida, saldo, fecha, eliminado, idproducto, idnota, usuario, id, ingresoimporte, salidaimporte, saldoimporte', 'safe', 'on'=>'search'),
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
                    'glosa' => 'Glosa',
                    'costo' => 'Costo',
                    'ingreso' => 'Ingreso',
                    'salida' => 'Salida',
                    'saldo' => 'Saldo',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idproducto' => 'Idproducto',
                    'idnota' => 'Idnota',
                    'usuario' => 'Usuario',
                    'id' => 'ID',
                    'ingresoimporte' => 'Ingresoimporte',
                    'salidaimporte' => 'Salidaimporte',
                    'saldoimporte' => 'Saldoimporte',
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

		$criteria->addSearchCondition('t.glosa',$this->glosa,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.costo',$this->costo,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.ingreso',$this->ingreso,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.salida',$this->salida,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.saldo',$this->saldo,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idproducto',$this->idproducto);
		$criteria->compare('t.idnota',$this->idnota);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.id',$this->id,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.ingresoimporte',$this->ingresoimporte,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.salidaimporte',$this->salidaimporte,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.saldoimporte',$this->saldoimporte,true,'AND','ILIKE');

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
     * @return Productonotatpv the static model class
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
        return parent::beforeSave();            
    }

    /**
     * Función para registrar y/o actualizar productos de la preventa
     * La función sigue la lógica de recorrer el array de productos
     * para luego setear el valor y guardarlo en la base de datos.
     * @param type $idnota id del registro de de la venta.
     * @param type $productonota array con los valores de productos.
     * @param integer $numeroNota
     * @param integer $idtipo
     * @param integer $idtipodocumento
     * @param string $glosa
     * @throws CrugeException
     */
    public function registrarProductoNota_TraspasoEntreAlmacenes($idnota, $productonota, $numeroNota, $idtipo,$idtipodocumento,$glosa) {
        if ($idnota != Null &&  isset($productonota)) {
            $cantidad = count($productonota);
            for ($i = 0; $i < $cantidad; $i++) {
                $modelo = new Productonotatpv;
                $modelo->idnota = $idnota;
                $itemProducto=$productonota[$i];
                $dato=$itemProducto['cantidadenviada'];
                if ($idtipo == Tipo::model()->INGRESO) {
                    $modelo->glosa=$glosa." - Nota Nro.".$numeroNota;
                    $modelo->ingreso = $dato;
                    $modelo->salida = 0;
                } else {
                    $modelo->glosa=$glosa." - Nota Nro.".$numeroNota;
                    $modelo->salida = $dato;
                    $modelo->ingreso = 0;
                }
                $cantidadInsumo = $dato;
                $dato=$itemProducto['idproducto'];
                if ($dato != Null) {
                    $modelo->idproducto = $dato;
                    // Modificacion
                    $modeloProducto = Producto::model()->findByPk($modelo->idproducto);
                    $saldoProducto = $modeloProducto->saldo;
                    if ($modeloProducto->saldo==0 || $modeloProducto->saldoimporte==0){
                         $ppp = $modeloProducto->ultimoppp;
                    }
                    else{
                        $ppp=$modeloProducto->saldoimporte/$modeloProducto->saldo;
                    }
                    $SalidaIngresoImporte = $ppp * $cantidadInsumo;
                    if ($idtipo == Tipo::model()->INGRESO) {
                        $modelo->ingresoimporte = $SalidaIngresoImporte;
                        $modelo->salidaimporte = 0;
                        $modelo->saldo = $saldoProducto + $cantidadInsumo;
                        $modelo->saldoimporte = $modeloProducto->saldoimporte + $modelo->ingresoimporte;
                    }
                    if ($idtipo == Tipo::model()->SALIDA) {
                        $modelo->salidaimporte = $SalidaIngresoImporte;
                        $modelo->ingresoimporte = 0;
                        $modelo->saldo = $saldoProducto - $cantidadInsumo;
                        $modelo->saldoimporte = round($modeloProducto->saldoimporte - $modelo->salidaimporte, 2);
                    }
                    $modeloProducto->saldo = $modelo->saldo;
                    $modeloProducto->saldoimporte = $modelo->saldoimporte;
                    $this->actualizarProductos($modeloProducto);
                    if ($modelo->save()) {
                        $modelo = new Productonotatpv;
                        $modelo->attributes = $productonota;
                        $modelo->idnota = $idnota;
                    }else {
                        print_r($modelo->getErrors());
                        echo System::hasErrors('productonota error');
                        return;
                    }
                }
            }
        } else {
            echo 'Error al registrar productos en la nota.';
            return;
        }
    }
    
    public function registrarProductoNota_DevolucionEntreAlmacenes($idnota, $productonota, $numeroNota, $idtipo, $idtipodocumento, $glosa, $model) {
        if($idnota != Null && isset($productonota)) {
            $cantidad = count($productonota);
            for ($i = 1; $i <= $cantidad; $i++) {
                $cantidadInsumo = $productonota[$i]['cantidaddevolucion'];
                $modelo = new Productonotatpv();
                $modelo->idnota = $idnota;
                $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                $modeloProductoDestino = Producto::model()->find("codigo = '".$productonota[$i]['codigo']."' AND idalmacen = ".$model->idalmacenorigen);
                $modelo->idproducto = $modeloProductoDestino->id;
                $precio = Producto::model()->find('id='.$productonota[$i]['idproducto'])->precio;
                $modelo->costo = $precio;
                if($idtipo == Tipo::model()->INGRESO) {
                    $modelo->ingreso = $cantidadInsumo;
                    $modelo->salida = 0;
                }
                
                $modeloProducto = Producto::model()->findByPk($productonota[$i]['idproducto']);
//                print_r($modeloProducto);
                $modeloProductoDestino = Producto::model()->find("codigo = '".$modeloProducto->codigo."' AND idalmacen = ".$model->idalmacendestino);
                $costo = $modeloProducto->costo;
                $ultimoppp = $modeloProducto->ultimoppp;
                if($modeloProductoDestino != null)
                {
                    $costo = $modeloProductoDestino->costo;
                    $ultimoppp = $modeloProductoDestino->ultimoppp;
                }
                $modeloProducto->costo = $costo;
                $modeloProducto->ultimoppp = $ultimoppp;
                
                if ($modeloProducto->saldo==0 || $modeloProducto->saldoimporte==0){
                    $ppp = $modeloProducto->ultimoppp;
                }
                else{
                   $ppp=$modeloProducto->saldoimporte/$modeloProducto->saldo;
                }
                $SalidaIngresoImporte = $ppp * $cantidadInsumo;
                
                $saldoProducto = $modeloProducto->saldo;
                if($idtipo == Tipo::model()->INGRESO) {
                    $modelo->ingresoimporte = $SalidaIngresoImporte;
                    $modelo->salidaimporte = 0;
                    $modelo->saldo = $saldoProducto + $cantidadInsumo;
                    $modelo->saldoimporte = $modeloProducto->saldoimporte + $modelo->salidaimporte;
                }
                $modeloProducto->saldo = $modelo->saldo;
                $modeloProducto->saldoimporte = $modelo->saldoimporte;
                
                $this->actualizarProductos($modeloProducto);
                $modelo->save();
            }
            
        } else {
            echo 'Error al registrar productos en la nota.';
        }
    }
    
    /*
     * Actualiza la tabla producto
     */
    public function actualizarProductos($modeloProducto) {
        $modeloProducto->setScenario('traspaso');
        $modeloProducto->save();
    }

}
