var Controlcalidadalmacen = new Object();
Controlcalidadalmacen.__proto__ = SystemWindow;
//variables
Controlcalidadalmacen.nameView = "Controlcalidadalmacen";
Controlcalidadalmacen.url = "controlcalidadalmacen";
Controlcalidadalmacen.bandera = 0;
Controlcalidadalmacen.insumos = [];
Controlcalidadalmacen.idControlCalidaProducto = 0;
Controlcalidadalmacen.gridProducto = null;

Controlcalidadalmacen.init = function () {
    var THIS=this;
    if (this.action === 'recepcion'){
//        this.verificaGrid();
        this.buttonChange({id: 'save', label: 'Recepcion'});
    }
    if (this.action === 'verificar'){
        this.verificarGrid();
        this.buttonChange({id: 'save', label: 'Verificar'});
    }
    if (this.action === 'finalizar'){
        this.verificaGrid();
        this.buttonChange({id: 'save', label: 'Finalizar'});
    }
    if (this.action === 'update'){
        this.verificaGrid();
    }
    if (this.action === 'view'){
        this.verificaGrid();
        this.disabledForm();
    }
    if (this.action === 'verRecuperarProducto'){
        this.verificaGrid();
        this.disabledForm();
    }
    if (this.action === 'recuperarProducto' || this.action === 'editarRecuperarProducto'){
        $('#' + this.Id("cantidad")).keyup(function () {
            THIS.calcularCantidadRecuperar();
        });
        $('#' + this.Id("cantidad")).blur(function () {
            if(Controlcalidadalmacen.get('cantidad') == ''){
                this.value = 0;
            }
            THIS.calcularCantidadRecuperar();
        });
        THIS.calcularCantidadRecuperar();
    }
};
Controlcalidadalmacen.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Control Calidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Control Calidad',
        initButtons: 'save,confirmar,cancel,print',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('view', {        
        WindowTitle: 'Ver Control Calidad',
        initButtons: 'back,print',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('recepcion', {        
        WindowTitle: 'Recepción Control Calidad',
        initButtons: 'save,cancel,pendiente',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('verificar', {        
        WindowTitle: 'Verificar Productos Devueltos',
        initButtons: 'save,cancel,rechazar,back',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('recuperarProducto', {        
        WindowTitle: 'Recuperación Insumos',
        initButtons: 'back,save,cancel',
        WindowWidth: 850,
        WindowHeight: 520,
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('verRecuperarProducto', {        
        WindowTitle: 'Ver Recuperación Insumos',
        initButtons: 'back',
        WindowWidth: 850,
        WindowHeight: 385,
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('editarRecuperarProducto', {        
        WindowTitle: 'Modificar Recuperación Insumos',
        initButtons: 'back,save,cancel',
        WindowWidth: 850,
        WindowHeight: 520,
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('finalizar', {        
        WindowTitle: 'FInalizar Control Calidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Controlcalidadalmacen',
        WindowWidth: 850,
        WindowHeight: 550,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
};

Controlcalidadalmacen.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
};
Controlcalidadalmacen.afterCreate = function () {
    Controlcalidadalmacen.reload();
};

Controlcalidadalmacen.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    var grid = this.getSGridView('gridProducto');
    var control =0;
    for (i =1 ; i <=grid.rows ; i++){
        var baja = grid.row(i).get('cantidadbaja');
        var aceptada = grid.row(i).get('cantidadaceptada');
        var total = (baja + aceptada).toFixed(4);
        grid.row(i).set('cantidadrecepcion',total);
        if (total != grid.row(i).get('cantidaddevolucion')){
            grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'red', 'font-weight': 'bold'}});
            control++;   
        }else{
            grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'black', 'font-weight': 'bold'}});
        }
    }
    
    /*if (control>0){
        error=true;
        this.showMessageError('No coinciden cantidades');
    }*/
    
    
    return error;
};
Controlcalidadalmacen.afterUpdate = function () {
    Controlcalidadalmacen.closeWindow();
    admControlcalidadalmacen.search();
};
Controlcalidadalmacen.beforeRecepcion = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
};
Controlcalidadalmacen.afterRecepcion = function () {
    Controlcalidadalmacen.closeWindow();
    admControlcalidadalmacen.search();
};
Controlcalidadalmacen.recepcion = function(id){
 this.action = 'recepcion';
    var options = {idKey: id};
    this.open(this.getOptions(options));   
};
Controlcalidadalmacen.beforeFinalizar = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    var grid = this.getSGridView('gridProducto');
    var control =0;
    for (i =1 ; i <=grid.rows ; i++){
        var baja = grid.row(i).get('cantidadbaja');
        var aceptada = grid.row(i).get('cantidadaceptada');
        var total = (baja + aceptada).toFixed(4);
        grid.row(i).set('cantidadrecepcion',total);
        if (total != grid.row(i).get('cantidaddevolucion')){
            grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'red', 'font-weight': 'bold'}});
            control++;   
        }else{
            grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'black', 'font-weight': 'bold'}});
        }
    }
    
    if (control>0){
        error=true;
        this.showMessageError('No coinciden cantidades');
    }
    
    return error;
};
Controlcalidadalmacen.afterFinalizar = function () {
    Controlcalidadalmacen.closeWindow();
    admControlcalidadalmacen.search();
};
Controlcalidadalmacen.finalizar = function(id){
 this.action = 'finalizar';
    var options = {idKey: id};
    this.open(this.getOptions(options));   
};
Controlcalidadalmacen.pendiente = function(){
    var THIS = this;
    var idcontrolcalidad= this.get('id');
        bootbox.dialog({
        message: "<form id='info' action=''>\
    <div class='column'  style='width:100%;'><p>EL proceso de control de calidad esta pendiente de recepcion</p> \
    </div></form>",
        buttons: {
            btn1: {
                label: 'Guardar',
                className: 'btn-success',
                callback: function () {
//                    motivo = $("#motivoRechazo").val();
                    $.post("almacen/controlcalidadalmacen/pendiente", {idcontrolcalidad:idcontrolcalidad})
                            .done(function (data) {
                                var myJsonString = JSON.parse(data);
                                if (myJsonString.errorRechazo == 1) {
                                    THIS.showMessageError('Error al registrar Pendiente');
                                } else {
                                    if (myJsonString.actualizo == 1) {
                                        admControlcalidadalmacen.search();
                                        THIS.closeWindow();
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
Controlcalidadalmacen.confirmar = function(){
    var THIS = this;
    var grid = this.getSGridView('gridProducto');
    var control =0;
    for (i =1 ; i <=grid.rows ; i++){
        var baja = grid.row(i).get('cantidadbaja');
        var aceptada = grid.row(i).get('cantidadaceptada');
        var total = baja + aceptada;
        grid.row(i).set('cantidadrecepcion',total);
        if (total != grid.row(i).get('cantidaddevolucion')){
            grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'red', 'font-weight': 'bold'}});
            control++;   
        }
    }
    if (control==0){
        var idcontrolcalidad= this.get('id');
        bootbox.dialog({
        message: "<form id='info' action=''>\
        <div class='column'  style='width:100%;'><p>EL proceso de control de calidad se esta FINALIZANDO</p> \
        </div></form>",
        buttons: {
            btn1: {
                label: 'Guardar',
                className: 'btn-success',
                callback: function () {
                    $.post("almacen/controlcalidadalmacen/confirmar", {idcontrolcalidad:idcontrolcalidad})
                            .done(function (data) {
                                var myJsonString = JSON.parse(data);
                                if (myJsonString.errorRechazo == 1) {
                                    THIS.showMessageError('Error al registrar Confirmacion');
                                } else {
                                    if (myJsonString.actualizo == 1) {
                                        admControlcalidadalmacen.search();
                                        THIS.closeWindow();
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
    }else{
        this.showMessageError('No coinciden cantidades');
    }
};
Controlcalidadalmacen.verificaGrid = function () {
  var grid = this.getSGridView('gridProducto');
  for (i =1 ; i <=grid.rows ; i++){
      var baja = grid.row(i).get('cantidadbaja');
      var aceptada = grid.row(i).get('cantidadaceptada');
      var total = (baja + aceptada).toFixed(4);
      grid.row(i).set('cantidadrecepcion',total);
      if (total != grid.row(i).get('cantidaddevolucion')){
          grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'red', 'font-weight': 'bold'}});
      }else{
          grid.row(i).attributes('cantidadrecepcion', {'style': {'color': 'black', 'font-weight': 'bold'}});
      }
      
  }
};
Controlcalidadalmacen.beforeRecuperarProducto = function() {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
};
Controlcalidadalmacen.afterRecuperarProducto = function() {
    var grid = this.gridProducto;
    for(var f = 1; f <= grid.rows; f++)
    {
        if(grid.row(f).get('id') == this.idControlCalidaProducto)
        {
            $('#' + grid.id + f + 'recuperada').html('<div class="confirmadoEnAlmacen"></div>');
            break;
        }
    }
    Controlcalidadalmacen.closeWindow();
};
Controlcalidadalmacen.recuperarProducto = function(){
 this.action = 'recuperarProducto';
 var THIS = this;
    var grid=this.getSGridView('gridProducto');
    var idccp=grid.rowSelected().get('id');
    this.gridProducto = this.getSGridView('gridProducto');
    this.idControlCalidaProducto = idccp;
    var baja = grid.rowSelected().get('cantidadbaja');
    if (baja == 0){
        bootbox.alert("No Existe producto a recuperar.");
        return;
    }
    var options = {idKey: idccp,varSend:'cantidad='+baja};
    jQuery.ajax({
        type: "GET",
        url: "almacen/controlcalidadalmacen/VerificaRecuperacionCC?id=" + idccp,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
            if (!data.recuperacion.estado) {
                var id = SGridView.getSelected('id');
                THIS.open(THIS.getOptions(options));
                return;
            }
            if (data.recuperacion.estado) {
                bootbox.alert("Ya se procedio a recuperar el producto");
                return;
            }
        },
        error: function (jqXHR, status) {
            // error handler
        }
    });
};
Controlcalidadalmacen.calcularCantidadRecuperar = function () {
    var cantidadRecuperar = $('#' + this.Id("cantidad")).val();
    var grid = this.getSGridView('gridInsumo');
    var variable;
    var totalItem = 0;
    if (this.bandera == 0) {
        for (var f = 1; f <= grid.rows; f++)
            this.insumos[f - 1] = grid.row(f).get('cantidad');
        this.bandera = 1;
    }

    if (this.bandera == 1) {
        if (grid.rows == this.insumos.length) {

            for (var f = 0; f < this.insumos.length; f++) {
                variable = f + 1;
                if (cantidadRecuperar == "") {
                    grid.row(variable).set('cantidadrecuperar', 0);
                } else {
                        var nuevoValor = parseFloat(cantidadRecuperar) * parseFloat(grid.row(variable).get('cantidad'));
                        grid.row(variable).set('cantidadrecuperar', nuevoValor);
                }
                if(grid.row(variable).get('idproducto') > 0)
                {
                    totalItem++;
                    $('#' + this.Id('spanTotalItems')).text(totalItem);
                }
            }

        } else
        {
            this.insumos = [];
            this.bandera = 0;
        }
    }
};
Controlcalidadalmacen.verRecuperarProducto = function(){
 this.action = 'verRecuperarProducto';
 var THIS = this;
    var grid=this.getSGridView('gridProducto');
    var idccp=grid.rowSelected().get('id');
    var baja = grid.rowSelected().get('cantidadbaja');
    if (baja == 0){
        bootbox.alert("No Existe producto recuperado.");
        return;
    }
    var options = {idKey: idccp,varSend:'cantidad='+baja};
    this.open(this.getOptions(options));
    
};
Controlcalidadalmacen.afterEditarRecuperarProducto = function () {
    Controlcalidadalmacen.closeWindow();
    admControlcalidadalmacen.search();
};
Controlcalidadalmacen.editarRecuperarProducto = function(){
 this.action = 'editarRecuperarProducto';
 var THIS = this;
    var grid=this.getSGridView('gridProducto');
    var idccp=grid.rowSelected().get('id');
    var baja = grid.rowSelected().get('cantidadbaja');
    if (baja == 0){
        bootbox.alert("No Existe producto recuperado.");
        return;
    }
    var options = {idKey: idccp,varSend:'cantidad='+baja};
    this.open(this.getOptions(options));
    
};
Controlcalidadalmacen.imprimirReporte = function () {
    var url = 'Imprimir?id=' + this.idKey();
    this.openUrl(url);
};
Controlcalidadalmacen.beforeVerificar = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
};
Controlcalidadalmacen.afterVerificar = function () {
    Controlcalidadalmacen.closeWindow();
    admControlcalidadalmacen.search();
};
Controlcalidadalmacen.verificar = function(id){
 this.action = 'verificar';
    var options = {idKey: id};
    this.open(this.getOptions(options));   
};
Controlcalidadalmacen.verificarGrid = function () {
    var grid = this.getSGridView('gridProducto');
    var totalItem = 0;
    for (var f = 1; f <= grid.rows; f++) {
        if(grid.row(f).get('idproducto') > 0)
        {
            totalItem++;
            $('#' + this.Id('spanTotalItems')).text(totalItem);
        }
    }
};
Controlcalidadalmacen.rechazar = function(){
    var THIS = this;
    var idcontrolcalidad= this.get('id');
    var grid = this.getSGridView('gridProducto');
    var arrayProducto={};
    var arrayP = [];
    for (i=1 ; i<=grid.rows;i++){
        arrayProducto.idproducto=grid.row(i).get('idproducto');
        arrayProducto.obs=grid.row(i).get('obs');
        arrayP.push(arrayProducto);
    }
    var gridProducto =JSON.stringify(Object.assign({}, arrayP));
        bootbox.dialog({
        message: "<form id='info' action=''>\
    <div class='column'  style='width:100%;'><p>El proceso de control de calidad se esta Rechazando para CORRECCION</p> \
    </div></form>",
        buttons: {
            btn1: {
                label: 'Guardar',
                className: 'btn-success',
                callback: function () {
                    $.post("almacen/controlcalidadalmacen/rechazar", {idcontrolcalidad:idcontrolcalidad,productos:gridProducto})
                        .done(function (data) {
                            var myJsonString = JSON.parse(data);
                            console.log(myJsonString);
                            if (myJsonString.errorRechazo == 1) {
                                THIS.showMessageError('Error al Rechazar la Devolucion');
                            } else {
                                if (myJsonString.actualizo == 1) {
                                    admControlcalidadalmacen.search();
                                    THIS.closeWindow();
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