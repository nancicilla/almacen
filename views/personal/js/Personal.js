var Personal = new Object();
Personal.__proto__ = SystemWindow;
//variables
Personal.nameView = "Personal";
Personal.url = "personal";

Personal.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Personal',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Personal',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Personal',
        WindowWidth: 250,
        WindowHeight: 300,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Personal.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Personal.afterCreate = function () {
    Personal.reload();
}

Personal.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Personal.afterUpdate = function () {
    Personal.closeWindow();
}
