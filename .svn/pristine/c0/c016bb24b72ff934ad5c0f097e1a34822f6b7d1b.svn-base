<?php

/*
 * Ordenreceta.php
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

 * This is the model class for table "ordenreceta".
 *
 * The followings are the available columns in table 'ordenreceta':
 * @property integer $id
 * @property string $descripcion
 * @property integer $idproducto
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Orden $orden
 * @property Ordenrecetacostoderivado[] $ordenrecetacostoderivados
 * @property Ordenrecetaprocesoempleadomaquina[] $ordenrecetaprocesoempleadomaquinas
 * @property Receta $receta
 * @property Ordenrecetaproducto[] $ordenrecetaproductos
 */

class ProduccionOrdenreceta extends CActiveRecord {
    
    public $idproductomerma;
    public $productoValidoMerma;
    public $productomerma;    
    public $unidadmerma;
    
    public $cantidadoriginalreceta;
    public $idorp;
    public $idnotaborrador;
    public $seguimientoinsumo;
    public $ultimoestado;
    public $totalentrega;
    public $totalsubproductos;
    public $totaldevolucion;
    public $mermasugerida;
    public $totalinsumos;
    
    public $idalmacen;
    public $idestadoreceta;
    
    public $recetaespecial;
    
    public $producto;
    public $productoValido;
    public $productoVerifica;
    public $idAnterior;
    
    // variables
    public $codigo;
    public $nombre;
    public $idordenreceta;
    public $simbolo;
    public $cantidad;
    public $cantidadproducir;
    public $cantidadProducirReceta;
    public $saldo;
    public $reserva;
    
    public $numero;
    public $fechaplanificada;
    public $estado;
    
    public $idresponsableorden;
    public $responsableorden;
    public $numerotrabajadores;
    
    //boolean para identificar si una receta es o no residual
    public $residual;
    
    public $rkw;
    
    //------ reprocesado ----
    public $reprocesado;
    public $idreprocesado;
    public $tienereprocesado;
    public $indirecto;
    public $tipocalculo;
    //---- calculo manual ---
    public $idproductoreprocesado;
    public $productoreprocesado;
    public $cantidadreprocesado;
    public $idreprocesadoindirecto;
    public $idproductoreceta;
    public $simboloproduccion;
    //----- validacion entero para unidades --
    public $entero;
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
        return 'ordenreceta';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idproducto', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 30),
            array('descripcion, codigo, fecha, eliminado, fechaplanificada', 'safe'),
            array('fechaplanificada', 'required', 'on' => array('insert')),
            array('producto', 'esProducto', 'on' => array('insert', 'update')),
            array('producto, cantidadproducir', 'required', 'on' => array('insert', 'update')),
            
            array('cantidadproducir', 'length', 'max' => 10),
            array('cantidadproducir', 'numerical', 'min'=>0.000001, 'tooSmall'=>'La cantidad a producir debe ser mayor a 0'),
            
            // // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rkw,id,descripcion, idproducto, fecha, usuario, eliminado', 'safe', 'on' => 'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orden' => array(self::HAS_ONE, 'Orden', 'id'),
            'ordenrecetacostoderivados' => array(self::HAS_MANY, 'Ordenrecetacostoderivado', 'idordenreceta'),
            'ordenrecetaprocesoempleadomaquinas' => array(self::HAS_MANY, 'Ordenrecetaprocesoempleadomaquina', 'idordenreceta'),
            'receta' => array(self::HAS_ONE, 'Receta', 'id'),
            'ordenrecetaproductos' => array(self::HAS_MANY, 'Ordenrecetaproducto', 'idordenreceta'),
            'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'descripcion' => 'Observación',
            'idproducto' => 'Idproducto',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'eliminado' => 'Eliminado',
            'fechaplanificada' => 'Fecha Planificada',
            'cantidadproducir' => 'Cantidad Producir',
            'estado' => 'INICIAR',
            'numero' => 'N°',
            'residual'=>'Subproducto',
            'recetaespecial'=>'Receta Especial',
            'idestadoreceta'=>'Estado Receta',
            'idalmacen'=>'Almacén',
            'totalentrega'=>'Total kg:',
            'totaldevolucion'=>'Total kg:',
            'mermasugerida'=>'Merma sugerida',
            'totalinsumos'=>'Total kg:',
            'responsableorden'=>'Responsable',
            'unidadmerma'=>'Unidad',
            'idproductomerma'=>'Producto',
            'productomerma'=>'Producto',
            'unidadmerma'=>'Unidad',
            'totalsubproductos'=>'Total kg:',
            'numerotrabajadores' => 'Nº Trabajadores',
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
        $criteria->addSearchCondition('t.descripcion', $this->descripcion, true, 'AND', 'ILIKE');
        $criteria->compare('t.idproducto', $this->idproducto);
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
     * @return Ordenreceta the static model class
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
        $this->descripcion = strtoupper($this->descripcion);
        if ($this->isNewRecord) {
            if ($this->fecha == Null || $this->fecha == '') {
                $this->fecha = new CDbExpression('NOW()');
            }
            if ($this->usuario == Null || $this->usuario == '') {
                $this->usuario = Yii::app()->user->getName();
            }
        }
        return parent::beforeSave();
    }

    /*
     * Metodo que registra orden receta insumos, al crear la orden
     * @param integer $idordenreceta
     * @param array $productos
     */
    public function registrarOrdenrecetaAlCrearOrden($idordenreceta, &$productos) {
        $modelo = new Ordenrecetaproducto;
        
        if ($idordenreceta != Null && isset($productos)) {
            $modelo->idordenreceta = $idordenreceta;
            $cantidad = count($productos);
            
            for ($i = 1; $i <= $cantidad; $i++) {
                $dato=$productos[$i];
                //foreach ($productos[$i] as $atributo => $dato) {
                    //if ($atributo == 'idproducto' || $atributo == 'id') {
                $modelo->numero=$i;
                if ($dato['id'] != Null) {
                    $modelo->idproducto = $dato['id'];
                }
                //}
                    
                    //if ($atributo == 'cantidad') {
                if ($dato['coeficiente'] != Null) {
                    $modelo->coeficiente = $dato['coeficiente'];
                }

                if($dato['seguimientoinsumo']!=0){
                    $modelo->seguimientoinsumo = 1;                            
                }else{
                    $modelo->seguimientoinsumo = 0;  
                }   
                        
                if ($dato['cantidadoriginalreceta'] != Null) {
                    $modelo->cantidadoriginalreceta = $dato['cantidadoriginalreceta'];
                } else {
                    $modelo->cantidadoriginalreceta = 0;
                }

                if ($dato['cantidad'] != Null) {
                    $modelo->cantidad = $dato['cantidad'];
                } else {
                    $modelo->cantidad = 0;
                }
                
                if ($dato['reprocesado'] != Null){
                    $modelo->reprocesado = $dato['reprocesado'];
                }else{
                    $modelo->reprocesado = false;
                }
                /*if($guardacosto){


                        $costo=Producto::model()->find("id=".$modelo->idproducto)->costo;

                            $modelo->preciounitario=$costo;
                        }*/
                if ($modelo->save()) {
                    $productos[$i]['idorp']=$modelo->idtemp;
                    $modelo = new Ordenrecetaproducto;
                    $modelo->idordenreceta = $idordenreceta;
                }
                    //}
                //}
                
            }
        }
    }
    /*
     * Metodo que registra orden receta al actualizar la orden
     * @param integer $idordenreceta
     * @param array $productos
     * @return array
     */
    public function registrarOrdenreceta($receta,$idordenreceta, &$productos) {
        //$seguimientoinsumo 0:es de receta;1:creado en planificacion;2:creado en actualizacion
        $numeroInicial=  Ordenrecetaproducto::model()->count('idordenreceta='.$idordenreceta);
        $modelo = new Ordenrecetaproducto;
        
        if ($idordenreceta != Null && isset($productos)) {
            $modelo->idordenreceta = $idordenreceta;
            $cantidad = count($productos);
            $j=1;
            $i=$numeroInicial+1;
            foreach ($productos as $value) {
                $dato=$value;
                $modelo->numero=$i;$i++;
                if ($dato['id'] != Null)
                    $modelo->idproducto = $dato['id'];

                if ($dato['coeficiente'] != Null) 
                    $modelo->coeficiente = $dato['coeficiente'];
                
                if(isset($dato['seguimientoinsumo']))
                if($dato['seguimientoinsumo']!=-1){
                    $modelo->seguimientoinsumo = $dato['seguimientoinsumo'];                            
                }else{
                    $modelo->seguimientoinsumo = 2;  
                }
                if (!$receta){
if ($dato['cantidadoriginalreceta'] != Null) 
                            $modelo->cantidadoriginalreceta = $dato['cantidadoriginalreceta'];
                        else 
                            $modelo->cantidadoriginalreceta = 0;
                }     
                if ($dato['cantidad'] != Null) 
                    $modelo->cantidad = $dato['cantidad'];
                else 
                    $modelo->cantidad = 0;
                
                if ($modelo->save()) {
                    
                    $productos[$j]['idorp']=$modelo->idtemp;
                    $j++;
                    //$value['idorp']=$modelo->idtemp;
                    
                    $modelo = new Ordenrecetaproducto;
                    $modelo->idordenreceta = $idordenreceta;
                }else{
                    return array('error'=>true,'mensaje'=>'No es posible guardar datos de ordenrecetaproducto... idorden='.idordenreceta.';idproducto='.$dato['id']);
                }
            }

            
        }
        return array('error'=>false); 
    }
    
   /*
     * Metodo que registra orden receta al actualizar, funcion parecida a registrarOrdenreceta, en esta funcion el index $j empieza en 0
     * @param integer $idordenreceta
     * @param array $productos
     * @return array
     */
    public function registrarOrdenrecetaComoObjeto($receta,$idordenreceta, &$productos) {
        //$seguimientoinsumo 0:es de receta;1:creado en planificacion;2:creado en actualizacion
        $numeroInicial=  Ordenrecetaproducto::model()->count('idordenreceta='.$idordenreceta);
        $modelo = new Ordenrecetaproducto;
        
        if ($idordenreceta != Null && isset($productos)) {
            $modelo->idordenreceta = $idordenreceta;
            $cantidad = count($productos);
            $j=0;
          
            $i=$numeroInicial+1;
            foreach ($productos as $value) {
                $dato=$value;
                $modelo->numero=$i;$i++;
                if ($dato['id'] != Null)
                    $modelo->idproducto = $dato['id'];

                if ($dato['coeficiente'] != Null) 
                    $modelo->coeficiente = $dato['coeficiente'];
                
                if(isset($dato['seguimientoinsumo']))
                if($dato['seguimientoinsumo']!=-1){
                    $modelo->seguimientoinsumo = $dato['seguimientoinsumo'];                            
                }else{
                    $modelo->seguimientoinsumo = 2;  
                }
                if (!$receta){
if ($dato['cantidadoriginalreceta'] != Null)
                            $modelo->cantidadoriginalreceta = $dato['cantidadoriginalreceta'];
                        else 
                            $modelo->cantidadoriginalreceta = 0;
                }     
                if ($dato['cantidad'] != Null) 
                    $modelo->cantidad = $dato['cantidad'];
                else 
                    $modelo->cantidad = 0;
                /*if($guardacosto){
                    $costo=Producto::model()->find("id=".$modelo->idproducto)->costo;
                    $modelo->preciounitario=$costo;
                }*/
                if ($modelo->save()) {
                    $productos[$j]['idorp']=$modelo->idtemp;
                    $j++;
                    $modelo = new Ordenrecetaproducto;
                    $modelo->idordenreceta = $idordenreceta;
                }else{
                    return array('error'=>true,'mensaje'=>'No es posible guardar datos de ordenrecetaproducto... idorden='.idordenreceta.';idproducto='.$dato['id']);
                }
            }
           
            
        }
        return array('error'=>false); 
    }
    /*
     * Metodo que registra orden receta, pero el original
     * @param integer $idordenreceta
     * @param array $productos
     */
    public function registrarOrdenreceta_registra_original($idordenreceta, $productos) {
        $modelo = new Ordenrecetaproducto;
        if ($idordenreceta != Null && isset($productos)) {
            $modelo->idordenreceta = $idordenreceta;
            $cantidad = count($productos);
            
            for ($i = 0; $i < $cantidad; $i++)
            {
                $dato=$productos[$i];
                
                        if ($dato['cantidad'] != Null)
                            $modelo->cantidad = $dato['cantidad'];
                        else 
                            $modelo->cantidad = 0;
                    
                        if ($dato['coeficiente'] != Null)
                            $modelo->coeficiente = $dato['coeficiente'];
                        else 
                            $modelo->coeficiente = false;
                    
                        if ($dato['idproducto'] != Null)
                            $modelo->idproducto = $dato['idproducto'];
                        
                        if ($modelo->save()) {
                            $modelo = new Ordenrecetaproducto;
                            $modelo->idordenreceta = $idordenreceta;
                        }
                    
            }
        }
    }
    
    public function esProducto($attribute) 
    {
        $cantidad = count(Producto::model()->findAll(
            array('condition' => "t.nombre ilike '" . $this->producto . "%' ")));
        if ($this->idproducto == Null || $this->idproducto == 0 || $cantidad <= 0) {
            $this->addError($attribute, "El producto no es válido");
        }
    }
    /*
    *Esta funcion obtiene el id de orden a partir de el id del producto. obtiene la ultima receta de un producto
    */
    /*public function obtenerIDUltimaRecetaProducto($idproducto){
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.eliminado=false AND idproducto = ".$idproducto);
        $criteria->order = 'id ASC';  
        $orderRecetaModel=Ordenreceta::model()->find($criteria);

        if($orderRecetaModel!=null){          
            $criteria2 = new CDbCriteria;
            $criteria2->addCondition("t.eliminado=false AND id = ".$orderRecetaModel->id);
            $receModel=Receta::model()->find($criteria2);
            if($receModel!=null){
                if($receModel->idreceta==null) return $receModel->id; else
                return $receModel->idreceta;
            }
        }
        return 5;

    }*/

    /*
    *Esta funcion obtiene el id de orden a partir de el id del producto. obtiene la ultima receta de un producto
    */
    public function obtenerIDUltimaRecetaProducto($idproducto){
        
        $criteria = new CDbCriteria;        
        $criteria->join="INNER JOIN receta re on re.id=t.id";
        $criteria->addCondition("re.idreceta is null AND re.eliminado = false AND t.eliminado=false AND t.idproducto = ".$idproducto);
        $criteria->order = 't.id ASC';  
        $orderRecetaModel=Ordenreceta::model()->find($criteria);
if($orderRecetaModel==null){
    return -1;
}
        return $orderRecetaModel->id;

    }
    
    /**
     * Obtiene los productos de una receta;solo para crear la orden
     * @param integer $idordenreceta
     * @return CActiveDataProvider
     */
    public function obtenerProductosOriginal($idordenreceta)
    {
    
        $criteria = new CDbCriteria;
        
        $criteria->select = '0 as seguimientoinsumo,p.id, o.idproducto, p.codigo, p.nombre, p.reserva, p.saldo, o.cantidad, o.cantidad cantidadoriginalreceta,  p.idunidad, u.simbolo,u.permitirdecimal as entero';
        $criteria->join = ' inner join ordenrecetaproducto o on t.id = o.idordenreceta
        inner join producto p on o.idproducto = p.id
        inner join receta r on t.id = r.id
        inner join unidad u on p.idunidad = u.id';
        
        $criteria->addCondition("o.eliminado=false AND t.eliminado = false AND r.eliminado = false AND t.id = ".$idordenreceta);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                        'defaultOrder' => 'o.fecha asc',                            
                        ),               
            ));
    }
    
    
    /**
     * Obtiene los productos de una receta
     * @param integer $idordenreceta
     * @return CActiveDataProvider
     */
    public function obtenerProductos($idordenreceta)
    {
    
        $criteria = new CDbCriteria;
        
        $criteria->select = '0 as seguimientoinsumo,p.id, o.idproducto, p.codigo, p.nombre, p.reserva, p.saldo, o.cantidad,  p.idunidad, u.simbolo';
        $criteria->join = ' inner join ordenrecetaproducto o on t.id = o.idordenreceta
        inner join producto p on o.idproducto = p.id
        inner join receta r on t.id = r.id
        inner join unidad u on p.idunidad = u.id';
        
        $criteria->addCondition("t.id = ".$idordenreceta);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                        'defaultOrder' => 'o.fecha asc',                            
                        ),               
            ));
    }
    
    public function findProductoExcluido($dato)
    {
        $criteria = new CDbCriteria;
        
        $criteria->distinct = true;
        $criteria->select = 't.id, p.codigo, p.nombre, t.cantidadproducir, u.simbolo ,t.idproducto, up.simbolo as simboloproduccion';
        $criteria->join = ' inner join producto p on t.idproducto = p.id
        inner join receta r on t.id = r.id
        inner join unidad u on p.idunidad = u.id
        inner join unidad up on p.idunidadproduccion = up.id';
        $criteria->addCondition("(p.codigo ilike '%".$dato."%' or p.nombre ilike '%".$dato."%') and r.idreceta is null
            and p.idproductopadre IS NULL and t.id in (select id from receta where idreceta is null) and r.idestadoreceta=1");

        $data = $this->findAll($criteria);

        return $data;
    }
    public function findProductoExcluidoReprocesado($dato,$producto)
    {
        $criteria = new CDbCriteria;
        
        $criteria->distinct = true;
        $criteria->select = 't.id, p.codigo, p.nombre, t.cantidadproducir, u.simbolo ,t.idproducto, up.simbolo as simboloproduccion';
        $criteria->join = ' inner join producto p on t.idproducto = p.id
        inner join receta r on t.id = r.id
        inner join unidad u on p.idunidad = u.id
        inner join unidad up on p.idunidadproduccion = up.id';
        $criteria->addCondition("(p.codigo ilike '%".$dato."%' or p.nombre ilike '%".$dato."%') and r.idreceta is null
            and p.idproductopadre IS NULL and t.id in (select id from receta where idreceta is null) and r.idestadoreceta=1 and p.id <>".$producto);

        $data = $this->findAll($criteria);

        return $data;
    }
    /**
    * Metodo para obtener producto con datos adicionales como el simbolo, el metodo será empleado en el metodo create de orden
    */
    public function findProductoExcluidoPK($idprod)
    {
        $criteria = new CDbCriteria;
        
        $criteria->distinct = true;
        $criteria->select = 't.id, p.codigo, p.nombre, t.cantidadproducir, u.simbolo';
        $criteria->join = ' inner join producto p on t.idproducto = p.id
        inner join receta r on t.id = r.id
        inner join unidad u on p.idunidad = u.id ';
        $criteria->addCondition("p.id=".$idprod." and r.idreceta is null
            and p.idproductopadre IS NULL and t.id in (select id from receta where idreceta is null)");

        $data = $this->find($criteria);

        return $data;
    }

    /**
     * Metodo para actualizar la devolucion
     * @param integer idordenreceta
     * @param array productos
     * @param ref integer numeroDevolucion
     */
    public function registrarOrdenrecetaDevolucion($idordenreceta, $productos, &$numeroDevolucion) {

        if ($idordenreceta != Null && isset($productos)) {
            //$myfile = fopen("newfilefre.txt", "w") or die("Unable to open file!");
            if (count($productos) > 0) {
                $modeloDevolcion = new Devolucion;
                $modeloDevolcion->idorden = $idordenreceta;
                $modeloDevolcion->save();
                $numeroDeregistrosDevolucion = Devolucion::model()->count("idorden=" . $idordenreceta);
                Devolucion::model()->updateAll(
                        array("numero" => $numeroDeregistrosDevolucion), "id=:iddevolucion", array(":iddevolucion" => $modeloDevolcion->id));

                $numeroDevolucion = $numeroDeregistrosDevolucion;

                foreach ($productos as $dato) {

                    if ($dato["Devolver"] != "") {
                        $modelDevProd = new Devolucionproducto;
                        $modelDevProd->iddevolucion = $modeloDevolcion->id;
                        $modelDevProd->idproducto = $dato["id"];
                        $modelDevProd->idordenrecetaproducto = $dato["idorp"];
                        $modelDevProd->cantidad = $dato["Devolver"];
                        $modelDevProd->save();


                        // $modelo = Ordenrecetaproducto::model()->findByAttributes( array('idordenreceta'=>$idordenreceta,'idproducto'=>$dato["id"]));
                        /* Ordenrecetaproducto::model()->updateAll(
                          array("devolucion"=>$dato["Devolver"]),
                          "idordenreceta=:idordenreceta AND idproducto=:idproducto",
                          array(":idordenreceta"=>$idordenreceta,
                          ":idproducto"=>$dato["id"])); */

                        // $modelo->devolucion = $dato["Devolver"];
                        // if ($modelo->save()) {
                        //  }
                    }
                }
            }
            //fclose($myfile);     
            //foreach ($arrayModels as $item) $item->save();
        }
    }
    
    public function estaconfirmada(){
        return false;
    }
    
}
