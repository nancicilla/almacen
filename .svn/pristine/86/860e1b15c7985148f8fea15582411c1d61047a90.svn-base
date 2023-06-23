
var Unidad = new Object();
Unidad.__proto__ = SystemWindow;
//variables
Unidad.nameView = "Unidad";
Unidad.url = "unidad";

Unidad.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        } 
    } catch (err) {
        alert('Error al cargar Unidad.init()');
    }
};

Unidad.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Unidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Unidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Unidad',
        WindowWidth: 260,
        WindowHeight: 225,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Unidad.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}

Unidad.afterCreate = function () {
    Unidad.reload();
}

Unidad.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}

Unidad.afterUpdate = function () {
    Unidad.closeWindow();
}
