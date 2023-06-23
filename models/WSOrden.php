<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WSOrden
 *
 * @author programador5
 */
class WSOrden{
    
    /**
     * Obtiene el último estado de una determinada orden de producción
     * @param integer $idorden
     * @return integer
     * @soap
     */
    public function getUltimoEstadoOrden($idorden) {
        try {
            $criteria = new CDbCriteria();
            $criteria->addCondition("idorden=:idorden");
            $criteria->params = array(':idorden' => $idorden);
            $criteria->order = 'fecha DESC';
            $criteria->limit = 1;
            
            $model = ProduccionOrdenestado::model()->find($criteria);
            $model->setScenario('cambioEstadoProceso');
            $idestado=$model->idestado;
            
            return $idestado;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            
        }
        return -1;
    }
    
        /**
     * Inserta un nuevo estado a una orden, retorna 0 si no hubo errores,y diferente de 0 si ocurrió algún error
     * @param integer $idorden
     * @param string $usuario
     * @return integer
     * @soap
     */
    public function nuevoEstadoOrden($idorden,$usuario) {
        try {
            Yii::app()->session['varUsuario'] = $usuario;
            $ordenestado = new ProduccionOrdenestado();  
            
            $ordenestado->idorden = $idorden;
            $ordenestado->idestado = 3;//-->Estado EN PROCESO
            $ordenestado->descripcion = 'EN PROCESO, PLANIFICADO EL '.$ordenestado->idorden0->fechaplanificada;
            if($ordenestado->save()){
                unset(Yii::app()->session['varUsuario']);
                return 0;
            }
            unset(Yii::app()->session['varUsuario']);
            
            return 1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            
        }
        return 1;
    }
    
    /**
     * actualiza los precios unitarios de OrdenRecetaProducto
     * los parametros que enviamos a este metodo es el id de la orden para poder actualizar el precio unitario
     * precioUnitario=SaldoImporte/saldo
     * if (program_executed_fine) return 0;else if (program_had_error) return 1;
     * @param integer $idorden
     * @param integer $idnotaborrador
     * @return integer
     * @soap
     */
    public function updatePrecioUnitarioOrdenRecetaProducto($idorden,$idnotaborrador) {
        $connection=Yii::app()->produccion;
        $transaction=$connection->beginTransaction();
        try {
            $productos = ProduccionOrden::model()->obtenerProductosDeOrdenModel($idorden,$idnotaborrador);
            
            foreach ($productos as $valorPro)
            {
                if($valorPro->saldo==0 || $valorPro->saldoimporte==0 )
                    $preciounitario=$valorPro->ultimoppp;
                else 
                    $preciounitario=$valorPro->saldoimporte/$valorPro->saldo;
                
                $sql="UPDATE ordenrecetaproducto SET preciounitario=".$preciounitario." WHERE idproducto = ".$valorPro->id.' AND idordenreceta='.$idorden.' AND idnotaborrador='.$idnotaborrador;
                $connection->createCommand($sql)->execute();
            }
            $transaction->commit();
            return 0;
        } catch (Exception $exc) {
            $transaction->rollback();
            return 1;
        }
        return 1;
    }
    
}