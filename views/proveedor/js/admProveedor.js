var admProveedor = new Object();
admProveedor.__proto__ = SystemSearch;

//declare var
admProveedor.nameView = "admProveedor";
admProveedor.url = "proveedor/admin";
admProveedor.idContainer = "";
admProveedor.eventRow = "THIS.update();";
admProveedor.nextView = "Proveedor";
//functions
admProveedor.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admProveedor.init()');
    }
}

admProveedor.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Proveedor.idKeySend());';
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
