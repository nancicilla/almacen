
var admStock = new Object();
admStock.__proto__ = SystemSearch;

//declare var
admStock.nameView = "admStock";
admStock.url = "producto/stock";
admStock.idContainer = "";
admStock.model="Producto";
//admStock.eventRow = "THIS.update();";
//admStock.nextView = "Producto";
//functions
admStock.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admStock.init()');
    }
}

admStock.options = function () {
    var afterFunction = '';
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        varsSend: varsSend
    };
    return options;
}   
admStock.registrarSolicitud = function (){
    compraSolicitud.create('&idProducto='+SGridView.getSelected('id'));
}






