var Proveedor = new Object();
Proveedor.__proto__ = SystemWindow;
//variables
Proveedor.nameView = "Proveedor";
Proveedor.url = "proveedor";

Proveedor.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Proveedor',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Proveedor',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Proveedor',
        WindowWidth: 250,
        WindowHeight: 400,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Proveedor.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Proveedor.afterCreate = function () {
    Proveedor.reload();
}

Proveedor.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Proveedor.afterUpdate = function () {
    Proveedor.closeWindow();
}
