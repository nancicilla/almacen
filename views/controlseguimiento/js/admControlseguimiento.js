var admControlseguimiento = new Object();
admControlseguimiento.__proto__ = SystemSearch;

//declare var
admControlseguimiento.nameView = "admControlseguimiento";
admControlseguimiento.url = "controlseguimiento/admin";
admControlseguimiento.idContainer = "";
admControlseguimiento.eventRow = "THIS.update();";
admControlseguimiento.nextView = "Seguimiento";
//functions
admControlseguimiento.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admControlseguimiento.init()');
    }


};

admControlseguimiento.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Controlseguimiento.idKeySend());';
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