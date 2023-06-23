
var Familia = new Object();
Familia.__proto__ = SystemWindow;
//variables
Familia.nameView = "Familia";
Familia.url = "familia";

Familia.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Familia.init()');
    }
};

Familia.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Familia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Familia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Familia',
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

Familia.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Familia.afterCreate = function () {
        Familia.reload();
}

Familia.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}

Familia.afterUpdate = function () {
    Familia.closeWindow();
}
