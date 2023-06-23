<?php
/*
 * Proyecto.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 14/06/2023
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
 
 * This is the model class for table "general.proyecto".
 *
 * The followings are the available columns in table 'general.proyecto':
 * @property integer $id
 * @property string $nombre
 * @property string $fechainicio
 * @property string $fechafin
 * @property boolean $itemensistema
 * @property boolean $enenvase
 * @property integer $numero
 * @property string $usuario
 * @property integer $idcaracteristica
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Caracteristicas $idcaracteristica
 */
class Proyecto extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $textos;
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
            return 'general.proyecto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('numero, idcaracteristica', 'numerical', 'integerOnly'=>true),
                    array('nombre', 'length', 'max'=>150),
                    array('usuario', 'length', 'max'=>30),
                    array('fechainicio, fechafin, itemensistema, enenvase, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre, fechainicio, fechafin, itemensistema, enenvase, numero, usuario, idcaracteristica, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idcaracteristica0' => array(self::BELONGS_TO, 'Caracteristicas', 'idcaracteristica'),
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
                    'fechainicio' => 'Fecha Inicio',
                    'fechafin' => 'Fecha Fin',
                    'itemensistema' => 'Item en Sistema',
                    'enenvase' => 'Para Envase?',
                    'numero' => 'Numero',
                    'usuario' => 'Usuario',
                    'idcaracteristica' => 'Diseño a usar',
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
		$criteria->addSearchCondition('t.fechainicio',$this->fechainicio,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechafin',$this->fechafin,true,'AND','ILIKE');
		$criteria->compare('t.itemensistema',$this->itemensistema);
		$criteria->compare('t.enenvase',$this->enenvase);
		$criteria->compare('t.numero',$this->numero);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idcaracteristica',$this->idcaracteristica);
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
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
     * @return Proyecto the static model class
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
    public function registrarInformacionProyecto($idproyecto,$idcaracteristica,$equipo,$proveedores) {
        $usuario= Yii::app()->user->getName();
        for($i=1;$i<=count($equipo);$i++){
            if($equipo[$i]['id']!=''){
                $e= new Equipotrabajo;
                $e->idpersonal=$equipo[$i]['id'];
                $e->idproyecto=$idproyecto;
                $e->esencargado=boolval($equipo[$i]['esencargado']);               
                $e->save();
            }
        }
        
        for($i=1;$i<=count($proveedores);$i++){
            if($proveedores[$i]['id']!=''){
                $p= new Proveedoreproyecto;
                $p->idproveedor=$proveedores[$i]['id'];
                $p->idproyecto=$idproyecto;
                $p->save();
            }
        }
        // registramos datos iniciales de las caracteristicas relacionadas al proyecto

       if($idcaracteristica!=''){
            $cadenaPrincipal='';
            
            $lista= Yii::app()->almacen->createCommand
                (" select id,nombre,tipovalor, idcaracteristicapadre,( select count(*) from general.caracteristicas c1 where c1.eliminado=false and c1.idcaracteristicapadre=c.id
										 ) as canthijos from general.caracteristicas 
										 c where c.eliminado=false and c.idcaracteristicapadre  =$idcaracteristica order by id asc")
                                    ->queryAll();
            $cantidad=count($lista);
            for($p=0;$p<$cantidad;$p++){
                
                   
                    // tiene hijos
                    $cadenaSecundaria='';
                    $sublista= Yii::app()->almacen->createCommand(" select id,nombre,tipovalor from general.caracteristicas  c where c.eliminado=false and c.idcaracteristicapadre  =".$lista[$p]['id']." order by id asc")
                                    ->queryAll();
                    $canthijos=count($sublista);
                    for($h=0;$h<$canthijos;$h++){
                        $cadenaSecundaria.='{"nombre":"'.$sublista[$h]['nombre'].'","tipovalor":'.$sublista[$h]['tipovalor'].',"valor":""},';
                    }
                    if($canthijos>0){
                    $cadenaSecundaria= substr($cadenaSecundaria,0,-1);
                    }
                    $cadenaPrincipal.='{"nombre":"'.$lista[$p]['nombre'].'","tipovalor":'.$lista[$p]['tipovalor'].',"hijos":['.$cadenaSecundaria.'],"valor":""},';
            
                
            }
            $cadenaPrincipal= substr($cadenaPrincipal,0,-1);
             Yii::app()->almacen->createCommand
                (" insert into historialproyectocaracteristica(idproyecto,informacion,usuario,fecha)values($idproyecto,'[$cadenaPrincipal]'::json,'$usuario',now())")
                                    ->execute();
            
       }        
    }
    public function registrarCaracteristicas($idproyecto,$listacaracteristica) {
        $usuario= Yii::app()->user->getName();
        Yii::app()->almacen->createCommand
                (" insert into historialproyectocaracteristica(idproyecto,informacion,usuario,fecha)values($idproyecto,'$listacaracteristica'::json,'$usuario',now())")
                                    ->execute();
        
    }
    /**
   * 
   * @param file $imagen, fotografia de la persona
   * @param string $directorioTemporal, ruta del directorio donde se almacenara la fotografia
   * @param integer $idproyecto , id relacionada con la persona
   * @return string, nombre del archivo
   * @throws CrugeException
   */
  public function registrarImagen( $imagen, $directorioTemporal,$idproyecto,$idcaracteristica) {
       
        $swFtp = Yii::app()->ftp;
      $nombreArchivo='';

        try {
            if (isset($imagen) && isset($idproyecto)) {
              
                $imagenPersona = $imagen;
                $cantidad = count($imagen);
                $swFtp->createDirectory($this->tableName());
                $swFtp->chdir($this->tableName());
                $swFtp->createDirectory($idproyecto);
                $swFtp->chdir($idproyecto);
                $swFtp->createDirectory($idcaracteristica);
                $swFtp->chdir($idcaracteristica);
                $swFtp->emptyDirectory();
                if ($cantidad > 0) {
                    for ($i = 1; $i <= $cantidad; $i++) {
                        foreach ($imagenPersona[$i] as $atributo => $dato) {
                                     if ($atributo == 'archivo') {
                                $ruta = explode("/", $dato);
                                if (count($ruta) > 1) {
                                    $nombreArchivo = $ruta['1'];
                                    if ($dato != Null) {
                                        $swFtp->put($nombreArchivo,$directorioTemporal . '/' . $dato,FTP_BINARY);
                                        $swFtp->chmod( $nombreArchivo,0705);                           


                                        
                                    }
                                }
                            }
                        }
                    }
                    exec("rm -rf " . escapeshellarg($directorioTemporal));
                }
            }
        } catch (Exception $ex) {
            throw new CrugeException('Error al registrar Fotografia ', 483);
        }
        return $nombreArchivo;
    }
    /**
     * 
     * @param integer $idproyecto, id de la persona
     * @param type $directorioTemporal
     * @throws CrugeException
     */
    public function prepararImagen($idproyecto,$idcaracteristica, $directorioTemporal) {
        $swFtp = Yii::app()->ftp;
        $swFtp->chdir($this->tableName());
        $swFtp->chdir($idproyecto);
        $swFtp->chdir($idcaracteristica);
         try {
             if ($idproyecto != Null && $directorioTemporal != Null) {
                 $swFtp->downloadDirectoryContent($directorioTemporal . "/uploads");
             }
         } catch (Exception $ex) {
             throw new CrugeException('Error al preparar imagen ', 483);
         }
         $swFtp->close();
    }
    public function cargarImagen($id) {
       
        $criteria = new CDbCriteria();
        $criteria->select = "t.id,CONCAT('uploads/',t.foto)as foto";
        ;
        $criteria->compare('t.id', $id);
        $informacion = $this->findAll($criteria);
        $dato = array();
        if (count($informacion) > 0) {
            foreach ($informacion as $i) {
                array_push($dato, $i->attributes);
            }
        }
        return $dato;
    }
    public function MostrarEliminar($idproyecto) {
        $idproyecto=SeguridadModule::dec($idproyecto);
        $cantidad =Yii::app()->almacen->createCommand
                (" select count(*) from historialproyectocaracteristica where idproyecto=$idproyecto")
                                    ->queryScalar();
        
       if($cantidad==1){
        return true;
       } 
       else{
        return false;
       }
    }
    
    


}
