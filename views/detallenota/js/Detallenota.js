var Detallenota = new Object();
Detallenota.__proto__ = SystemWindow;
//variables
Detallenota.nameView = "Detallenota";
Detallenota.url = "detallenota";

Detallenota.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Detalle de Nota',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Detalle de Nota',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Detalle de Nota',
        WindowWidth: 430,
        WindowHeight: 150,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Detallenota.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Detallenota.afterCreate = function () {
    Detallenota.reload();
}

Detallenota.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Detallenota.afterUpdate = function () {
    Detallenota.closeWindow();
}
