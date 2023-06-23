<?php

/*
 * Producto.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 21/05/2015
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

 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $valor
 * @property string $costo
 * @property string $utilidad
 * @property string $stockminimo
 * @property string $stockreposicion
 * @property string $stockmaximo
 * @property string $saldo
 * @property integer $idproductopadre
 * @property string $puntopedido
 * @property string $reserva
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Ordenrecetaproducto[] $ordenrecetaproductos
 */

class ProduccionProducto extends CActiveRecord {
  public $seguimientoinsumo;
   public $cantidad;
    
    // Variables
    public $totalentregado;
    
    public $simbolo;
    public $entero;
    public $reserva;
    public $saldo;
    
    public $almacen;
   
    public $cantidadEntregada;
    public $cantidadPresente;


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
            array('id, nombre, valor, fecha', 'required'),
            array('id, idproductopadre', 'numerical', 'integerOnly' => true),
            array('codigo, stockminimo, stockreposicion, stockmaximo, saldo, puntopedido', 'length', 'max' => 12),
            array('nombre', 'length', 'max' => 100),
            array('costo', 'length', 'max' => 10),
            array('utilidad', 'length', 'max' => 20),
            array('almacen', 'length', 'max' => 50),
            array('reserva', 'length', 'max' => 14),
            array('usuario', 'length', 'max' => 30),
            array('eliminado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, nombre, valor, costo, utilidad, stockminimo, '
                . 'stockreposicion, stockmaximo, saldo, almacen, idproductopadre,'
                . ' puntopedido, reserva, fecha, eliminado, idunidad, usuario,'
                . 'inventariar,codigouniversal,
		nombresenasag,idunidadpresentacion,ultimoppp,precio,utilidad ', 'safe', 'on' => 'search'),
        );
        
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ordenrecetaproductos' => array(self::HAS_MANY, 'Ordenrecetaproducto', 'idproducto'),
            'idalmacen0' => array(self::BELONGS_TO, 'Almacen', 'idalmacen'),
            'idunidad0' => array(self::BELONGS_TO, 'Unidad', 'idunidad'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'valor' => 'Valor',
            'costo' => 'Costo',
            'utilidad' => 'Utilidad',
            'stockminimo' => 'Stockminimo',
            'stockreposicion' => 'Stockreposicion',
            'stockmaximo' => 'Stockmaximo',
            'saldo' => 'Saldo',
            'almacen' => 'Almacen',
            'idproductopadre' => 'Idproductopadre',
            'puntopedido' => 'Puntopedido',
            'reserva' => 'Reserva',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.codigo', $this->codigo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.valor', $this->valor, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.costo', $this->costo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.utilidad', $this->utilidad, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.stockminimo', $this->stockminimo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.stockreposicion', $this->stockreposicion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.stockmaximo', $this->stockmaximo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.saldo', $this->saldo, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.almacen', $this->almacen, true, 'AND', 'ILIKE');
        $criteria->compare('t.idproductopadre', $this->idproductopadre);
        $criteria->addSearchCondition('t.puntopedido', $this->puntopedido, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.reserva', $this->reserva, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->produccion;
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
        $this->codigo = strtoupper($this->codigo);
        $this->nombre = strtoupper($this->nombre);
        $this->valor = strtoupper($this->valor);
        $this->almacen = strtoupper($this->almacen);
        if ($this->isNewRecord) {
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }
     /**
     * Consultar el producto actual para obtener el simbolo de la unidad
     * @return string
     */
    public function getSimbolo() {
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.*, u.simbolo';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';
        $criteria->addCondition("t.id=".$this->id);
       
        $data = $this->find($criteria);
        //
        return $data->simbolo;
    }

    /**
     * Consultar los productos que coincidan con el código o nombre
     * @param string $valor
     * @return \CActiveDataProvider
     */
    public function findProductoExcluido($dato,$idalmacen) {
        //condicion, si el almacen no a sido enviado buscar en todos los almacenes
        $consultaadicional="";
        if($idalmacen!=null){
            $consultaadicional="AND t.idalmacen=".$idalmacen;        
            
        }
        
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.*, u.simbolo';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';
        $criteria->addCondition("(t.codigo like '" . $dato . "%' OR "
                                ."t.nombre like '%" . $dato . "%') AND "
                                //."t.idproductopadre is null AND "
                                ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ".($idalmacen!=null?$consultaadicional:"")." AND "
                                ."t.id NOT IN (select idproducto
                                from receta r inner join ordenreceta o on r.id=o.id
                                where r.idreceta is null and r.eliminado is false
                                order by r.id asc)");
        $data = $this->findAll($criteria);
        return $data;
    }
    /**
     * Consultar los productos que coincidan con el código o nombre. Para la merma
     * @param string $valor
     * @return \CActiveDataProvider
     */
    public function findProductoExcluidoMerma($dato,$idalmacen) {
        //condicion, si el almacen no a sido enviado buscar en todos los almacenes
        $consultaadicional="";
        if($idalmacen!=null){
            $consultaadicional="AND t.idalmacen=".$idalmacen;
            
        }
        
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.*, u.simbolo';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';
        $criteria->addCondition("(t.codigo like '" . $dato . "%' OR "
                                ."t.nombre like '%" . $dato . "%') AND "
                                //."t.idproductopadre is null AND "
                                ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ".($idalmacen!=null?$consultaadicional:""));
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
                               ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ");
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
                               ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ");
        $criteria->addNotInCondition('t.id', $productoExcluido);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }
    /*
     * filtra los ingredientes del producto residual
     */
    public function searchCodigoProductoResidualExcluida($valor = '', $productoExcluido) {
        $criteria = new CDbCriteria();
        
        $criteria->select = 't.*, u.simbolo';
        $criteria->join = 'inner join unidad u on t.idunidad = u.id ';
        
        $criteria->addCondition("t.eliminado = false AND t.codigo ilike '%" . $valor . "%' AND "
                               ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ");
        $criteria->addNotInCondition('t.id', $productoExcluido);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
    /*
     * filtra los ingredientes del producto residual
     */
    public function searchNombreProductoResidualExcluida($valor = '', $productoExcluido) {
        $criteria = new CDbCriteria();

        $criteria->select = 't.*, u.simbolo';
        $criteria->join =  'inner join unidad u on t.idunidad = u.id ';
       
        $criteria->addCondition("t.eliminado = false AND t.nombre ilike '%" . $valor . "%' AND "
                               ."t.idalmacen in(select id from almacen where eliminado is false and idalmacen is null) ");
        $criteria->addNotInCondition('t.id', $productoExcluido);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    public function primaryKey() {
        //parent::primaryKey();
        return "id";
    }
    
    /*
     * funcion creada para el icono de "Iniciar Orden" del admin de "Orden".
     * Retorna los productos de la base de datos.
     * @param integer $indice
     * @param integer $idproducto
     * @param array $productos
     * @return array
     */
    public function datosProductos($indice, $idproducto, $productos)
    {
        $criteria = new CDbCriteria;
        $productosSeleccionadas = array();
        
        if (isset($productos))
            $productosSeleccionadas = $this->getIdProductos($indice, $idproducto, $productos);
        
        $criteria->select = 't.*';
        $criteria->addInCondition('t.id', $productosSeleccionadas);
        $data = $this->findAll($criteria);
        return $data;
    }
    
    /*
     * devuelve los ids de todos los productos
     * @param integer $indice
     * @param integer $idproducto
     * @param array $producto
     * @return array
     */
    private function getIdProductos($indice, $idproducto, $producto) {
        $idProducto = null;
        $cantidad = count($producto);
        
        if($indice == 0)
            $cantidad = $cantidad - 1;
        else
            $cantidad = $cantidad;
        
        for ($i = $indice; $i <= $cantidad; $i++) {
            $idProducto[] = ($producto[$i][$idproducto]);
        }
        return $idProducto;
    }
    
    /*
     * retorno los productos filtrados por los codigos de los productos del Grid
     * @param array $productos
     * @param integer $idAlmacen
     */
    public function codigosProductos($productos, $idAlmacen)
    {
        $criteria = new CDbCriteria;
        $productosSeleccionadas = array();
        
        if (isset($productos))
            $productosSeleccionadas = $this->getCodigosProductos($productos);
        
        $criteria->select = 't.*';
        $criteria->addInCondition('t.codigo', $productosSeleccionadas);
        $criteria->addCondition('t.idalmacen != '.$idAlmacen.' and idproductopadre is null');
        $data = $this->findAll($criteria);
        
        return $data;
    }
    
    /*
     * retorna los codigos de los productos
     * @param array $productos
     * @return array
     */
    private function getCodigosProductos($productos) {
        $codigoProducto = null;
        $cantidad = count($productos);
        
        for ($i = 0; $i < $cantidad; $i++)
            $codigoProducto[] = ($productos[$i]['codigo']);
        
        return $codigoProducto;
    }
    
}
