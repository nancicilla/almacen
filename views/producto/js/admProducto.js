
var admProducto = new Object();
admProducto.__proto__ = SystemSearch;

//declare var
admProducto.nameView = "admProducto";
admProducto.url = "producto/admin";
admProducto.idContainer = "";
admProducto.eventRow = "THIS.update();";
admProducto.nextView = "Producto";
//functions
admProducto.init = function (e) {
    $('#'+this.Id('nombreClase')).keypress(function (e){
        var key = e.keyCode || e.charCode;
        if( key === 8 || key === 46)
            admProducto.search();
    });
    $('#'+this.Id('nombreFamilia')).keypress(function (e){
        var key = e.keyCode || e.charCode;
        if( key === 8 || key === 46)
            admProducto.search();
    });
    try {         
    } catch (err) {
        alert('Error al cargar admProducto.init()');
    }
}

admProducto.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Producto.idKeySend());';
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

};


    /**
     * Antes de eliminar invoca ala accion elimin
     * @param {type} showConfirm
     */
    admProducto.eliminar = function () {           
       
        this.executeAdmin({actionController:'eliminar',
                           varSend:''
                          });
        
    };





