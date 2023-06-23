/* global SGridView, SystemSearch, bootbox */

var admControlcalidadalmacen = new Object();
admControlcalidadalmacen.__proto__ = SystemSearch;

//declare var
admControlcalidadalmacen.nameView = "admControlcalidadalmacen";
admControlcalidadalmacen.url = "controlcalidadalmacen/admin";
admControlcalidadalmacen.idContainer = "";
admControlcalidadalmacen.eventRow = "THIS.modificarCC();";
admControlcalidadalmacen.nextView = "Controlcalidadalmacen";
//functions
admControlcalidadalmacen.init = function () {
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
        alert('Error al cargar admControlcalidadalmacen.init()');
    }
};

admControlcalidadalmacen.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Controlcalidadalmacen.idKeySend());';
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

admControlcalidadalmacen.recepcionCC = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaRecepcionCC?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.recepcion.estado && (data.pendiente.estado || data.espera.estado) && (!data.pendiente.finalizado || !data.espera.finalizado) && (!data.espera.sinverificar) && !data.espera.correccion) {
                var id = SGridView.getSelected('id');
                Controlcalidadalmacen.recepcion(id);
                return;
            }
            if (data.recepcion.estado && data.recepcion.finalizado) {
                bootbox.alert("El control de calidad esta RECEPCIONADO, no se puede Recepcionar para Control de Calidad.");
                return;
            }
            if (data.espera.sinverificar) {
                bootbox.alert("El control de calidad NO esta VERIFICADO, no se puede Recepcionar para Control de Calidad.");
                return;
            }
            if (data.espera.correccion) {
                bootbox.alert("El control de calidad esta en CORRECCION, no se puede Recepcionar para Control de Calidad.");
                return;
            }
            if (!data.espera.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admControlcalidadalmacen.modificarCC = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaEstadoCC?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizadoCC.estado && (data.pendienteCC.estado) && (data.pendienteCC.recepcion) || data.enprocesoCC.estado) {
                var id = SGridView.getSelected('id');
                Controlcalidadalmacen.update(id);
                return;
            }
            if (data.finalizadoCC.estado) {
                bootbox.alert("El control de calidad esta Finalizado, no se puede Modificar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.recepcion){
                bootbox.alert("El control de calidad NO esta RECEPCIONADO, no se puede Actualizar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};

admControlcalidadalmacen.bajaCC = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaBajaCC?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizadoCC.estado && (data.espera.estado) && (data.espera.pendiente)) {
                var id = SGridView.getSelected('id');
                Controlcalidadalmacen.update(id);
                return;
            }
            if (data.finalizadoCC.estado) {
//                bootbox.alert("El control de calidad esta FINALIZADO, no se puede Finalizar Control de Calidad.");
                admControlcalidadalmacen.showMessageError('El control de calidad esta FINALIZADO, no se puede Finalizar Control de Calidad.');
                return;
            }
            if (!data.pendienteCC.pendiente){
                bootbox.alert("El control de calidad esta RECEPCIONADO, no puede darse de Baja los productos.");
                return;
            }
            if (!data.pendienteCC.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admControlcalidadalmacen.finalizarCC = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaEstadoCC?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizadoCC.estado && (data.enprocesoCC.estado) && (data.enprocesoCC.recepcion)) {
                var id = SGridView.getSelected('id');
                Controlcalidadalmacen.finalizar(id);
                return;
            }
            if (data.finalizadoCC.estado) {
                bootbox.alert("El control de calidad esta Finalizado, no se puede finalizar para Control de Calidad.");
                return;
            }
            if (data.pendienteCC.estado){
                bootbox.alert("El control de calidad NO esta en PROCESO, no se puede FINALIZAR para Control de Calidad.");
                return;
            }
            if (data.correccion.estado){
                bootbox.alert("El control de calidad esta en CORRECCION, no se puede Verificar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.recepcion){
                bootbox.alert("El control de calidad NO esta RECEPCIONADO, no se puede Finalizar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
admControlcalidadalmacen.verificar = function () {
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaEstadoCC?id=" + SGridView.getSelected('id'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.finalizadoCC.estado && (data.sinverificarCC.estado) && (!data.correccion.estado)) {
                var id = SGridView.getSelected('id');
                Controlcalidadalmacen.verificar(id);
                return;
            }
            if (data.finalizadoCC.estado) {
                bootbox.alert("El control de calidad esta Finalizado, no se puede Verificar para Control de Calidad.");
                return;
            }
            if (data.correccion.estado){
                bootbox.alert("El control de calidad esta en CORRECCION, no se puede Verificar para Control de Calidad.");
                return;
            }
            if (data.pendienteCC.estado){
                bootbox.alert("El control de calidad esta PENDIENTE, no se puede Verificar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.recepcion){
                bootbox.alert("El control de calidad NO esta RECEPCIONADO, no se puede Verificar para Control de Calidad.");
                return;
            }
            if (!data.pendienteCC.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};