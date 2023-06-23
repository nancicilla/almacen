var Controlseguimiento = new Object();
Controlseguimiento.__proto__ = SystemWindow;
//ACCIONES DE FORMULARIO [this.action=create/update/delete/show/annul]
//variables
Controlseguimiento.nameView = "Controlseguimiento";
Controlseguimiento.url = "controlseguimiento";

Controlseguimiento.init = function () {
    try {
        if (this.action === 'update') {
            this.buttonChange({id:'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id:'save', label: 'Registrar', key: 'R'});
        }      
    } catch (err) {
        alert('Error al cargar Controlseguimiento.init()');
    }
};

Controlseguimiento.options = function () {
    this.setActions('create', {layerHeight: 356,
        WindowTitle: 'Crear Seguimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {layerHeight: 356,
        WindowTitle: 'Modificar Seguimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('registrarseguimientonota', {layerHeight: 356,
        WindowTitle: 'Registrar Seguimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    }); 
    this.setActions('registrarseguimientonr', {layerHeight: 356,
        WindowTitle: 'Registrar Seguimiento',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    }); 
    this.setActions('delete', {layerHeight: 356,
        WindowTitle: 'Eliminar Seguimiento',
        initButtons: 'delete,back',
        endButtons: 'back',
        ableBackWindow: true
    });
    var options = {WindowName: this.nameView,
        WindowTitle: 'Seguimiento',
        WindowWidth: 640,
        WindowHeight: 350,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;

};

Controlseguimiento.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    //escribir codigo antes de crear formulario , mensajes de error.....

    return error;
};
Controlseguimiento.afterCreate = function () {
    Controlseguimiento.reload();
    this.print();
};

Controlseguimiento.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    //escribir codigo antes de actualizar formulario  , mensajes de error.....

    return error;
}
Controlseguimiento.afterUpdate = function () {
    Controlseguimiento.closeWindow();
    this.print();
};

Controlseguimiento.beforeDelete = function () {
    var error = false;//false es no existe error antes de eliminar formulario
    //escribir codigo antes de Eliminar formulario  , mensajes de error.....

    return error;
};

Controlseguimiento.registrarseguimientonota = function (options) {
    this.action = 'registrarseguimientonota';
    var WindowName = '';
    var WindowTitle = '';
    var updateFunction = '';
    var idKey = (options['idKey'] != null) ? options['idKey'] : '';

    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;

    options.url = this.url + '/registrarseguimientonota';
    options.varSend = 'idNota=' + idKey;
    options.idKey = '';
    options.ableBackWindow = (this.layer[this.action]['ableBackWindow'] != null && this.layer[this.action]['ableBackWindow']) ? true : false;
    options.updateFunction = updateFunction;
    options.WindowWidth = 260;
    options.WindowHeight = 225;
    this.open(options);
};

Controlseguimiento.afterRegistrarseguimientonota = function () {
    this.closeWindow();
    admNota.showMessage("Se registro exitosamente");
};

Controlseguimiento.registrarseguimientonr = function (options) {
    this.action = 'registrarseguimientonr';
    var WindowName = '';
    var WindowTitle = '';
    var updateFunction = '';
    var idKey = (options['idKey'] != null) ? options['idKey'] : '';

    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;

    options.url = this.url + '/registrarseguimientonr';
    options.varSend = 'idNotarecepcion=' + idKey;
    options.idKey = '';
    options.ableBackWindow = (this.layer[this.action]['ableBackWindow'] != null && this.layer[this.action]['ableBackWindow']) ? true : false;
    options.updateFunction = updateFunction;
    options.WindowWidth = 260;
    options.WindowHeight = 225;
    this.open(options);
};

Controlseguimiento.afterRegistrarseguimientonr = function () {
    this.closeWindow();
    admVistanotarecepcion.showMessage("Se registro exitosamente");
};
