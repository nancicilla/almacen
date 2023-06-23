var admSolicitud = new Object();
admSolicitud.__proto__ = SystemSearch;

//declare var
admSolicitud.nameView = "admSolicitud";
admSolicitud.url = "solicitud/admin";
admSolicitud.idContainer = "";
admSolicitud.eventRow = "";
admSolicitud.nextView = "Solicitud";
//functions
admSolicitud.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admSolicitud.init()');
    }
};

admSolicitud.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(compraSolicitud.idKeySend());';
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
admSolicitud.solicitarCompra = function () {
    compraSolicitud.create('',this.getOptions());
};