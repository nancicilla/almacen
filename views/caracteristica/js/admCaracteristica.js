
var admCaracteristica = new Object();
admCaracteristica.__proto__ = SystemSearch;

//declare var
admCaracteristica.nameView = "admCaracteristica";
admCaracteristica.url = "caracteristica/admin";
admCaracteristica.idContainer = "";
admCaracteristica.eventRow = "THIS.update();";
admCaracteristica.nextView = "Caracteristica";
//functions
admCaracteristica.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admCaracteristica.init()');
    }
}

admCaracteristica.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Caracteristica.idKeySend());';
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

admCaracteristica.personalizar = function () {   
    Caracteristica.personalizar(this.getOptions());
}






