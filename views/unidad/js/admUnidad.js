
var admUnidad = new Object();
admUnidad.__proto__ = SystemSearch;

//declare var
admUnidad.nameView = "admUnidad";
admUnidad.url = "unidad/admin";
admUnidad.idContainer = "";
admUnidad.eventRow = "THIS.update();";
admUnidad.nextView = "Unidad";
//functions
admUnidad.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admUnidad.init()');
    }
}

admUnidad.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Unidad.idKeySend());';
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






