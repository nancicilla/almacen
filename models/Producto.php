<?php

/*
 * Producto.php
 *
 * Version 0.$Rev: 1123 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2022-08-15 15:05:14 -0400 (lun, 15 ago 2022) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $valor
 * @property string $costo
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $idclase
 * @property integer $idfamilia
 * @property integer $idunidad
 * @property string $stockminimo
 * @property string $stockreposicion
 * @property string $stockmaximo
 * @property string $saldo
 * @property integer $idalmacen
 * @property integer $idproductopadre
 * @property integer $idalmacen
 * @property boolean $inventariar
 * @property boolean $lineatabu
 * @property boolean $admitedescuento
 * The followings are the available model relations:
 * @property Productoproducto[] $productoproductos
 * @property Productoproducto[] $productoproductos1
 * @property Clase $idclase0
 * @property Familia $idfamilia0
 * @property Unidad $idunidad0
 * @property Almacen $idalmacen0
 * @property Producto $idproductopadre0
 * @property Producto[] $productos
 * @property Productocaracteristica[] $productocaracteristicas
 * @property Productonota[] $productonotas
 * @property Productoinventario[] $productoinventarios
 * @property Almacen $idalmacen0 
 * @property array $productoComplementario 
 * 
 */

class Producto extends CActiveRecord {
    public $fechaInicio; //reporte entre rangos
    public $fechaFin; //reporte entre rangos
    public $duracionCuatroMesesCheck;
    public $existeRelacionProduccion = false;
    public $codigoAlmacen;
    public $nombreFamilia;
    public $codigoFamilia;
    public $nombreCompletadoFamilia;
    public $nombreClase;
    public $codigoClase;
    public $nombreCompletadoClase;
    public $nombreCompletoProducto;
    public $auxiliarCodigo;
    public $auxiliarNombre;
    public $stockminimode;
    public $stockminimoa;
    public $stockde;
    public $stocka;
    public $stockmaximode;
    public $stockmaximoa;
    public $puntopedidode;
    public $puntopedidoa;
    public $existeImagen;
    public $nutricional;
    public $incorrecto;
    
    //atributos para actualizar datos de [SALDO / RESERVA]
    public $saldoIncrementar;
    public $saldoDecrementar;
    public $saldoimporteIncrementar;
    public $saldoimporteDecrementar;
    public $reservaIncrementar;
    public $reservaDecrementar;
    public $requisito;
    public $aumentarColumna;
    public $id_producto;
    public $nombrealmacen;
    public $simbolo;
    public $entero;
    public $producto;
    public $idproductogrupo;
    public $almacen;
    
    //atributo de busqueda para filtrar por PROVEEDOR
    public $proveedor;
    
    public $tipomovimiento;
    public $grupoproducto;
    public $idproveedor;
    public $familia;
    public $idproductoindividual;
    public $fechacambio;
    public $meses;
    public $permitirdecimal;
    
    public function defaultScope() {
       if (Yii::app()->user->getName() == 'invitado') {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false'
            );
        }
        else {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false'
                . ' and ' . $this->getTableAlias(false, false) .
                '.idalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[]))',
            );
        }
    }

    public function init() {
        //se filtran los productos del primer almacen por defecto
        $alm = Almacen::model()->find(array('order' => 'codigo', 'limit' => 1));
        if ($alm !== null)
            $this->idalmacen = $alm->id;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'producto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('reserva', 'required', 'on' => 'traspaso'),
            array('idalmacen,idfamilia,idclase,valor,idunidad,codigo,nombre, codigoAlmacen', 'required', 'on' => array('insert', 'update')),
            array('nombreFamilia,nombreClase', 'required', 'on' => array('insert', 'update')),
            array('producto', 'required', 'on' => array('registraAgrupacion')),
            array('codigo,nombre', 'unico', 'on' => array('insert', 'update')),
            array('nombreFamilia', 'isFamilia', 'on' => array('insert', 'update'), 'message' => 'Familia no valida.'),
            array('nombreClase', 'isClase', 'on' => array('insert', 'update'), 'message' => 'Familia no valida.'),
            array('codigo', 'length', 'max' => 12),
            array('coduniversal', 'length', 'max' => 13),
            array('nombre', 'length', 'max' => 100),
            array('valor', 'length', 'max' => 3),
            array('ultimoppp', 'numerical', 'integerOnly' => false, 'on' => array('insert')),
            array('coduniversal,stockde,stocka,stockminimode,stockminimoa,stockmaximode,stockmaximoa,puntopedidode,puntopedidoa', 'numerical'),
            array('stockde,stocka,stockminimode,stockminimoa,stockmaximode,stockmaximoa,puntopedidode,puntopedidoa', 'length', 'max' => 12),
            array('stocka', 'compareStockRange'),
            array('stockminimoa', 'compareStockMinimoRange'),
            array('stockmaximoa', 'compareStockMaximoRange'),
            array('puntopedidoa', 'comparePuntoPedidoRange'),
            array('saldo,stockminimo', 'numerical', 'integerOnly' => false, 'message' => '{attribute} debe ser un número.'),
            array('ultimoppp,nombresenasag,id,stockminimo,stockmaximo,puntopedido,'
                . ' saldo,idalmacen,codigoFamilia,nombreCompletadoFamilia,codigoClase,'
                . 'nombreCompletadoClase,nombreClase,nombreFamilia,eliminado,'
                . 'idunidad,idunidadpresentacion,saldoimporte'
                . 'inventariar,codigouniversal,nombresenasag,idunidadpresentacion,'
                . 'ultimoppp,precio,utilidad,incorrecto,lineatabu,admitedescuento,ventatpv,grupo ', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idalmacen,id,stockminimo,stockmaximo,puntopedido, codigo,saldo, nombre,'
                . ' valor, costo, fecha, eliminado,lineatabu,admitedescuento,ventatpv,'
                . ' usuario, idclase, idfamilia, idunidad,idunidadpresentacion,duracionCuatroMesesCheck,meses,idestadofichatecnica,proveedor',
                'safe', 'on' => 'search,searchStock'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productoproductos' => array(self::HAS_MANY, 'Productoproducto', 'idproducto1'),
            'productoproductos1' => array(self::HAS_MANY, 'Productoproducto', 'idproducto2'),
            'idclase0' => array(self::BELONGS_TO, 'Clase', 'idclase'),
            'idfamilia0' => array(self::BELONGS_TO, 'Familia', 'idfamilia'),
            'idunidad0' => array(self::BELONGS_TO, 'Unidad', 'idunidad'),
            'idalmacen0' => array(self::BELONGS_TO, 'Almacen', 'idalmacen'),
            'idproductopadre0' => array(self::BELONGS_TO, 'Producto', 'idproductopadre'),
            'productos' => array(self::HAS_MANY, 'Producto', 'idproductopadre'),
            'productocaracteristicas' => array(self::HAS_MANY, 'Productocaracteristica', 'idproducto'),
            'productonotas' => array(self::HAS_MANY, 'Productonota', 'idproducto'),
            'productoinventarios' => array(self::HAS_MANY, 'Productoinventario', 'idproducto'),
            'idestadofichatecnica0' => array(self::BELONGS_TO, 'Estadofichatecnica', 'idestadofichatecnica'),
            'iditem0' => array(self::HAS_ONE, 'FtblCompraItem', 'idproducto')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idalmacen' => 'Almacén',
            'id' => 'ID',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'valor' => 'Presentacion',
            'costo' => 'Costo',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'idclase' => 'Clase',
            'idfamilia' => 'Familia',
            'idunidad' => 'Unidad',
            'idunidadpresentacion' => '.',
            'nombreFamilia' => 'Familia',
            'nombreClase' => 'Clase',
            'codigoAlmacen' => 'Almacén',
            'saldo' => 'Saldo',
            'stockminimo' => 'Consumo Promedio',
            'stockmaximo' => 'Consumo Máximo',
            'nombreCompletadoFamilia' => 'Familia',
            'nombreCompletadoClase' => 'Clase',
            'idproductopadre' => 'Idproductopadre',
            'puntopedido' => 'Pto. de Pedido',
            'productoComplementario' => 'Producto Complementario',
            'stockminimode' => 'Consumo Promedio desde',
            'stockminimoa' => 'Consumo Promedio hasta',
            'stockde' => 'Saldo desde',
            'stocka' => 'Saldo hasta',
            'stockmaximode' => 'Consumo Máximo desde',
            'stockmaximoa' => 'Consumo Máximo hasta',
            'puntopedidode' => 'Pto. de Pedido desde',
            'puntopedidoa' => 'Pto. de Pedido hasta',
            'coduniversal' => 'Código Universal',
            'nombresenasag'=> 'Clasificación SENASAG',
            'saldoimporte' => 'Saldo Importe',
            'duracionCuatroMesesCheck'=>'Duración < 4 meses',
            'nutricional' => 'Información Nutricional',
            'ultimoppp'=> 'Costo',
            'incorrecto' => 'Incorrecto(s)',
            'idestadofichatecnica' => 'Est. FichaTéc.',
            'admitedescuento'=> 'Desc',
            'lineatabu'=> 'Tabu',
            'ventatpv' => 'Venta en TPV',
            'pesopromedio' => 'Peso Promedio(gr)',
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
        $criteria->with = array('idfamilia0', 'idclase0', 'idalmacen0', 'idunidad0');

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->compare('t.coduniversal', $this->coduniversal);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('valor', $this->valor, true);
        $criteria->compare('costo', $this->costo, true);
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idclase0.nombre', $this->nombreClase, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idfamilia0.nombre', $this->nombreFamilia, true, 'AND', 'ILIKE');

        $criteria->compare('t.idunidad', $this->idunidad);
        $criteria->compare('t.idalmacen', $this->idalmacen);
        $criteria->compare('t.idestadofichatecnica', $this->idestadofichatecnica);
        if ($this->lineatabu !=null){
            $criteria->compare('t.lineatabu', $this->lineatabu==1?true:false);
        }
        if ($this->admitedescuento != null){
            $criteria->addCondition('t.admitedescuento='.$this->admitedescuento);
        }
        if ($this->ventatpv != null) {
            $criteria->addCondition('t.ventatpv=' . $this->ventatpv);
        }

        if ($this->incorrecto == true)
        {
            $condicion = "eliminado is false";
            if($this->idalmacen != null)
                $condicion = "idalmacen = ".$this->idalmacen." and eliminado is false";

            $criteria->addCondition("t.id IN(
                select x.id
                from
                (
                   select id, (select muestrakardexconerrores(id)) as errores
                   from producto
                   where ".$condicion."
                )x
                where x.errores::integer > 0
                )");
        }

        Yii::app()->session['reporteProductoLote'] = $criteria;

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc,idalmacen0.nombre asc',
                'attributes' => array(
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    'idalmacen' => array(
                        'asc' => 'idalmacen0.nombre',
                        'desc' => 'idalmacen0.nombre DESC',
                    ),
                    '*',
                ),
            ),
        ));
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
     * @return Producto the static model class
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
        if (
            $this->getScenario() == 'salidaVentaConsignacion'
            || $this->getScenario() == 'updateSaldoAnulacionVenta'
            || $this->getScenario() == 'CSdocumentoVenta'    
            || $this->getScenario() == 'updateSaldoAnulacionTraspaso'    
            || $this->getScenario() == 'inventariar'               
            || $this->getScenario() == 'correccioncantidad'  
            || $this->getScenario() == 'actualizarsaldo'
            || $this->getScenario() == 'actualizarreserva'      
            || $this->getScenario() == 'actualizarSaldoimporte'  
            || $this->getScenario() == 'actualizarCosto'  
                )
            return parent::beforeSave();
        
        if ($this->getScenario() !== 'actualizarSaldos') {
            if ($this->getScenario() == 'traspaso')
                return parent::beforeSave();

            $this->codigo = strtoupper($this->codigo);
            $this->valor = strtoupper($this->valor);
            if ($this->isNewRecord || Yii::app()->user->getName() =='rcarbajal'){
                $this->costoini=$this->ultimoppp;
                $this->fecha = new CDbExpression('NOW()');
                $this->usuario = Yii::app()->user->getName();
                $this->idunidadproduccion= $this->idunidad;
            }
            if($this->codigoAlmacen != null) {
                $criteria = new CDbCriteria;
                $criteria->select = 'id';
                $criteria->condition = 'codigo = ' . $this->codigoAlmacen;
                $modeloTemporal = Almacen::model()->find($criteria);
                $this->idalmacen = $modeloTemporal['id'];
                $this->nombresenasag = strtoupper($this->nombresenasag);
                $this->precio = $this->precio > 0? $this->precio : 0;
                if ($this->coduniversal==Null){
                    $this->coduniversal=0;
                }
            }
        }
        
        return parent::beforeSave();
    }

    /**
     * Busca y filtra el stock de productos
     */
    public function searchStock() {

        $criteria = new CDbCriteria;
        if ($this->validate()) {

            Yii::app()->session['mostrarReporteProductoStock'] = true;

            if ($this->id != null) {
                $criteria->addCondition('t.id=' . (int) $this->id . '');
            }
            if ($this->codigo != null) {
                $criteria->addCondition("t.codigo ilike '%" . $this->codigo . "%'");
            }
            if ($this->nombre != null) {
                $criteria->addCondition("t.nombre ilike '%" . $this->nombre . "%'");
            }
            $criteria->compare('t.idunidad', $this->idunidad);
            if ($this->saldo != null) {
                $criteria->addCondition("t.saldo=" . $this->saldo);
            }            
            if ($this->stockde != null) {
                $criteria->addCondition("t.saldo>=" . $this->stockde);
            }
            if ($this->stocka != null) {
                $criteria->addCondition("t.saldo<=" . $this->stocka);
            }
            if ($this->proveedor != null) {
                $criteria->join = 'inner join ftbl_compra_item i on i.nombre = t.nombre '
                        . 'inner join ftbl_compra_proveedoritem pi on pi.iditem = i.id '
                        . 'inner join ftbl_compra_proveedor p on p.id = pi.idproveedor';
                $criteria->addCondition("p.nombre ilike '%" . $this->proveedor . "%'");
                Yii::app()->session['proveedorStock'] = strtoupper($this->proveedor);
            } else {
                Yii::app()->session['proveedorStock'] = null;
            }
            $criteria->addCondition('t.idalmacen = ' . $this->idalmacen);
            Yii::app()->session['almacen'] = Almacen::model()->findByPk($this->idalmacen)->nombre;
        } else {
            Yii::app()->session['mostrarReporteProductoStock'] = false;
            $criteria->compare('idalmacen', -10);
        }
        Yii::app()->session['productoreporteStock'] = $criteria;

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'codigo asc',
                'attributes' => array(
                    'saldo' => array(
                        'asc' => 'saldo',
                        'desc' => 'saldo DESC',
                    ),
                    'stockminimo' => array(
                        'asc' => 'stockminimo',
                        'desc' => 'stockminimo DESC',
                    ),
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    '*',
                ),
            ),
                )
        );
    }

    /**
     *
     * Verifica si el nombre introducido es una familia         * 
      @param modelAttribute $attribute Atributo a validar
     */
    public function isFamilia($attribute) {
        if (!empty($this->nombreFamilia)) {
            $cantidad = Familia::model()->count("nombre = '" . $this->nombreFamilia . "'");
            if ($cantidad == 0) {
                $this->addError($attribute, "La familia '" . $this->nombreFamilia . "' no existe");
            }
        }
    }

    /**
     *
     * Verifica si el nombre introducido es una clase         * 
      @param modelAttribute $attribute Atributo a validar
     */
    public function isClase($attribute) {
        if (!empty($this->nombreClase)) {
            $cantidad = Clase::model()->count("nombre = '" . $this->nombreClase . "'");
            if ($cantidad == 0) {
                $this->addError($attribute, "La clase '" . $this->nombreClase . "' no existe");
            }
        }
    }

    /**
     *
     * Verifica si el nombre y codigo introducido es unico        * 
      @param modelAttribute $attribute Atributo a validar
     */
    public function unico($attribute) {
        if (!isset($this->id)) {
            $informacion = $this->findAllByAttributes(array('codigo' => $this->codigo));
            $cantidad = count($informacion);
            if ($cantidad > 0) {
                $isUnico = false;
            } else {
                $isUnico = true;
            }
        } else {
            $criteria = new CDbCriteria;
            $criteria->addCondition("id <> '" . $this->id . "'");
            $criteria->addCondition("codigo = '" . $this->codigo . "'");
            $criteria->addCondition("idproductopadre IS NULL");
            $criteria->addCondition("eliminado=false");
            $informacion = $this->findAll($criteria);
            $cantidad = count($informacion);
            if ($cantidad > 0) {
                $isUnico = false;
            } else {
                $isUnico = true;
            }
        }
        if (!$isUnico) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' ' . $this->$attribute . "  ya ha sido tomado.");
        }
    }

    /**
     * Verifica si un producto puede ser actualizado
     */
    public function isActualizable() {
        $command = Yii::app()->almacen->createCommand
                ("select producto_es_actualizable(" . $this->getPrimaryKey() . ");");
        return $command->queryScalar();
    }

    /**
     *
     * Replica todos los datos de un producto y sus caracteristicas,creando productos hijos, 
     * para los subalmacenes del almacen al que pertenece el producto
     * @param integer $idProducto Id del producto a replicarse   
     * 
     * 
     */
    public function registrarHijo($idProducto) {
        try {
            $command = Yii::app()->almacen->createCommand("select producto_registrar_hijo('" . $idProducto . "');");
            $command->queryScalar();
        } catch (Exception $ex) {
            throw new CrugeException('No se pudo actualizar los productos de subalmacenes.'.$ex, 483);
        }
    }

    /**
     *
     * Actualiza todos los datos de un producto, sus caracteristicas y complementarios, 
     * para los subalmacenes del almacen al que pertenece el producto
     * @param integer $idProducto Id del producto a actualizarse

     * 
     * 
     */
    public function actualizarHijo($idProducto) {
        try {
            $command = Yii::app()->almacen->createCommand("select producto_actualizar_hijo('" . $idProducto . "');");
            $command->queryScalar();
        } catch (Exception $ex) {
            throw new CrugeException('No se pudo actualizar los productos de subalmacenes.', 483);
        }
    }

    /**
     *
     * Obtiene los productos hijos de un producto, estos pertenecen a subalmacenes       
     * @param integer $idProducto Id del producto padre
     * @return array que contiene los id de los productos hijo
     * 
     * 
     */
    public function getHijo($idProducto) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id';
        $criteria->compare('t.idproductopadre', $idProducto);
        $informacion = $this->findAll($criteria);

        $dato = array();
        if (count($informacion) > 0) {
            foreach ($informacion as $i) {
                array_push($dato, $i->attributes);
            }
        }
        return $dato;
    }

    /**
     *
     * Obtiene el nombre del producto concatenado con su código           
     * @return string Nombre concatenado
     * 
     * 
     */
    public function getNombreConcatenado() {
        return $this->nombre . ' (' . $this->codigo . ' ' . $this->idalmacen0->nombre . ')';
    }

    /**
     * Remueve el valor de todos los atributos del modelo
     */
    public function emptyAttributes() {
        $this->unsetAttributes();
        $this->codigoAlmacen = NULL;
        $this->nombreFamilia = NULL;
        $this->codigoFamilia = NULL;
        $this->nombreCompletadoFamilia = NULL;
        $this->nombreClase = NULL;
        $this->codigoClase = NULL;
        $this->nombreCompletadoClase = NULL;
        $this->nombreCompletoProducto = NULL;
        $this->auxiliarCodigo = NULL;
        $this->auxiliarNombre = NULL;
    }

    /**
     *
     * Sirve para validar el rango de busqueda de stock
     * 
     */
    public function compareStockRange($attribute, $params) {
        if (!empty($this->stocka) && !empty($this->stockde)) {
            if ($this->stocka < $this->stockde) {
                $this->addError($attribute, 'El rango establecido para Stock es '
                        . 'incorrecto.');
            }
        }
    }

    /**
     *
     * Sirve para validar el rango de busqueda de stock minimo
     * 
     */
    public function compareStockMinimoRange($attribute, $params) {
        if (!empty($this->stockminimoa) && !empty($this->stockminimode)) {
            if ($this->stockminimoa < $this->stockminimode) {
                $this->addError($attribute, 'El rango establecido para Stock Minimo es '
                        . 'incorrecto.');
            }
        }
    }

    /**
     *
     * Sirve para validar el rango de busqueda de stock maximo
     * 
     */
    public function compareStockMaximoRange($attribute, $params) {
        if (!empty($this->stockmaximoa) && !empty($this->stockmaximode)) {
            if ($this->stockmaximoa < $this->stockmaximode) {
                $this->addError($attribute, 'El rango establecido para Stock Maximo es '
                        . 'incorrecto.');
            }
        }
    }

    /**
     *
     * Sirve para validar el rango de busqueda de punto de pedido
     * 
     */
    public function comparePuntoPedidoRange($attribute, $params) {
        if (!empty($this->puntopedidoa) && !empty($this->puntopedidode)) {
            if ($this->puntopedidoa < $this->puntopedidode) {
                $this->addError($attribute, 'El rango establecido para Punto de pedido es '
                        . 'incorrecto.');
            }
        }
    }

    /**
     * Antes de eliminar de forma segura verifica dependencias
     */
    protected function beforeSafeDelete() {
        $swFtp = Yii::app()->ftp;
        $command = Yii::app()->almacen->createCommand
                ("select producto_eliminar(" . $this->getPrimaryKey() . ");");
        $aux = $command->queryScalar();
        if ($aux !== 'exito') {
            echo System::messageError($aux);
            return;
        } else {
            $swFtp->chdir(Productocaracteristica::model()->tableName());
            $swFtp->chdir($this->id);
            $swFtp->emptyDirectory();
            return parent::beforeSafeDelete();
        }
    }

    /**
     * Consultar los productos que coincidan con el nombre
     * @param string $nombre
     * @param array $productoExcluido //Id de productos que no debe mostrarse
     * @return \CActiveDataProvider
     */
    public function searchProductoNombre($arrayParametros) {
        $nombre = $arrayParametros['nombre'];
        $productoExcluido = $arrayParametros['productoExcluido'];
        $idprod = $arrayParametros['idprod'];
        $idalm = $arrayParametros['idalm'];
        
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0');
        //$criteria->addNotInCondition("t.id", $productoExcluido);
        if ($idprod !== '') {
            $criteria->addCondition("t.id<>$idprod", "AND");
        }
        if ($idalm !== '') {
            $criteria->addCondition("t.idalmacen=$idalm", "AND");
        }
        $criteria->addSearchCondition('t.nombre', $nombre, true, 'AND', 'ILIKE');
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Consultar los productos que coincidan con el codigo
     * @param string $codigo
     * @param array $productoExcluido //Id de productos que no debe mostrarse
     * @return \CActiveDataProvider
     */
    public function searchProductoCodigo($codigo = '', $productoExcluido, $idprod, $idalm) {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0', 'idunidad0');
        $criteria->addNotInCondition("t.id", $productoExcluido);
        if ($idprod !== '') {
            $criteria->addCondition("t.id <> ".$idprod, "AND");
        }
        if ($idalm !== '') {
            $criteria->addCondition("t.idalmacen=$idalm", "AND");
        }
        $criteria->addSearchCondition('t.codigo', $codigo, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Consultar los productos que coincidan con el codigo
     * @param string $codigo
     * @param array $productoExcluido //Id de productos que no debe mostrarse
     * @return \CActiveDataProvider
     */
    public function searchProductoCodigoSinExcluir($arrayParametros) {
        $codigo = $arrayParametros['codigo'];
        $productoExcluido = $arrayParametros['productoExcluido'];
        $idprod = $arrayParametros['idprod'];
        $idalm = $arrayParametros['idalm'];
        
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0', 'idunidad0');
       
        //$criteria->addNotInCondition("t.id", $productoExcluido);
        if ($idprod !== '') {
            $criteria->addCondition("t.id<>$idprod", "AND");
        }
        if ($idalm !== '') {
            $criteria->addCondition("t.idalmacen=$idalm", "AND");
        }

        $criteria->addSearchCondition('t.codigo', $codigo, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
    public function asignacionSaldos() {
        $criteria = new CDbCriteria;
        $criteria->with = array('idfamilia0', 'idclase0', 'idalmacen0', 'idunidad0');

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('valor', $this->valor, true);
        $criteria->compare('costo', $this->costo, true);
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }        
        
        if ($this->duracionCuatroMesesCheck != Null) { 
            if($this->duracionCuatroMesesCheck==true){
                $criteria->addCondition("t.consumohistorico<>0");
                $criteria->addCondition("(CASE WHEN t.consumohistorico=0 THEN 0 ELSE t.saldo/t.consumohistorico END) <= 4");
//                $criteria->addCondition($this->getConsumoHistorico()."<>0");
//                $criteria->addCondition("(case when ".$this->getConsumoHistorico()."=0 then 0 else ".$this->saldo/$this->getConsumoHistorico()." end) <=4");
            }                
        }
        
        if ($this->meses >0){
            $criteria->addCondition("t.consumohistorico<>0");
            $criteria->addCondition("(CASE WHEN t.consumohistorico=0 THEN 0 ELSE t.saldo/t.consumohistorico END) <= ".$this->meses);
        }
        
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idclase0.nombre', $this->nombreClase, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idfamilia0.nombre', $this->nombreFamilia, true, 'AND', 'ILIKE');

        $criteria->compare('t.idunidad', $this->idunidad);
        $criteria->compare('t.idalmacen', $this->idalmacen);
        
        Yii::app()->session['reporteAsignacionConsumos'] = $criteria;
        
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc,idalmacen0.nombre asc',
                'attributes' => array(
                    'idalmacen' => array(
                        'asc' => 'idalmacen0.nombre',
                        'desc' => 'idalmacen0.nombre DESC',
                    ),
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }
    
    public function asignacionSaldosImporte() {
        $criteria = new CDbCriteria;
        $criteria->with = array('idfamilia0', 'idclase0', 'idalmacen0', 'idunidad0');

        $criteria->compare('t.id', $this->id);
        //$criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('valor', $this->valor, true);
        $criteria->compare('costo', $this->costo, true);
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idclase0.nombre', $this->nombreClase, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('idfamilia0.nombre', $this->nombreFamilia, true, 'AND', 'ILIKE');

        $criteria->compare('t.idunidad', $this->idunidad);
        $criteria->compare('t.idalmacen', $this->idalmacen);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc,idalmacen0.nombre asc',
                'attributes' => array(
                    'idalmacen' => array(
                        'asc' => 'idalmacen0.nombre',
                        'desc' => 'idalmacen0.nombre DESC',
                    ),
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    public function getIdproductoDestino($idproducto, $idalmacenDestino) {
        $command = Yii::app()->almacen->createCommand("select p2.id 
            from producto p 
            inner join producto p2 
            on p.codigo=p2.codigo 
            where  p2.idalmacen=" . $idalmacenDestino . " and p.eliminado=false 
            and p2.eliminado=false and  p.id=" . $idproducto);
        return $command->queryScalar();
    }

    /**
     * Conocer el saldo disponible de un producto
     * @param integer $idProducto
     * @return float Saldo disponible del producto
     */
    public function getSaldoDisponible($idProducto) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $idProducto);
        $producto = $this->find($criteria);
        return $producto->saldo - $producto->reserva;
    }

    /**
     * Verifica si existe cantidad suficiente de un producto
     * @param integer $idProducto
     * @param float $cantidad Cantidad necesaria
     * @return boolean
     */
    public function isSaldoSuficiente($idProducto, $cantidad) {
        $model = Producto::model()->findByPk($idProducto);
        $saldoDisponible = $model->saldo - $model->reserva;
        if ($cantidad > $saldoDisponible) {
            return false;
        } else {
            return true;
        }
    }

    public function inventariar() {
        $criteria = new CDbCriteria;
        $criteria->with = array('idunidad0');

        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->addCondition('t.idalmacen in ('. $this->idalmacen.')');
        
        $criteria->compare('t.idunidad', $this->idunidad);       

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.inventariar desc',
                'attributes' => array(
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    '*'
                )
            )
        ));
    }

    /**
     * Verifica si existen producto para realizar un inventario, es decir is 
     * alguno de los producto del almacen esta habilitado para realizar inventario
     * (columna inventariar de tabla producto en true) 
     * @param integer $idAlmacen al que corresponde el producto
     * @return boolean
     */
    public function existenProductosParaInventario($idAlmacen) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'idalmacen =' . $idAlmacen . ' and inventariar=true';
        $count = $this->count($criteria);

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Actualiza el saldo del producto 
     * @param float $saldo nuevo saldo del producto
     * @return boolean
     */
    public function actualizarSaldo($saldo) {
        $this->setScenario("nombre");
        $nuevosaldo = (float) $this->saldo + (float) $saldo;
        try {
            $this->updateAll(array('saldo' => round($nuevosaldo, 4)), 'id=:id', array(':id' => $this->getPrimaryKey()));
        } catch (Exception $e) {            
        }
    }
    
    /*
     * Obtiene todos los productos de un determinado almacen
     */
    public function getProductos($idalmacen, $dato)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idalmacen = ".$idalmacen);
        $criteria->addCondition("(t.codigo ilike '%".$dato."%' or t.nombre ilike '%".$dato."%')");

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc',
            ),
        ));
    }
    /**
     * Verifica la duracion de la asignacion de consumo del admin de Asignacion de Saldos
     */
    public function verificaDuracionAsignacionConsumo($data){
        //$valor=($data->stockminimo == null||$data->stockminimo==0)?0:$data->saldo/$data->stockminimo;
        $valor=($data->consumohistorico == null||$data->consumohistorico==0)?0:($data->saldo!=0?$data->saldo/$data->consumohistorico:0);
        //if($valor<=4) return true;
        if($valor<=($data->tiempoentrega/30)) return true;
        return false;
    }
    /**
     * Obtener valor de la duración de la asignación de consumo del admin de Asignacion de Saldos
     */
    public function getDuracionAsignacionConsumo($data){
        //return ($data->stockminimo == null||$data->stockminimo==0)?null:round($data->saldo/$data->stockminimo,3);
        return ($data->consumohistorico == null||$data->consumohistorico==0)?0:($data->saldo!=0?round($data->saldo/$data->consumohistorico,3):0);
    }
    
    public function obtenerProductos($parametro, $scenario = '', $idalmacen) {
        $criteria = new CDbCriteria;
        
        if ($scenario != '') {
            switch ($scenario) {
                case "codigo":
                    $criteria->addCondition("t.codigo ilike '%".$parametro."%' and t.idalmacen = ". $idalmacen);
                    break;
                case "nombre":
                    $criteria->addCondition("t.nombre ilike '%".$parametro."%' and t.idalmacen = ". $idalmacen);                    
                    break;
            }
        }
        return new CActiveDataProvider($this, array(
            'pagination' => FALSE,
            'criteria' => $criteria,
            
        ));
    }
    /**
     * Consultar los productos que coincidan con el codigo/nombre
     * @param string $request Busqueda (nombre/codigo)
     * @return \CActiveDataProvider
     */
    public function searchProducto($request='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.codigo ilike '%$request%' or t.nombre ilike '%$request%'");       
        return new CActiveDataProvider($this, array(
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'criteria' => $criteria,
            
        ));
    }
    /**
     * Calculo de ppp si el saldo es diferente de cero
     */
    public function getPpp(){
        if($this->saldo==0 || $this->saldo==null || $this->saldoimporte==0 || $this->saldoimporte==null)return $this->ultimoppp;
        
        return $this->saldoimporte/$this->saldo;
    }
    
    /**
     * Obtiene el id de una producto a partir del código y el id del almacen
     * @param type $codigo
     * @param type $idalmacen
     */
    public function getIdProducto($codigo,$idalmacen){
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.codigo like '".$codigo."'");
        $criteria->addCondition("t.idalmacen = ".$idalmacen);
        $modelArray = Producto::model()->find($criteria)->id;
        return $modelArray;
    }
    
    /**
     * Encuentra la fecha del primer increso de los movimientos del almacen a 
     * partir de una determinada fecha
     */
    public function getFechaPrimerIngresoEncontrado($fecha,$idproducto){
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';
        $criteria->addCondition("t.glosa LIKE 'SALIDA ESP. - POR AJUSTE DE SISTEMA%'");
        $criteria->addCondition("t.fecha >= '".$fecha."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha,t.id";        
        
        $modelArray = Productonota::model()->find($criteria)->fecha;
        return $modelArray;
    }
    /**
     * Obtiene los movimientos principales del almacen de un determinado producto
     * a partir de una determinada fecha.
     * Esta funcion no es recursiva
     */
    public function getArbolPrincipal($fecha,&$data,$idpadre,$idproducto,$index){
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';     
        $criteria->addCondition("t.fecha >= '".$fecha."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha,t.id";
         
        $modelArray = Productonota::model()->findAll($criteria);
        if($modelArray == null) {
            return;
        }
        
        foreach ($modelArray as $get) {
            
            $sop=strpos($get->glosa, 'SALIDA PARA O.P.')!==false?true:false;
            $iop=strpos($get->glosa, 'INGRESO POR ENTREGA DE O.P. N')!==false?true:false;
            
            if(!$sop || $get->idnota0->idtipo!=2){
                
                $data[] = array(
                    'key' => $get->id,
                    'fechamovimiento' => $get->fecha,
                    'fechap' => $fecha,
                    'glosa' => $get->glosa,
                    'txt' => $get->idproducto0->codigo,
                    'parent' => $idpadre,
                    'idtipo' => $get->idnota0->idtipo,
                    'sop' => $sop,
                    'iop' => $iop,
                    'idproductonota' => $get->idproducto,
                    'index' => $index,
                    'keylist' => "".$idpadre."_".$index
                    //'idroducto' => $idproducto,
                );  
                $index++;
                continue;
            }
            //if(count($data)>500) return;
            
            $idnotaborr=$get->idnota0->idnotaborrador;
            if($idnotaborr==null){
                $myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
                $idnota=$get->idnota0->id;
                $txt = "".$idnota."\n";
                fwrite($myfile, $txt);
                fclose($myfile);
                continue;
            }
            //$idnota=$idnotaborr==null?"".$get->idnota0->id."n":$idnotaborr;
            //echo "<br>".$idnota."<br>";
            $command = Yii::app()->produccion->createCommand("select p.codigo,p.id,ore.id as idop,t.costos FROM orden t INNER JOIN ordenreceta ore ON ore.id=t.id INNER JOIN ordenrecetaproducto orp ON orp.idordenreceta = t.id INNER JOIN producto p ON p.id = ore.idproducto AND orp.idnotaborrador=".$idnotaborr)
                ->queryRow();
            $idproducto = $command['id'];
            
            $fechaDeCierre='-';
            if($command['costos']!=null){
                $commandfc = Yii::app()->produccion->createCommand("select fecha from ordenestado where idestado = 7 and idorden=".$command['idop'])
                ->queryRow();
                $fechaDeCierre=$commandfc["fecha"];//$get->fecha
                
            }
            
            $data[] = array(
                'key' => $get->id,
                'fechamovimiento' => $get->fecha,
                'fechap' => $fecha,
                'glosa' => $get->glosa,
                'txt' => $get->idproducto0->codigo,
                'parent' => $idpadre,
                'idtipo' => $get->idnota0->idtipo,
                'idop' => $command['idop'],
                'sop' => $sop,
                'iop' => $iop,
                'idproducto' => $idproducto,
                'idproductonota' => $get->idproducto,
                'index' => $index,
                'keylist' => "".$idpadre."_".$index,
                'idnotaborrador'=>$idnotaborr,
                'costoconfirmado'=>$command['costos']!=null?true:false,
                'fechacierre'=>$fechaDeCierre
                );
            $index++;
            //$this->getArbolPrincipal($get->fecha,$data,$get->id,$idproducto);
        }
    }
    
    /**
     * Arbol ramificado
     * Obtiene los movimientos principales del almacen de un determinado producto
     * a partir de una determinada fecha.
     * Esta funcion a diferencia de getArbolPrincipal es recursiva.
     */
    public function getArbolRamificado($fecha,&$data,$idpadre,$idproducto,$index){
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';     
        $criteria->addCondition("t.fecha > '".$fecha."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha,t.id";
         
        $modelArray = Productonota::model()->findAll($criteria);
        if($modelArray == null) {
            
            return;
        }
        
        foreach ($modelArray as $get) {
            
            $sop=strpos($get->glosa, 'SALIDA PARA O.P.')!==false?true:false;
            $iop=strpos($get->glosa, 'INGRESO POR ENTREGA DE O.P. N')!==false?true:false;
            
            if(!$sop || $get->idnota0->idtipo!=2){
                
                $data[] = array(
                    'key' => $get->id,
                    'fechamovimiento' => $get->fecha,
                    'fechap' => $fecha,
                    'glosa' => $get->glosa,
                    'txt' => $get->idproducto0->codigo,
                    'parent' => $idpadre,
                    'idtipo' => $get->idnota0->idtipo,
                    'sop' => $sop,
                    'iop' => $iop,
                    'idproductonota' => $get->idproducto,
                    'index' => $index,
                    'keylist' => "".$idpadre."_".$index
                    //'idroducto' => $idproducto,
                ); 
                $index++;
                continue;
            }
            //if(count($data)>500) return;
            
            $idnotaborr=$get->idnota0->idnotaborrador;
            if($idnotaborr==null){
                $myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
                $idnota=$get->idnota0->id;
                $txt = "".$idnota."\n";
                fwrite($myfile, $txt);
                fclose($myfile);
                continue;
            }
            //$idnota=$idnotaborr==null?"".$get->idnota0->id."n":$idnotaborr;
            //echo "<br>".$idnota."<br>";
            $command = Yii::app()->produccion->createCommand("select p.codigo,p.id,ore.id as idop,t.costos FROM orden t INNER JOIN ordenreceta ore ON ore.id=t.id INNER JOIN ordenrecetaproducto orp ON orp.idordenreceta = t.id INNER JOIN producto p ON p.id = ore.idproducto AND orp.idnotaborrador=".$idnotaborr)
                ->queryRow();
            $idproducto = $command['id'];
            
            $keylist="".$idpadre."_".$index;
            $fechaDeCierre='-';
            if($command['costos']!=null){
                $commandfc = Yii::app()->produccion->createCommand("select fecha from ordenestado where idestado = 7 and idorden=".$command['idop'])
                ->queryRow();
                $fechaDeCierre=$commandfc["fecha"];//$get->fecha
                
            }
            
            $data[] = array(
                'key' => $get->id,
                'fechamovimiento' => $get->fecha,
                'fechap' => $fecha,
                'glosa' => $get->glosa,
                'txt' => $get->idproducto0->codigo,
                'parent' => $idpadre,
                'idtipo' => $get->idnota0->idtipo,
                'idop' => $command['idop'],
                'sop' => $sop,
                'iop' => $iop,
                'idproducto' => $idproducto,
                'idproductonota' => $get->idproducto,
                'index' => $index,
                'keylist' => $keylist,
                'idnotaborrador'=>$idnotaborr,
                'costoconfirmado'=>$command['costos']!=null?true:false,
                'fechacierre'=>$fechaDeCierre
                );
            $index++;
            if($command['costos']!=null){                
                $this->getArbolRamificado($fechaDeCierre,$data,$keylist,$idproducto,1);
            }
        }
    }   
    /**
     * Construye una tabla HTML para mostrar en la vista de modificacion del Kardex
     */
    public function construirTablaMovimientoAlmacen($productonotamodel){
        $ingreso=$productonotamodel->ingreso;
        $salida=$productonotamodel->salida;
        $ingresoimporte=round($productonotamodel->ingresoimporte,4);
        $salidaimporte=round($productonotamodel->salidaimporte,4);
        $saldo=$productonotamodel->saldo;
        $saldoimporte=round($productonotamodel->saldoimporte,2);
        return "<table class='tablaModificarKardex'>"
        . "<tr>"
                . "<td title='Ingreso' class='anchoColumnaTablaModificarKardex'>$ingreso</td>"
                . "<td title='Salida' class='anchoColumnaTablaModificarKardex'>$salida</td>"
                . "<td title='Saldo' class='anchoColumnaTablaModificarKardex'>$saldo</td>"
                . "<td title='Ingreso Importe' class='anchoColumnaTablaModificarKardex'>$ingresoimporte</td>"
                . "<td title='Salida Importe' class='anchoColumnaTablaModificarKardex'>$salidaimporte</td>"
                . "<td title='Saldo Importe' class='anchoColumnaTablaModificarKardex'>$saldoimporte</td>"
                . "</tr></table";
    }
    /**
     * Ajusta un movimiento del almacen. el id del movimeinto 'idproductonota' es enviado como parámetro
     * EL producto del cual se desea ajustar el kardex tb será enviado como parámetro aunque no es necesario
     * ya que tenemos el idproductonota y podríamos extraer el idproducto  de esta tupla pero como
     * ya tenemos el idproducto lo utilizaresmos directamente sin hacer una consulta demás
     * 
     */
    public function ajustaMovimientoKardexAlmacen($nuevocosto,$idproductonota,$idproducto,$fechamovimiento){
        $respuesta=array();
        $modelProductonota = Productonota::model()->findByAttributes(array('id' => $idproductonota));
        $modelNota = $modelProductonota->idnota0;
        $movimientoAnterior = $this->obtenerMovimientoAnteriorProductoNota($fechamovimiento,$idproductonota,$idproducto);
        if($modelProductonota==null){
            $respuesta=array(
                    "error" => true,
                    'mensaje' => 'No se encontro productonota'
                );
            return respuesta;
        }
        
        if($movimientoAnterior==null){
            
            $respuesta=array(
                    "error" => true,
                    'mensaje' => 'No se encontro un movimiento anterior'
                );
            return respuesta;
            
        }else{
            $modelProducto = Producto::model()->findByAttributes(array('id' => $idproducto));
            $importeanterior = 0;
            $saldoimporteanterior = 0;
            $importenuevo = 0;
            $saldoimporteanterior = $movimientoAnterior->saldoimporte;
            $ultimoppp = 0;
            if($movimientoAnterior->saldo==0)
            {  //($data->ingresoimporte-$data->salidaimporte)/($dataingreso-$data->salida)
                $difimp=($movimientoAnterior->ingresoimporte-$movimientoAnterior->salidaimporte);
                $difcantida=($movimientoAnterior->ingreso-$movimientoAnterior->salida);
                $ultimoppp = $difimp/$difcantida;
                //$ultimoppp = round($ultimoppp,4);
            }
            else{
                $ultimoppp = $movimientoAnterior->saldoimporte/$movimientoAnterior->saldo;
                //$ultimoppp = round($ultimoppp,4);
            }
            
            if($modelNota->idtipo==1){//INGRESO                
                $iop=strpos($modelProductonota->glosa, 'INGRESO POR ENTREGA DE O.P. N')!==false?true:false;
                if($iop===false)
                $iop=strpos($modelProductonota->glosa, 'INGRESO POR AJUSTE DE SISTEMA')!==false?true:false;
                if($iop===true){
                    $importeanterior = $modelProductonota->ingresoimporte;
                    $modelProductonota->ingresoimporte = $nuevocosto * $modelProductonota->ingreso;
                    $modelProductonota->ingresoimporte = round($modelProductonota->ingresoimporte,2);
                    $modelProductonota->saldoimporte=$movimientoAnterior->saldoimporte+$modelProductonota->ingresoimporte;
                    $importenuevo = $modelProductonota->ingresoimporte;
                }else{
                    $importeanterior = $modelProductonota->ingresoimporte;
                    $modelProductonota->ingresoimporte = $ultimoppp * $modelProductonota->ingreso;
                    $modelProductonota->ingresoimporte = round($modelProductonota->ingresoimporte,2);
                    $modelProductonota->saldoimporte=$movimientoAnterior->saldoimporte+$modelProductonota->ingresoimporte;
                    $importenuevo = $modelProductonota->ingresoimporte;
                }
            }
            if($modelNota->idtipo==2){//SALDIA                
                
//                if($sop===true){
//                    $importeanterior = $modelProductonota->salidaimporte;
//                    $modelProductonota->salidaimporte = $nuevocosto * round($modelProductonota->salida, 4);
//                    $modelProductonota->saldoimporte=$movimientoAnterior->saldoimporte-$modelProductonota->salidaimporte;
//                    $importenuevo = $modelProductonota->saldoimporte;
//                }else{
                    $importeanterior = $modelProductonota->salidaimporte;
                    $modelProductonota->salidaimporte = $ultimoppp * $modelProductonota->salida;
                    $modelProductonota->salidaimporte = round($modelProductonota->salidaimporte,2);
                    $modelProductonota->saldoimporte=$movimientoAnterior->saldoimporte-$modelProductonota->salidaimporte;
                    $importenuevo = $modelProductonota->salidaimporte;
//                }
            }
            $ultimoppp = round($ultimoppp,4);
            if($modelProductonota->update(array("ingresoimporte","salidaimporte","saldoimporte"))){
                $respuesta = array(
                    "error" => false,
                    'idtipo' => $modelNota->idtipo,
                    'importeanterior' => $importeanterior,
                    'saldoimporteanterior' => $saldoimporteanterior,
                    'idproductonotaanterior' => $movimientoAnterior->id,
                    'nuevoimporte' => $importenuevo,
                    'nuevocosto' => $nuevocosto,
                    'uppp' => $ultimoppp,
                    'movimientohtml' => $this->construirTablaMovimientoAlmacen($modelProductonota)
                );
            }else{
                $respuesta=array(
                    "error" => true,
                    'mensaje' => 'No se guardó producto nota'
                );
                return $respuesta;
            }
        }
        return $respuesta;
    }
    /**
     * Obtiene el moviento anterior del almacen que pertenece a algún producto
     * 
     */
    public function obtenerMovimientoAnteriorProductoNota($fecha,$idprodnota,$idproducto){
        
        
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';
        //$criteria->addCondition("t.glosa LIKE 'INGRESO POR ENTREGA DE O.P. N%'");
        $criteria->addCondition("t.fecha < '".$fecha."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha DESC,t.id DESC";        
        
        $modelArray = Productonota::model()->find($criteria);
        
        $modelNotaId=$this->obtenerMovimientoAnteriorProductoNotaPorId($idprodnota,$idproducto);
        if($modelNotaId->fecha==$fecha){
            $modelArray=$modelNotaId;
        }
        
        return $modelArray;
    }   
    /**
     * Obtiene el moviento anterior del almacen que pertenece a algún producto
     * busca por id
     */
    public function obtenerMovimientoAnteriorProductoNotaPorId($idprodnota,$idproducto){
        
        
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';
        //$criteria->addCondition("t.glosa LIKE 'INGRESO POR ENTREGA DE O.P. N%'");
        $criteria->addCondition("t.id < '".$idprodnota."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha DESC,t.id DESC";        
        
        $modelArray = Productonota::model()->find($criteria);
        return $modelArray;
    }   
    /*
     * Ajusta el costo de orden de produccion
    */
    public function ajustarCostoOrdenProduccion($idordenproduccion){
        
    }
    
    public function obtenerUltimoMovimientoAlmacen(){
        $idproducto = $this->id;
        $criteria = new CDbCriteria;
        $criteria->with = array('idnota0');
        $criteria->select = 't.*';
        //$criteria->addCondition("t.glosa LIKE 'INGRESO POR ENTREGA DE O.P. N%'");
        //$criteria->addCondition("t.idproducto = '".$idprodnota."'");
        $criteria->addCondition("t.idproducto = ".$idproducto);
        $criteria->addCondition("idnota0.eliminado = FALSE");
        $criteria->order = "t.fecha DESC,t.id DESC";        
        
        $modelArray = Productonota::model()->find($criteria);
        return $modelArray;
    }
    
    /**
     * Actuliza los saldos de un producto
     * Este método es invocado despues de modificar el kardex del almacen
     */
    public function actualizarSaldosProductoMK(){
        $modelproductoNota = $this->obtenerUltimoMovimientoAlmacen();
        $saldo=$modelproductoNota->saldo;
        $saldoimporte=$modelproductoNota->saldoimporte;
        //$this->update(array("saldo","saldoimporte"));
        $sqlactualizar = "UPDATE producto SET saldoimporte=$saldoimporte WHERE id=".$this->id;
        Yii::app()->almacen->createCommand($sqlactualizar)->execute();
    }
    
//    public function getArbol($fecha,&$data,$idpadre,$codigo){        
//        $criteria = new CDbCriteria;
//        $criteria->with = array('idnota0');
//        $criteria->select = 't.*';
//        //$criteria->join = 'INNER JOIN ';
//        $criteria->addCondition("t.glosa LIKE 'SALIDA PARA O.P.%'");
//        $criteria->addCondition("t.fecha > '".$fecha."'");
//        $criteria->addCondition("t.idproducto = (SELECT id FROM producto WHERE codigo like '".$codigo."' limit 1)");
//        $criteria->addCondition("idnota0.eliminado = FALSE");
//        $criteria->order = "t.fecha,idnota0.id ASC";
//        /*$connection = Yii::app()->almacen;        
//        $q = "SELECT pn.* FROM productonota pn "
//                . "INNER JOIN producto p ON p.id=pn.idproducto "
//                . "INNER JOIN nota n ON n.id = pn.idnota "
//                . "WHERE pn.eliminado=false AND "
//                . "pn.fecha > '".$fecha."' AND "
//                . "pn.idproducto = (SELECT id FROM producto WHERE codigo like '".$codigo."' limit 1) AND "
//                . "n.eliminado=false AND pn.idproducto = ".$idproducto." "
//                . "ORDER BY pn.fecha,n.id asc";      
//        $command = $connection->createCommand($q);
//        $modelArray = $command->queryAll();*/
//        
//        $modelArray = Productonota::model()->findAll($criteria);
//        if($modelArray == null) {
//            /*$data[] = array(
//                'fecha' => $fecha,
//                'idpadre' => $idpadre,
//                'cod' => $codigo,
//                
//                );*/
//            return;
//        }
//        
//        foreach ($modelArray as $get) {
//            $idnotaborr=$get->idnota0->idnotaborrador;
//            $command = Yii::app()->produccion->createCommand("select p.codigo FROM orden t INNER JOIN ordenreceta ore ON ore.id=t.id INNER JOIN ordenrecetaproducto orp ON orp.idordenreceta = t.id INNER JOIN producto p ON p.id = ore.idproducto AND orp.idnotaborrador=".$idnotaborr)
//                ->queryRow();
//            /*$opmo=Orden::model()->findByPk($iddocon);
//            if($opmo==null) return;*/
//            $codP = $command['codigo'];
//            //Producto::model()->findByPk($opmo->idproducto)->codigo;
//            $data[] = array(
//                'key' => $get->id,
//                'txt' => $codP!=null?$codP:"idnotaborrador:".$idnotaborr,
//                'parent' => $idpadre
//                );
//            $this->getArbol($get->fecha,$data,$get->id,$codP);
//        }
//        
//    }
    
    /*
     * Obtiene por cada producto si tiene error o no, devuelve 1 o 0
     * 1 => SI TIENE ERROR
     * 0 => NO TIENE ERROR
     */
    public function getMovimiento()
    {
        $arrayResultado = Productonota::model()->movimientoProducto($this->id);
        
        $saldoImporte = $arrayResultado['saldoImporte'];
        $contadorSaldoCantidadError = $arrayResultado['contadorSaldoCantidadError'];
        $contadorSaldoCantidadNegativos = $arrayResultado['contadorSaldoCantidadNegativos'];
        $contadorSaldoImporteError = $arrayResultado['contadorSaldoImporteError'];
        $contadorSaldoImporteNegativos = $arrayResultado['contadorSaldoImporteNegativos'];
        
        if($contadorSaldoCantidadError > 0 || $contadorSaldoCantidadNegativos > 0 || 
           $contadorSaldoImporteError > 0 || $contadorSaldoImporteNegativos > 0 || 
           $saldoImporte != $this->saldoimporte && $saldoImporte != null)
            $errores = 1;
        else
            $errores = 0;
        return $errores;
    }
    
    /**
     * Consultar los productos que coincidan con el codigo
     * @param string $codigo
     * @param array $productoExcluido //Id de productos que no debe mostrarse
     * @return \CActiveDataProvider
     */
    public function buscarProductoCodigo($productoExcluido, $idalm, $codigo = '') {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0', 'idunidad0');
        $criteria->addNotInCondition("t.id", $productoExcluido);
        if ($idalm !== Null) {
            $criteria->compare('t.idalmacen', $idalm);
        }
        $criteria->addSearchCondition('t.codigo', $codigo, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Consultar los productos que coincidan con el nombre
     * @param string $codigo
     * @param array $productoExcluido //Id de productos que no debe mostrarse
     * @return \CActiveDataProvider
     */
    public function buscarProductoNombre($productoExcluido, $idalm, $nombre = '') {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0', 'idunidad0');
        $criteria->addNotInCondition("t.id", $productoExcluido);
        if ($idalm !== Null) {
            $criteria->compare('t.idalmacen', $idalm);
        }
        $criteria->addSearchCondition('t.nombre', $nombre, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * actualiza saldo/reserva de producto , INCREMENTANDO O DECREMENTANDO las cantidades
     */
    public function updateSaldoReserva(){  
        $set ='';
        if($this->saldoIncrementar!=null){
            $set.=' saldo=saldo+'.$this->saldoIncrementar;
        }
        if($this->saldoimporteIncrementar!=null){
            $set.=($set==''?'':',').' saldoimporte=saldoimporte+'.$this->saldoimporteIncrementar;
        }
        
        if($this->saldoDecrementar!=null){
            $set.=($set==''?'':',').' saldo=saldo-'.$this->saldoDecrementar;
        }
                
        if($this->saldoimporteDecrementar!=null){
            $set.=($set==''?'':',').' saldoimporte=saldoimporte-'.$this->saldoimporteDecrementar;
        }
        
        if($this->reservaIncrementar!=null){
            $set.=($set==''?'':',').' reserva=reserva+'.$this->reservaIncrementar;
        }
        
        if($this->reservaDecrementar!=null){
            $set.=($set==''?'':',').' reserva=reserva-'.$this->reservaDecrementar;
        }
        
        if($set!=''){
            $sql="update producto set $set  where id=".$this->id;
            $command = Yii::app()->almacen->createCommand($sql);
            $command->query();        
        }
        
    }

    // ----- funcion para reserva de solicitudes de tpv ---
    public function actualizaReservaSolicitud($idproducto,$cantidad){
        $producto = Producto::model()->findByPk($idproducto);
        $producto->scenario = 'actualizarreserva';
        $producto->reserva = $producto->reserva + $cantidad;
        $producto->update(array('reserva'));
    }
    // ----- funcion para quitar reserva de solicitudes de tpv ---
    public function quitarReservaSolicitud($idproducto,$cantidad){
        $producto = Producto::model()->findByPk($idproducto);
        $producto->scenario = 'actualizarreserva';
        $producto->reserva = $producto->reserva - $cantidad;
        $producto->update(array('reserva'));
    }
    // ----- funcion para actualizar saldo de solicitudes de tpv ---
    public function actualizaSaldoSolicitud($idproducto,$cantidad){
        $producto = Producto::model()->findByPk($idproducto);
        $producto->scenario = 'actualizarreserva';
        $producto->saldo = $producto->saldo - $cantidad;
        $producto->update(array('reserva'));
    }
    public function searchProductoTpv($nombre, $itemExcluido, $idalmacenorigen, $idalmacen,$boolCodigo) {
        $criteria = new CDbCriteria;
        $criteria->addNotInCondition('t.id', $itemExcluido);
        if ($idalmacen !== '') {
            $criteria->addCondition("t.idalmacen =" . $idalmacen, "AND");
        }
        if($boolCodigo == true)
            $criteria->addSearchCondition('t.codigo', $nombre, true, 'AND', 'ILIKE');
        else
            $criteria->addSearchCondition('t.nombre', $nombre, true, 'AND', 'ILIKE');
        
        $criteria->addCondition("t.codigo IN (SELECT codigo FROM producto WHERE nombre ilike '%" . $nombre . "%' or codigo ilike '%" . $nombre . "%' AND idalmacen =" . $idalmacenorigen . ")");
        
        return new CActiveDataProvider($this, array(
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'criteria' => $criteria
        ));
    }
    public function searchProductos($dato, $itemExcluido) {
        $criteria = new CDbCriteria;
        
        $criteria->addNotInCondition('t.id', $itemExcluido);
        $criteria->compare('t.idalmacen', Almacen::TERMINADOS);
        $criteria->addCondition("(t.codigo ilike '%".$dato."%' or t.nombre ilike '%".$dato."%')");
        
        return new CActiveDataProvider($this, array(
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'criteria' => $criteria
        ));
    }
    
    /**
     * Función que obtiene el stock de productos de un determinado almacén
     * y retorna para que pueda exportarse a un archivo de EXCEL
     * @param type $ids
     */
    public function obtieneStockProductos($ids) {
        $command = Yii::app()->almacen->createCommand("select p.codigo,p.nombre, p.stockminimo,p.saldo,p.stockmaximo,p.puntopedido, p.reserva, p.saldo-p.reserva as disponible,u.simbolo from producto p inner join (select unnest('".$ids."'::int[]) as id) as x on (x.id=p.id) left join unidad u on p.idunidad = u.id order by p.codigo");
        return $command->queryAll();
    }
    
    public function updateSaldoAlmacen(){  
        $sql="update producto set saldo=".$this->saldo.","
                . " reserva=".$this->reserva.","
                . " saldoimporte=".($this->saldoimporte==null?'null':$this->saldoimporte).""
                . " where id=".$this->id;
       
        $command = Yii::app()->almacen->createCommand($sql);
        $command->query();
    }
    
    public function findProducto($dato)
    {
        $criteria = new CDbCriteria;
        $criteria->distinct = true;
        $criteria->select = 't.id, t.codigo, t.nombre, u.simbolo, a.nombre as almacen';
        $criteria->join = ' inner join unidad u on t.idunidad = u.id'
                            . ' inner join almacen a on a.id = t.idalmacen';
        //inner join unidad up on t.idunidadproduccion = up.id';
        $criteria->addCondition("(t.codigo ilike '%".$dato."%' or t.nombre ilike '%".$dato."%') 
            and t.id in (select idproducto
                                from receta r
                                where r.eliminado is false and idestadoreceta <> ".FtblProduccionEstadoreceta::BORRADOR."
                                order by r.id asc)");
        $data = $this->findAll($criteria);
        return $data;
    }
    
    /*
     * filtra los ingredientes del producto
     */
    public function searchCodigoProductoExcluida($valor = '', $productoExcluido) {
        
        $criteria = new CDbCriteria();
        
        $criteria->select = 't.*, u.simbolo,u.permitirdecimal as entero';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';

        $criteria->addCondition("t.codigo ilike '%" . $valor . "%' AND "
                               ."t.idalmacen in(select id from almacen where eliminado is false"
                . " and idalmacen is null) ");
        $criteria->addNotInCondition('t.id', $productoExcluido);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }
    
    public function searchNombreProductoExcluida($valor = '', $productoExcluido) {

        $criteria = new CDbCriteria();

        $criteria->select = 't.*, u.simbolo,u.permitirdecimal as entero';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';

        $criteria->addCondition("t.nombre ilike '%" . $valor . "%' AND "
                               ."t.idalmacen in (select id from almacen where eliminado is false"
                . " and idalmacen is null) ");
        $criteria->addNotInCondition('t.id', $productoExcluido);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }
    
    public function findProductoExcluido($dato,$idalmacen) {
        //condicion, si el almacen no a sido enviado buscar en todos los almacenes
        $consultaadicional="";
        if($idalmacen!=null){
            $consultaadicional="AND t.idalmacen=".$idalmacen;        
        }
        
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.*, u.simbolo';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';
        $criteria->addCondition("(t.codigo ilike '" . $dato . "%' OR "
                                ."t.nombre ilike '%" . $dato . "%') AND "
                                ."t.idalmacen in(select id from almacen where eliminado is false) ".($idalmacen!=null?$consultaadicional:"")." AND "
                                .'t.id NOT IN (select idproducto
                                from receta r
                                where r.eliminado is false
                                order by r.id asc)');
        $data = $this->findAll($criteria);
        return $data;
    }
    
    public function buscarProducto($request='') {
        $criteria = new CDbCriteria;
        $criteria->select='t.codigo,t.nombre,t.id';
        $criteria->addCondition("(t.codigo ilike '%$request%' or t.nombre ilike '%$request%') and t.idproductopadre is null");
        $criteria->distinct = true;
        return new CActiveDataProvider($this, array(
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'criteria' => $criteria,
            
        ));
    }
    
    
    
    // -------------------------------------------------------------------------
    // ------------------- [ Agrupación de productos "TPV" ] -------------------
    // -------------------------------------------------------------------------
    public function searchAgrupacion() {
        $criteria = new CDbCriteria;
        $criteria->with = array('idfamilia0', 'idclase0', 'idalmacen0', 'idunidad0');
        $criteria->addCondition("t.grupo is true");
        
        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->compare('t.coduniversal', $this->coduniversal);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('valor', $this->valor, true);
        $criteria->compare('costo', $this->costo, true);
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        //$criteria->compare('t.idalmacen', Almacen::model()->idAlmacenProductosTerminados);
        $criteria->addCondition("idalmacen0.idalmacen is null");
        
        if ($this->lineatabu !=null){
            $criteria->compare('t.lineatabu', $this->lineatabu==1?true:false);
        }
        if ($this->admitedescuento != null){
            $criteria->addCondition('t.admitedescuento='.$this->admitedescuento);
        }
        
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.codigo asc,idalmacen0.nombre asc',
                'attributes' => array(
                    'idunidad' => array(
                        'asc' => 'idunidad0.simbolo',
                        'desc' => 'idunidad0.simbolo DESC',
                    ),
                    'idalmacen' => array(
                        'asc' => 'idalmacen0.nombre',
                        'desc' => 'idalmacen0.nombre DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }
    public function muestraProductoPadre($dato) {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0');
        $criteria->addCondition("idalmacen0.idalmacen is null");
        $criteria->addCondition("t.grupo is false and (t.codigo ilike '".$dato."%' OR t.nombre ilike '%".$dato."%') ");
        $criteria->limit = 15;//Yii::app()->params['defaultPageSizeSearch'];
        $data = $this->findAll($criteria);
        
        return $data;
    }
    public function searchProductoAgrupacion($nombre = '', $itemExcluido, $precio, $idproductoPadre) {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0');
        $criteria->addNotInCondition('t.id', $itemExcluido);
        $criteria->addCondition("t.id != ".$idproductoPadre);
//        $criteria->addCondition("t.id NOT IN(select idproducto from agrupacionproducto where eliminado is false)");
//        $criteria->addCondition("t.idalmacen = ".Almacen::TERMINADOS);
        $criteria->addCondition("idalmacen0.idalmacen is null");
//        $criteria->addCondition("t.precio = ".$precio);
        $criteria->addCondition("t.nombre ilike '%" . $nombre . "%' or t.codigo ilike '%" . $nombre . "%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSizeSearch'],
            ),
        ));
    }
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    public function searchProductoReproceso($nombre = '', $itemExcluido, $idproductoPadre) {
        $criteria = new CDbCriteria;
        $criteria->with = array('idalmacen0');
        $criteria->addNotInCondition('t.id', $itemExcluido);
        $criteria->addCondition("t.id != ".$idproductoPadre);
//        $criteria->addCondition("t.id NOT IN(select idproducto from agrupacionproducto where eliminado is false)");
//        $criteria->addCondition("t.idalmacen = ".Almacen::TERMINADOS);
        $criteria->addCondition("idalmacen0.idalmacen is null");
        $criteria->addCondition("t.nombre ilike '%" . $nombre . "%' or t.codigo ilike '%" . $nombre . "%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSizeSearch'],
            ),
        ));
    }
    
    public function buscaProducto($request='') {
        $criteria = new CDbCriteria;
        $criteria->select='t.codigo,t.nombre,t.id';
        $criteria->addCondition("(t.codigo ilike '%$request%' or t.nombre ilike '%$request%')");
        $criteria->distinct = true;
        return new CActiveDataProvider($this, array(
            'sort' => array('defaultOrder' => 't.nombre asc'),
            'criteria' => $criteria,
            
        ));
    }
    
    public function getConsumoActual(){
        $consumoactual = Yii::app()->almacen->createCommand("select consumoactual(".$this->id.")")->queryScalar();
        
        if(empty($consumoactual)){
           $consumoactual =0; 
        }
        
        return $consumoactual;
    }
    
    /*public function getConsumoHistorico(){
        $gestion = Yii::app()->almacen->createCommand("select * from configuracion.gestion where abierta is false order by id desc limit 1")->queryRow();
        $consumohistorico=0;
        if (!empty($gestion)){
            $totalConsumoHistorico = Yii::app()->almacen->createCommand("select coalesce(sum(sum),0) from (
                select * from consumomeses(".$this->id.",'".$gestion['inicio']."','".$gestion['fin']."','".$gestion['esquema']."'))a")->queryScalar();
            $cantidadMesesConsumo = Yii::app()->almacen->createCommand("select count(sum) from (
                select * from consumomeses(".$this->id.",'".$gestion['inicio']."','".$gestion['fin']."','".$gestion['esquema']."') where sum > 0)a")->queryScalar();
            if (!empty($totalConsumoHistorico)){
                $consumohistorico = $totalConsumoHistorico/$cantidadMesesConsumo;
            }
        }
        
        return $consumohistorico;

    }*/
    
    public function getConsumoMaximo(){
        $gestion = Yii::app()->almacen->createCommand("select * from configuracion.gestion where abierta is false order by id desc limit 1")->queryRow();
        $consumomaximo=0;
        if (!empty($gestion)){
            $consumomaximo = Yii::app()->almacen->createCommand("select max(sum) from (
                select * from consumomeses(".$this->id.",'".$gestion['inicio']."','".$gestion['fin']."','".$gestion['esquema']."'))a")->queryScalar();
            if (empty($consumomaximo)){
                $consumomaximo=0;
            }
        }
        
        return $consumomaximo;

    }
    
    public function getDuracionConsumo(){
        return ($this->stockminimo == null||$data->stockminimo==0)?null:round($data->saldo/$data->stockminimo,3);
    }
}