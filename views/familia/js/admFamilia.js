
var admFamilia = new Object();
admFamilia.__proto__ = SystemSearch;

//declare var
admFamilia.nameView = "admFamilia";
admFamilia.url = "familia/admin";
admFamilia.idContainer = "";
admFamilia.eventRow = "THIS.update();";
admFamilia.nextView = "Familia";
//functions
admFamilia.init = function () {
    try {

    } catch (err) {
        alert('Error al cargar admFamilia.init()');
    }
}

admFamilia.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Familia.idKeySend());';
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






