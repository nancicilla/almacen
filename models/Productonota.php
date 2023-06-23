<?php

/*
 * Productonota.php
 *
 * Version 0.$Rev: 1129 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2023-03-03 09:27:03 -0400 (Fri, 03 Mar 2023) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
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
 * @property string ingresoimporte
 * @property string salidaimporte
 * @property string saldoimporte
 *
 * The followings are the available model relations:
 * @property Producto $idproducto0
 * @property Nota $idnota0
 */

class Productonota extends CActiveRecord {

    public $notaNumero; //número de nota a la cual corresponde el movimiento
    public $fechaInicio; //busqueda entre rangos
    public $fechaFin; //busqueda entre rangos
    public $nombreProducto; //nombre del producto que corresponde al movimiento
    public $nombreCompletoProducto; //variable auxiliar que almacen el nombre del
    //completo del producto
    public $notaTipo; // tipo de nota al que corresponde el movimiento
    public $idalmacen;
    public $precioPromedioPonderado;
    public $codigo;
    public $nombre;
    public $cantidad;    
    public $producto;
    public $idalmacenValorado;
    public $productoValorado;
    public $idtipomov;
    public $idorigen;
    public $nameView;

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }

    public function primaryKey() {
        //IMPORTANTE! en este orden se obtienen los ids en $keyvalue de 
        //la extension.
        return array('id');
    }

    public function init() {
        $this->idproducto = -1;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'productonota';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ingreso, salida, ingresoimporte, salidaimporte', 'required', 'on' => array('cambiarMovimiento')),
            array('nombreProducto', 'required', 'on' => 'search'),
            array('fecha', 'type', 'type' => 'date', 'message' => 'Fecha no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'except' => array('cambiarMovimiento')),
            array('notaNumero', 'numerical', 'integerOnly' => true, 'message' => 'El Nº de nota debe ser un número entero.'),
            array('idproducto, idnota', 'numerical', 'integerOnly' => true),
            array('idproducto', 'required', 'on' => array('insert', 'update')),
//            array('costo, ingreso, salida, saldo', 'numerical', 'integerOnly' => false),
            array('fechaFin', 'compareDateRange', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
            array('fechaInicio', 'type', 'type' => 'date', 'message' => 'Fecha inicio no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
            array('fechaFin', 'type', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
            array('fechaFin,fechaInicio', 'required', 'on' => 'checked'),
            array('idproducto,glosa,idnota', 'safe'),
            array('costo, ingreso, salida, saldo, eliminado, cantidad', 'safe'),
            array('nombreProducto,codigoProducto,nombreCompletadoProducto,idproductonota', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('glosa, costo,  ingreso, salida, saldo, fecha,'
                . 'notaNumero,notaTipo,fechaInicio,fechaFin,'
                . ' eliminado, idproducto, idnota', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            'idnota0' => array(self::BELONGS_TO, 'Nota', 'idnota'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
            'nombreProducto' => 'Producto',
            'fechaInicio' => 'Fecha desde',
            'fechaFin' => 'Fecha hasta',
            'glosa' => 'Descripción',
            'ingresoimporte' => 'Debe',
            'salidaimporte' => 'Haber',
            'saldoimporte' => 'Saldo',
            'precioPromedioPonderado' => 'Precio'
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
    public function search() {

        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0', 'idnota0.idtipo0');

        if ($this->validate()) {
            Yii::app()->session['mostrarReporteKardex'] = true;
            $criteria->compare('costo', $this->costo);
            $criteria->compare('ingreso', $this->ingreso);
            $criteria->compare('salida', $this->salida);
            $criteria->compare('saldo', $this->saldo);
            if ($this->fecha != Null) {
                $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
            }

            $criteria->compare('idalmacen', $this->idalmacen);

            if ($this->notaNumero != Null) {
                $criteria->addCondition("numero = " . (int) $this->notaNumero . "");
            }

            if ($this->notaTipo != Null) {
                $criteria->addCondition("idtipo0.nombre ilike '%" . $this->notaTipo . "%'");
            }

            if ($this->glosa != Null) {
                $criteria->addCondition("t.glosa ilike '%" . $this->glosa . "%'");
            }

            if ($this->fechaInicio != Null) {
                if ($this->fechaFin == Null) {
                    $this->fechaFin = new CDbExpression('NOW()');
                }
                $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaInicio' AND '$this->fechaFin'");
            }

            $criteria->compare('idnota', $this->idnota);
            $criteria->compare('idproducto', $this->idproducto);
        } else {
            Yii::app()->session['mostrarReporteKardex'] = false;
            $criteria->compare('idnota', -10);
        }
        Yii::app()->session['productonotaReporteKardex'] = $criteria;
        Yii::app()->session['productonotaKardexfechaInicio'] = $this->fechaInicio;
        Yii::app()->session['productonotaKardexfechaFin'] = $this->fechaFin;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.fecha asc',
                'attributes' => array(
                    'notaNumero' => array(
                        'asc' => 'idnota0.numero',
                        'desc' => 'idnota0.numero DESC',
                    ),
                    'notaTipo' => array(
                        'asc' => 'idtipo0.nombre',
                        'desc' => 'idtipo0.nombre DESC',
                    ),
                    '*',
                ),
            ),
                )
        );
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Productonota the static model class
     */
    public static function model($className = __CLASS__) {
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
        
        if(
            $this->scenario=='correccionsistema'
          )
        {
            $this->glosa = strtoupper($this->glosa);       
            return parent::beforeSave();
        }
        
        
        $this->glosa = strtoupper($this->glosa);
        
        if($this->scenario != 'cambiarMovimiento')
            $this->fecha = new CDbExpression('NOW()');
        
        $this->usuario = Yii::app()->user->getName();
        if (isset(Yii::app()->session['var']))
            $this->usuario = Yii::app()->session['var'];
        else
            $this->usuario = Yii::app()->user->getName();
        return parent::beforeSave();
    }

    /**
     *
     * Sirve para comparar un rango de fechas, verifica que la fecha posterior
     * sea mayor a la fecha inicial, de no ser asi, se añade un error
     * 
     */
    public function compareDateRange($attribute, $params) {
        if (!empty($this->fechaFin)) {
            if (strtotime($this->fechaFin) < strtotime($this->fechaInicio)) {
                $this->addError($attribute, 'Fecha fin no puede ser menor a la fecha de inicio.');
            }
        }
    }

    /**
     * Función para registrar y/o actualizar productos de la preventa
     * La función sigue la lógica de recorrer el array de productos
     * para luego setear el valor y guardarlo en la base de datos.
     * @param type $idnota id del registro de de la venta.
     * @param type $productonota array con los valores de productos.
     * @throws CrugeException
     */
    public function registrarProductoNota($arrayParametros)
    {
        $idnota = $arrayParametros['idnota'];
        $productonota = $arrayParametros['productonota'];
        $tipo = $arrayParametros['tipo'];
        $causa = $arrayParametros['causa'];
        $numero = $arrayParametros['numero'];
        $idtipo = $arrayParametros['idtipo'];
        $idtipodocumento = $arrayParametros['idtipodocumento'];
        $postNota = $arrayParametros['postNota'];
        
        $modelo = new Productonota();
        if ($idnota != Null && isset($modelo) && isset($productonota)) {
            $modelo->attributes = $productonota;
            $modelo->idnota = $idnota;
            $cantidad = count($productonota);
            
            for ($i = 1; $i <= $cantidad; $i++)
            {
                $glosaanterior = $productonota[$i]['glosa']==null? ' - ':' - '.$productonota[$i]['glosa'];
                $glosaParcial = $causa . ', ' . $tipo.$glosaanterior;

                if ($idtipo == Tipo::model()->INGRESO) {
                    $modelo->glosa = 'INGRESO POR ' . $glosaParcial;
                    $modelo->ingreso = $productonota[$i]['cantidad'];
                    $modelo->salida = 0;
                } else {
                    $modelo->glosa = 'SALIDA POR ' . $glosaParcial;
                    $modelo->salida = $productonota[$i]['cantidad'];
                    $modelo->ingreso = 0;
                }
                $cantidadInsumo = $productonota[$i]['cantidad'];

                if($postNota['costovariable'])
                    if($productonota[$i]['costo'] > 0 && $productonota[$i]['costo'] != $productonota[$i]['costoHidden'])
                    {
                        $modelo->costo = $productonota[$i]['costo'];
                        $modelo->importefijo = true;                          
                    }

                if ($productonota[$i]['idproducto'] != Null) {
                    $modelo->idproducto = $productonota[$i]['idproducto'];

                    // Modificacion
                    $modeloProducto = Producto::model()->findByPk($modelo->idproducto);
                    $saldoProducto = $modeloProducto->saldo;                    
                        if ($modeloProducto->saldo==0 || $modeloProducto->saldoimporte==0)
                            $ppp = $modeloProducto->ultimoppp;
                        else
                            $ppp=$modeloProducto->saldoimporte/$modeloProducto->saldo;
                    $SalidaIngresoImporte = $ppp * $cantidadInsumo;
                    if($postNota['costovariable'])
                        $SalidaIngresoImporte = $modelo->costo * $productonota[$i]['cantidad'];

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
                        $modelo->saldoimporte = $modeloProducto->saldoimporte - $modelo->salidaimporte;
                    }
                    $modeloProducto->saldo = $modelo->saldo;
                    $modeloProducto->saldoimporte = $modelo->saldoimporte;

                    $this->actualizarProductos($modeloProducto);
                    if ($modelo->save()) {
                        $modelo = new Productonota;
                        $modelo->attributes = $productonota;
                        $modelo->idnota = $idnota;
                    }
                }
            }
        } else {
            echo 'Error al registrar productos en la nota.';
        }
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
            
            for ($i = 1; $i <= $cantidad; $i++) {
                $modelo = new Productonota();
                $modelo->idnota = $idnota;
                $itemProducto=$productonota[$i];
                
                $dato=$itemProducto['cantidad'];
                if ($idtipo == Tipo::model()->INGRESO) {
                    $nota->glosa="TRASPASO ENTRE ALMACENES - ".$glosa;//. ' - NOTA Nº ' . $numeroNota;
                    //$modelo->glosa = 'INGRESO POR ' . $glosaParcial;
                    $modelo->ingreso = $dato;
                    $modelo->salida = 0;
                } else {
                    $modelo->glosa="TRASPASO ENTRE ALMACENES - ".$glosa;//. ' - NOTA Nº ' . $numeroNota;
                    //$modelo->glosa = 'SALIDA POR ' . $glosaParcial;
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
                    if ($idtipodocumento==17){
                        $ppp = $modeloProducto->precio;
                    }
                    else{ 
                        if ($modeloProducto->saldo==0 || $modeloProducto->saldoimporte==0){
                             $ppp = $modeloProducto->ultimoppp;
                        }
                        else{
                            $ppp=$modeloProducto->saldoimporte/$modeloProducto->saldo;
                        }
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
                        $modelo = new Productonota;
                        $modelo->attributes = $productonota;
                        $modelo->idnota = $idnota;
                    }
                }
                
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
    public function searchValorado() {

        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0', 'idnota0.idtipo0');

        if ($this->validate()) {
            Yii::app()->session['mostrarReporteKardexValorado'] = true;
            $criteria->compare('costo', $this->costo);
            $criteria->compare('ingreso', $this->ingreso);
            $criteria->compare('salida', $this->salida);
            $criteria->compare('saldo', $this->saldo);
            if ($this->fecha != Null) {
                $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
            }

            $criteria->compare('idalmacen', $this->idalmacen);

            if ($this->notaNumero != Null) {
                $criteria->addCondition("numero = " . (int) $this->notaNumero . "");
            }

            if ($this->notaTipo != Null) {
                $criteria->addCondition("idtipo0.nombre ilike '%" . $this->notaTipo . "%'");
            }

            if ($this->glosa != Null) {
                $criteria->addCondition("t.glosa ilike '%" . $this->glosa . "%'");
            }

            if ($this->fechaInicio != Null) {
                if ($this->fechaFin == Null) {
                    $this->fechaFin = new CDbExpression('NOW()');
                }
                $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaInicio' AND '$this->fechaFin'");
            }

            $criteria->compare('idnota', $this->idnota);
            $criteria->compare('idproducto', $this->idproducto);
        } else {
            Yii::app()->session['mostrarReporteKardexValorado'] = false;
            $criteria->compare('idnota', -10);
        }
        Yii::app()->session['productonotaReporteKardexValorado'] = $criteria;
        Yii::app()->session['productonotaKardexValoradofechaInicio'] = $this->fechaInicio;
        Yii::app()->session['productonotaKardexValoradofechaFin'] = $this->fechaFin;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 't.fecha asc',
                'attributes' => array(
                    'notaNumero' => array(
                        'asc' => 'idnota0.numero',
                        'desc' => 'idnota0.numero DESC',
                    ),
                    'notaTipo' => array(
                        'asc' => 'idtipo0.nombre',
                        'desc' => 'idtipo0.nombre DESC',
                    ),
                    '*',
                ),
            ),
                )
        );
    }
    
    /*
     * Devuelve los productos de nota borrador
     */
    public function obtenerProductoNota($idnota) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, p.codigo, p.nombre';
        $criteria->join = ' inner join producto p on t.idproducto = p.id';
        $criteria->addCondition("t.idnota = " . $idnota);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Carga en un array los productos de una nota
     * @param type $idnota id del registro de la Nota.   
     * @return array detalle de productos.
     */
    public function obtenerProductos($idnota) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.idnota', $idnota);       

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>false
        ));
    }

    /**
     * Funcion que registrar por correccion de cantidad ingreso en nota
     * @param type $nnota
     * @param type $idproducto
     * @param type $idnota
     * @param type $cantidad
     * @param type $usuario
     */
    public function registrarCorreccionCantidadIngreso($nnota, $idproducto, $idnota, $cantidad, $usuario) {
        $model = new Productonota;
        $model->setScenario('correccioncantidad');
        $model->glosa = 'INGRESO POR CORRECCION DE CANTIDAD EN NOTA Nº ' . $nnota;
        $model->costo = 0;
        $modelProducto = Producto::model()->findBySql('select * from producto where id = ' . $idproducto);
        $model->ingreso = $cantidad;
        $model->salida = 0;
        $model->saldo = $modelProducto->saldo + $cantidad;
        $model->idproducto = $idproducto;
        $model->idnota = $idnota;
        $model->ingresoimporte = 0;
        $model->salidaimporte = 0;
        $saldoimporteanterior = $modelProducto->saldoimporte;
        $model->saldoimporte = $saldoimporteanterior;
        $model->usuario = $usuario;
        $modelProducto->setScenario('actualizarsaldo');
        $modelProducto->saldo = $model->saldo;
        if ($model->save()) {
            $modelProducto->save();
            return true;
        } else
            return false;
    }

    /**
     * Funcion que registrar por correccion de cantidad salida en nota
     * @param type $nnota
     * @param type $idproducto
     * @param type $idnota
     * @param type $cantidad
     * @param type $usuario
     */
    public function registrarCorreccionCantidadSalida($nnota, $idproducto, $idnota, $cantidad, $usuario) {
        $model = new Productonota;
        $model->setScenario('correccioncantidad');
        $model->glosa = 'SALIDA POR CORRECCION DE CANTIDAD EN NOTA Nº ' . $nnota;
        $model->costo = 0;
        $modelProducto = Producto::model()->findBySql('select * from producto where id = ' . $idproducto);
        $model->ingreso = 0;
        $model->salida = abs($cantidad);
        $model->saldo = $modelProducto->saldo - abs($cantidad);
        $model->idproducto = $idproducto;
        $model->idnota = $idnota;
        $model->ingresoimporte = 0;
        $model->salidaimporte = 0;
        $saldoimporteanterior = $modelProducto->saldoimporte;
        $model->saldoimporte = $saldoimporteanterior;
        $model->usuario = $usuario;
        $modelProducto->setScenario('actualizarsaldo');
        $modelProducto->saldo = $model->saldo;
        if ($model->save()) {
            $modelProducto->save();
            return true;
        } else
            return false;
    }
    
    /*
     * Obtiene producto nota de un determinado producto
     */
    public function getProductoNota($idproducto, $fechaInicio, $fechaFin, $movimiento, $origen)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        
        if($fechaInicio == "")
        {
            $fechaInicioGestion = Gestion::model()->getGestionInicio();
            $fechaInicio = $fechaInicioGestion;
        }
        if($fechaFin == "")
        {
            $fechaFinGestion = Gestion::model()->getGestionFin();
            $fechaFin = $fechaFinGestion;
        }
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("t.fecha::date BETWEEN ' $fechaInicio' AND ' $fechaFin ' ");
        if ($movimiento!=''){
            $criteria->addCondition("idnota0.idtipo =".$movimiento);
        }
        if ($origen!=''){
            $criteria->addCondition("idnota0.idorigen =".$origen);
        } 
        Yii::app()->session['sesionProductoNotaKardexYKardexValorado'] = $criteria;
        
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.fecha asc,t.idnota,t.id asc',
            ),
        ));
    }
    
    public function getProductoNotaDetallado($idproducto, $fechaInicio, $fechaFin, $movimiento)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        
        if($fechaInicio == "")
        {
            $fechaInicioGestion = Gestion::model()->getGestionInicio();
            $fechaInicio = $fechaInicioGestion;
        }
        if($fechaFin == "")
        {
            $fechaFinGestion = Gestion::model()->getGestionFin();
            $fechaFin = $fechaFinGestion;
        }
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("t.fecha::date BETWEEN ' $fechaInicio' AND ' $fechaFin ' ");
        if ($movimiento!=''){
            $criteria->addCondition("idnota0.idtipo =".$movimiento);
        }
        $criteria->order = "t.fecha asc,t.idnota,t.id asc";
        Yii::app()->session['sesionProductoNotaKardexYKardexValorado'] = $criteria;
        
        $modelProductonota = Productonota::findAll($criteria);
        $productonota = array();
        $saldoimporteCorrecto = 0;
        $i = 0;
        foreach($modelProductonota as $dato)
        {
            $ingreso = $dato->ingreso;
            $salida = $dato->salida;
            $debe = $dato->ingresoimporte;
            $haber = $dato->salidaimporte;
            if($i == 0)
            {
                if($ingreso > 0)
                    $saldocorrectoCantidad = $ingreso;
                else
                    $saldocorrectoCantidad = $salida;
                if($debe > 0)
                    $saldoimporteCorrecto = $debe;
                else
                    $saldoimporteCorrecto = $haber;
            }
            else
            {
                if($ingreso > 0)
                    $saldocorrectoCantidad = $saldocorrectoCantidad + $ingreso;
                else
                    $saldocorrectoCantidad = $saldocorrectoCantidad - $salida;
                
                if($debe > 0)
                    $saldoimporteCorrecto = $saldoimporteCorrecto + $debe;
                if($haber > 0)
                    $saldoimporteCorrecto = $saldoimporteCorrecto - $haber;
            }
            $saldocorrectoCantidad = number_format((float)$saldocorrectoCantidad, 4, '.', '');
            if($saldocorrectoCantidad == $dato->saldo)
                $saldocorrectoCantidad = $dato->saldo;
            
            $saldoimporteCorrecto = number_format((float)$saldoimporteCorrecto, 2, '.', '');
            if($saldoimporteCorrecto == $dato->saldoimporte)
                $saldoimporteCorrecto = $dato->saldoimporte;
            
            $precioPromedioPonderado = $dato->saldo == 0?
                (($dato->ingreso - $dato->salida) != 0 ?
                ($dato->ingresoimporte - $dato->salidaimporte)/($dato->ingreso - $dato->salida) : null) : 
                ($dato->saldo > 0? $dato->saldoimporte/$dato->saldo : null);

            $productonota[] = array(
                'id' => $dato->id,
                'idnota' => $dato->idnota,
                'fecha' => date('d-m-Y H:i:s', strtotime($dato->fecha)),
                'numero' => $dato->idnota0->numero,
                'glosa' => $dato->glosa,
                'tipo' => $dato->idnota0->idtipo == Tipo::model()->INGRESO? "ING.":"SAL.",
                'ingreso' => $dato->ingreso,
                'salida' => $dato->salida,
                'saldo' => $dato->saldo,
                'saldoCantidadCorrecto' => $saldocorrectoCantidad,
                'ingresoimporte' => $dato->ingresoimporte,
                'salidaimporte' => $dato->salidaimporte,
                'saldoimporte' => $dato->saldoimporte,
                'saldoImporteCorrecto' => $saldoimporteCorrecto,
                'precioPromedioPonderado' => number_format((float)$precioPromedioPonderado, 4, '.', ''),
            );
            $i++;
        }
        return $productonota;
    }
    
    /*
     * Devuelve la cantidad de errores de "saldo cantidad" o "saldo importe" 
     */
    public function movimientoProducto($idproducto)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->order = "t.fecha asc,idnota0.numero,t.id asc";
        
        $modelProductonota = Productonota::findAll($criteria);
        $saldoimporteCorrecto = 0;
        $i = 0;
        $contadorSaldoCantidadError = 0;
        $contadorSaldoCantidadNegativos = 0;
        $contadorSaldoImporteError = 0;
        $contadorSaldoImporteNegativos = 0;
        
        foreach($modelProductonota as $dato)
        {
            $ingreso = $dato->ingreso;
            $salida = $dato->salida;
            $debe = $dato->ingresoimporte;
            $haber = $dato->salidaimporte;
            if($i == 0)
            {
                $saldoImporte = null;
                if($ingreso > 0)
                    $saldocorrectoCantidad = $ingreso;
                else
                    $saldocorrectoCantidad = $salida;
                if($debe > 0)
                    $saldoimporteCorrecto = $debe;
                else
                    $saldoimporteCorrecto = $haber;
            }
            else
            {
                if($ingreso > 0)
                    $saldocorrectoCantidad = $saldocorrectoCantidad + $ingreso;
                else
                    $saldocorrectoCantidad = $saldocorrectoCantidad - $salida;
                
                if($debe > 0)
                    $saldoimporteCorrecto = $saldoimporteCorrecto + $debe;
                else
                    $saldoimporteCorrecto = $saldoimporteCorrecto - $haber;
            }
            $saldocorrectoCantidad = number_format((float)$saldocorrectoCantidad, 4, '.', '');
            if($saldocorrectoCantidad == $dato->saldo)
            {
                if($saldocorrectoCantidad < 0)
                    $contadorSaldoCantidadNegativos++;
            }
            else
                $contadorSaldoCantidadError++;

            $saldoimporteCorrecto = number_format((float)$saldoimporteCorrecto, 2, '.', '');
            $saldoImporte = $dato->saldoimporte;
            if($saldoimporteCorrecto == $dato->saldoimporte)
            {
                if($saldoimporteCorrecto < 0)
                    $contadorSaldoImporteNegativos++;
            }
            else
                $contadorSaldoImporteError++;

            $i++;
        }
        
        return array(
            'saldoImporte' => $saldoImporte,
            'contadorSaldoCantidadError' => $contadorSaldoCantidadError,
            'contadorSaldoCantidadNegativos' => $contadorSaldoCantidadNegativos,
            'contadorSaldoImporteError' => $contadorSaldoImporteError,
            'contadorSaldoImporteNegativos' => $contadorSaldoImporteNegativos,
        );
    }
   
    public function registrarProductoNota_TraspasoEntreAlmacenesTpv($idnota, $productonota, $numeroNota, $idtipo,$idtipodocumento,$glosa) {
        if ($idnota != Null &&  isset($productonota)) {
            $cantidad = count($productonota);
            for ($i = 1; $i <= $cantidad; $i++) {
                $modelo = new Productonota;
                $modelo->idnota = $idnota;
                $itemProducto=$productonota[$i];
                $dato=$itemProducto['cantidadenviada'];
                if ($dato>0){
                    if ($idtipo == Tipo::model()->INGRESO) {
                        $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                        $modelo->ingreso = $dato;
                        $modelo->salida = 0;
                    } else {
                        $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                        $modelo->salida = $dato;
                        $modelo->ingreso = 0;
                    }
                    $cantidadInsumo = $dato;
                    $dato=$itemProducto['idproducto'];
                    if ($dato != Null) {
                        $modelo->idproducto = $dato;
                        $modeloProducto = Producto::model()->findByPk($modelo->idproducto);
                        $saldoProducto = $modeloProducto->saldo;
                        if ($modeloProducto->saldo==0 || $modeloProducto->saldoimporte==0){
                             $ppp = $modeloProducto->ultimoppp;
                        }
                        else{
                            $ppp=$modeloProducto->saldoimporte/$modeloProducto->saldo;
                        }
                        $SalidaIngresoImporte = $ppp * $cantidadInsumo;

    //                    $costo = $modeloProducto->costo;
    //                    $ultimoppp = $modeloProducto->ultimoppp;
    //                    if($costo == 0 || $costo == null)
    //                    {
    //                        if (($modeloProducto->saldo <= 0 || $modeloProducto->saldo == null) || 
    //                            ($modeloProducto->saldoimporte <= 0 || $modeloProducto->saldoimporte == null)) {
    //                            $SalidaIngresoImporte = $ultimoppp * round($cantidadInsumo, 4);
    //                        } else {
    //                            $SalidaIngresoImporte = ($modeloProducto->saldoimporte / $modeloProducto->saldo) * round($cantidadInsumo, 4);
    //                        }
    //                    } else {
    //                        $SalidaIngresoImporte = $costo * round($cantidadInsumo, 4);
    //                    }

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
                            $modelo = new Productonota;
                            $modelo->attributes = $productonota;
                            $modelo->idnota = $idnota;
                        }else {
                            print_r($modelo->getErrors());
                            echo System::hasErrors('productonota error');
                            return;
                        }
                    }
                }
            }
        } else {
            echo 'Error al registrar productos en la nota.';
            return;
        }
    }
    
    public function registrarProductoNota_DevolucionEntreAlmacenesTpv($idnota, $productonota, $numeroNota, $idtipo, $idtipodocumento, $glosa, $model) {
        if($idnota != Null && isset($productonota)) {
            $cantidad = count($productonota);
            for ($i = 1; $i <= $cantidad; $i++) {
                $cantidadInsumo = $productonota[$i]['cantidaddevolucion'];
                $modelo = new Productonota();
                $modelo->idnota = $idnota;
                $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                $modeloProductoDestino = Producto::model()->find("codigo = '".$productonota[$i]['codigo']."' AND idalmacen = ".$model->idalmacendestino);
                $modelo->idproducto = $modeloProductoDestino->id;
                $precio = $modeloProductoDestino->precio;
                $modelo->costo = $precio;
                if($idtipo == Tipo::model()->INGRESO) {
                    $modelo->ingreso = $cantidadInsumo;
                    $modelo->salida = 0;
                }
                
//                $modeloProducto = Producto::model()->find('id='.$productonota[$i]['idproducto']);
                $modeloProducto = Producto::model()->find("codigo = '".$productonota[$i]['codigo']."' AND idalmacen = ".$model->idalmacendestino);
//                print_r($modeloProducto);
//                $modeloProductoDestino = Producto::model()->find("codigo = '".$modeloProducto->codigo."' AND idalmacen = ".$model->idalmacendestino);
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
    
    public function registrarProductoNota_SalidaOrdentrabajo($idnota, $productonota, $numeroNota, $idtipo,$idtipodocumento,$glosa) {
        if ($idnota != Null &&  isset($productonota)) {
            $cantidad = count($productonota);
            for ($i = 0; $i < $cantidad; $i++) {
                $modelo = new Productonota;
                $modelo->idnota = $idnota;
                $itemProducto=$productonota[$i];
                $dato=$itemProducto['cantidad'];
                if ($idtipo == Tipo::model()->INGRESO) {
                    $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                    $modelo->ingreso = $dato;
                    $modelo->salida = 0;
                } else {
                    $modelo->glosa=$glosa;//." - Nota Nro.".$numeroNota;
                    $modelo->salida = $dato;
                    $modelo->ingreso = 0;
                }
                $cantidadInsumo = $dato;
                $dato=$itemProducto['id'];
                if ($dato != Null) {
                    $modelo->idproducto = $dato;
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
                        $modelo = new Productonota;
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
    
    public function obtenerDiferenciasIntegrado($fechaFin) {
        $command = Yii::app()->almacen->createCommand('select 
            p.id,a.nombre as almacen,p.codigo,p.nombre as producto,sum(pn.ingreso)
            -sum(pn.salida) as saldocantidad,sum(pn.ingresoimporte)-sum(pn.salidaimporte)
            as saldoimporte,z.saldocantidadintegrado,z.saldoimporteintegrado,
            (select "'.getGestionSchema().'".obtener_negativo(p.id,\''.$fechaFin.'\')) as observacion,p.precio
            from producto p inner join "'.getGestionSchema().'".productonota pn on p.id = pn.idproducto
            inner join almacen a on a.id = p.idalmacen left join 
            (select x.idproducto,sum(x.ingreso)-sum(x.salida)
            as saldocantidadintegrado,sum(x.ingresoimporte)-sum(x.salidaimporte)
            as saldoimporteintegrado
            from "'.getGestionSchema().'".ftbl_fiscal_productonota x
            where x.fecha::date <= \''.$fechaFin.'\'::date and x.eliminado is false
            group by x.idproducto) z on z.idproducto=p.id
            where pn.fecha::date <= \''.$fechaFin.'\'::date and pn.eliminado is false
            group by p.id,a.id,z.saldocantidadintegrado,z.saldoimporteintegrado
            order by p.codigo');
        return $command->queryAll();
    }
}
