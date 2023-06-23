var Orden = new Object();
Orden.__proto__ = SystemWindow;
//variables
Orden.nameView = "Orden";
Orden.url = "orden";

Orden.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Orden',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Orden',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Orden',
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

Orden.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Orden.afterCreate = function () {
    Orden.reload();
}

Orden.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Orden.afterUpdate = function () {
    Orden.closeWindow();
}
