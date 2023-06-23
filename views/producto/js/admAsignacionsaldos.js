var admAsignacionsaldos = new Object();
admAsignacionsaldos.__proto__ = SystemSearch;

//declare var
admAsignacionsaldos.nameView = "admAsignacionsaldos";
admAsignacionsaldos.url = "producto/asignacionSaldos";
admAsignacionsaldos.model="Producto";
admAsignacionsaldos.idContainer = "";

//functions
admAsignacionsaldos.init = function () {
    try {
    } catch (err) {
        alert('Error al cargar admAsignacionsaldos.init()');
    }
};

admAsignacionsaldos.options = function () {
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

admAsignacionsaldos.cambiarSaldos = function () {    
    var grid = this.getSGridView('admAsignacionsaldos');
    var id = grid.rowSelected().get('id');
    var minimo = grid.rowSelected().get('stockminimo');  
    var maximo = grid.rowSelected().get('stockmaximo');
    var pedido = grid.rowSelected().get('puntopedido');
    var saldo = grid.rowSelected().get('saldo');

    var url = 'producto/actualizarSaldos';
    var varSend = 'id='+id+'&stockminimo='+minimo+'&stockmaximo='+maximo+'&puntopedido='+pedido;
    this.process({idContainer:'divAnswer',
        url: url,
        varSend: varSend,
        type: 'post'
    });  
    var puntopedido=minimo==0?'':parseFloat((saldo/minimo)).toFixed(2);
    
    if(puntopedido<=4){
        puntopedido="<div class=\'duracionAlerta\'>"+puntopedido+"</div>";
        //grid.rowSelected().set('puntopedido',puntopedido);        
    }
    grid.rowSelected().set('puntopedido',puntopedido);
};