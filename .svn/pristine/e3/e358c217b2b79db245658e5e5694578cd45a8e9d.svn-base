var admVentaEntregadespacho = new Object();
admVentaEntregadespacho.__proto__ = SystemSearch;

//declare var
admVentaEntregadespacho.nameView = "admVentaEntregadespacho";
admVentaEntregadespacho.url = "venta/adminVentaEntregadespacho";
admVentaEntregadespacho.idContainer = "";
//functions
admVentaEntregadespacho.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admVentaEntregadespacho.init()');
    }
}

admVentaEntregadespacho.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(VentaProceso.idKeySend());';
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

admVentaEntregadespacho.entregaEnvio= function () {        
        var data='&id='+SGridView.getSelected('iddocumento');
        var view=SGridView.getSelected('tipodocumento');
        var success=null;
        
        if(view=='VENTA')view='VentaProceso';
        else view='VentaCambio';
        var afterFunction='if(admVentaEntregadespacho.error==false)'+view+'.entregaEnvio(THIS.getOptions());';
        //afterFunction='';
        this.executeAdmin({actionController:'verificarEntregaEnvio',
                           varSend:data,
                           afterFunction:afterFunction
                      });


    return false;


};