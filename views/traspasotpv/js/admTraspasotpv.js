var admTraspasotpv = new Object();
admTraspasotpv.__proto__ = SystemSearch;

//declare var
admTraspasotpv.nameView = "admTraspasotpv";
admTraspasotpv.url = "traspasotpv/admin";
admTraspasotpv.idContainer = "";
admTraspasotpv.eventRow = "THIS.view();";
admTraspasotpv.nextView = "Traspasotpv";
//functions
admTraspasotpv.init = function () {
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
        alert('Error al cargar admTraspasotpv.init()');
    }
};

admTraspasotpv.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Traspasotpv.idKeySend());';
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
admTraspasotpv.confirmarSolicitud = function () {

   jQuery.ajax({
       type: "GET",
       url: "almacen/traspasotpv/VerificaEstadosTraspaso?id="+SGridView.getSelected('id'),  
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       success: function (data, status, jqXHR) {  
        
            if(!data.finalizado.estado && (data.reserva.estado)){
              var id=SGridView.getSelected('id');
              Traspasotpv.registrarConfirmacion(id);
              return;
            }
            if(data.finalizado.estado) {
                bootbox.alert("La Solicitud está finalizada, no se puede confirmar esta Solicitud.");
            return;}
            if(data.solicitud.estado) {
                bootbox.alert("La Solicitud no está RESERVADA, no se puede confirmar esta Solicitud.");
            return;}
            if(!data.traspaso.estado || !data.borrador.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
            },

            error: function (jqXHR, status) {           
              // error handler
          }

      });

};
admTraspasotpv.recepcionSolicitud = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/traspasotpv/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.solicitud.estado)) {
                var id = SGridView.getSelected('id');
                Traspasotpv.recepcionSolicitud(id);
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Solicitud está finalizada, no se puede confirmar esta Solicitud.");
                return;
            }
            if (data.reserva.estado) {
                bootbox.alert("La Solicitud está RESERVADA, no se puede realizar la operación.");
                return;
            }
            if(!data.traspaso.estado || !data.borrador.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admTraspasotpv.quitarReserva = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/traspasotpv/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.reserva.estado)) {
                var id = SGridView.getSelected('id');
                Traspasotpv.quitarReserva(id);
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Solicitud está finalizada, no se puede confirmar esta Solicitud.");
                return;
            }
            if (data.solicitud.estado) {
                bootbox.alert("La Solicitud no está RESERVADA, no se puede realizar la operación.");
                return;
            }
            if(!data.traspaso.estado || !data.borrador.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admTraspasotpv.editarSolicitud = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/traspasotpv/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.reserva.estado)) {
                var id = SGridView.getSelected('id');
                Traspasotpv.modificarSolicitud(id);
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Solicitud está finalizada, no se puede Modificar esta Solicitud.");
                return;
            }
            if (data.solicitud.estado) {
                bootbox.alert("La Solicitud no está Recepcionada, no se puede realizar la operación.");
                return;
            }
            if(!data.traspaso.estado || !data.borrador.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admTraspasotpv.anularSolicitud = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/traspasotpv/VerificaEstadosTraspaso?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizado.estado && (data.solicitud.estado)) {
                var idtraspaso = SGridView.getSelected('id');
                bootbox.dialog({
                    message: "<form id='info' action=''>\
                <div class='column'  style='width:100%;'> <label> Motivo Anulación:</label><textarea autofocus id='motivoAnulacion' name='descripcion' style='width:98%;text-transform: uppercase;'/><br/>\
                </div></form>",
                    buttons: {
                        btn1: {
                            label: 'Si',
                            className: 'btn-success',
                            callback: function () {
                                motivo = $("#motivoAnulacion").val();
                                $.post("almacen/traspasotpv/AnularSolicitud", {idtraspaso: idtraspaso,motivo: motivo})
                                        .done(function (dato) {
                                            var myJsonString = JSON.parse(dato);
                                            if (myJsonString.errorSaldo == 1) {
                                                Traspasotpv.showMessageError('No Existe Traspaso a Anular! ');
                                            } else {
                                                if (myJsonString.actualizo == 1) {
                                                    admTraspasotpv.showMessage('Traspaso ANULADO correctamente !!');
                                                    admTraspasotpv.search();
                                                }
                                            }
                                        });
                            }
                        },
                        btn2: {
                            label: 'Cancelar',
                            className: 'btn-warning',
                            callback: function () {
                            }
                        }
                    }});
                return;
            }
            if (data.finalizado.estado) {
                bootbox.alert("La Solicitud está Finalizada, no se puede anular esta Solicitud.");
                return;
            }
            if (data.reserva.estado) {
                bootbox.alert("La Solicitud está en Reserva, no se puede anular esta Solicitud.");
                return;
            }
            if (data.borrador.estado) {
                bootbox.alert("La Solicitud está en Borrador, no se puede anular esta Solicitud.");
                return;
            }
            if (!data.solicitud.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};