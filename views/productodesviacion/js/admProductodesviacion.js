var admProductodesviacion = new Object();
admProductodesviacion.__proto__ = SystemSearch;

//declare var
admProductodesviacion.nameView = "admProductodesviacion";
admProductodesviacion.url = "productodesviacion/admin";
admProductodesviacion.idContainer = "";
admProductodesviacion.eventRow = "THIS.update();";
admProductodesviacion.nextView = "Productodesviacion";
//functions
admProductodesviacion.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admProductodesviacion.init()');
    }
}

admProductodesviacion.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Productodesviacion.idKeySend());';
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
