var Devoluciontpv = new Object();
Devoluciontpv.__proto__ = SystemWindow;
//variables
Devoluciontpv.nameView = "Devoluciontpv";
Devoluciontpv.url = "devoluciontpv";

Devoluciontpv.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Devoluciontpv',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Devoluciontpv',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('recepcionDevolucion', {        
        WindowTitle: 'Recepcion Devolución',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('aceptarDevolucion', {        
        WindowTitle: 'Aceptar Devolución',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Devoluciontpv',
        WindowWidth: 850,
        WindowHeight: 500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Devoluciontpv.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Devoluciontpv.afterCreate = function () {
    Devoluciontpv.reload();
}

Devoluciontpv.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Devoluciontpv.afterUpdate = function () {
    Devoluciontpv.closeWindow();
};

Devoluciontpv.beforeRecepcionDevolucion = function () {
    var error = false;//false es no existe error antes de crear formulario
    var grid = this.getSGridView('gridDevolucionproducto');
    var cantidad = 0;

    for (var f = 1; f <= grid.rows; f++)
    {
        if (grid.row(f).get('cantidaddevolucion') == 0) {
            cantidad++;
        }
    }
    if (cantidad == 0) {
        error = false;
    } else {
        error = true;
        Devoluciontpv.showMessageError('Existen productos con cantidad cero');
    }
    return error;
};
Devoluciontpv.recepcionDevolucion = function (id) {
    this.action = 'recepcionDevolucion';
    var options = {idKey: id};
    this.open(this.getOptions(options));
};
Devoluciontpv.afterRecepcionDevolucion = function () {
    Devoluciontpv.closeWindow();
    admDevoluciontpv.search();
};

Devoluciontpv.cantidadFocus = function () {
    var grid = Devoluciontpv.getSGridView('gridDevolucionproducto');
    grid.rowSelected().ById('cantidadrecibida').click();
};
Devoluciontpv.BuscaCodigoBarra = function (input, event) {
    var grid = this.getSGridView('gridDevolucionproducto');
    var idalmacen = Devoluciontpv.get('idalmacendestino');
    var k = (document.all) ? event.keyCode : event.which;
    if (idalmacen != '') {
        if (k == 13) {
            var data = {
                codigobarra: input.value,
                idalmacen: idalmacen
            };
            jQuery.ajax({
                url: this.urlIni + 'devoluciontpv/BuscacodigoBarra',
                type: 'post',
                data: data,
                success: function (resultado) {
                    if (resultado == 0) {
                        grid.rowSelected().set('idproducto', null);
                        grid.rowSelected().set('codigo', null);
                        grid.rowSelected().set('nombre', null);
                        grid.rowSelected().set('idunidad', null);
                        grid.rowSelected().set('saldoDisponible', null);
                        grid.rowSelected().set('pedidos', null);
                        Devoluciontpv.showMessageError('No existe el Producto, Por favor verique el Código de Barra! ');
                    } else {
                        var arrayDatosProducto = JSON.parse(resultado);
                        grid.rowSelected().ById('cantidaddevolucion').click();

                        grid.rowSelected().set('idproducto', arrayDatosProducto.idproducto);
                        grid.rowSelected().set('codigo', arrayDatosProducto.codigo);
                        grid.rowSelected().set('nombre', arrayDatosProducto.nombre);
                        grid.rowSelected().set('idunidad', arrayDatosProducto.unidad);
                        grid.rowSelected().set('saldoDisponible', arrayDatosProducto.saldoDisponible);
                    }
                    return;
                },
                error: function (jqXHR, status) {
                    SystemLoad.done();
                    alert('error! ');
                }
            });
        }
    } else {
        Devolucion.showMessageError('No existe Almacen seleccionado! ');
    }
};
Devoluciontpv.beforeAceptarDevolucion = function () {
    var error = false;//false es no existe error antes de crear formulario
    var grid = this.getSGridView('gridDevolucionproducto');
    var cantidad = 0;

    for (var f = 1; f <= grid.rows; f++)
    {
        if (grid.row(f).get('cantidaddevolucion') == 0) {
            cantidad++;
        }
    }
    if (cantidad == 0) {
        error = false;
    } else {
        error = true;
        Devoluciontpv.showMessageError('Existen productos con cantidad cero');
    }
    return error;
};
Devoluciontpv.aceptarDevolucion = function (id) {
    this.action = 'aceptarDevolucion';
    var options = {idKey: id};
    this.open(this.getOptions(options));
};
Devoluciontpv.afterAceptarDevolucion = function () {
    Devoluciontpv.closeWindow();
    admDevoluciontpv.search();
};