
var Chofer = new Object();
Chofer.__proto__ = SystemWindow;
//variables
Chofer.nameView = "Chofer";
Chofer.url = "chofer";

Chofer.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Chofer.init()');
    }
};

Chofer.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Chofer',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Chofer',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Chofer',
        WindowWidth: 250,
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

Chofer.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Chofer.afterCreate = function () {
    Chofer.reload();
}

Chofer.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Chofer.afterUpdate = function () {
    Chofer.closeWindow();
}