var admInventariar = new Object();
admInventariar.__proto__ = SystemSearch;

//declare var
admInventariar.nameView = "admInventariar";
admInventariar.url = "producto/InventariarProducto";
admInventariar.idContainer = "";
admInventariar.eventRow = "THIS.update();";
admInventariar.nextView = "Producto";
//functions
admInventariar.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admInventariar.init()');
    }
};

admInventariar.options = function () {
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