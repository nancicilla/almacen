var Rangoalertas = new Object();
Rangoalertas.__proto__ = SystemWindow;
//variables
Rangoalertas.nameView = "Rangoalertas";
Rangoalertas.url = "rangoalertas";

Rangoalertas.init = function(){
    if(this.action==='create'){
        
    }
}
Rangoalertas.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Rangoalertas',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Rangoalertas',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Rangoalertas',
        WindowWidth: 545,
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

Rangoalertas.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Rangoalertas.afterCreate = function () {
    Rangoalertas.reload();
}

Rangoalertas.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Rangoalertas.afterUpdate = function () {
    Rangoalertas.closeWindow();
}
