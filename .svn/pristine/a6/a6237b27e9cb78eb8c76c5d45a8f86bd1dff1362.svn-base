var Tipodocumento = new Object();
Tipodocumento.__proto__ = SystemWindow;
//variables
Tipodocumento.nameView = "Tipodocumento";
Tipodocumento.url = "tipodocumento";

Tipodocumento.init = function() {
    try 
    {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }
    } catch (err) {
        alert('Error al cargar Tipodocumento.init()');
    }
}

Tipodocumento.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear tipo de documento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar tipo de documento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Tipodocumento',
        WindowWidth: 300,
        WindowHeight: 170,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Tipodocumento.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Tipodocumento.afterCreate = function () {
    Tipodocumento.reload();
}

Tipodocumento.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Tipodocumento.afterUpdate = function () {
    Tipodocumento.closeWindow();
}
