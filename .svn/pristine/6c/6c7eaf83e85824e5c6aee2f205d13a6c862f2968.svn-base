var Alerta = new Object();
Alerta.__proto__ = SystemWindow;
//variables
Alerta.nameView = "Alerta";
Alerta.url = "alerta";

Alerta.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Alerta',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('view', {        
        WindowTitle: 'Ver Alerta',
        initButtons: 'back',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Alerta',
        WindowWidth: 450,
        WindowHeight: 450,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Alerta.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Alerta.afterCreate = function () {
    Alerta.reload();
}

Alerta.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Alerta.afterUpdate = function () {
    Alerta.closeWindow();
}
