var admProductolote = new Object();
admProductolote.__proto__ = SystemSearch;

//declare var
admProductolote.nameView = "admProductolote";
admProductolote.url = "vencimiento/adminProductolote";
admProductolote.idContainer = "";
admProductolote.eventRow = "THIS.verVencimiento();";
admProductolote.nextView = "Vencimiento";
//functions
admProductolote.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admProductolote.init()');
    }
}

admProductolote.options = function () {
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

admProductolote.verVencimiento = function () {
    Vencimiento.verVencimiento(this.getOptions());
}