var admDetallenota = new Object();
admDetallenota.__proto__ = SystemSearch;

//declare var
admDetallenota.nameView = "admDetallenota";
admDetallenota.url = "detallenota/admin";
admDetallenota.idContainer = "";
admDetallenota.eventRow = "THIS.update();";
admDetallenota.nextView = "Detallenota";
//functions
admDetallenota.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admDetallenota.init()');
    }
}

admDetallenota.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Detallenota.idKeySend());';
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
