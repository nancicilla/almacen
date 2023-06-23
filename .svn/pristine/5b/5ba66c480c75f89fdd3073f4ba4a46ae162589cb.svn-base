var admTemporada = new Object();
admTemporada.__proto__ = SystemSearch;

//declare var
admTemporada.nameView = "admTemporada";
admTemporada.url = "temporada/admin";
admTemporada.idContainer = "";
admTemporada.eventRow = "THIS.update();";
admTemporada.nextView = "Temporada";
//functions
admTemporada.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTemporada.init()');
    }
}

admTemporada.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Temporada.idKeySend());';
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
