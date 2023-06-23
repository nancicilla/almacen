
var Causa = new Object();
Causa.__proto__ = SystemWindow;
//variables
Causa.nameView = "Causa";
Causa.url = "causa";

Causa.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Causa.init()');
    }
};

Causa.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Causa',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Causa',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Causa',
        WindowWidth: 290,
        WindowHeight: 295,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Causa.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Causa.afterCreate = function () {
    Causa.reload();
}

Causa.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Causa.afterUpdate = function () {
    Causa.closeWindow();
}
