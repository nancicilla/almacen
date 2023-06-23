var Nota = new Object();
Nota.__proto__ = SystemWindow;
//variables
Nota.nameView = "Nota";
Nota.url = "nota";
Nota.init = function () {
    try {
        if (this.action !== 'verNota')
        {
            if (this.action === 'update') {
                this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
            }
            if (this.action === 'create') {
                $('label[for="'+ Nota.Id('iddetallenota')+'"]').css('visibility','hidden');
                $('#' + Nota.Id('iddetallenota')).css('visibility','hidden');
                this.buttonChange({id: 'save', label: 'Registrar', key: 'R'});
                $('#' + this.Id('detalle')).click(function () {
                    var detalle = this.checked;
                    if (!detalle) {  
                        $('label[for="'+ Nota.Id('iddetallenota')+'"]').css('visibility','hidden');
                        $('#' + Nota.Id('iddetallenota')).css('visibility','hidden');
                    } else {
                        $('label[for="'+ Nota.Id('iddetallenota')+'"]').css('visibility','visible');
                        $('#' + Nota.Id('iddetallenota')).css('visibility','visible');
                    }
                });
                $('#' + this.Id('costovariable')).click(function() {
                    var grid = Nota.getSGridView('Productonota');
                    var costovariable = this.checked;
                    var color = Nota.get('color');
                    if(costovariable)
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
            }
            if (this.action === 'verNota') {
                this.buttonChange({id: 'save', label: 'Cerrar', key: 'C'});
            }
            if (this.action !== 'reporteVentanaInformeBajas') {
                this.gridSearchVars('Productonota', '&idalmacn=' + $('#' + this.Id("idalmacen")).val());
                $('#' + this.Id("idalmacen")).live('change', function (e)
                {
                    Nota.gridReset('Productonota');
                    Nota.gridSearchVars('Productonota', '&idalmacn=' + $(this).val());
                });

                this.gridEventClickRow('Productonota', 'Nota.showDisponible();');
                this.gridEventBlur('Productonota', 'Nota.hiddenDisponible();');
            }
            
        }
    } catch (err) {
        alert('Error al cargar Nota.init()');
    }
}

Nota.options = function () {    
    this.setActions('reporteVentanaInformeBajas', {
             layerHeight: 356,
             WindowWidth: 320,
             WindowHeight: 230,
             WindowTitle: 'Informe de Bajas',   
             initButtons: 'print,cancel',
             layerEndOn: false,
             ableBackWindow: true
    });
    this.setActions('create', {
        WindowTitle: 'Crear Nota',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Nota',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('despachar', {
        WindowTitle: 'Despachar Nota',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('verNota', {
        layerHeight: 356,
        WindowWidth: 740,
        WindowHeight: 363,
        WindowTitle: 'Ver Nota',
        initButtons: 'back',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Nota',
        WindowWidth: 1200,
        WindowHeight: 460,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Nota.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Nota.afterCreate = function () {
    Nota.reload();
    this.print();
}

Nota.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Nota.afterUpdate = function () {
    Nota.closeWindow();
}

Nota.beforeDelete = function () {
    var error = false;//false es no existe error antes de eliminar formulario
    return error;
}

Nota.despacho = function (options) {
    this.action = 'despachar';
    var updateFunction = (options['updateFunction'] != null) ? options['updateFunction'] : '';
    var idKey = (options['idKey'] != null) ? options['idKey'] : '';
    var options = this.options();
    options['WindowTitle'] = (this.layer[this.action] != null && this.layer[this.action]['WindowTitle'] != null) ? this.layer[this.action]['WindowTitle'] : this.action;
    options['WindowWidth'] = 260,
            options['WindowHeight'] = 305,
            options.url = this.url + '/despachar';
    options.varSend = 'id=' + idKey;
    options.idKey = idKey;
    options.updateFunction = updateFunction;
    this.open(options);
}

Nota.afterDespachar = function () {
    Nota.closeWindow();
    admNota.showMessage("El despacho se registró correctamente!");
}

Nota.print = function () {
    if (this.action === 'reporteVentanaInformeBajas') {
        var datos = this.prepareSend($('#' + this.groupForm).serialize());
        var urlCompleta = 'reporteInformeBajas?' + datos;
        this.openUrl(urlCompleta);
    }else{
        var url = 'ReporteNota?id=' + this.idKey();
        this.openUrl(url);
    }
};

Nota.showDisponible = function () {
    var divSaldo = this.ById('divSaldo');
    var grid = this.getSGridView('Productonota');

    var saldodisponible = grid.rowSelected().get('disponible');

    if (grid.rowSelected().get('idproducto') != '') {
        var disponibleTotal = Nota.cantidadTotalProductoNota(grid.rowSelected().get('idproducto'));
        divSaldo.innerHTML = parseFloat(saldodisponible - disponibleTotal).toFixed(4);
        divSaldo.parentElement.style.visibility = 'visible';
    } else {
        divSaldo.innerHTML = '';
        divSaldo.parentElement.style.visibility = 'hidden';
    }
}

Nota.hiddenDisponible = function () {
    var divSaldo = this.ById('divSaldo');
    divSaldo.parentElement.style.visibility = 'hidden';
}

/**
 * Suma la cantidad propducto de la nota, para el caluclo de la disponibilidad del mismo
 * @returns float
 */
Nota.cantidadTotalProductoNota = function (idproducto) {
    var grid = Nota.getSGridView('Productonota');
    var cantidatotal = 0;
    for (var f = 1; f <= grid.rows; f++)
    {
        if (grid.row(f).get('idproducto') == idproducto) {
            cantidatotal += grid.row(f).get('cantidad');
        }
    }
    return cantidatotal;
}

Nota.verificarGridInsumos = function () {
    var grid = this.getSGridView('Productonota');

    var idtipodocumento = this.get("idtipodocumento");
    var ingresoSalida;

    if (idtipodocumento != null)
    {
        var action = 'almacen/nota/devuelveIdtipo?idtipodocumento=' + idtipodocumento;
        $.getJSON(action, function (listaJson) {
            $.each(listaJson, function (key, documento) {
                ingresoSalida = documento.idtipo;
                if (ingresoSalida == 2) // SALIDA
                {
                    for (var f = 1; f <= grid.rows; f++)
                    {
                        var disponible = grid.row(f).get('disponible');
                        var cantidad = grid.row(f).get('cantidad');
                        var disponibleTotal = Nota.cantidadTotalProductoNota(grid.row(f).get('idproducto'));

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
    Nota.calcularCostoUnitarioCostoTotal(grid.rowSelected());

}

Nota.verNota = function (id) {
    this.action = 'verNota';
    this.open(this.getOptions(id));
};

Nota.afterVerNota = function (id) {
    Nota.closeWindow();
};

Nota.ventanaInformeBajas= function () {
    Nota.action='reporteVentanaInformeBajas';
    Nota.open(Nota.getOptions());
};
/*
 * Cuando selecciona una fecha se limita la fecha fin
 * en la vista de imprimir reportes pendientes por fechas
 * @param {type} selectedDate
 * @param {type} options
 * @returns {undefined} 
 * */    
Nota.validarFechaInicio = function (selectedDate, options) {
    if (selectedDate !== "") {
        if ($('#' + Nota.Id("fechaFin")).datepicker("getDate") === null) {
            $('#' + Nota.Id("fechaFin")).datepicker("option", "maxDate", new Date());
        }
    }
    $('#' + Nota.Id("fechaFin")).datepicker("option", "minDate", selectedDate);
}

/**
* Cuando selecciona la fechya se limita la fecha de inicio
* En la vista para imprimir reporte de órdenes pendietes por fechas
 * @param {type} selectedDate
 * @param {type} options
 * @returns {undefined} */
Nota.validarFechaFin = function (selectedDate, options) {
    if (selectedDate === "") {
        $('#' + Nota.Id("fechaInicio")).datepicker("option", "maxDate", new Date());
    }

    else {
        $('#' + Nota.Id("fechaInicio")).datepicker("option", "maxDate", selectedDate);
    }
}
/*
 * Recalcula el grid del formulario
 * Si ingresa el costo unitario debe calcularse el costo total
 * si ingresa el costo total debe calcularse el costo unitario
 */
Nota.calcularCostoUnitarioCostoTotal=function(fila){
    
        //fila.attributes('cantidad', {validate: true, tooltip: ''});

        var cantidad = fila.get('cantidad');
        if (cantidad == 0){            
            //grid.row(f).attributes('cantidad', {validate: false, tooltip: 'La cantidad debe ser mayor a CERO!'});
            return;
        }
        if(fila.isFocus('cantidad'))
        {
            if(cantidad > 0) {
                var costounitario = fila.get('costo');
                fila.set('costototal',(parseFloat(cantidad)*parseFloat(costounitario)));
            }
        }
        
        var costounitario = fila.get('costo');
        var costototal = fila.get('costototal');        
        if(fila.isFocus('costo'))
        if(parseFloat(costounitario)!=0){
            fila.set('costototal',(parseFloat(cantidad)*parseFloat(costounitario)));
        }
        if(fila.isFocus('costototal'))
        if(parseFloat(costototal)!=0){
            fila.set('costo',(parseFloat(costototal)/parseFloat(cantidad)));
        }
    
}
// ---------------------------------------------------------
// ------------------ Busca Codigo de Barra ----------------
// ---------------------------------------------------------
Nota.BuscaCodigoBarra = function (input, event) {
    var grid = this.getSGridView('Productonota');
    var idalmacen = Nota.get('idalmacen');
    var k = (document.all) ? event.keyCode : event.which;
    if (idalmacen != '') {
        if (k == 13) {
            var data = {
                codigobarra: input.value,
                idalmacen: idalmacen
            };
            jQuery.ajax({
                url: this.urlIni + 'nota/BuscacodigoBarra',
                type: 'post',
                data: data,
                success: function (resultado) {
                    if (resultado == 0) {
                        grid.rowSelected().set('idproducto', null);
                        grid.rowSelected().set('codigo', null);
                        grid.rowSelected().set('nombre', null);
                        grid.rowSelected().set('udd', null);
                        grid.rowSelected().set('costo', null);
                        grid.rowSelected().set('costototal', null);
                        grid.rowSelected().set('Saldo', null);
                        Nota.showMessageError('No existe el Producto, Por favor verique el Código de Barra! ');
                    } else {
                        var arrayDatosProducto = JSON.parse(resultado);
                        grid.rowSelected().set('idproducto', arrayDatosProducto.idproducto);
                        grid.rowSelected().set('codigo', arrayDatosProducto.codigo);
                        grid.rowSelected().set('nombre', arrayDatosProducto.nombre);
                        grid.rowSelected().set('udd', arrayDatosProducto.udd);
                        grid.rowSelected().set('costo', arrayDatosProducto.costo);
                        grid.rowSelected().set('costoHidden', arrayDatosProducto.costo);
                        grid.rowSelected().set('disponible', arrayDatosProducto.saldo);
                        grid.rowSelected().set('costototal', '0.00');
                        grid.rowSelected().set('Saldo', arrayDatosProducto.entero);
                    }
                    return;
                },
                error: function (jqXHR, status) {
                    SystemLoad.done();
                    alert('error!');
                }
            });
        }
    } else {
        Nota.showMessageError('No existe Almacen seleccionado! ');
    }
};