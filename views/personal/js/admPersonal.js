var admPersonal = new Object();
admPersonal.__proto__ = SystemSearch;

//declare var
admPersonal.nameView = "admPersonal";
admPersonal.url = "personal/admin";
admPersonal.idContainer = "";
admPersonal.eventRow = "THIS.update();";
admPersonal.nextView = "Personal";
//functions
admPersonal.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPersonal.init()');
    }
}

admPersonal.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Personal.idKeySend());';
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
