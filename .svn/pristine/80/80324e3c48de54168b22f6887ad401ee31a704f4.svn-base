var admAsignacionsaldosimp = new Object();
admAsignacionsaldosimp.__proto__ = SystemSearch;

//declare var
admAsignacionsaldosimp.nameView = "admAsignacionsaldosimp";
admAsignacionsaldosimp.url = "producto/asignacionSaldoImporte";
admAsignacionsaldosimp.model="Producto";
admAsignacionsaldosimp.idContainer = "";

//functions
admAsignacionsaldosimp.init = function () {
    try {
    } catch (err) {
        alert('Error al cargar admAsignacionsaldosimp.init()');
    }
};

admAsignacionsaldosimp.options = function () {
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

admAsignacionsaldosimp.cambiarSaldos = function () {
    var grid = this.getSGridView('admAsignacionsaldosimp');
    var filaseleccionada = grid.rowSelected();
    var id = filaseleccionada.get('id');
    var saldo = filaseleccionada.get('saldo');
    var saldoimporte = filaseleccionada.get('saldoimporte');
    var saldocopia = filaseleccionada.get('saldocopia');
    var saldoimportecopia = filaseleccionada.get('saldoimportecopia');
    var url = this.urlIni+'producto/actualizarSaldoImporte';
    var varSend = 'id='+id+'&saldo='+saldo+'&saldoimporte='+saldoimporte;
    show('saldo='+saldo+'<br>saldocopia='+saldocopia+'<br>saldoimporte='+saldoimporte+'<br>saldoimportecopia='+saldoimportecopia);
    if (saldo == saldocopia && saldoimporte == saldoimportecopia)
        return;
    SystemLoad.start();
    $.ajax({
        url: url,
        type: 'post',
        data: varSend,
        success: function (data) {
            SystemLoad.done();
            filaseleccionada.set('saldocopia',saldo);
            filaseleccionada.set('saldoimportecopia',saldoimporte);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            SystemLoad.done();
            alert('Error al guardar');
        }
    });
};