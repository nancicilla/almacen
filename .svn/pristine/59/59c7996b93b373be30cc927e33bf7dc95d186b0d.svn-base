var admVistanotarecepcion = new Object();
admVistanotarecepcion.__proto__ = SystemSearch;

//declare var
admVistanotarecepcion.nameView = "admVistanotarecepcion";
admVistanotarecepcion.url = "vistanotarecepcion/admin";
admVistanotarecepcion.idContainer = "";
admVistanotarecepcion.nextView = "Vistanotarecepcion";
//functions
admVistanotarecepcion.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admVistanotarecepcion.init()');
    }
}

admVistanotarecepcion.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(VentaNotarecepcion.idKeySend());';
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
 admVistanotarecepcion.controlAlmacen = function () { 
    VentaNotarecepcion.controlAlmacen(this.getOptions());
};

admVistanotarecepcion.registrarseguimiento = function () {
    Controlseguimiento.registrarseguimientonr(this.getOptions());
};
