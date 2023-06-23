<?php

/*
 * Receta.php
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

 * This is the model class for table "receta".
 *
 * The followings are the available columns in table 'receta':
 * @property integer $id
 * @property integer $idreceta
 *
 * The followings are the available model relations:
 * @property Ordenreceta $id0
 */

class ProduccionReceta extends CActiveRecord {
    public $idalmacen;
    public $codigo;
    public $nombre;
    public $descripcion;
    public $fecha;
    public $usuario;
    public $ingrediente;
    public $idingrediente;
    public $proceso;
    public $estadoreceta;
    public $producto;
    public $idproducto;

    public $productoValido;
    public $idAnterior;
    
    public $cantidadproducir;
    public $simbolo;

    //variables para la busqueda por cantidad
    public $cantidadHasta;
    public $cantidadDesde; 
    
    public $actualizarOrden = 0;
    
    public $rkw;// registro kw para el calculo de los costos de las ordenes de produccion solo si este registro es diferente de 0
    //----- reprocesado
    public $reprocesado;
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
        return 'receta';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('id', 'required'),
            array('id, idreceta', 'numerical', 'integerOnly' => true),
            //array('cantidadDesde,cantidadHasta','my_required', 'on' => array('search')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rkw,numero,id,cantidadDesde,cantidadHasta, idreceta, codigo, nombre, descripcion, fecha, usuario, idingrediente, proceso,estadoreceta,idestadoreceta', 'safe', 'on' => 'search'),
        );
    }

    /**
 * Funcion de validación personalizada, para la busque por cantidad
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
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'id0' => array(self::BELONGS_TO, 'Ordenreceta', 'id'),
            'idestadoreceta0' => array(self::BELONGS_TO, 'Estadoreceta', 'idestadoreceta')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'idreceta' => 'Idreceta',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'producto' => 'Producto',
            'cantidadproducir' => 'Cantidad Producir',
            'recetaespecial'=>'Receta Especial',
            'estadoreceta'=>'Estado',
            'idalmacen'=>'Almacén',
            'numero'=>'Nº',
            'idestadoreceta'=>'Estado Receta',
            'rkw'=>'Electricidad',
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
        $criteria->with = array('id0','idestadoreceta0', 'id0.idproducto0');
        
        if ($this->codigo != Null) {
            $criteria->addCondition("idproducto0.codigo ilike '" . $this->codigo . "%'");
        }
        if ($this->nombre != Null) {
            $criteria->addCondition("idproducto0.nombre ilike '%" . $this->nombre . "%'");
        }
        if ($this->descripcion != Null) {
            $criteria->addCondition("id0.descripcion ilike '%" . $this->descripcion . "%'");
        }
        if ($this->fecha != Null) {
            $criteria->addCondition("id0.fecha::date = '" . $this->fecha . "'");
        }
        if ($this->usuario != Null) {
            $criteria->addCondition("id0.usuario ilike '%" . $this->usuario . "%'");
        }
        if ($this->idingrediente != Null) {
            $criteria->join = 'INNER JOIN Ordenreceta ot ON ot.id=t.id INNER JOIN Ordenrecetaproducto op ON op.idordenreceta=ot.id INNER JOIN Producto p ON p.id=op.idproducto';
            $criteria->compare("op.idproducto", $this->idingrediente);
        }
        if ($this->proceso != Null) {
            $criteria->join = "INNER JOIN Ordenreceta ot ON ot.id=t.id INNER JOIN Ordenrecetaprocesoempleadomaquina om ON om.idordenreceta=ot.id INNER JOIN Ordenrecetaproducto op ON op.idordenreceta=ot.id INNER JOIN Proceso p ON p.id=om.idproceso";
            $criteria->compare('p.id', $this->proceso);
        }
        if($this->estadoreceta!= Null) {
            //$criteria->join = "INNER JOIN configuracion.estadoreceta er ON er.id=t.idestadoreceta ";
            $criteria->addCondition('t.idestadoreceta='. $this->estadoreceta);
        }
        if($this->numero!= Null) {
            //$criteria->join = "INNER JOIN configuracion.estadoreceta er ON er.id=t.idestadoreceta ";
            $criteria->addCondition('t.numero='. $this->numero);
        }
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
        
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.idreceta', $this->idreceta);
        $criteria->addCondition('t.idreceta is null');
        //$criteria->order = 'idproducto0.codigo asc';
        //$criteria->order = 't.id asc';
        
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'numero ASC',
                'attributes' => array(
                    'numero' => array(
                        'asc' => 'numero',
                        'desc' => 'numero DESC'
                    ),
                    'codigo' => array(
                        'asc' => 'idproducto0.codigo',
                        'desc' => 'idproducto0.codigo DESC'
                    ),
                    'nombre' => array(
                        'asc' => 'idproducto0.nombre',
                        'desc' => 'idproducto0.nombre DESC'
                    ),
                    'descripcion' => array(
                        'asc' => 'id0.descripcion',
                        'desc' => 'id0.descripcion DESC'
                    ),
                    'fecha' => array(
                        'asc' => 'id0.fecha',
                        'desc' => 'id0.fecha DESC'
                    ),
                    'usuario' => array(
                        'asc' => 'id0.usuario',
                        'desc' => 'id0.usuario DESC'
                    ),
                    'cantidadproducir'=>array(
                        'asc' => 'id0.cantidadproducir',
                        'desc' => 'id0.cantidadproducir DESC'
                    ),
                    'estadoreceta'=>array(
                        'asc' => 'idestadoreceta0.nombre',
                        'desc' => 'idestadoreceta0.nombre DESC'
                    ),
                    '*'
                )
            )
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
     * @return Receta the static model class
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
        return parent::beforeSave();
    }
    
    public function beforeSafeDelete() 
    {
        $idproducto = Yii::app()->produccion->createCommand(""
                . "select idproducto from ordenreceta where id = ".$this->id." and eliminado=false")->queryScalar();

        /*$cantidadOrden = Yii::app()->produccion->createCommand(
        "select count(id) "
        ."from ordenreceta "
        ."where idproducto = $idproducto and id in(select id from orden where eliminado is true)")->queryScalar();*/
        $cantidadOrden = Yii::app()->produccion->createCommand('select count(*) from ordenreceta ore inner join orden o on o.id=ore.id where ore.idproducto='.$idproducto.' and o.eliminado is false')->queryScalar();

        if ($cantidadOrden > 0) {
            echo System::messageError('No se puede eliminar ya que existe ORDEN asociado a esta RECETA!');
            return;
        }
        else
        {
            //Ordenrecetaprocesoempleadomaquina::model()->deleteAll('idordenreceta in(select id from receta where id = '.$this->id.' or idreceta = '.$this->id.')');
            $criteriaorpem=new CDbCriteria();
            $criteriaorpem->addCondition('idordenreceta in(select id from receta where id = '.$this->id.' or idreceta = '.$this->id.')');
            Ordenrecetaprocesoempleadomaquina::model()->updateAll(array('eliminado'=>true,'fecha'=>date('Y-m-d H:i:s'),'usuario'=>Yii::app()->user->getName()),$criteriaorpem);
            
            //Ordenrecetaproducto::model()->deleteAll('idordenreceta in(select id from receta where id = '.$this->id.' or idreceta = '.$this->id.')');
            $criteriaorp=new CDbCriteria();
            $criteriaorp->addCondition('idordenreceta in(select id from receta where id = '.$this->id.' or idreceta = '.$this->id.')');
            Ordenrecetaproducto::model()->updateAll(array('eliminado'=>true,'fecha'=>date('Y-m-d H:i:s'),'usuario'=>Yii::app()->user->getName()),$criteriaorp);
            
            
            $array = $this->extraeRecetas($this->id);
            //Receta::model()->deleteAll('id = '.$this->id.' or idreceta = '.$this->id);
            $criteriar=new CDbCriteria();
            $criteriar->addCondition('id = '.$this->id.' or idreceta = '.$this->id);
            Receta::model()->updateAll(array('eliminado'=>true,'fecha'=>date('Y-m-d H:i:s'),'usuario'=>Yii::app()->user->getName()),$criteriar);

            for($i = 0; $i < count($array); $i++){
                //Ordenreceta::model()->deleteAll('id = '.$array[$i]);  
                $criteriaor=new CDbCriteria();
                $criteriaor->addCondition('id = '.$array[$i]);
                Ordenreceta::model()->updateAll(array('eliminado'=>true,'fecha'=>date('Y-m-d H:i:s'),'usuario'=>Yii::app()->user->getName()),$criteriaor);
            }  
            return;
        }
    }
    
    /*
     * metodo que extrae los ids de las recetas historiales a eliminar
     */
    private function extraeRecetas($id)
    {
        $criteria = new CDbCriteria;
        $ids = null;
        
        $criteria->select = 't.id';
        $criteria->addCondition('t.id in (select id from receta where id = '.$id.' or idreceta = '.$id.')');
        $data = $this->findAll($criteria);
        
        for ($i = 0; $i < count($data); $i++) {
            $ids[] = ($data[$i]['id']);
        }
        return $ids;
    }
    
    /*
     * metodo para verificar que hayan existido cambios en el grid con
     * respecto a los datos reales de la base de datos.
     * @param array $productos
     * @param integer $idordenreceta
     */
    public function modificacionInsumos($productos, $idordenreceta)
    {
        $datosBd = array();
        $datosBd = Ordenrecetaproducto::model()->datosOrdenRecetaProductoBd($idordenreceta);
        $cantidadProductosGrid = count($productos);
        $cantidadProductosBd = count($datosBd);
        $cambiosRealizados = 0;
        
        if($cantidadProductosGrid == $cantidadProductosBd)
        {
            $iguales = 0;
            for($filaGrid = 1; $filaGrid <= $cantidadProductosGrid; $filaGrid++)
            {
                for($filaBd = 0; $filaBd < $cantidadProductosBd; $filaBd++)
                {
                    if($productos[$filaGrid]['id'] == $datosBd[$filaBd]['idproducto'])
                    {
                        $iguales++;
                        if($productos[$filaGrid]['cantidad'] != $datosBd[$filaBd]['cantidad'])                            
                            return $cambiosRealizados = 1;
                        //if(isset($productos[$filaGrid]['coeficiente']))
                        if($productos[$filaGrid]['coeficiente'] != $datosBd[$filaBd]['coeficiente'])
                            return $cambiosRealizados = 1;
                        break;
                    }
                }
            }
            if($iguales == $cantidadProductosBd)
                return $cambiosRealizados = 0;
            else
                return $cambiosRealizados = 1;
        }
        else
            return $cambiosRealizados = 12;
    }
    
    /*
     * funcion que valida de que el Grid de insumos no contenga ningun registro con
     * cantidad igual a cero
     */
    public function validaInsumos($productos)
    {
        $cantidad = count($productos);
        for($i = 1; $i <= $cantidad; $i++)
        {
            if($productos[$i]['cantidad'] == 0)
                return 0;
        }
        return 1;
    }
    /*
     * funcion que valida los coeficientes de los insumos de una receta
     * verifica que la sunma total de los coeficientes sea igual a 1
     */
    public function coeficientesInsumosEsIgualAUno($productos)
    {
        
        $totalsumacoeficiente=0;
               $cantidad = count($productos); 
            for($i = 1; $i <= $cantidad; $i++)
            {
                if($productos[$i]['coeficiente'] == true){
                    $totalsumacoeficiente+=$productos[$i]['cantidad'];
                }
            }
       
        $totalsumacoeficiente=round($totalsumacoeficiente,7);
        if($totalsumacoeficiente==1)
        return true;
        else{
            return false;
        }
        
    }
    /*
     * funcion que valida los coeficientes de los insumos de una receta
     * verifica si exite coeficientes en los insumos
     */
    public function validaSiExisteCoeficientesInsumos($productos)
    {
        $cantidad = count($productos);
        //primero verificamos si existen coeficientes
        $escoeficiente=false;
        for($i = 1; $i <= $cantidad; $i++)
        {
            if($productos[$i]['coeficiente'] == true){
                $escoeficiente=true;
                break;
            }
        }
       
        return $escoeficiente;
    }
    /**
     * Este método retorna el numero de receta, para el registro del mismo
     * Se utiliza al momento de crear una nueva receta
     */
    public function obtenerNumero(){
        //$numero=Receta::model()->count('idreceta is null');
        
        $maxNumero = Yii::app()->produccion->createCommand('select max(numero) + 1 from receta where idreceta is null')->queryScalar();
        if($maxNumero==null)$maxNumero=1;
                    $maxNumero = $maxNumero > 0 ? $maxNumero: 1;
        return $maxNumero;
    }
    /**
     * Obtiene el formato para el registro de la columna kw en la tabla receta
     * Este registro se utiliza al momento de hacer el calculo de los costos
     */
    public function obtenerRegistroKwElectricidad($param_rkw){
        /**
COSTEO AGUA=c_agua
COSTEO GAS=c_gas
COSTEO MANT. PREV.=c_mant_prev
COSTEO MANT. CORR.=c_mant_corr
COSTEO DEPRECIACIÓN=c_depreciacion
         */
        $arrayKW = array(
            array("idci"=>2,"descr"=>"c_electricidad","costo"=>$param_rkw),
            array("idci"=>9,"descr"=>"c_agua","costo"=>$param_rkw),
            array("idci"=>10,"descr"=>"c_gas","costo"=>$param_rkw),
            array("idci"=>14,"descr"=>"c_mant_prev","costo"=>$param_rkw),
            array("idci"=>15,"descr"=>"c_mant_corr","costo"=>$param_rkw),
            array("idci"=>16,"descr"=>"c_depreciacion","costo"=>$param_rkw),
        );
        return CJSON::encode($arrayKW);
    }
    
}
