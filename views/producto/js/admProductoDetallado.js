var admProductoDetallado = new Object();
admProductoDetallado.__proto__ = SystemSearch;

//declare var
admProductoDetallado.nameView = "admProductoDetallado";
admProductoDetallado.url = "producto/adminDetallado";
admProductoDetallado.idContainer = "";
admProductoDetallado.eventRow = "THIS.MovimientosProducto();";
admProductoDetallado.nextView = "Producto";
//functions
admProductoDetallado.init = function(e) {
    try {
        
    } catch (err) {
        alert('Error al cargar admProductoDetallado.init()');
    }
}

admProductoDetallado.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Producto.idKeySend());';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        updateFunction: updateFunction,
        varsSend: varsSend
    };

    return options;

};

admProductoDetallado.MovimientosProducto = function () {
    this.set_url();
    var THIS = this;
    Producto.Movimientos(THIS.getOptions());
}