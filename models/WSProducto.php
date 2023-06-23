<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WSProducto
 *
 * @author programador3
 */
class WSProducto {
    //put your code here
    /**
     * Verifica si el producto tiene alguna relación con las tablas OrdenReceta y OrdenRecetaProducto
     * Si es 0 quiere decir que tiene un relacion
     * Si es 1 entonces no existe ninguna relacion 
     * Si es -1 entonces ocurrio algún error
     * @param integer $idproducto
     * @return array
     * @soap
     */
    public function existeRelacionProducto($idproducto) {
        $respuesta = array("error" => false, "existe" => false);
        try {
            $productomodel = ProduccionProducto::model()->findByPk($idproducto);
            //verifica insumos de la orden           
            $criteriaordeninsumo = new CDbCriteria();
            $criteriaordeninsumo->join = "inner join ordenrecetaproducto orp on t.id = orp.idordenreceta inner join orden o on o.id=t.id";
            //$criteriacoden->addNotInCondition('orp.idordenreceta',$arrayidsreceta);
            $criteriaordeninsumo->addCondition("orp.idproducto = :idproducto");
            $criteriaordeninsumo->addCondition("o.eliminado is false");
            $criteriaordeninsumo->params = array(
                ':idproducto' => $idproducto
            );
            $cantidadordeninsumo = ProduccionOrdenreceta::model()->find($criteriaordeninsumo);
            if ($cantidadordeninsumo != null) {
                $ordenmodel = ProduccionOrden::model()->findByPk($cantidadordeninsumo->id);
                return array("error" => false, "existe" => true, "mensaje" => sprintf("El producto %s esta relacionado con los insumos de la orden Nº %d", $productomodel->codigo, $ordenmodel->numero));
            }
            //verifica insumos de la receta
            $criteriarecetainsumo = new CDbCriteria();
            $criteriarecetainsumo->join = "inner join ordenrecetaproducto orp on t.id = orp.idordenreceta inner join receta r on r.id=t.id";
            //$criteriacoden->addNotInCondition('orp.idordenreceta',$arrayidsreceta);
            $criteriarecetainsumo->addCondition("orp.idproducto = :idproducto");
            $criteriarecetainsumo->addCondition("r.idreceta is null and r.eliminado is false");
            $criteriarecetainsumo->params = array(
                ':idproducto' => $idproducto
            );
            $cantidadrecetainsumo = ProduccionOrdenreceta::model()->find($criteriarecetainsumo);
            if ($cantidadrecetainsumo != null) {
                $recetamodel = ProduccionReceta::model()->findByPk($cantidadrecetainsumo->id);
                return array("error" => false, "existe" => true, "mensaje" => sprintf("El producto %s esta relacionado con los insumos de la receta Nº %d", $productomodel->codigo, $recetamodel->numero));
            }
            //realacion con el producto de la orden
            $criteriaorden = new CDbCriteria();
            $criteriaorden->join = "inner join orden o on o.id=t.id";
            $criteriaorden->addCondition("t.idproducto = :idproducto");
            $criteriaorden->addCondition("o.eliminado is false");
            $criteriaorden->params = array(
                ':idproducto' => $idproducto
            );
            $cantidadorden = ProduccionOrdenreceta::model()->find($criteriaorden);
            if ($cantidadorden != null) {
                $recetamodel = ProduccionOrden::model()->findByPk($cantidadorden->id);
                return array("error" => false, "existe" => true, "mensaje" => sprintf("El producto %s esta relacionado con la orden Nº %d", $productomodel->codigo, $recetamodel->numero));
            }
            //realacion con el producto de la receta    
            $criteriarecetainsumo = new CDbCriteria();
            $criteriarecetainsumo->join = "inner join receta r on r.id=t.id";
            $criteriarecetainsumo->addCondition("t.idproducto = :idproducto");
            $criteriarecetainsumo->addCondition("r.idreceta is null and r.eliminado is false");
            $criteriarecetainsumo->params = array(
                ':idproducto' => $idproducto
            );
            $cantidadreceta = ProduccionOrdenreceta::model()->find($criteriarecetainsumo);
            if ($cantidadreceta != null) {
                $recetamodel = ProduccionReceta::model()->findByPk($cantidadreceta->id);
                return array("error" => false, "existe" => true, "mensaje" => sprintf("El producto %s esta relacionado con la receta Nº %d", $productomodel->codigo, $recetamodel->numero));
            }
            if (ProduccionProducto::model()->exists('t.id=' . $idproducto) == false) {
                $respuesta = array("error" => true, "mensaje" => sprintf("El producto %s no existe en la BD de Produccion", $productomodel->codigo));
            }
        } catch (Exception $exc) {
            $respuesta = array("error" => true, "mensaje" => sprintf("Error al verificar coincidencias en Producción", $productomodel->codigo));
        }
        return $respuesta;
    }

}
