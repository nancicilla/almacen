var Notaborrador = new Object();
Notaborrador.__proto__ = SystemWindow;
//variables
Notaborrador.nameView = "Notaborrador";
Notaborrador.url = "notaborrador";

Notaborrador.init = function () {
    try {

        if (this.action === 'verNotaBorrador') {
            this.buttonChange({id: 'save', label: 'Cerrar', key: 'G'});
        }
        if (this.action === 'confirmarNotaBorrador') {
            this.buttonChange({id: 'save', label: 'Confirmar', key: 'G'});
        }
        
        if (this.action === 'create') {
            //previsualización inicial caso bajas
            $('label[for="' + Notaborrador.Id('Baja') + '"]').css('visibility', 'hidden');
            $('#' + Notaborrador.Id('detalle')).css('visibility', 'hidden');
            //previsualización inicial caso ingreso especial
            $('label[for="' + Notaborrador.Id('cambiarcosto') + '"]').css('visibility', 'hidden');
            $('#' + Notaborrador.Id('costovariable')).css('visibility', 'hidden');
            $('#' + this.Id("idtipodocumento")).live('change', function (e)
            {
                var grid = Notaborrador.getSGridView('Productonotaborrador');
                if (($(this).val())=== $('#' + Notaborrador.Id('baja')).val()){                    
                    $('label[for="' + Notaborrador.Id('Baja') + '"]').css('visibility', 'visible');
                    $('#' + Notaborrador.Id('detalle')).css('visibility', 'visible');  
                    $('label[for="' + Notaborrador.Id('cambiarcosto') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('costovariable')).css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('costovariable')).prop("checked", false);         
                    grid.col('costo').attr({editableCondition: 'false'});
                    grid.col('costo').attr({style: {'background': 'none'}});
                }
                else if (($(this).val())=== $('#' + Notaborrador.Id('ingesp')).val())
                {
                    $('label[for="' + Notaborrador.Id('cambiarcosto') + '"]').css('visibility', 'visible');
                    $('#' + Notaborrador.Id('costovariable')).css('visibility', 'visible');
                    $('label[for="' + Notaborrador.Id('Baja') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('detalle')).css('visibility', 'hidden');
                    $('label[for="' + Notaborrador.Id('iddetallenota') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('iddetallenota')).css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('detalle')).prop("checked", false);
                }
                else
                {
                    $('label[for="' + Notaborrador.Id('Baja') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('detalle')).css('visibility', 'hidden');
                    $('label[for="' + Notaborrador.Id('cambiarcosto') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('costovariable')).css('visibility', 'hidden');
                    $('label[for="' + Notaborrador.Id('iddetallenota') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('iddetallenota')).css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('costovariable')).prop("checked", false);
                    $('#' + Notaborrador.Id('detalle')).prop("checked", false);  
                    grid.col('costo').attr({editableCondition: 'false'});
                    grid.col('costo').attr({style: {'background': 'none'}});
                }
            });
            $('label[for="' + Notaborrador.Id('iddetallenota') + '"]').css('visibility', 'hidden');
            $('#' + Notaborrador.Id('iddetallenota')).css('visibility', 'hidden');
            this.buttonChange({id: 'save', label: 'Registrar', key: 'R'});
            $('#' + this.Id('detalle')).click(function () {
                var detalle = this.checked;
                if (!detalle) {
                    $('label[for="' + Notaborrador.Id('iddetallenota') + '"]').css('visibility', 'hidden');
                    $('#' + Notaborrador.Id('iddetallenota')).css('visibility', 'hidden');
                } else {
                    $('label[for="' + Notaborrador.Id('iddetallenota') + '"]').css('visibility', 'visible');
                    $('#' + Notaborrador.Id('iddetallenota')).css('visibility', 'visible');
                }
            });
            $('#' + this.Id('costovariable')).click(function () {
                var grid = Notaborrador.getSGridView('Productonotaborrador');
                var costovariable = this.checked;
                var color = Notaborrador.get('color');
                if (costovariable)
                {
                    grid.col('costo').attr({editableCondition: 'true'});
                    grid.col('costo').attr({style: {'background': color}});
                }
                else
                {
                    grid.col('costo').attr({editableCondition: 'false'});
                    grid.col('costo').attr({style: {'background': 'none'}});
                }
            });
            this.gridSearchVars('Productonotaborrador', '&idalmacn=' + $('#' + this.Id("idalmacen")).val());
            $('#' + this.Id("idalmacen")).live('change', function (e)
            {
                Notaborrador.gridReset('Productonotaborrador');
                Notaborrador.gridSearchVars('Productonotaborrador', '&idalmacn=' + $(this).val());
            });

            this.gridEventClickRow('Productonotaborrador', 'Notaborrador.showDisponible();');
            this.gridEventBlur('Productonotaborrador', 'Notaborrador.hiddenDisponible();');
        }

    } catch (err) {
        //alert('Error al cargar Notaborrador.init()');
    }
}

Notaborrador.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Nota Borrador',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Notaborrador',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    this.setActions('verNotaBorrador', {
        layerHeight: 356,
        WindowWidth: 740,
        WindowHeight: 363,
        WindowTitle: 'Ver Nota Borrador',
        initButtons: 'back',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('confirmarNotaBorrador', {
        layerHeight: 356,
        WindowWidth: 740,
        WindowHeight: 363,
        WindowTitle: 'Confirmar Nota Borrador',
        initButtons: 'back,save',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Notaborrador',
        WindowWidth: 1200,
        WindowHeight: 480,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Notaborrador.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Notaborrador.afterCreate = function () {
    Notaborrador.reload();
}

Notaborrador.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Notaborrador.afterUpdate = function () {
    Notaborrador.closeWindow();
}

Notaborrador.verNotaBorrador = function (id) {
    this.action = 'verNotaBorrador';
    this.open(this.getOptions(id));
};

Notaborrador.afterVerNotaBorrador = function () {
    Notaborrador.closeWindow();
};

Notaborrador.verificarGridInsumos = function () {
    var grid = this.getSGridView('Productonotaborrador');

    var idtipodocumento = this.get("idtipodocumento");
    var ingresoSalida;

    if (idtipodocumento != null)
    {
        var action = 'almacen/notaborrador/devuelveIdtipo?idtipodocumento=' + idtipodocumento;
        $.getJSON(action, function (listaJson) {
            $.each(listaJson, function (key, documento) {
                ingresoSalida = documento.idtipo;
                if (ingresoSalida == 2) // SALIDA
                {
                    for (var f = 1; f <= grid.rows; f++)
                    {
                        var disponible = grid.row(f).get('disponible');
                        var cantidad = grid.row(f).get('cantidad');
                        var disponibleTotal = Notaborrador.cantidadTotalProductoNota(grid.row(f).get('idproducto'));

                        if (disponibleTotal > disponible)
                            grid.row(f).attributes('cantidad', {validate: false, tooltip: 'Excede la cantidad disponible'});
                        else
                            grid.row(f).attributes('cantidad', {validate: true, tooltip: ''});

                        if (cantidad == 0)
                            grid.row(f).attributes('cantidad', {validate: false, tooltip: 'La cantidad debe ser mayor a CERO!'});
                    }
                }
                else
                {
                    for (var f = 1; f <= grid.rows; f++)
                    {
                        grid.row(f).attributes('cantidad', {validate: true, tooltip: ''});

                        var cantidad = grid.row(f).get('cantidad');
                        if (cantidad == 0)
                            grid.row(f).attributes('cantidad', {validate: false, tooltip: 'La cantidad debe ser mayor a CERO!'});
                    }
                }

            });
        });
    }
    Notaborrador.calcularCostoUnitarioCostoTotal(grid.rowSelected());

}
/*
 * Recalcula el grid del formulario
 * Si ingresa el costo unitario debe calcularse el costo total
 * si ingresa el costo total debe calcularse el costo unitario
 */
Notaborrador.calcularCostoUnitarioCostoTotal = function (fila) {

    //fila.attributes('cantidad', {validate: true, tooltip: ''});

    var cantidad = fila.get('cantidad');
    if (cantidad == 0) {
        //grid.row(f).attributes('cantidad', {validate: false, tooltip: 'La cantidad debe ser mayor a CERO!'});
        return;
    }
    if (fila.isFocus('cantidad'))
    {
        if (cantidad > 0) {
            var costounitario = fila.get('costo');
            fila.set('costototal', (parseFloat(cantidad) * parseFloat(costounitario)));
        }
    }

    var costounitario = fila.get('costo');
    var costototal = fila.get('costototal');
    if (fila.isFocus('costo'))
        if (parseFloat(costounitario) != 0) {
            fila.set('costototal', (parseFloat(cantidad) * parseFloat(costounitario)));
        }
    if (fila.isFocus('costototal'))
        if (parseFloat(costototal) != 0) {
            fila.set('costo', (parseFloat(costototal) / parseFloat(cantidad)));
        }
}

/**
 * Suma la cantidad propducto de la nota, para el caluclo de la disponibilidad del mismo
 * @returns float
 */
Notaborrador.cantidadTotalProductoNota = function (idproducto) {
    var grid = Notaborrador.getSGridView('Productonotaborrador');
    var cantidatotal = 0;
    for (var f = 1; f <= grid.rows; f++)
    {
        if (grid.row(f).get('idproducto') == idproducto) {
            cantidatotal += grid.row(f).get('cantidad');
        }
    }
    return cantidatotal;
}

Notaborrador.showDisponible = function () {
    var divSaldo = this.ById('divSaldo');
    var grid = this.getSGridView('Productonotaborrador');

    var saldodisponible = grid.rowSelected().get('disponible');

    if (grid.rowSelected().get('idproducto') != '') {
        var disponibleTotal = Notaborrador.cantidadTotalProductoNota(grid.rowSelected().get('idproducto'));
        divSaldo.innerHTML = parseFloat(saldodisponible - disponibleTotal).toFixed(4);
        divSaldo.parentElement.style.visibility = 'visible';
    } else {
        divSaldo.innerHTML = '';
        divSaldo.parentElement.style.visibility = 'hidden';
    }
}

Notaborrador.hiddenDisponible = function () {
    var divSaldo = this.ById('divSaldo');
    divSaldo.parentElement.style.visibility = 'hidden';
}

/**
 * Suma la cantidad propducto de la nota, para el caluclo de la disponibilidad del mismo
 * @returns float
 */
Notaborrador.cantidadTotalProductoNota = function (idproducto) {
    var grid = Notaborrador.getSGridView('Productonotaborrador');
    var cantidatotal = 0;
    for (var f = 1; f <= grid.rows; f++)
    {
        if (grid.row(f).get('idproducto') == idproducto) {
            cantidatotal += grid.row(f).get('cantidad');
        }
    }
    return cantidatotal;
}

Notaborrador.beforeConfirmarNotaBorrador = function () {
    var error = false;//false es no existe error antes de actulizar formulario
//    message = "¿Está seguro que desea confirmar la Nota Borrador?";
//    bootbox.dialog({
//                message: message,
//                buttons: {
//                    btn1: {
//                        label: 'Si',
//                        className: 'btn-success',
//                        callback: function () {
//                           // $("#" + Receta.Id('actualizarOrden')).val(1);
//                            Notaborrador.save();
//                        }
//                    },
//                    btn3: {
//                        label: 'Cancelar',
//                        className: 'btn-warning',
//                        callback: function () {
//
//                        }
//                    }
//                }});  
    //if (valida > 0) error = true;
    return error;
};

Notaborrador.confirmarNotaBorrador = function (id) {
    this.action = 'confirmarNotaBorrador';
    this.open(this.getOptions(id));
};

Notaborrador.afterConfirmarNotaBorrador = function () {
    Notaborrador.closeWindow();
    //admNotaborrador.search()
};

