var Comunicacion = new Object();
Comunicacion.__proto__ = SystemWindow;
//variables
Comunicacion.nameView = "Comunicacion";
Comunicacion.url = "comunicacion";

Comunicacion.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Comunicacion.init()');
    }
};

Comunicacion.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Comunicación',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Comunicación',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Comunicación',
        WindowWidth: 250,
        WindowHeight: 120,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Comunicacion.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Comunicacion.afterCreate = function () {
    Comunicacion.reload();
}

Comunicacion.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Comunicacion.afterUpdate = function () {
    Comunicacion.closeWindow();
}
