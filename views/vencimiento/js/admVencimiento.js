var admVencimiento = new Object();
admVencimiento.__proto__ = SystemSearch;

//declare var
admVencimiento.nameView = "admVencimiento";
admVencimiento.url = "vencimiento/admin";
admVencimiento.idContainer = "";
//admVencimiento.eventRow = "THIS.update();";
admVencimiento.nextView = "Vencimiento";
//functions
admVencimiento.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admVencimiento.init()');
    }
}

admVencimiento.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Vencimiento.idKeySend());';
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
