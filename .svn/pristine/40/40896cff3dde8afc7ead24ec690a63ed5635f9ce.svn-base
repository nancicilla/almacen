
var admClase = new Object();
admClase.__proto__ = SystemSearch;

//declare var
admClase.nameView = "admClase";
admClase.url = "clase/admin";
admClase.idContainer = "";
admClase.eventRow = "THIS.update();";
admClase.nextView = "Clase";
//functions
admClase.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admClase.init()');
    }
}

admClase.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Clase.idKeySend());';
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






