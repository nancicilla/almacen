<?php
/*
 * Caracteristicas.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 10/06/2023
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
 
 * This is the model class for table "general.caracteristicas".
 *
 * The followings are the available columns in table 'general.caracteristicas':
 * @property integer $id
 * @property string $nombre
 * @property integer $orden
 * @property boolean $paraenvase
 * @property integer $tipovalor
 * @property integer $idcaracteristicapadre
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Caracteristicas $idcaracteristicapadre
 * @property Caracteristicas[] $caracteristicases
 */
class Caracteristicas extends CActiveRecord
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
            return 'general.caracteristicas';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                   // array('id', 'required'),
                    array('id, orden, tipovalor, idcaracteristicapadre', 'numerical', 'integerOnly'=>true),
                    array('nombre', 'length', 'max'=>200),
                    array('usuario', 'length', 'max'=>30),
                    array('paraenvase, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre, orden, paraenvase, tipovalor, idcaracteristicapadre, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                
                    'idcaracteristicapadre0' => array(self::BELONGS_TO, 'Caracteristicas', 'id'),
                    'caracteristicases' => array(self::HAS_MANY, 'Caracteristicas', 'idcaracteristicapadre'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'nombre' => 'Nombre',
                    'orden' => 'Orden',
                    'paraenvase' => 'Diseño Envase ?',
                    'tipovalor' => 'Tipovalor',
                    'idcaracteristicapadre' => 'Idcaracteristicapadre',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
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
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipovalor',$this->tipovalor);
		$criteria->compare('t.idcaracteristicapadre',$this->idcaracteristicapadre);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                 $criteria->addCondition("t.idcaracteristicapadre is null");
               

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
     * @return Caracteristicas the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    public function guardarInformacion($lista,$nombre,$opcion) {
        $cantidad=count($lista);
        
        $nombre=strtoupper($nombre);
	$usuario= Yii::app()->user->getName();
        Yii::app()->almacen->createCommand
                ("insert into general.caracteristicas(nombre,paraenvase, usuario, fecha)values('$nombre','$opcion'::boolean,'$usuario',now())")
                                    ->execute();
        
        $idpadre=Yii::app()->almacen->createCommand
                (" select currval('general.caracteristicas_id_seq'::regclass)::int")
                                    ->queryScalar();
        //;
        /*if(!$padre->save())
        {
            print_r($padre);
            return false;
        }
        $id=$padre->id;
        print_r($id);*/
        for($i=0;$i<$cantidad;$i++){
            /*$hijo=new Caracteristicas;
            $hijo->nombre=strtoupper($lista[$i]['nombre']);
            $hijo->usuario= Yii::app()->user->getName();
            $hijo->fecha= new CDbExpression('NOW()');
            $hijo->tipovalor=$lista[$i]['tipo'];
            $hijo->idcaracteristicapadre=1;
             if(!$hijo->save())
        {
            print_r($hijo);
            return false;
        }*/
            $nombre=strtoupper($lista[$i]['nombre']);
            $tipo=$lista[$i]['tipo'];
        
            Yii::app()->almacen->createCommand
                ("insert into general.caracteristicas(nombre,tipovalor,idcaracteristicapadre, usuario, fecha)values('$nombre',$tipo,$idpadre,'$usuario',now())")
                                    ->execute();
        
        $idhijo=Yii::app()->almacen->createCommand
                (" select currval('general.caracteristicas_id_seq'::regclass)::int")
                                    ->queryScalar();
            
        if(!empty($lista[$i]['hijos'])){
        for($n=0;$n<count($lista[$i]['hijos']);$n++){
           /*     $nieto=new Caracteristicas;
                $nieto->nombre=strtoupper($lista[$i]['hijos'][$n]['nombre']);
                $nieto->usuario= Yii::app()->user->getName();
                $nieto->fecha= new CDbExpression('NOW()');
                $nieto->tipovalor=$lista[$i]['hijos'][$n]['tipo'];
                $nieto->idcaracteristicapadre0=$hijo->id;
                 if(!$nieto->save())
        {
            print_r($nieto);
            return false;
        }*/
            $nombre=strtoupper($lista[$i]['hijos'][$n]['nombre']);
            $tipo=$lista[$i]['hijos'][$n]['tipo'];
        
            Yii::app()->almacen->createCommand
                ("insert into general.caracteristicas(nombre,tipovalor,idcaracteristicapadre, usuario, fecha)values('$nombre',$tipo,$idhijo,'$usuario',now())")
                                    ->execute();
        }
        
        }

            
        }
        
    }
    public function MostrarActualizar($id) {
        $id=SeguridadModule::dec($id);
        $respuesta= Yii::app()->almacen->createCommand
                ("select count(*) from general.proyecto  where eliminado=false and idcaracteristica=$id")
                                    ->queryScalar();
        if($respuesta==0){
            return true;
        }else{
            return false;
        }
    }
    public function actualizarInformacion($lista,$idpadre) {
        $cantidad=count($lista);
        
	$usuario= Yii::app()->user->getName();
        Yii::app()->almacen->createCommand
                ("update general.caracteristicas set eliminado=true ,fecha=now() where id in(
select id from general.caracteristicas c where c.eliminado=false and c.idcaracteristicapadre  in
( (select $idpadre::int as id)union(select  id from general.caracteristicas where eliminado=false and idcaracteristicapadre=$idpadre) ))")
                                    ->execute();
        
        
       
        
        for($i=0;$i<$cantidad;$i++){
            
            $nombre=strtoupper($lista[$i]['nombre']);
            $tipo=$lista[$i]['tipo'];
        
            Yii::app()->almacen->createCommand
                ("insert into general.caracteristicas(nombre,tipovalor,idcaracteristicapadre, usuario, fecha)values('$nombre',$tipo,$idpadre,'$usuario',now())")
                                    ->execute();
        
        $idhijo=Yii::app()->almacen->createCommand
                (" select currval('general.caracteristicas_id_seq'::regclass)::int")
                                    ->queryScalar();
            
        if(!empty($lista[$i]['hijos'])){
        for($n=0;$n<count($lista[$i]['hijos']);$n++){
           
            $nombre=strtoupper($lista[$i]['hijos'][$n]['nombre']);
            $tipo=$lista[$i]['hijos'][$n]['tipo'];
        
            Yii::app()->almacen->createCommand
                ("insert into general.caracteristicas(nombre,tipovalor,idcaracteristicapadre, usuario, fecha)values('$nombre',$tipo,$idhijo,'$usuario',now())")
                                    ->execute();
        }
        
        }

            
        }
        
    }


}
