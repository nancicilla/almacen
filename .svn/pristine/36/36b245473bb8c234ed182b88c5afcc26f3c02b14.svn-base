var admTraspaso = new Object();
admTraspaso.__proto__ = SystemSearch;

//declare var
admTraspaso.nameView = "admTraspaso";
admTraspaso.url = "traspaso/admin";
admTraspaso.idContainer = "";
admTraspaso.eventRow = "THIS.view();";
admTraspaso.nextView = "VentaTraspaso";
//functions
admTraspaso.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTraspaso.init()');
    }
}

admTraspaso.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(VentaTraspaso.idKeySend());';
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
