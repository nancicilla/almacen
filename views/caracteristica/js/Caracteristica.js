
var Caracteristica = new Object();
Caracteristica.__proto__ = SystemWindow;
//variables
Caracteristica.nameView = "Caracteristica";
Caracteristica.url = "caracteristica";
Caracteristica.caract = [];

Caracteristica.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
        if (this.action === 'personalizar') {
            this.buttonChange({id: 'save', label: 'Salir', key: 'G'});
        }
    } catch (err) {
        alert('Error al cargar Caracteristica.init()');
    }
};

Caracteristica.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Característica',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Característica',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('personalizar', {
             layerHeight: 356,
             WindowWidth: 401,
             WindowHeight: 515,
             WindowTitle: 'Personalizar orden de características',
             initButtons: 'back',
             layerEndOn: false,
             ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Característica',
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

Caracteristica.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Caracteristica.afterCreate = function () {
    var idgenero=this.get('idgenero');
    Caracteristica.reload('idgenero='+idgenero);
}

Caracteristica.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}

Caracteristica.afterUpdate = function() {
    Caracteristica.closeWindow();
}

Caracteristica.personalizar = function(options){
    this.action='personalizar';
    this.open(this.getOptions(options));       
}