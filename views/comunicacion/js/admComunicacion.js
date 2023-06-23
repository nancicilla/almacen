var admComunicacion = new Object();
admComunicacion.__proto__ = SystemSearch;

//declare var
admComunicacion.nameView = "admComunicacion";
admComunicacion.url = "comunicacion/admin";
admComunicacion.idContainer = "";
admComunicacion.eventRow = "THIS.update();";
admComunicacion.nextView = "Comunicacion";
//functions
admComunicacion.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admComunicacion.init()');
    }
}

admComunicacion.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Comunicacion.idKeySend());';
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
