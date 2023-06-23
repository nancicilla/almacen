var admPedidoespecial = new Object();
admPedidoespecial.__proto__ = SystemSearch;

//declare var
admPedidoespecial.nameView = "admPedidoespecial";
admPedidoespecial.url = "pedidoespecial/admin";
admPedidoespecial.eventRow = "THIS.confirmarAlmacen()";
admPedidoespecial.idContainer = "";
//functions
admPedidoespecial.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPedidoespecial.init()');
    }
}

admPedidoespecial.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(VentaPedido.idKeySend());';
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

admPedidoespecial.setAlerta=function(){ 
    
    var grid=this.getSGridView('admPedidoespecial');  
    for(var f=1;f<=grid.rows;f++){        
        var dias=grid.row(f).get('dias');
        if(dias=='ENTREGADO'){
            grid.row(f).attributes('dias',{'style':{'color':'#006c05','font-weight':'bold'}});
            grid.row(f).attributes('fechaentrega',{'style':{'color':'#006c05','font-weight':'bold'}});
            continue;
        }
        
        var alerta='alerta';
        if(dias!=''){
            dias*=1;
            if(dias<0){
                alerta+='MasAlta';
                grid.row(f).set('dias',''+(dias*-1)+' (<span style="font-weight:bold; font-size:11px;">DEMORADO</span>)');
                grid.row(f).attributes('dias',{'style':{'color':'#ff0000'}});
                grid.row(f).attributes('fechaentrega',{'style':{'color':'#ff0000','font-weight':'bold'}});
            }
            else{
                if(dias<=5) alerta+='Alta';
                else{
                    if(dias<=10) alerta+='Media';
                    else{
                        if(dias<=15) alerta+='Baja'; 
                    }
                }
            }
        }else alerta+='MasAlta';
        
        grid.row(f).set('alerta','<div class="'+alerta+'"></div>');
    }
 
    
    
}

admPedidoespecial.print=function(){
    var url = 'venta/pedido/reportePedido?id=' + SGridView.getSelected('id');
    this.openUrl(url);
}

admPedidoespecial.transpasoPedidoEspecial = function () {
    var THIS = this;
    VentaPedido.generarTraspasoProducto(THIS.getOptions());
}