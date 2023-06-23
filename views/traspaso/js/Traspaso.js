var Traspaso = new Object();
Traspaso.__proto__ = SystemWindow;
//variables
Traspaso.nameView = "Traspaso";
Traspaso.url = "traspaso";

Traspaso.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Traspaso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Traspaso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Traspaso',
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

Traspaso.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Traspaso.afterCreate = function () {
    Traspaso.reload();
}

Traspaso.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Traspaso.afterUpdate = function () {
    Traspaso.closeWindow();
}
