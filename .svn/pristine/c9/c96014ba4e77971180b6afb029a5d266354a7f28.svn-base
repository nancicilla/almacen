var admRangoalertas = new Object();
admRangoalertas.__proto__ = SystemSearch;

//declare var
admRangoalertas.nameView = "admRangoalertas";
admRangoalertas.url = "rangoalertas/admin";
admRangoalertas.idContainer = "";
admRangoalertas.eventRow = "THIS.update();";
admRangoalertas.nextView = "Rangoalertas";
//functions
admRangoalertas.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admRangoalertas.init()');
    }
}

admRangoalertas.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Rangoalertas.idKeySend());';
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
