/* global parseFloat */

var Ordentrabajo = new Object();
Ordentrabajo.__proto__ = SystemWindow;
//variables
Ordentrabajo.nameView = "Ordentrabajo";
Ordentrabajo.url = "ordentrabajo";
Ordentrabajo.bandera = 0;
Ordentrabajo.insumos = [];

Ordentrabajo.init = function () {
    var THIS = this;
    Ordentrabajo.gridSearchVars('Producto', '&idproductoorden=' + $('#' + Ordentrabajo.Id("idproducto")).val()); //Ordentrabajo.get('idproducto'));
    if (this.action == "create"){
        $('#'+this.Id('producto')).keyup(function(e){
            var k = (document.all) ? e.keyCode : e.which;
            if(k!=37 && k!=38  && k!=39  && k!=40  && k!=13  && k!=9) {
                Ordentrabajo.set('idproducto', '');
                Ordentrabajo.ById('producto').style.background="";
            }
        });
        $('#'+this.Id('producto')).blur(function(){
            if(Ordentrabajo.get('idproducto') == ''){
                this.value = '';
                Ordentrabajo.ById('producto').style.background="";
            }
        });
        $('#' + this.Id("cantidadproducir")).keyup(function () {
            THIS.calcularCantidadProducirOrden();
        });
        
        //Ordentrabajo.gridSearchVars('Producto', '&idproductoorden=' + $('#' + Ordentrabajo.Id("idproducto")).val()); //Ordentrabajo.get('idproducto'));
        this.gridEventClickRow('Producto', 'Ordentrabajo.showDisponible();');
        this.gridEventBlur('Producto', 'Ordentrabajo.hiddenDisponible();');
    }
    if (this.action == "update"){
        this.buttonChange({id: 'save', display: 'none'});
        this.disabledForm();
    }
    if (this.action === 'registrarEntrega') {
        this.buttonChange({id: 'save', label: 'Registrar', key: 'G'});
        this.keyUpCantidadEntrega(this);
    }
};
Ordentrabajo.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Orden de Trabajo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Ver Orden de Trabajo',
        initButtons: 'cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('registrarEntrega', {layerHeight: 356,
        WindowWidth: 720,
        WindowHeight: 280,
        WindowTitle: 'Registrar entrega',
        initButtons: 'save',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    this.setActions('registrarDevolucion', {layerHeight: 356,
        WindowWidth: 850,
        WindowHeight: 405,
        WindowTitle: 'Registrar devoclución',
        initButtons: 'save',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    this.setActions('ventanaReportePendientesFecha', {
        layerHeight: 356,
        WindowWidth: 320,
        WindowHeight: 200,
        WindowTitle: 'Reporte - Ordenes Pendientes',
        initButtons: 'print,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Ordentrabajo',
        WindowWidth: 900,
        WindowHeight: 515,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Ordentrabajo.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    var grid = this.getSGridView('Producto');
    var cantidad = 0;
    var noDisponible = 0;
    for (var f = 1; f <= grid.rows; f++){
        var saldoDisponible = parseFloat(grid.row(f).get('saldoDisponible'));
        var cantidadReceta = parseFloat(grid.row(f).get('cantidad'));
        if(grid.row(f).get('id') > 0 && grid.row(f).get('cantidad') == 0){
            cantidad++;  
        }
        if (cantidadReceta > saldoDisponible) {
//            grid.row(f).attributes('cantidad', {validate: false, tooltip: 'Excede la cantidad disponible'});
            grid.row(f).attributes('cantidad', {'style': {'color': 'red', 'font-weight': 'bold'}});
            noDisponible++;
        }else{
            grid.row(f).attributes('cantidad', {validate: true, tooltip: ''});
        }
    }
    if (cantidad==0){
        error = false;
    }else{
        error = true;
        Ordentrabajo.showMessageError('Existen productos con cantidad cero');
    }
    if (!error){
        if (noDisponible > 0) {
            error = true;
            Ordentrabajo.showMessageError('Existen productos no disponibles');
        } else {
            error = false;
        } 
    }
    Ordentrabajo.verificarGrid();
    return error;
}
Ordentrabajo.afterCreate = function () {
    Ordentrabajo.reload();
}

Ordentrabajo.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Ordentrabajo.afterUpdate = function () {
    Ordentrabajo.closeWindow();
}
Ordentrabajo.registrarEntrega = function (options) {
    this.action = 'registrarEntrega';
    //var options={idKey:id};    
    this.open(this.getOptions(options));
};
Ordentrabajo.afterRegistrarEntrega = function () {
    Ordentrabajo.closeWindow();
}
Ordentrabajo.showDisponible = function () {
    var divSaldoDisponible = this.ById('divSaldoDisponible');
    var grid = this.getSGridView('Producto');

    var saldodisponible = grid.rowSelected().get('saldoDisponible');

    if (grid.rowSelected().get('id') != '') {
        divSaldoDisponible.innerHTML = parseFloat(saldodisponible).toFixed(8);
        divSaldoDisponible.parentElement.style.visibility = 'visible';
    } else {
        divSaldoDisponible.innerHTML = '';
        divSaldoDisponible.parentElement.style.visibility = 'hidden';
    }
};

Ordentrabajo.hiddenDisponible = function () {
    var divSaldoDisponible = this.ById('divSaldoDisponible');
    divSaldoDisponible.parentElement.style.visibility = 'hidden';
};
Ordentrabajo.verificarGrid = function () {

    var grid = this.getSGridView('Producto');
    var noDisponible = 0;
    var cantidadProducir=this.get('cantidadproducir');
    for (var f = 1; f <= grid.rows; f++)
    {
        var cantidadoriginal = parseFloat(grid.row(f).get('cantidadoriginalreceta'));
        if(cantidadProducir>0){
            grid.row(f).set('cantidad',cantidadoriginal*cantidadProducir);
        }
        var cantidad = parseFloat(grid.row(f).get('cantidad'));
        var cantidad = parseFloat(grid.row(f).get('cantidad'));
        var costo = parseFloat(grid.row(f).get('ultimoppp'));
        var saldoDisponible = parseFloat(grid.row(f).get('saldoDisponible'));
        var Disponiblereal = 0;
        
        if (this.action === 'create') {
            Disponiblereal = saldoDisponible;
        }
        if (this.action === 'update') {
            if (estado == 4) {
                Disponiblereal = saldoDisponible;
            } else {
                Disponiblereal = saldoDisponible + cantidad;
            }
        }
        if (cantidad > Disponiblereal) {
            grid.row(f).attributes('cantidad', {validate: false, tooltip: 'Excede la cantidad disponible'});
//            grid.row(f).attributes('cantidad', {'style': {'color': 'red', 'font-weight': 'bold'}});
            noDisponible++;
        }else{
            grid.row(f).attributes('cantidad', {validate: true, tooltip: ''});
        }
        
    }
//    if (noDisponible > 0) {
//        $('#' + Traspasotpv.Id("disponible")).val(0);
//    } else {
//        $('#' + Traspasotpv.Id("disponible")).val(1);
//    }
};
Ordentrabajo.metodo = function () {
    //var product = nombreProducto + '=' +this.get("producto");

    var idproducto = this.get("idproducto");
    var cantidadproducir = this.get("cantidadproducir");
    var vars = '&parametros=' + JSON.stringify({idproducto: idproducto, producto: {producto: this.get("producto")},cantidadproducir:cantidadproducir});
    this.reload(vars);
};
Ordentrabajo.calcularCantidadProducirOrden = function () {
    var respuesta = {excede: false};
    var cantidadProducirOrden = $('#' + this.Id("cantidadproducir")).val();
    var grid = this.getSGridView('Producto');
    var variable;

    if (this.bandera == 0) {
        for (var f = 1; f <= grid.rows; f++)
            this.insumos[f - 1] = grid.row(f).get('cantidad');
        this.bandera = 1;
    }

    if (this.bandera == 1) {
        if (grid.rows == this.insumos.length) {

            var verificaGrid = function (f) {
                var cantidad = grid.row(f).get('cantidad');
                var saldoDisponible = grid.row(f).get('saldoDisponible');

                if (cantidad > saldoDisponible) {
                    grid.row(f).attributes('cantidad', {validate: false, tooltip: 'Excede la cantidad disponible'});
                    return {excede: true};
                } else {
                    grid.row(f).attributes('cantidad', {validate: true, tooltip: ''});
                    return {excede: false};
                }
            }

            for (var f = 0; f < this.insumos.length; f++) {
                variable = f + 1;
                if (cantidadProducirOrden == "") {
                    grid.row(variable).set('cantidad', 0);
                } else {
                    if (grid.row(variable).get('modificar') == 0) {
                        var nuevoValor = parseFloat(cantidadProducirOrden) * parseFloat(grid.row(variable).get('cantidadoriginalreceta'));
                        grid.row(variable).set('cantidad', nuevoValor);
                    }
                }
            }
          // si esta tickeado el checkbox actualiza el Grid
            var grid = this.getSGridView('Producto');

            for (var f = 1; f <= grid.rows; f++) {
                
                    respuesta = verificaGrid(f);
              }
        } else
        {
            this.insumos = [];
            this.bandera = 0;
        }
    }
    return respuesta;
};
Ordentrabajo.registrarDevolucion = function (options) {
    this.action = 'registrarDevolucion';
    //var options={idKey:id};    
    this.open(this.getOptions(options));
};
Ordentrabajo.afterRegistrarDevolucion = function () {
    Ordentrabajo.closeWindow();
};
Ordentrabajo.keyUpCantidadEntrega = function (context) {
    THIS = context;
    $("#" + THIS.Id("cantidad")).keyup(function () {
        //valida cantidad
        valorActual = parseFloat($(this).val());
        cantidad = parseFloat($("#" + THIS.Id("cantidadproducir")).val());
        gastounitario = parseFloat($("#" + THIS.Id("gastounitario")).val());

        totalProducido = $("#" + THIS.Id("total")).val();
        tfOrden = $("#" + THIS.Id("costotrabajo"));

        if ($(this).val() != "")
            if (false){

            }else{
                if (totalProducido==1){
                    tfOrden.val((cantidad * gastounitario));
                }else{
                    tfOrden.val((valorActual * gastounitario));
                }
            }
        else{
            tfOrden.val("");
        }


    });

};

Ordentrabajo.print = function (options) {
    if (this.action === 'ventanaReportePendientesFecha') {
        var datos = this.prepareSend($('#' + this.groupForm).serialize());
        var urlCompleta = 'reporteOrdenesPendientesFechas?' + datos;
        this.openUrl(urlCompleta);
    }
};
Ordentrabajo.ventanaReportePendientesFecha = function () {
    this.action = 'ventanaReportePendientesFecha';
    this.open(this.getOptions());
};
Ordentrabajo.validarFechaInicio = function (selectedDate, options) {
    if (selectedDate !== "") {
        if ($('#' + Ordentrabajo.Id("fechaFin")).datepicker("getDate") === null) {
            $('#' + Ordentrabajo.Id("fechaFin")).datepicker("option", "maxDate", new Date());
        }
    }
    $('#' + Ordentrabajo.Id("fechaFin")).datepicker("option", "minDate", selectedDate);
};
Ordentrabajo.validarFechaFin = function (selectedDate, options) {
    if (selectedDate === "") {
        $('#' + Ordentrabajo.Id("fechaInicio")).datepicker("option", "maxDate", new Date());
    } else {
        $('#' + Ordentrabajo.Id("fechaInicio")).datepicker("option", "maxDate", selectedDate);
    }
};
Ordentrabajo.anularOrden = function (options) {
    var idOrdentrabajo = options.idKey;
    bootbox.dialog({
        message: "<form id='info' action=''>\
    <div class='column'  style='width:100%;'> <label> Motivo Anulación:</label><textarea autofocus id='motivoAnulacion' name='descripcion' style='width:98%;text-transform: uppercase;'/><br/>\
    </div></form>",
        buttons: {
            btn1: {
                label: 'Si',
                className: 'btn-success',
                callback: function () {
                    motivo = $("#motivoAnulacion").val();
                    $.post("almacen/ordentrabajo/anularOrdentrabajo", {idOrdentrabajo: idOrdentrabajo,motivo: motivo})
                            .done(function (data) {
                                var myJsonString = JSON.parse(data);
                                if (myJsonString.errorSaldo == 1) {
                                    Ordentrabajo.showMessageError('No Existe Orden de Trabajo a Anular! ');
                                } else {
                                    if (myJsonString.actualizo == 1) {
                                        admOrdentrabajo.showMessage('Orden de Trabajo ANULADA correctamente !!');
                                        admOrdentrabajo.search();
                                    }
                                }
                            });
                }
            },
            btn2: {
                label: 'Cancelar',
                className: 'btn-warning',
                callback: function () {
                }
            }
        }});
};