
var Almacen = new Object();
Almacen.__proto__ = SystemWindow;
//variables
Almacen.nameView = "Almacen";
Almacen.url = "almacen";
Almacen.productoSeleccionado = false;


Almacen.init = function () {
    try {
        if (this.action === 'update') {re
            this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'create') {
            this.buttonChange({id: 'save', label: 'Registrar', key: 'R'});
        }
        if (this.action === 'generarResumenMayor') {
            this.showWarning = false;

            this.buttonChange({id: 'print', onclick: 'Almacen.printResumen()'});
        }
        if (this.action === 'generarLibroMayor') {
            this.showWarning = false;
        }
        if (this.action === 'update') {
            this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
        }
        if (this.action === 'generarResumenCompras') {
            this.showWarning = false;
            this.buttonChange({id: 'print', onclick: 'Almacen.printResumenCompras()'});
        }
        if (this.action === 'generarComprobanteContable') {
            this.showWarning = false;
            this.buttonChange({id: 'print', onclick: 'Almacen.printComprobanteContable()'});
            $('#' + Almacen.Id('detalle')).change(function () {                                  
                if (this.checked) {
                    $('#' + Almacen.Id('cuenta')).prop('disabled', false);
                }
                else
                {
                    $('#' + Almacen.Id('cuenta')).prop('disabled', true);
                    $('#' + Almacen.Id('cuenta')).val("");
                    $('#' + Almacen.Id('idcuenta')).val("");
                }
            });
        }
        if (this.action === 'generarSalidasAlmacen') {
            this.showWarning = false;
            this.buttonChange({id: 'print', onclick: 'Almacen.printSalidasAlmacen()'});
        }
        $("select").change(function () {
            $('#' + Almacen.Id("idproducto")).val("");
            $('#' + Almacen.Id("nombreProducto")).val("");
        });

        $('#' + Almacen.Id("nombreProducto")).unbind("keyup");
        $('#' + Almacen.Id("nombreProducto")).keyup(function (e) {
            if (Almacen.productoSeleccionado) {
                //verifica que exista un producto seleccionado a partir del autocomplete
                //en el textfield nombreProducto, de no ser asi, setea el id por defecto
                //-1 para que no muestre nada en el SGridView
                var nombreAutocomplete = $('#' + Almacen.Id("nombreProducto")).val();
                var nombreCorrecto = $('#' + Almacen.Id("Productonota_nombreCompletoProducto")).val();
                if (nombreAutocomplete.trim() === "") {
                    $('#' + Almacen.Id("idproducto")).val("");
                    Almacen.productoSeleccionado = false;
                }
                else if ((nombreAutocomplete !== nombreCorrecto)) {
                    $('#' + Almacen.Id("idproducto")).val("-1");
                    Almacen.productoSeleccionado = false;
                }
            }
        });
    } catch (err) {
        alert('Error al cargar Almacen.init()');
    }
};

Almacen.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Almacén',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Almacén',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('generarLibroMayor', {
        WindowTitle: 'Generar Libro Mayor',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('generarResumenMayor', {
        WindowTitle: 'Generar Resumen Mayor',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('generarResumenCompras', {
        WindowTitle: 'Generar Resumen Compras',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('generarComprobanteContable', {
        WindowTitle: 'Generar Reporte Movimientos Almacén',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('generarSalidasAlmacen', {
        WindowTitle: 'Salidas de Almacen',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('formDiferenciasAlmacen', {
        WindowTitle: 'Diferencias de Almacen',
        initButtons: 'generar',
        endButtons: 'generar',
        WindowWidth: 300,
        WindowHeight: 150,
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Almacén',
        WindowWidth: 250,
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

Almacen.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Almacen.afterCreate = function () {
    Almacen.reload();
}

Almacen.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Almacen.afterUpdate = function () {
    Almacen.closeWindow();
}

Almacen.generarLibroMayor = function (options) {
    this.action = 'generarLibroMayor';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 245,
    options['WindowHeight'] = 270,
    options.url = this.url + '/generarLibroMayor';
    this.open(options);

}

Almacen.generarResumenMayor = function (options) {
    this.action = 'generarResumenMayor';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 275,
            options['WindowHeight'] = 170,
            options.url = this.url + '/generarResumenMayor';
    this.open(options);

}


Almacen.generarResumenCompras = function (options) {
    this.action = 'generarResumenCompras';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 275,
    options['WindowHeight'] = 220,
    options.url = this.url + '/generarResumenCompras';
    this.open(options);

}

Almacen.generarComprobanteContable = function (options) {
    this.action = 'generarComprobanteContable';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 275,
    options['WindowHeight'] = 350,
    options.url = this.url + '/generarComprobanteContable';
    this.open(options);

}

Almacen.generarSalidasAlmacen = function (options) {
    this.action = 'generarSalidasAlmacen';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 245,
    options['WindowHeight'] = 270,
    options.url = this.url + '/generarSalidasAlmacen';
    this.open(options);
}

Almacen.print = function (options) {
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var urlCompleta = 'reporteLibroMayor?' + datos;
    this.openUrl(urlCompleta);
}

Almacen.printResumen = function (options) {
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var urlCompleta = 'reporteResumenMayor?' + datos;
    this.openUrl(urlCompleta);
}

Almacen.printResumenCompras = function (options) {
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var urlCompleta = 'reporteResumenCompras?' + datos;
    this.openUrl(urlCompleta);
}

Almacen.printComprobanteContable = function (options) {
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var urlCompleta = 'reporteComprobanteContable?' + datos;
    this.openUrl(urlCompleta);
}

Almacen.printSalidasAlmacen = function (options) {
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var urlCompleta = 'reporteSalidasAlmacen?' + datos;
    this.openUrl(urlCompleta);
}

Almacen.validarFechaInicio = function (selectedDate, options) {
    if (selectedDate !== "") {
        if ($('#' + Almacen.Id("fechaFin")).datepicker("getDate") === null) {
            $('#' + Almacen.Id("fechaFin")).datepicker("option", "maxDate", new Date());
        }
    }
    $('#' + Almacen.Id("fechaFin")).datepicker("option", "minDate", selectedDate);
}

Almacen.validarFechaFin = function (selectedDate, options) {
    if (selectedDate === "") {
        $('#' + Almacen.Id("fechaInicio")).datepicker("option", "maxDate", new Date());
    }

    else {
        $('#' + Almacen.Id("fechaInicio")).datepicker("option", "maxDate", selectedDate);
    }
}

Almacen.setIdCuenta = function (id) {
    $('#' + this.Id('idcuenta')).val(id);
};

Almacen.formDiferenciasAlmacen = function(id) {
    this.action = 'formDiferenciasAlmacen';
    this.open(this.getOptions(id));
}

Almacen.generarExcelDiferenciasAlmacen = function() {
    var fechafin = this.get('fechaFin');
    this.downloadFile(this.urlIni+this.url+'/generarExcelDiferenciasAlmacen?fechafin='+fechafin+this.gestionSchemaMain());
}
