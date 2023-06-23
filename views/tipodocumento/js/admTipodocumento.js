var admTipodocumento = new Object();
admTipodocumento.__proto__ = SystemSearch;

//declare var
admTipodocumento.nameView = "admTipodocumento";
admTipodocumento.url = "tipodocumento/admin";
admTipodocumento.idContainer = "";
admTipodocumento.eventRow = "THIS.update();";
admTipodocumento.nextView = "Tipodocumento";
//functions
admTipodocumento.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTipodocumento.init()');
    }
}

admTipodocumento.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tipodocumento.idKeySend());';
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
