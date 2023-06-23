<?php
/*
 * Orden.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 03/08/2015
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
 
 * This is the model class for table "orden".
 *
 * The followings are the available columns in table 'orden':
 * @property integer $id
 * @property integer $numero
 * @property string $fechaplanificada
 * @property string $duracion
 *
 * The followings are the available model relations:
 * @property Ordenestado[] $ordenestados
 * @property Ordenreceta $id0
 * @property Seguimiento[] $seguimientos
 * @property Entrega[] $entregas
 */
class ProduccionOrden extends CActiveRecord
{
    public $tienesubproductos;
    public $fechaInicio;
    public $fechaFin;
    
    public $confirmarcerrarorden;
    public $ultimoppp;
    
    public $notaborradorconfirmada;
    
    public $idnotaborrador;
    public $idtemp;//id ordenrecetaproducto
    public $idorp;//id ordenrecetaproducto
    public $cantidadoriginalreceta;
    //propiedad para el cálculo del PrecioUnitario
    public $seguimientoinsumo;
    public $saldoimporte;

    // variables
    public $producto;
    public $nombre;
    public $idordenreceta;
    
    public $idorden_receta;
    public $orden_receta;
    public $orden_recetaValido ; //$productoValido;
    public $idproducto;
    public $simbolo;
    public $codigo;
    
    public $nombreProceso;
    public $descripcion;
    public $cantidadproducir;
    public $cantidad;
    public $cantidadProducirReceta;
    
    public $ultimoEstado;
    public $fechaDel;
    public $fechaAl;
    public $idestado;
    public $descripcionOrdenReceta;
    public $usuario;
    public $idingrediente;
    public $ingrediente;
    
    public $estado;
    public $saldo;
    public $reserva;
    
    public $preciounitario;
    
    //propiedades para cantidad orden producir en la vista registrarorden
    public $cantidadOrden;
    public $cantidadOrdenPorcentaje;
    
    public $cantidadRegistradaOrdenPorcentaje;
    public $cantidadRegistradaOrden;
    //Cantidad disponible para entrega
    public $cantidadPresenteOrdenPorcentaje;
    public $cantidadPresenteOrden;
    
    //propiedad para devolucion
    public $devolucion;
    
    //variables para la busqueda por cantidad
    public $cantidadHasta;
    public $cantidadDesde;
    
    // atributos extras
    public $desabilitaFormOrden = 2;

    public $cantidaddevuelta;

    public $cantidadentregada;

    public $idunidad;

    //Propiedades para la vista VerCosto Insumo
    public $precio;
    
    public $preciototal;
    public $idalmacen;
    
    //propiedad para registrar insumo desde almacen
    public $planificada;
    public $iniciada;
    public $enproceso;
    
    public $ventaIdpedido='';
    public $ventaNumeropedido='';
    public $ventaEstadopedido='';
    public $accesoDesdeVentas=false;

    public $observacionEntrega;
    public $totalhoras;
    public $idproductoS;
    
    public $nombreCompletoProducto;
    public $productividad;
    public $rendimiento;
    public $porcentajeTolerancia;
    
    //reprocesado
    public $reprocesado;
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
     * Obtiene el ultimo estado de una orden
     */
    function getUltimoEstado() {
        /*$criteria = new CDbCriteria();
        $criteria->condition = 'idorden=:idorden AND eliminado=false';
        $criteria->params = array(':idorden'=>$this->id);
        $criteria->order = 'idestado ASC';
        $estadosoredenes = Ordenestado::model()->findAll($criteria);*/
                
        $estado = Estado::model()->findByPk($this->idultimoestado);
        
        if ($estado==null){
             return "";
        }
        else {
            return $estado->nombre;
        }
    }        
    
    /**
    * obtiene el último estado de una orden como objeto
    * @return obj
    */
    public function getUltimoEstadoObj() {
       
        /*$criteria = new CDbCriteria();
        $criteria->condition = 'idorden=:idorden AND eliminado=false';
        $criteria->params = array(':idorden'=>$this->id);
        $criteria->order = 'idestado DESC';
        $estadosoredenes = Ordenestado::model()->find($criteria);*/
        $estado = Estado::model()->findByPk($this->idultimoestado);
        return $estado;
    }
    
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    /*public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }*/
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'orden';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, numero', 'numerical', 'integerOnly'=>true),
            array('duracion', 'length', 'max'=>12),

            array('fechaplanificada', 'required', 'on' => array('insert', 'update')),
            array('fechaplanificada,confirmarcerrarorden,cantidadOrden,iddocumentoproductoventa', 'safe'),      
            array('horastrabajadas', 'numerical', 'min'=>0, 'tooSmall'=>'Número de hrs. debe ser mayor o igual a 0'),
            array('cantidadOrden', 'cantidadEntregaValidar'),
           //array('cantidadDesde,cantidadHasta','my_required', 'on' => array('search')),
            //array('cantidadHasta', 'numerical', 'min'=>$this->cantidadDesde),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('tienesubproductos,id,cantidadDesde,cantidadHasta,codigo,fechaDel,idingrediente,ingrediente,'
                . 'idestado,descripcionOrdenReceta,usuario,idproducto,producto,fechaAl, numero, fechaplanificada,'
                . ' duracion', 'safe', 'on'=>'search'),
        );
    }
    
    public function cantidadEntregaValidar($attribute, $params) {
        if($this->scenario!='registrarEntrega')return;
        if((empty($this->cantidadOrden) || $this->cantidadOrden=='0')){
             $this->addError($attribute, 'La "Cantidad Entrega" debe ser mayor a 0 ');
             return;
        }
           
            
//        if($this->id0->idproducto0->idunidad0->permitirdecimal  && !ctype_digit(strval($this->cantidadOrden)))
//        $this->addError($attribute, 'La "Cantidad Entrega" debe ser número entero'.!ctype_digit(strval($this->cantidadOrden)));
        
        
    }
                    
    /**
    * Funcion de validación personalizada
    * @param type $nombre_atributo
    * @param type $parametros
    */
    public function my_required($attribute_name,$params){

        if(!empty($this->cantidadDesde)&&!empty($this->cantidadHasta))
         {

            if($this->cantidadDesde>$this->cantidadHasta){
                $this->addError('cantidadDesde','Ésta cantidad debe ser menor a la Cantidad Hasta');


                 $this->addError('cantidadHasta','Ésta cantidad debe ser mayor a la Cantidad Desde');
            }



         }
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'ordenestados' => array(self::HAS_MANY, 'Ordenestado', 'idorden'),
                'id0' => array(self::BELONGS_TO, 'Ordenreceta', 'id'),
                'idultimoestado0' => array(self::BELONGS_TO, 'Estado', 'idultimoestado'),
                'seguimientos' => array(self::HAS_MANY, 'Seguimiento', 'idorden'),
                'entregas' => array(self::HAS_MANY, 'Entrega', 'idorden'),   
                'ordenreceta' => array(self::HAS_ONE, 'Ordenreceta', 'id'),
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Nº',
                    'fechaplanificada' => 'Fecha Pl.',
                    'duracion' => 'Duración',
                    'ultimoEstado'=>'Estado', 
                    'fechaDel'=>'Fecha Desde', 
                    'fechaAl'=>'Fecha Hasta', 
                    'idproducto'=>'Producto', 
                    'producto'=>'Producto', 
                    'descripcionOrdenReceta'=>'Descripción',
                    'usuario'=>'Usuario',
                    'idingrediente'=>'Ingredientes',
                    'descripcion'=>'Descripción',
                    'codigo' => 'Código',
                    'nombre' => 'nombre',
                    'idordenreceta' => 'idordenreceta',
                    'idempleado' => 'idempleado',
                    'cantidadDesde' => 'Desde',
                    'cantidadHasta' => 'Hasta',
                    'cantidadRegistradaOrden'=>'Cantidad',
                    'cantidadRegistradaOrdenPorcentaje'=>'%',
                    'cantidadOrden'=>'Cantidad',
                    'cantidadOrdenPorcentaje'=>'%',
                    'cantidaddevuelta'=>'Cantidad Devuelta',
                    'idunidad'=>'Udd',
                    'numerotrabajadores'=>'Nº Trabajadores',
                    'horastrabajadas'=>'Hrs. Trabajadas',
                    'descripcionanulacion'=>'Motivo de la anulación',
                    'idalmacen' => 'Almacén',
                    'tienesubproductos'=>'Subproductos',
                    'totalhoras'=>'Calculo Hrs.',
                    'productividad'=>'Productividad',
                    'rendimiento'=>'Rendimiento'
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
        $criteria->with = array('id0','id0.idproducto0','id0.idproducto0.idunidad0','idultimoestado0');
        //$criteria->with = array('id0','id0.idproducto0','ordenestados','ordenestados.idestado0','id0.idproducto0.idunidad0');
        $criteria->together=true;
        
        $criteria->addCondition("t.id>0");
        //
        //$criteria->addCondition('(SELECT fecha from ordenestado where idorden=t.id ORDER BY fecha DESC LIMIT 1) = ordenestados.fecha ');
            
        $criteria->compare('t.id',$this->id);

        if ($this->codigo != Null)
            $criteria->addCondition("upper(idproducto0.codigo) LIKE '".strtoupper($this->codigo). "%'");

        if ($this->numero != Null)
        $criteria->addCondition("CAST(t.numero AS text) LIKE '" .$this->numero. "'");
        //1:cantidadDesde!=null y cantidadHasta!=null;mostramos rango de cantidades
        //2:cantidadDesde!=null y cantidadHasta==null;mostramos cantidades mayores a fechaDesde inclusive, hasta el final
        //3:cantidadDesde==null y cantidadHasta!=null;mostramos cantidades menores a fechaHasta inclusive, hasta el principio
        $casoCriteriaCantidad=
                ($this->cantidadDesde != Null && $this->cantidadHasta != Null)*1+
                ($this->cantidadDesde != Null && $this->cantidadHasta == Null)*2+
                ($this->cantidadDesde == Null && $this->cantidadHasta != Null)*3;
        switch ($casoCriteriaCantidad)
        {
            case 1:
                    $criteria->addBetweenCondition("id0.cantidadproducir",$this->cantidadDesde,$this->cantidadHasta);
                break;
            case 2:
                    $criteria->addCondition("id0.cantidadproducir >= '" . $this->cantidadDesde. "'");
                break;
            case 3:
                    $criteria->addCondition("id0.cantidadproducir <= '" . $this->cantidadHasta. "'");
                break;
            default :
        }
        //1:fechaDel!=null y fechaAl!=null;mostramos rango de fechas
        //2:fechaDel!=null y fechaAl==null;mostramos fechas mayores a fechaDel inclusive, hasta el final
        //3:fechaDel==null y fechaAl!=null;mostramos fechas menores a fechaAl inclusive, hasta el principio
        $casoCriteria=
                ($this->fechaDel != Null && $this->fechaAl != Null)*1+
                ($this->fechaDel != Null && $this->fechaAl == Null)*2+
                ($this->fechaDel == Null && $this->fechaAl != Null)*3;
        switch ($casoCriteria)
        {
            case 1:
                    $criteria->addBetweenCondition("id0.fecha::date",$this->fechaDel,$this->fechaAl);
                break;
            case 2:
                    $criteria->addCondition("id0.fecha::date >= '" . $this->fechaDel. "'");
                break;
            case 3:
                    $criteria->addCondition("id0.fecha::date <= '" . $this->fechaAl. "'");
                break;
            default :
        }
        if($this->tienesubproductos!=null){
            switch ($this->tienesubproductos){
               case 1:
                   $criteria->addCondition('t.id IN (SELECT ore.id FROM orden ore INNER JOIN entrega entr ON entr.idorden = ore.id WHERE entr.idproductoresidual IS NOT NULL)');
                   break;
               case 2:
                   $criteria->addCondition('t.id IN (SELECT ore.id FROM orden ore INNER JOIN entrega entr ON entr.idorden = ore.id WHERE entr.idproductoresidual IS NULL)');
                   break;
            }
        }
        if ($this->idestado != Null)
        {
           $criteria->addCondition("t.idultimoestado = '".$this->idestado."'");                    
        }
        if ($this->producto != Null) {
            //$criteria->compare('al.idalmacen',null);

            $productval=strtoupper($this->producto);

            $criteria->addCondition("upper(idproducto0.nombre) LIKE '%$productval%'");
        }
        if ($this->descripcionOrdenReceta != Null) {

            $criteria->addCondition("id0.descripcion LIKE '%" .strtoupper($this->descripcionOrdenReceta). "%'");
        }

        if ($this->usuario != Null) {

            $criteria->addCondition("upper(id0.usuario) LIKE '%" .strtoupper($this->usuario). "%'");
        }

        if ($this->ingrediente != Null) {
            $criteria->join="INNER JOIN ordenrecetaproducto orp ON orp.idordenreceta = t.id INNER JOIN producto projoin ON projoin.id=orp.idproducto";
            $paringr=strtoupper($this->ingrediente);
            $criteria->addCondition(
                    "upper(projoin.codigo) LIKE '$paringr%' OR upper(projoin.nombre) LIKE '%$paringr%'");
        }

        if ($this->fechaplanificada != Null) {
            $criteria->addCondition("t.fechaplanificada::date = '" . $this->fechaplanificada. "'");
        }

        $criteria->addSearchCondition('t.duracion',$this->duracion,true,'AND','ILIKE');

        Yii::app()->session['reporteOrdenLote'] = $criteria;


        $respuesta=new CActiveDataProvider($this, array(
            'pagination'=>array(
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ), 
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'id0.fecha DESC',
                    'attributes' => array(
                        'fecha' => array(
                            'asc' => 'id0.fecha::date',
                            'desc' => 'id0.fecha::date DESC',
                        ),
                        'ultimoEstado' => array(
                            'asc' => 'idultimoestado0.nombre',
                            'desc' => 'idultimoestado0.nombre DESC',
                        ),
                        'producto' => array(
                            'asc' => 'idproducto0.nombre',
                            'desc' => 'idproducto0.nombre DESC',
                        ),
                        'codigo' => array(
                            'asc' => 'idproducto0.codigo',
                            'desc' => 'idproducto0.codigo DESC',
                        ),
                        'descripcionOrdenReceta'=> array(
                            'asc' => 'id0.descripcion',
                            'desc' => 'id0.descripcion DESC',
                        ),
                        'cantidad'=> array(
                            'asc' => 'id0.cantidadproducir',
                            'desc' => 'id0.cantidadproducir DESC',
                        ),
                        'usuario'=> array(
                            'asc' => 'id0.usuario',
                            'desc' => 'id0.usuario DESC',
                        ),
            'idunidad' => array(
                'asc' => 'idunidad0.simbolo',
                'desc' => 'idunidad0.simbolo DESC',
            ),

                        '*',
                ),
            ),
        ));

        return $respuesta;
    }
    
    public function horasProduccion() {
        return round($this->horastrabajadas, 3);
    }
    
    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->produccion;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orden the static model class
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
        //$this->fechaplanificada = new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    
    public function afterSave() {
        
    }
    
    public function getNombreProceso()
    {
        $command = Yii::app()->produccion->createCommand("select t.idproceso, p.nombre, e.nombre, t.porcentaje
        from ordenrecetaprocesoempleadomaquina t inner join empleadomaquina e on t.idempleadomaquina = e.id
                                                 inner join proceso p on t.idproceso = p.id
        where t.idproceso = ".$this->idproceso);
        return $command->queryScalar();
    }
    
    /*Obtiene los insumos de una orden, Este método es empleado para el registro del precio unitario en WSOrdenController
     *@param $idordenreceta
     *@param $idnotaborrador
    */
    public function obtenerProductosDeOrdenModel($idordenreceta,$idnotaborrador)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ord.cantidadoriginalreceta,ord.seguimientoinsumo,p.ultimoppp,p.id, p.codigo, p.nombre,p.saldoimporte, p.reserva, p.saldo, u.simbolo, ord.cantidad,  ord.preciounitario, p.idalmacen';
        $criteria->join = ' inner join ordenreceta o on t.id = o.id
                            inner join orden orde on o.id = orde.id
                            inner join ordenrecetaproducto ord on t.id = ord.idordenreceta
                            inner join producto p on ord.idproducto = p.id
                            inner join unidad u on p.idunidad = u.id';
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = ".$idordenreceta);
        $criteria->addCondition("ord.idnotaborrador = ".$idnotaborrador);

        return ProduccionOrden::model()->findAll($criteria);
    }
    
    public function obtenerProductosInsumoAdicional($idordenreceta, $arrayIdtemp) {
        $criteria = new CDbCriteria;
        $criteria->select = 'ord.idtemp,ord.cantidadoriginalreceta,ord.seguimientoinsumo,p.ultimoppp,p.id, p.codigo, p.nombre,p.saldoimporte, p.reserva, p.saldo, u.simbolo, ord.cantidad,  ord.preciounitario, p.idalmacen';
        $criteria->join = ' inner join ordenreceta o on t.id = o.id
                            inner join orden orde on o.id = orde.id
                            inner join ordenrecetaproducto ord on t.id = ord.idordenreceta
                            inner join producto p on ord.idproducto = p.id
                            inner join unidad u on p.idunidad = u.id';
        $criteria->addCondition("t.id = " . $idordenreceta);
        $criteria->addInCondition('ord.idtemp', $arrayIdtemp);
        return ProduccionOrden::model()->findAll($criteria);
    }

    public function estaconfirmada() {
        if ($this->idordenreceta > 0) {
            if ($this->idnotaborrador == null)
                return false;
            //// para permitir que se devuelvan de ordenes negativas
            $modelnotaborrador = Notaborrador_Almacen::model()->find("id=" . $this->idnotaborrador);
            //return $modelnotaborrador->eliminado==true?'si':'no:'.$this->idnotaborrador.CJSON::encode($modelnotaborrador);
            if ($modelnotaborrador != null) {
                if ($modelnotaborrador->eliminado == true) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        } else {
            return true;
        }
    }

    /*
    * Método para obtener los productos de una orden
    * @param integer $idordenreceta
    * @return CActiveDataProvider
    */
    public function obtenerProductosDeOrden($idordenreceta)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ord.idnotaborrador, ord.idtemp as idorp, o.id as idordenreceta,'
                . 'ord.cantidadoriginalreceta,ord.seguimientoinsumo,'
                . 'p.id, p.codigo, p.nombre,p.saldoimporte, p.reserva, p.saldo, '
                . 'u.simbolo, ord.cantidad,  ord.preciounitario, p.idalmacen,ord,reprocesado';
        $criteria->join = 'inner join "'.getGestionSchema().'".ordenreceta o on t.id = o.id and o.eliminado = false
                            inner join "'.getGestionSchema().'".ordenrecetaproducto ord on t.id = ord.idordenreceta and ord.eliminado = false
                            inner join "'.getGestionSchema().'".producto p on ord.idproducto = p.id and p.eliminado = false
                            inner join unidad u on p.idunidad = u.id';
      
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = ".$idordenreceta);

        return new CActiveDataProvider(
                $this, 
                array(
                    'pagination' => false,
                    'criteria' => $criteria,
                    'sort'=>array(
                        'defaultOrder'=>'ord.numero ASC',
                    ),
                )
        );
    }  
    /*Obtiene los insumos de una orden
     *@param $idordenreceta
    */
    public function obtenerProductosDeOrdenVerCostoInsumo($idordenreceta)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'p.id, p.codigo, p.nombre, p.reserva, p.saldo, u.simbolo, ord.cantidad,  ord.preciounitario as precio, (ord.preciounitario*ord.cantidad) as preciototal';
        $criteria->join = ' inner join ordenreceta o on t.id = o.id
                            inner join ordenrecetaproducto ord on t.id = ord.idordenreceta
                            inner join producto p on ord.idproducto = p.id
                            inner join unidad u on p.idunidad = u.id';
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = ".$idordenreceta);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
        ));
    }

    
    /*
     * Esta función devuelve la cantidad que se entrego segun el porcentaje registrado en la orden
     * @param float cantidadtotaldelproducto
     * @param integer idproducto
     * @return float
     */
    public function obtenerCantidadEntregadaProductoOrden($entregaModel,$cantidadtotaldelproducto){
        if($entregaModel!=null){            
            
        $porcentaje=(float)$entregaModel->porcentaje;
        if($entregaModel->ultimaentrega==true){
            $porcentajeEntregadoHastaElmomento=Entrega::model()->obtenerCantidadTotalProductoOrdenEntrega($entregaModel->idorden,$entregaModel->id);
            $xporc=(float)1.0-((float)$porcentajeEntregadoHastaElmomento-(float)$porcentaje);
            $porcentaje=$xporc;
        }
        
            return (float)$porcentaje*(float)$cantidadtotaldelproducto;
        }else{
            return 0;
        }
    }

    /*
     * Esta función devuelve la cantidad de devoluciones de una orden
     * @param integer idorden
     * @return integer
     */
    public function obtenerCantidadDevoluciones($idorden){

        $devolucionCount=Devolucion::model()->count('idorden = '.$idorden);
        return $devolucionCount;

    }
    /*
     * Esta función devuelve las devoluciones de una orden
     * @param integer idorden
     * @return integer
     */
    public function obtenerDevolucionesOrden($idorden){

        $devoluciones=Devolucion::model()->findAll('idorden = '.$idorden);
        return $devoluciones;

    }
    /*
     * Esta función devuelve la cantidad devuelta de un determinado insumo de una orden
     * @param integer idorden
     * @param integer idproducto
     * @param integer idordenrecetaproducto
     * @return integer
     */
    public function obtenerCantidadTotalDevolucionesProductoOrden($idorden,$idproducto,$idordenrecetaproducto){
        $devolucionesModel=Devolucion::model()->findAll('idorden = '.$idorden);
        $cantidadTotal=0;
        foreach ($devolucionesModel as $valueDevo) {
            //$proiducModelDev=Devolucionproducto::model()->findAll('iddevolucion='.$valueDevo->id.' AND idproducto='.$idproducto);
            $proiducModelDev=Devolucionproducto::model()->findAll('iddevolucion='.$valueDevo->id.' AND idordenrecetaproducto='.$idordenrecetaproducto);
            foreach ($proiducModelDev as $valueProdc) {
                $cantidadTotal+=$valueProdc->cantidad;
            }
        }
        return $cantidadTotal;

    }

    /*
     * Esta función devuelve la cantidad de devolcion segun el id de devolución
     * @param integer iddevolucion
     * @param integer idproducto
     * @return integer
     */
    public function obtenerMontoDevolucionProducto($iddevolucion,$idordenrecetaproducto){

        //$devolucionCount=Devolucion::model()->count('idorden = '.$idorden);
        $criteria = new CDbCriteria();
        $criteria->condition = "iddevolucion=$iddevolucion AND idordenrecetaproducto=$idordenrecetaproducto";
       
       

       $devProductoModel=Devolucionproducto::model()->find($criteria);
if($devProductoModel!=null)
    return $devProductoModel->cantidad;
       //return sprintf($formato, $iddevolucion, $idproducto);
return '';
    }

    /* esta función le inidica al boton de abrir orden si estara visible o no,
     * dependerá si la orden esta cerrada
     * @param string id de la orden
     * @return boolean retornamos true si se muestra el boton y false si no se muestra
     */
    public function mostrarBotonAbrirOrden($idorden)
    {
        $idultimoestado=Orden::model()->findByPk($idorden)->idultimoestado;
        if($idultimoestado==Estado::$idEstadoCerrada)
            return true;
        else
        return false;
    }
    
    /*
     * funcion que habilita ó inhabilita el icono de iniciar orden
     * @param string $estado, recibe una cadena
     */
    public function mostrarBotonesIniciarOrden($estado)
    {
        return ($estado == 'INICIADO') ? false: true;
    }
    /**
     * Crea un nuevoi estado para la orden, esta funcion se invoca cuando se inicia la orden
     * @return array
     */
    public function cambioEstadoIniciada(){
        $ordenestado = new Ordenestado();
        $ordenestado->attributes = $_POST['Orden'];
        $ordenestado->idorden = $this->id;
        $ordenestado->idestado = Estado::$idEstadoIniciada;
        $ordenestado->descripcion = 'INICIADO EL '.$_POST['Orden']['fechaplanificada'];
        if($ordenestado->save()){
            return array('error'=>false); 
        }else{
            return array('error'=>true,'mensaje'=>'No es posible guardar el estado de la orden. Id orden=='.$this->id);
        }
    }
    
    /*
     * funcion para habilitar ó inhabilitar el formulario de actualización de orden de producción
     * @param string $id, es la contraseña encriptada
     * @return boolean
     */
    public function paraActualizar($id) {
        $orden = Orden::model()->findByPk(SeguridadModule::dec($id));

        //$estado = Yii::app()->produccion->createCommand('select idestado from ordenestado where idorden='.SeguridadModule::dec($id).' and (idestado = '.$this->desabilitaFormOrden.' OR idestado =5) order by idestado desc')->queryScalar();
        /*$estado=$orden->getUltimoEstadoObj();
        if ($estado->idestado == Estado::$idEstadoPlanificada 
                || $estado->idestado == Estado::$idEstadoIniciada
                || $estado->idestado == Estado::$idEstadoEnProceso
                || $estado->idestado == Estado::$idEstadoEntrega
            || $estado->idestado == Estado::$idEstadoTerminada )
                
            return true;
        else
            return false;*/
        return true;
    }
    
    /*
     * Método que irá actualizando en la bd cada producto en el campo de reserva.
     * @param integer $indice, posición de inicio en el ciclo for
     * @param integer $idproducto, es el campo de una determinado posición del array de productos.
     * @param array $productos, array de productos
     * @return array
     */
    public function actualizarProductos($indice, $idproducto, $productos)
    {
        //$datosBd = array();
        //$datosBd = Producto::model()->datosProductos($indice, $idproducto, $productos);
        $cantidad = count($productos);
        //$cantidadBd = count($datosBd);
        $modelProducto = array();
        foreach ($productos as $value) {
            $modelProducto = Producto_Almacen::model()->findByPk($value['id']);            
            $modelProducto->reserva = $modelProducto->reserva + $value['cantidad'];
            if(!$modelProducto->save()){
                return array('error'=>true,'mensaje'=>'No se pudo actualizar la reserva del producto... idproducto=='.$value['id'].";reserva=".$modelProducto->reserva );
            }
        }
        return array('error'=>false);

        /*if($cantidad == $cantidadBd)
        {
            if($indice == 0)
                $cantidad = $cantidad - 1;
            else
                $cantidad = $cantidad;
            for($posicion = $indice; $posicion <= $cantidad; $posicion++)
            {
                for($posicionBd = 0; $posicionBd < $cantidadBd; $posicionBd++)
                {
                    if($productos[$posicion][$idproducto] == $datosBd[$posicionBd]['id'])
                    {
                        $modelProducto = Producto::model()->findByPk($datosBd[$posicionBd]['id']);
                        $modelProducto->reserva = (int)($datosBd[$posicionBd]['reserva']) + intval($productos[$posicion]['cantidad']);
                        $modelProducto->save();
                    }
                }
            }
        }*/
    }
    

    
    /*
     * funcion que verifica que no exceda la disponibilidad de insumos.
     * @param integer $indice, posición de inicio en el ciclo for
     * @param integer $idproducto, es el campo de una determinado posición del array de productos.
     * @param array $productos, array de productos
     * @return integer
     */
    public function compruebaDisponilidadInsumos($productos)
    {

        foreach ($productos as $value) {
            $productomodel=Producto::model()->findByPk($value['id']);
            $saldoDisponible = round($productomodel->saldo - $productomodel->reserva,4);
            if($value['cantidad']*1 > $saldoDisponible){
                return $resultado = 1; //significa que excede la disponibilidad de saldo de insumos
            }
        }
        return $resultado = 0;
        /*$datosBd = array();
        $datosBd = Producto::model()->datosProductos($indice, $idproducto, $productos);
        $cantidad = count($productos);
        $resultado = 0;
        $cantidadProductosBd = count($datosBd);
        if($indice == 0)
            $cantidad = $cantidad - 1;
        else
            $cantidad = $cantidad;
        
        for($posicion = $indice; $posicion <= $cantidad; $posicion++)
        {
            for($filaBd = 0; $filaBd < $cantidadProductosBd; $filaBd++)
            {
                $saldoDisponible = $datosBd[$filaBd]['saldo'] - $datosBd[$filaBd]['reserva'];
                if($productos[$posicion][$idproducto] == $datosBd[$filaBd]['id'])
                {
                   if($productos[$posicion]['cantidad'] > $saldoDisponible)
                       return $resultado = 1; //significa que excede la disponibilidad de saldo de insumos
                }
            }
        }
        return $resultado = 0;*/
    }
    
private function ordenarIndexArrayCero($array){
    $respuestaarray=array();
    foreach($array as $value){
        array_push($respuestaarray, $value);
    }
    return $respuestaarray;
}

    private function reiniciaIndexArray($productos){
        $respuestaArray=array();
        $indice=0;
        foreach($productos as $item){
            $respuestaArray[$indice]=$item;
            $indice++;
        }
        return $respuestaArray;
    }
    
    private function clasificacionDeInsumosPorAlmacen($productos){
        $respuesta=array();
        $idAlmacenPadre = $this->obtieneAlmacenesPadre($productos);
        for($i=0;$i<count($idAlmacenPadre);$i++){
            $idalmacen=$idAlmacenPadre[$i];
            $j=0;
            $productosAlmacen=array();            
            for($k=0;$k<count($productos);$k++){                
                $productomodel=  Producto::model()->findByPk($productos[$k]['id']);
                if($productomodel->idalmacen == $idalmacen)
                {
                    $productos[$k]['codigo'] = $productomodel->ultimoppp;
                    array_push($productosAlmacen, $productos[$k]); 
                }                
            }
            array_push($respuesta, array("idalmacen"=>$idalmacen,"productos"=>$productosAlmacen));
        }
        return $respuesta;
    }
    
    private function clasificacionDeInsumosAdPorAlmacen($productos) {
        $respuesta = array();
        $idAlmacenPadre = $this->obtieneAlmacenesPadre($productos);
        for ($i = 0; $i < count($idAlmacenPadre); $i++) {
            $idalmacen = $idAlmacenPadre[$i];
            $j = 0;
            $productosAlmacen = array();
            for ($k = 1; $k <= count($productos); $k++) {
                $productomodel = Producto::model()->findByPk($productos[$k]['id']);
                if ($productomodel->idalmacen == $idalmacen) {
                    $productos[$k]['codigo'] = $productomodel->ultimoppp;
                    array_push($productosAlmacen, $productos[$k]);
                }
            }
            array_push($respuesta, array("idalmacen" => $idalmacen, "productos" => $productosAlmacen));
        }
        return $respuesta;
    }

    private function clasificarproductos($productos){
        $conreceta=array();//si es de la receta
        $k=0;
        for($i=0;$i<count($productos);$i++){
            if($productos[$i]['seguimientoinsumo']==0){
                array_push($conreceta,$productos[$i]);
                      
            }
        }
        
        $sinreceta=array();
        if(count($productos)>0){
            $k=0;
            for($i=0;$i<count($productos);$i++){
                if($productos[$i]['seguimientoinsumo']!=0){
                    array_push($sinreceta,$productos[$i]);                      
                }
            }
        }
        
        //clasificacion por almacen
        
        return array("conreceta"=>$this->clasificacionDeInsumosPorAlmacen($conreceta),"sinreceta"=>$this->clasificacionDeInsumosPorAlmacen($sinreceta));
    }
    /**
     * 
     * @param array $productosalmacen
     * @param model $orden
     * @param string $nombreProductoP
     * @param string $usuario
     * @param integer $idorden
     * @return array
     * @throws CException
     */
    private function registrar_productos_clasificados_NotaBorradorAlmacen($productosalmacen, $orden, $codigoproducto, $usuario, $idorden) {
        $idcontracuenta = Costoindirecto::model()->findByPk(Costoindirecto::model()->ID_COSTO_INSUMO)->idcuenta;
        
        $nota = new WSNotaborrador;
        foreach ($productosalmacen as $value) {
            $productosEnviarWebService = $value['productos'];
            $datosAlmacen = array("idalmacen" => $value['idalmacen'],"idcontracuenta" => $idcontracuenta, "producto" => $codigoproducto);
            $idnotaborrador = $nota->registrarNotaBorradorIngresoSalidaAlmacen($orden->numero, $datosAlmacen, $productosEnviarWebService, $usuario, $idorden);
            foreach ($productosEnviarWebService as $item) {
                //update("iidprod="$item['id']);
                /*
                  $myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
                  $txt = sprintf('idorp: %d --- idnotaborrador:%d', $item['idorp'], $idnotaborrador)."\n";
                  fwrite($myfile, $txt);
                  fclose($myfile); */

                $numerofilasafectadas = Ordenrecetaproducto::model()->updateAll(array('idnotaborrador' => $idnotaborrador), 'idtemp=:idorp', array(':idorp' => $item['idorp']));
                //$numerofilasafectadas=Ordenrecetaproducto::model()->updateByPk(array("idtemp"=>$item['idorp']),array('idnotaborrador'=>$idnotaborrador));
                if ($numerofilasafectadas == 0) {
                    $errores = Ordenrecetaproducto::model()->getErrors();
                    $error = 'No se actualizo ordenrecetaproducto para introducir el idnotaborrador: ' . CJSON::encode($errores);
                    throw new CException($error);
                }
            }
        }
        return array("error"=>false);//no hubo errores
    }

    /*
     * funcion que registra el ingreso y salida de O.P.
     * @param integer $identificador, es el id que se manda a esta función
     */
    public function NotaBorradorProduccion($identificador, $productosenviar) {
        
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $orden = Orden::model()->find('id = ' . $identificador);
            $idProductoProducir = Ordenreceta::model()->find('id = ' . $identificador)->idproducto;
            $nombreProductoP = Producto::model()->findByPk($idProductoProducir)->codigo;
            $idAlmacenPadre = $this->obtieneAlmacenesPadre($productosenviar);


            $clasificaciondeproductos=$this->clasificarproductos($productosenviar);
            
            
            $conreceta=$clasificaciondeproductos['conreceta'];
             
            $sinreceta=$clasificaciondeproductos['sinreceta'];
            
            $usuario = Yii::app()->user->getName();
            
            $respuesta = $this->registrar_productos_clasificados_NotaBorradorAlmacen($conreceta, $orden,$nombreProductoP,$usuario,$identificador);
            if($respuesta['error']){
                $error = 'Error: function registrar_productos_clasificados_NotaBorradorAlmacen' ;
                    throw new CException($error);
            }                        
            $respuesta = $this->registrar_productos_clasificados_NotaBorradorAlmacen($sinreceta, $orden,$nombreProductoP,$usuario,$identificador);
            if($respuesta['error']){
                $error = 'Error: function registrar_productos_clasificados_NotaBorradorAlmacen' ;
                    throw new CException($error);
            }     
//            $cantidad = count($idAlmacenPadre);

//            if ($idAlmacenPadre != null) {
//                // ---------------------------- SALIDA (2) --------------------------------
//                for ($i = 0; $i < $cantidad; $i++) {
//                    $idAlmacen = $idAlmacenPadre[$i];
//                    $productosAlmacen = $this->obtieneProductosGrid($productosenviar, $idAlmacen);
//                    $nuevaCantidad = count($productosAlmacen);
//                    $productosEnviarWebService = array();
//                    if (count($productosAlmacen) > 0) {
//                        for ($nuevaFila = 0; $nuevaFila < $nuevaCantidad; $nuevaFila++) {
//                            for ($index = 0; $index < count($productosenviar); $index++) {
//                                $idProductoAlmacen = $productosAlmacen[$nuevaFila]['id'];
//                                $idProductoPost = $productosenviar[$index]['id'];
//                                if ($idProductoAlmacen == $idProductoPost) {
//                                    $productosenviar[$index]['codigo'] = $productosAlmacen[$nuevaFila]['saldoimporte'] / $productosAlmacen[$nuevaFila]['saldo'];
//                                    $productosEnviarWebService[$nuevaFila] = $productosenviar[$index];
//                                    unset($productosenviar[$index]);
//                                    $productosenviar = $this->ordenarIndexArrayCero($productosenviar);
//                                    break;
//                                }
//                            }
//                        }
//                    }
//                    $idcontracuenta = Costoindirecto::model()->findByPk(Costoindirecto::model()->ID_COSTO_INSUMO)->idcuenta;
//                    $datosAlmacen = array("idalmacen" => $idAlmacen, "idcontracuenta" => $idcontracuenta, "producto" => $nombreProductoP);
//                    if (count($productosEnviarWebService) > 0) {
//                        $idnotaborrador=$nota->registrarNotaBorradorIngresoSalidaAlmacen($orden->numero, $datosAlmacen, $productosEnviarWebService, $usuario, $identificador);
//                      
//                        foreach ($productosEnviarWebService as $item){
//                            //update("iidprod="$item['id']);
//    /*                        
//$myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");  
//$txt = sprintf('idorp: %d --- idnotaborrador:%d', $item['idorp'], $idnotaborrador)."\n";
//fwrite($myfile, $txt);
//fclose($myfile);*/
//                            
//                     $numerofilasafectadas=Ordenrecetaproducto::model()->updateAll(array('idnotaborrador'=>$idnotaborrador), 'idtemp=:idorp', array (':idorp'=> $item['idorp']));
//                            //$numerofilasafectadas=Ordenrecetaproducto::model()->updateByPk(array("idtemp"=>$item['idorp']),array('idnotaborrador'=>$idnotaborrador));
//                            if($numerofilasafectadas==0){
//                                $errores= Ordenrecetaproducto::model()->getErrors();
//                                $error = 'No se actualizo ordenrecetaproducto para introducir el idnotaborrador: '.CJSON::encode($errores);
//                                throw new CException($error);
//                            }
//                        } 
//                    }
//                }
//            }
            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollback();
        }
    }
    
//    public function NotaProduccionIngresoAdicional($identificador,$productos) {
//        $transaction = Yii::app()->db->beginTransaction();
//        try {
//            $orden = Orden::model()->find('id = ' . $identificador);
//            $idProductoProducir = Ordenreceta::model()->find('id = ' . $identificador)->idproducto;
//            $codigoproducto = Producto::model()->findByPk($idProductoProducir)->codigo;
//            $clasificacionproductos = $this->clasificacionDeInsumosAdPorAlmacen($productos);
//            $usuario = Yii::app()->user->getName();
//            $nota = new WSNota;
//            foreach ($clasificacionproductos as $value) {
//                $productosWebServiceEnviar = $value['productos'];
//                $datosAlmacen = array("idalmacen" => $value['idalmacen'], "producto" => $codigoproducto);
//                $idnota = $nota->registrarSalidaInsumoAdicional($orden->numero, $datosAlmacen, $productosWebServiceEnviar, $usuario);
//            }
//            $transaction->commit();
//        } catch (Exception $exc) {
//            $transaction->rollback();
//        }
//    }
    
    public function NotaBorradorProduccionIngresoAdicional($identificador, $productos) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $orden = Orden::model()->find('id = ' . $identificador);
            $idProductoProducir = Ordenreceta::model()->find('id = ' . $identificador)->idproducto;
            $codigoproducto = Producto::model()->findByPk($idProductoProducir)->codigo;
            $clasificacionproductos = $this->clasificacionDeInsumosAdPorAlmacen($productos);
            $usuario = Yii::app()->user->getName();
            $notaborrador = new WSNotaBorrador;
            foreach ($clasificacionproductos as $value) {
                $productosWebServiceEnviar = $value['productos'];
                $datosAlmacen = array("idalmacen" => $value['idalmacen'], "producto" => $codigoproducto);
                $idnotaborrador = $notaborrador->registrarSalidaInsumoAdicional($orden->numero, $datosAlmacen, $productosWebServiceEnviar, $usuario, $identificador);
                foreach ($productosWebServiceEnviar as $item) {
                    $numerofilasafectadas = Ordenrecetaproducto::model()->updateAll(array('idnotaborrador' => $idnotaborrador), 'idtemp=:idorp', array(':idorp' => $item['idtemp']));
                    if ($numerofilasafectadas == 0) {
                        $errores = Ordenrecetaproducto::model()->getErrors();
                        $error = 'No se actualizo ordenrecetaproducto para introducir el idnotaborrador: ' . CJSON::encode($errores);
                        throw new CException($error);
                    }
                }
                
            }
            
        } catch (Exception $exc) {
            $transaction->rollback();
        }
    }

    /*
     * funcion que obtiene los almacenes padres
     * @param array $productos, productos de la bd
     * @return array, retorna el array de productos padres NO repetidos
     */
    private function obtieneAlmacenesPadre($productos)
    {
        $arrayAlmacenPadre = array();
        $array = array();
        $cantidad = count($productos);
        
        $posicion=0;
        foreach ($productos as $value) {
            $productomodel=  Producto::model()->findByPk($value['id']);
            $arrayAlmacenPadre[$posicion] = $productomodel->idalmacen;
            $posicion++;
        }
               
        $array = array_unique($arrayAlmacenPadre);
        $newArray = array();
        $indice = 0;
        foreach($array as $key => $value)
        {
            $newArray[$indice] = $array[$key];
            $indice++;
        }
        
        return $newArray;
    }
    
    /*
     * funcion que devuelve los ids de producto de un determinado almacen
     * @param array $productos
     * @param integer $idAlmacen
     * @return array
     */
    private function obtieneProductosGrid($productos, $idAlmacen)
    {
        $cantidad = count($productos);
        $arrayProductos = array(); // nuevo vector del almacen
        
        $posicion = 0;        
        foreach ($productos as $value) {
            $productomodel=  Producto::model()->findByPk($value['id']);
            if($productomodel->idalmacen == $idAlmacen)
            {
                $arrayProductos[$posicion] = $productomodel;
                $posicion++;
            }
        }        
        return $arrayProductos;
    }
    
    
    /*
     * funcion para la nota de borrador de entrega(s)
     * @param integer $identificador
     * @param array $productoN
     * @param array $productosResiduales
     */
    public function NotaEntrega($productoNormal, $productosResiduales,$modelEntrega)
    {
        
    }
    
    /*
     * funcion para la nota de borrador de devolucion(s)
     * @param integer $identificador
     * @param integer $cantidadIngreso
     */
    public function NotaDevolucion($identificador, $cantidadIngreso,$numeroDevolucion) 
    {
        return;
    }
    /*
     * compara los codigos de los productos del Grid con los codigos de los 
     * productos de la base de datos, para luego asignar la cantidad del producto
     * del Grid a un campo de los datos de la Bd, ya que en los datos de la bd
     * tienen diferentes ids.
     * @param integer $indice, posición de inicio del recorrido del array
     * @param array $productosGrid, productos del Grid
     * @param array $productosAlmProc, productos de la bd
     * @param string $PresenteDevolver, es el campo a asignar ese valor a otro campo
     * @return array, nuevo vector de insumos(mas que todo mantengo este formato para mis demás funciones)
     */
    private function productosDeParametro($indice, $productosGrid, $productosAlmProc, $PresenteDevolver)
    {
        $cantidadProdGrid = count($productosGrid);
        $cantidadAlmProc = count($productosAlmProc);
        $arrayProductos = array();
        $posicion = 0;
        if($indice == 1)
            $cantidadProdGrid = $cantidadProdGrid + 1;
        else
            $cantidadProdGrid = $cantidadProdGrid;
        
        for($i = $indice; $i < $cantidadProdGrid; $i++)
        {
            for($j = 0; $j < $cantidadAlmProc; $j++)
            {
                if($productosGrid[$i]['codigo'] == $productosAlmProc[$j]['codigo'])
                {
                    $productosAlmProc[$j]['valor'] = $productosGrid[$i][$PresenteDevolver];//cantidad
                    $arrayProductos[$posicion] = $productosAlmProc[$j];
                    $posicion++;
                    break;
                }
            }
        }
        
        return $arrayProductos;
    }
    
    /*
     * Esta funcion valida la(s) devolucion(es) de nota borrador.
     * @param integer $identificador, id de orden de produccion
     * @param integer $cantidadPresente, valor que se envia del formulario
     */
    public function validaDevolucion($identificador, $cantidadPresente)
    {
        if(isset($_POST['Producto']))
        {
            $productos = $_POST['Producto'];
            $contador = 0;
            for($fila = 1; $fila <= count($_POST['Producto']); $fila++)
            {
                if($productos[$fila]['Devolver'] != null)
                    $contador++;                
            }
            
            if($contador > 0)
            {
                $entrega = Entrega::model()->findAll('idorden = '.$identificador);
                $suma = 0;
                for($i = 0; $i < count($entrega); $i++)
                    $suma += $entrega[$i]['cantidad'];
                
                $ordenReceta = Ordenreceta::model()->find('id = '.$identificador);
                $cantidadValida = $ordenReceta->cantidadproducir - $suma;
                //$ordenProducto = Ordenrecetaproducto::model()->findAll('idordenreceta = '.$identificador);
                
                if($cantidadValida = $cantidadPresente)
                {
                    $this->NotaBorradorDevolucion($identificador);
                    echo "Se hizo la devolución con éxito!!!";
                }
                else
                    echo "Cantidad presente diferente a la cantidad de entrega!!!";
            }
            else
                echo "No existen devoluciones!!!";
        }
    }
    
    /*
     * anulacion de orden de produccion y de nota borrador
     * @param integer $identificador
     */
    public function anulacionOrden($identificador)
    {
        $arrayParametro = array('iddocumento' => $identificador);
        $nota = new WSNotaborrador;
        $nota->anulacionBorrador($arrayParametro);
        
        $ordenestado = new Ordenestado();
        $ordenestado->idorden = $identificador;
        $ordenestado->idestado = 6;
        $ordenestado->descripcion = 'ANULADA EL '.date("d-m-Y");
        $ordenestado->save();
    }
    /**
     * Obtiene todos los isnumos de esta orden
     * @return type
     */
    public function getInsumosOrden(){
        $productos=array();
        $ordenrecetaproducto=Ordenrecetaproducto::model()->findAll('idordenreceta = '.$this->id);
        $index=0;
        foreach ($ordenrecetaproducto as $value) {          
            $producto =  Producto::model()->findByPk($value->idproducto);
            $producto->cantidad=$value->cantidad;
            //$producto->seguimientoinsumo=$value->seguimientoinsumo;
            $productos[$index]=array("id"=>$producto->id,"cantidad"=>$producto->cantidad,"idorp"=>$value->idtemp,"seguimientoinsumo"=>$value->seguimientoinsumo);
            $index++;
        }
        return $productos;
    }
    
    /*
     * Filtra los productos residuales de una determinada orden
     */
    public function obtenerResiduales($idorden)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'p.codigo, p.nombre, u.simbolo, e.* ';
        $criteria->join = ' inner join "'.getGestionSchema().'".entrega e on t.id = e.idorden and e.eliminado = false
                            inner join "'.getGestionSchema().'".producto p on e.idproductoresidual = p.id
                            inner join unidad u on p.idunidad = u.id ';
        $criteria->compare('t.id', $idorden);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            ));
    }
/*
     * Actualiza la la columna eliminado de la orden a true y tambien la columna eliminado de la tabla Ordenreceta
 *@return array
     */
    public function anularOrden($descripcionanulacion)
    {
        $respuesta=array();
        
        if($descripcionanulacion==null||$descripcionanulacion==''){
            return $respuesta=array('error'=>true,'mensaje'=>'El motivo de la anulación es abligatorio.');
        }
        
        $modelOrden=$this;
        $modelOrden->descripcionanulacion=$descripcionanulacion;
        $modelOrden->fechaanulacion = new CDbExpression('NOW()');
        $usuario = Yii::app()->user->getName();
        $modelOrden->usuarioanulacion = $usuario;
            $modelOrden->eliminado=true;
            $modelOrdenReceta = Ordenreceta::model()->findByPk($modelOrden->id);
            $modelOrdenReceta->eliminado=true;
            if($modelOrden->save() && $modelOrdenReceta->save(false))
            {  
               return $respuesta=array('error'=>false,'mensaje'=>'La orden se anuló correctamente.');
            }
            else return $respuesta=array('error'=>true,'mensaje'=>'Error al anular la orden!');
            
    }
    /*
     * Elimina físicamente las notas borrador generadas al iniciar la orden
     */
    public function quitarNotasBorrador(){
        $respuesta=array();
        $arraynb=Notaborrador_Almacen::model()->findAll("iddocumento=:idorden",array(":idorden"=>$this->id));
        foreach ($arraynb as $valuenb) {
            $arraypnb=Productonotaborrador_Almacen::model()->findAll("idnotaborrador=:idnotaborrador",array(":idnotaborrador"=>$valuenb->id));
            foreach ($arraypnb as $valuepnb) {
                if(!$valuepnb->delete()){
                    $respuesta=array("error"=>true,"mensaje"=>"No se eliminó productonotaborrador:".$valuepnb->idtemp);
                }                
            }
            if(!$valuenb->delete()){
                $respuesta=array("error"=>true,"mensaje"=>"No se eliminó notaborrador:".$valuenb->id);
            }
        }
        $respuesta=array("error"=>false,"mensaje"=>"Las notas se eliminaron correctamente.");
    }
     /*
     * Verifica si la cantidad de devolucion es igual a la cantidad original de insumos de esta Orden
     */
    public function verificarDevolucionOrden(){
        $respuesta = array();
        
        $insumosOrden =  Ordenrecetaproducto::model()->findAll("idordenreceta=:idorden",array(":idorden"=>$this->id));
        foreach ($insumosOrden as $valueinsumos) {
            if($valueinsumos->idnotaborrador == null || $valueinsumos->idnotaborrador == -1){
                $respuesta=array("error"=>true,"mensaje"=>"El insumo ".$valueinsumos->idproducto1->codigo." no tiene una NotaBorrador");
                return $respuesta;
            }
            $modelnotaborrador = Notaborrador_Almacen::model()->find("id=".$valueinsumos->idnotaborrador);
            if($modelnotaborrador == null){
                $respuesta = array("error"=>true,"mensaje"=>"El insumo ".$valueinsumos->idproducto1->codigo." no tiene una NotaBorrador en Almacen");
                return $respuesta;
            }
            if($modelnotaborrador->eliminado == false){
                $respuesta = array("error"=>true,"mensaje"=>"La notaborrador del insumo ".$valueinsumos->idproducto1->codigo." no se ha confirmado en Almacen");
                return $respuesta;
            }
           
            $command = Yii::app()->produccion->createCommand("select sum(t.cantidad) from devolucionproducto t inner join devolucion dev on dev.id=t.iddevolucion where dev.idorden=:idorden AND t.idproducto=:idproducto");
            $command->bindValue(":idorden", $this->id, PDO::PARAM_INT);
            $command->bindValue(":idproducto", $valueinsumos->idproducto, PDO::PARAM_INT);
            $cantidaddevuelta= $command->queryScalar();
            
            //cantidad total del insumo, en el caso de que haya duplicados
            $insumosOrdenSuma =  Ordenrecetaproducto::model()->findAll("idordenreceta=:idorden AND idproducto=:idproducto",array(":idorden"=>$this->id,":idproducto"=>$valueinsumos->idproducto));
            $cantidadtotal=0;
            foreach ($insumosOrdenSuma as $value) {
                $cantidadtotal+=$value->cantidad;
            }
            
            if(number_format($cantidaddevuelta, 8, '.', ',')<>number_format($cantidadtotal, 8, '.', ',')){
                $respuesta=array("error"=>true,"mensaje"=>"La cantidad devuelta en Almacen es diferentte; para el insumo ".$valueinsumos->idproducto1->codigo."");
                return $respuesta;
            }
            
        }
        $respuesta=array("error"=>false,"mensaje"=>"Se puede anular la orden.");
                return $respuesta;
       
    }
    
    public function actualizarPuOrdenRecetaProducto($idordenreceta, $arrayIdtemp) {
        $conexion = Yii::app()->produccion;
        $transaction = $conexion->beginTransaction();
        try {
            $productos = $this->obtenerProductosInsumoAdicional($idordenreceta, $arrayIdtemp);
            foreach ($productos as $dato) {
                if ($dato->saldo == 0 || $dato->saldoimporte == 0)
                    $preciounitario = $dato->ultimoppp;
                else
                    $preciounitario = $dato->saldoimporte / $dato->saldo;

                $sql = "UPDATE ordenrecetaproducto SET preciounitario=" . $preciounitario . " WHERE idproducto = " . $dato->id . ' AND idordenreceta=' . $idordenreceta;
                $conexion->createCommand($sql)->execute();
            }
            $transaction->commit();
            return 0;
        } catch (Exception $exc) {
            $transaction->rollback();
            return 1;
        }
    }

    /*
     * Devuelve los parametros de un determinado costos, el id del costo se envía como parámetro
     * 
     */

    public function obtenerIDsCostosUtilizados() {
        $idorden = $this->id;
        
        $data = $command = Yii::app()->produccion->createCommand()
                ->select("DISTINCT(obj::json->>'idci') idcostoindirecto")
                ->from('orden t,json_array_elements(t.costostotales::json) obj')
                //->join("json_array_elements(t.costos::json->'pc') obj", 'obj.value is not null')
                ->where("costos is not null AND t.id = :idorden", array(":idorden" => $idorden))
                ->order("(obj::json->>'idci') ASC")
                ->queryColumn();
        return $data;
    }
    /**
     * Verifica si la orden está cerrada y si el costo a sido confirmada
     * @return array
     */
    public function verificaConfirmacionCostos(){
        $identificador = $this->id;

        $orpArray= Ordenestado::model()->findAll('idorden='.$identificador);

        $data = array();
        $cerrado= false;
        $costoconfirmado= false;    
        foreach ($orpArray as $orp) {
            if($orp->idestado==7)
            {
                $cerrado= true;
                break;
            }

        }     
        
        $ordenModel=Orden::model()->findByPk($identificador);
        if($ordenModel->costos!=null){
            $costoconfirmado= true;  
        }
$data[0] = array(            
            'cerrado' => $cerrado,
            'costoconfirmado' => $costoconfirmado); 
      
        return $data[0];
    }
    /**
     * Actualiza la columna idultimoestado de la orden
     * @return boolean
     */
    public function actualizaUltimoEstadoOrden(){
        try{
        $command = Yii::app()->produccion->createCommand("select t.id FROM orden t WHERE t.id=".$this->id)
                ->queryColumn();
        
        foreach ($command as $valueIdOrden) {
            $commandUltimoEstado = Yii::app()->produccion->createCommand(
                    "select oe.idestado FROM ordenestado oe "
                    . "WHERE idorden=".$valueIdOrden." ORDER BY oe.idestado DESC")
                ->queryRow();
            
            
                $conexion = Yii::app()->produccion;
                $sql = "UPDATE orden SET idultimoestado=" . $commandUltimoEstado["idestado"] . " WHERE id = " . $valueIdOrden;
                $conexion->createCommand($sql)->execute();
        }
        $arrayOrdenes =  Ordenanulacion::model()->findAll();
        }  catch (Exception $e){
            return false;
        }
        return true;
    }
    public function obtenerFechaPostgres(){
        $now = new CDbExpression("NOW()");
        $fechadb = Yii::app()->db->createCommand('select '.$now.' as fecha')->queryColumn();
        $fehaPostgre= date('Y-m-d H:i:s',strtotime($fechadb[0]));
        return $fehaPostgre;
    }
    /**
     * Verifica si la orden tiene subproductos
     */
    public function tieneSubProductos(){
        $cantidadSubproductod=Entrega::model()->count("idproductoresidual IS NOT NULL AND idorden = ".$this->id);
        return $cantidadSubproductod>0?true:false;
    }
    public function generarNotasDevolucionSubProductos(){
        $entregas =  Entrega::model()->findAll("idproductoresidual IS NOT NULL AND idorden = ".$this->id);
        $productos=array();
        foreach ($entregas as $value) {
            $productos[]=array(
                "id"=>$value->idproductoresidual,         
                "cantidad"=>$value->cantidad,
            );
        }
        
        $productos=  $this->unirProductosRepetidos($productos);
        $productosPorAlmacen=$this->clasificacionDeProductosPorAlmacen($productos);  
        
        Nota_Almacen::model()->registrarNotaSalidaSubproductos($productosPorAlmacen, $this->numero, $this->id);
    }
    /**
     * Une productos repetidos, si encuentra un producto repetido suma la cantidad
     * @param type $productos
     * @return type
     */
    private function unirProductosRepetidos($productos){
        $nproductos =  array_column($productos, 'id');
        $nproductos = array_unique($nproductos);
                
        $respuestaProductos=array();
        foreach ($nproductos as $idpro) {
            $sumacantidad=0;
            foreach ($productos as $value) {
                if($value["id"]==$idpro){
                    $sumacantidad+=$value["cantidad"];
                }
            }
            $respuestaProductos[]=array(
                "id"=>$idpro,         
                "cantidad"=>$sumacantidad,
            );
        }
        
        return $respuestaProductos;
    }
    
    /**
     * Clasificación de productos por almacen
     * @param type $productos
     * @return array
     */
    private function clasificacionDeProductosPorAlmacen($productos) {
        $respuesta = array();
        $idAlmacenPadre = $this->obtieneAlmacenesPadre($productos);
        for ($i = 0; $i < count($idAlmacenPadre); $i++) {
            $idalmacen = $idAlmacenPadre[$i];
            $j = 0;
            $productosAlmacen = array();
            
            
            for ($k = 0; $k < count($productos); $k++) {
                $productomodel = Producto::model()->findByPk($productos[$k]['id']);
                if ($productomodel->idalmacen == $idalmacen) {                    
                    array_push($productosAlmacen, $productos[$k]);
                }
            }
            array_push($respuesta, array("idalmacen" => $idalmacen, "productos" => $productosAlmacen));
        }
        return $respuesta;
    }
    
    public function setVentaPedidoEspecial($registrarNuevo=false){
        
        if($this->iddocumentoproductoventa!=null || $this->iddocumentoproductoventa!=''){
           
            $ids= explode(',',$this->iddocumentoproductoventa);
            $q="select p.id,p.numero,e.nombre  as estado,especificacionpedido
                from documentoproducto dp inner join pedido p on p.id=dp.idpedido
                     left join general.estado e on e.id=p.idestado
                where dp.id=".$ids[0]."
                ";
            
            $pedido=Yii::app()->venta->createCommand($q)->queryRow();
            if($pedido!=null){
                $this->ventaIdpedido=$pedido['id'];
                $this->ventaNumeropedido=$pedido['numero'];
                $this->ventaEstadopedido=$pedido['estado'];
                
                if($registrarNuevo){
                  $this->descripcion=$pedido['especificacionpedido'];
                }
            }
            
        }
    }
    
    /*
    * Método para obtener los productos de una orden para devolucion de un almacen especifico
    * @param integer $idordenreceta
    * @return CActiveDataProvider
    */
    public function obtenerProductosDeOrdenDevolucion($idordenreceta){
        $criteria = new CDbCriteria;
        $criteria->select = 'ord.idnotaborrador, ord.idtemp as idorp, o.id as idordenreceta,'
                . 'ord.cantidadoriginalreceta,ord.seguimientoinsumo,'
                . 'p.id, p.codigo, p.nombre,p.saldoimporte, p.reserva, p.saldo, '
                . 'u.simbolo, ord.cantidad,  ord.preciounitario, p.idalmacen';
        $criteria->join = 'inner join "'.getGestionSchema().'".ordenreceta o on t.id = o.id
                            inner join "'.getGestionSchema().'".ordenrecetaproducto ord on t.id = ord.idordenreceta
                            inner join "'.getGestionSchema().'".producto p on ord.idproducto = p.id
                            inner join unidad u on p.idunidad = u.id';
      
        //$criteria->order = 'p.codigo asc';
        $criteria->addCondition("t.id = ".$idordenreceta);
        $criteria->addCondition('p.idalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[])) and t.id>0');

        return new CActiveDataProvider(
                $this, 
                array(
                    'pagination' => false,
                    'criteria' => $criteria,
                    'sort'=>array(
                        'defaultOrder'=>'ord.numero ASC',
                    ),
                )
        );
    }
    
    /* esta función le inidica al boton de abrir orden si estara visible o no,
     * dependerá si la orden esta cerrada
     * @param string id de la orden
     * @return boolean retornamos true si se muestra el boton y false si no se muestra
     */
    public function mostrarBotonAnularEntrega($idorden)
    {
        $idultimoestado=Orden::model()->findByPk($idorden)->idultimoestado;
        if ($idultimoestado == 4) {
            return true;
        } else {
            return false;
        }
    }
}
