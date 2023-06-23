var Vencimiento = new Object();
Vencimiento.__proto__ = SystemWindow;
//variables
Vencimiento.nameView = "Vencimiento";
Vencimiento.url = "vencimiento";

Vencimiento.init = function (){
    if (this.action === 'verVencimiento') {
                this.buttonChange({id: 'save', label: 'Cerrar', key: 'C'});
            }
}
Vencimiento.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Vencimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Vencimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('editar', {  
        WindowWidth: 560,
        WindowHeight: 290,
        WindowTitle: 'Modificar Vencimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('verVencimiento', {
        layerHeight: 356,
        WindowWidth: 780,
        WindowHeight: 405,
        WindowTitle: 'Ver Vencimiento',
        initButtons: 'back,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Vencimiento',
        WindowWidth: 250,
        WindowHeight: 255,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Vencimiento.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Vencimiento.afterCreate = function () {
    Vencimiento.reload();
}

Vencimiento.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Vencimiento.afterUpdate = function () {
    Vencimiento.closeWindow();
}
Vencimiento.verVencimiento = function (id) {
    this.action = 'verVencimiento';
    this.open(this.getOptions(id));
};

Vencimiento.afterVerVencimiento = function (id) {
    Vencimiento.closeWindow();
};

Vencimiento.anular = function(options){
    var idvencimiento = SGridView.getSelected('id');
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
                    $.post("almacen/vencimiento/anularVencimiento", {idvencimiento: idvencimiento,motivo: motivo})
                            .done(function (data) {
                                var myJsonString = JSON.parse(data);
                                if (myJsonString.errorSaldo == 1) {
                                    Vencimiento.showMessageError('No Existe Lote a Anular! ');
                                } else {
                                    if (myJsonString.actualizo == 1) {
                                        Vencimiento.showMessage('Lote ANULADO correctamente !!');
                                        Vencimiento.reload();
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
};
Vencimiento.cerrar = function(options){
    var idvencimiento = SGridView.getSelected('id');
    bootbox.dialog({
        message: "<form id='info' action=''>\
    <div class='column'  style='width:100%;'> <label> Esta seguro de dar de BAJA el lote?:</label><br/>\
    </div></form>",
        buttons: {
            btn1: {
                label: 'Si',
                className: 'btn-success',
                callback: function () {
                    $.post("almacen/vencimiento/cerrarVencimiento", {idvencimiento: idvencimiento})
                            .done(function (data) {
                                var myJsonString = JSON.parse(data);
                                if (myJsonString.errorSaldo == 1) {
                                    Vencimiento.showMessageError('No Existe Lote a Cerrar! ');
                                } else {
                                    if (myJsonString.actualizo == 1) {
                                        Vencimiento.showMessage('Lote CERRADO correctamente !!');
                                        Vencimiento.reload();
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
};
Vencimiento.beforeEditar = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Vencimiento.editar = function () {
    this.action = 'editar';
    var id = SGridView.getSelected('id');
    var options = {idKey: id};
    this.open(this.getOptions(options));
}
Vencimiento.afterEditar = function () {
    var arrayParametros = {
        producto: $('#' + this.Id('idproducto')).val(),
        groupForm: this.groupForm
    };
    var url = this.urlIni + this.url + '/busquedaLotes';
    var THIS = this;
    var container = 'divLotes';
    
    SystemLoad.start();
    jQuery.ajax({
        url: url,
        type: 'get',
        data: arrayParametros,
        success: function (data) {
            SystemLoad.done();
            THIS.ById(container).innerHTML = data;
            THIS.runScriptAjax(data);
        },
        error: function (jqXHR, status) {
            SystemLoad.done();
            alert('error! ');
        }
    });
    this.closeWindow();
}