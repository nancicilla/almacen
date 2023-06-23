
var admCausa = new Object();
admCausa.__proto__ = SystemSearch;

//declare var
admCausa.nameView = "admCausa";
admCausa.url = "causa/admin";
admCausa.idContainer = "";
admCausa.eventRow = "THIS.update();";
admCausa.nextView = "Causa";
//functions
admCausa.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admCausa.init()');
    }
}

admCausa.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Causa.idKeySend());';
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






