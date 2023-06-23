
var admAlmacen = new Object();
admAlmacen.__proto__ = SystemSearch;

//declare var
admAlmacen.nameView = "admAlmacen";
admAlmacen.url = "almacen/admin";
admAlmacen.idContainer = "";
admAlmacen.eventRow = "THIS.update();";
admAlmacen.nextView = "Almacen";
//functions
admAlmacen.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admAlmacen.init()');
    }
}

admAlmacen.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Almacen.idKeySend());';
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

}   






