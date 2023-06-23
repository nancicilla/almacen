var Vistaordenpedido = new Object();
Vistaordenpedido.__proto__ = SystemWindow;
//variables
Vistaordenpedido.nameView = "Vistaordenpedido";
Vistaordenpedido.url = "vistaordenpedido";

Vistaordenpedido.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Vistaordenpedido',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Vistaordenpedido',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Vistaordenpedido',
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

Vistaordenpedido.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Vistaordenpedido.afterCreate = function () {
    Vistaordenpedido.reload();
}

Vistaordenpedido.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Vistaordenpedido.afterUpdate = function () {
    Vistaordenpedido.closeWindow();
}
