var admAsignacionCostos = new Object();
admAsignacionCostos.__proto__ = SystemSearch;

//declare var
admAsignacionCostos.nameView = "admAsignacionCostos";
admAsignacionCostos.url = "producto/asignacionCosto";
admAsignacionCostos.model="Producto";
admAsignacionCostos.idContainer = "";

//functions
admAsignacionCostos.init = function () {
    try {
    } catch (err) {
        alert('Error al cargar admAsignacionCostos.init()');
    }
};

admAsignacionCostos.options = function () {
    var afterFunction = '';
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        varsSend: varsSend
    };

    return options;

};

admAsignacionCostos.cambiarCostos = function () {
    var grid = this.getSGridView('admAsignacionCostos');
    var filaseleccionada = grid.rowSelected();
    var id = filaseleccionada.get('id');
    var ultimoppp = filaseleccionada.get('ultimoppp');
    var ultimopppcopia = filaseleccionada.get('ultimopppcopia');
    var url = this.urlIni+'producto/actualizarCosto';
    var varSend = 'id='+id+'&ultimoppp='+ultimoppp;
    if (ultimoppp == ultimopppcopia)
        return;
    SystemLoad.start();
    $.ajax({
        url: url,
        type: 'post',
        data: varSend,
        success: function (data) {
            SystemLoad.done();
            filaseleccionada.set('ultimopppcopia',ultimoppp);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            SystemLoad.done();
            alert('Error al guardar');
        }
    });
};