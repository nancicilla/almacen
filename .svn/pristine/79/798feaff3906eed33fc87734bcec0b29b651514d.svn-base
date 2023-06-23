var admDevoluciontpv = new Object();
admDevoluciontpv.__proto__ = SystemSearch;

//declare var
admDevoluciontpv.nameView = "admDevoluciontpv";
admDevoluciontpv.url = "devoluciontpv/admin";
admDevoluciontpv.idContainer = "";
admDevoluciontpv.eventRow = "THIS.update();";
admDevoluciontpv.nextView = "Devoluciontpv";
//functions
admDevoluciontpv.init = function () {
    try {
        var THIS=this;
        $('#'+this.Id('producto')).keyup(function(e){
                var k = (document.all) ? e.keyCode : e.which;
                if(k!=37 && k!=38  && k!=39  && k!=40  && k!=13  && k!=9) {
                    THIS.set('idproducto','');
                    THIS.ById('producto').style.background="";
                }
            });            
        $('#'+this.Id('producto')).blur(function(){
                    if(THIS.get('idproducto')==''){
                        this.value='';
                        THIS.ById('producto').style.background="";
                        THIS.search();

                    }
                });
    } catch (err) {
        alert('Error al cargar admDevoluciontpv.init()');
    }
};

admDevoluciontpv.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Devoluciontpv.idKeySend());';
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
admDevoluciontpv.aceptarDevolucion = function () {
    jQuery.ajax({
        type: "GET",
        url: "tpv/devolucion/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.recepcion.estado)) {
                var id = SGridView.getSelected('id');
                Devoluciontpv.aceptarDevolucion(id);
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Devolución está en finalizada, no se puede anular esta devolución.");
                return;
            }
            if (data.devolucion.estado) {
                bootbox.alert("Devolucion no Recepcionada, no se puede realizar la operación.");
                return;
            }
            if (!data.recepcion.estado) {
                bootbox.alert("Devolucion no Confirmada, no se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admDevoluciontpv.recepcionDevolucion = function () {
    jQuery.ajax({
        type: "GET",
        url: "tpv/devolucion/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.devolucion.estado)) {
                var id = SGridView.getSelected('id');
                Devoluciontpv.recepcionDevolucion(id);
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Devolución está en finalizada, no se puede recepcionar esta devolución.");
                return;
            }
            if (data.recepcion.estado) {
                bootbox.alert("Devolucion recepcionada, no se puede realizar la operación.");
                return;
            }
            if (!data.devolucion.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};