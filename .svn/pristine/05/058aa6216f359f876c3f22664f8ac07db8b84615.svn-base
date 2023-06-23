var Clase = new Object();
Clase.__proto__ = SystemWindow;
//variables
Clase.nameView = "Clase";
Clase.url = "clase";

Clase.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Clase.init()');
    }
};

Clase.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Clase',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Clase',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Clase',
        WindowWidth: 250,
        WindowHeight: 203,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Clase.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}

Clase.afterCreate = function () {
    Clase.reload();
}

Clase.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}

Clase.afterUpdate = function () {
    Clase.closeWindow();
}
