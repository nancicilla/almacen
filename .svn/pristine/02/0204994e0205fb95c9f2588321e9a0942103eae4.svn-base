
var admChofer = new Object();
admChofer.__proto__ = SystemSearch;

//declare var
admChofer.nameView = "admChofer";
admChofer.url = "chofer/admin";
admChofer.idContainer = "";
admChofer.eventRow = "THIS.update();";
admChofer.nextView = "Chofer";
//functions
admChofer.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admChofer.init()');
    }
}

admChofer.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Chofer.idKeySend());';
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






