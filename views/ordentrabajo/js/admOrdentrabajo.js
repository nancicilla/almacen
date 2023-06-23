var admOrdentrabajo = new Object();
admOrdentrabajo.__proto__ = SystemSearch;

//declare var
admOrdentrabajo.nameView = "admOrdentrabajo";
admOrdentrabajo.url = "ordentrabajo/admin";
admOrdentrabajo.idContainer = "";
admOrdentrabajo.eventRow = "THIS.update();";
admOrdentrabajo.nextView = "Ordentrabajo";
//functions
admOrdentrabajo.init = function () {
    try {
        var THIS = this;
        $('#' + this.Id('producto')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                THIS.set('idproducto', '');
                THIS.ById('producto').style.background = "";
            }
        });
        $('#' + this.Id('producto')).blur(function () {
            if (THIS.get('idproducto') == '') {
                this.value = '';
                THIS.ById('producto').style.background = "";
                THIS.search();

            }
        });
        $('#' + this.Id('ingrediente')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                THIS.set('idingrediente', '');
                THIS.ById('ingrediente').style.background = "";
            }
        });
        $('#' + this.Id('ingrediente')).blur(function () {
            if (THIS.get('idingrediente') == '') {
                this.value = '';
                THIS.ById('ingrediente').style.background = "";
                THIS.search();

            }
        });
    } catch (err) {
        alert('Error al cargar admOrdentrabajo.init()');
    }
}

admOrdentrabajo.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Ordentrabajo.idKeySend());';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        updateFunction: updateFunction,
        varsSend: varsSend
    };

    return options;

}   
admOrdentrabajo.registrarEntrega = function () {
    gridOrdenAdmin=this;
    jQuery.ajax({
       type: "GET",
       url: "almacen/ordentrabajo/VerificaEstadosOrden?idorden="+SGridView.getSelected('id'),  
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       success: function (data, status, jqXHR) {  
           //&&!data.terminada.estado
            if(data.enproceso.estado ){
                Ordentrabajo.registrarEntrega(gridOrdenAdmin.getOptions());
                return;
            }
            if(data.entrega.estado) {
                bootbox.alert("La orden está entregada, no se pueden registrar entregas.");
                return;} 
            if(!data.enproceso.estado || !data.entrega.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
        },
        error: function (jqXHR, iniciada) {           
              // error handler
          }
      });
};
admOrdentrabajo.registrarDevolucion = function () {
    gridOrdenAdmin=this;
    jQuery.ajax({
       type: "GET",
       url: "almacen/ordentrabajo/VerificaEstadosOrden?idorden="+SGridView.getSelected('id'),  
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       success: function (data, status, jqXHR) {  
           //&&!data.terminada.estado
            if(data.enproceso.estado ){
                Ordentrabajo.registrarDevolucion(gridOrdenAdmin.getOptions());
                return;
            }
            if(data.entrega.estado) {
                bootbox.alert("La orden está en entregada, no se pueden registrar devoluciones.");
                return;} 
            if(!data.enproceso.estado || !data.entrega.estado) {
                bootbox.alert("No se puede realizar la operación.");
                return;}
        },
        error: function (jqXHR, iniciada) {           
              // error handler
          }
      });
}

/*
 *Esta funcíon se ejecuta caundo introduciomos la fecha de inicio para busqueda, y limita la fecha fin
 */
admOrdentrabajo.validarFechaInicio = function (selectedDate, options) {

    if (selectedDate !== "") {
        //alert('vo:'+admOrden.Id("fechaAl"));
        if ($('#' + admOrdentrabajo.Id("fechaFin")).datepicker("getDate") === null) {
            // alert('diferente de null');
            $('#' + admOrdentrabajo.Id("fechaFin")).datepicker("option", "maxDate", new Date());
        }
    }
    $('#' + admOrdentrabajo.Id("fechaFin")).datepicker("option", "minDate", selectedDate);
    admOrdentrabajo.search();
}

/*
 *Esta funcíon se ejecuta caundo introduciomos la fecha fin para busqueda, y limita la fecha inicio
 */
admOrdentrabajo.validarFechaFin = function (selectedDate, options) {
    if (selectedDate === "") {
        $('#' + admOrdentrabajo.Id("fechaInicio")).datepicker("option", "maxDate", new Date());
    } else {
        $('#' + admOrdentrabajo.Id("fechaInicio")).datepicker("option", "maxDate", selectedDate);
    }
    admOrdentrabajo.search();
}

admOrdentrabajo.setInformacionProductoSearch = function (idProducto, nombreProducto) {
    $('#' + this.Id("idproducto")).val(idProducto);
    $('#' + this.Id("producto")).val(nombreProducto);
}

admOrdentrabajo.setInformacionIngredienteSearch = function (idIngrediente, nombreIngrediente) {
    $('#' + this.Id("idingrediente")).val(idIngrediente);
    $('#' + this.Id("ingrediente")).val(nombreIngrediente);
}

admOrdentrabajo.anularOrden = function () {
//    this.idSelected = SGridView.getSelected('id');
//    var afterFunction =  "if(THIS.error == false) Ordentrabajo.anularOrden(admOrdentrabajo.getOptions());";
//    
//    this.executeAdmin(
//        {
//            actionController:'verificaAnularOrden',
//            varSend:'',
//            afterFunction:afterFunction
//        });  
    var data='&id='+SGridView.getSelected('id');
        var success=null;
        var afterFunction='if(admOrdentrabajo.error==false)Ordentrabajo.anularOrden(THIS.getOptions());';

        this.executeAdmin({actionController:'verificaAnularOrden',
                           varSend:data,
                           afterFunction:afterFunction
                      });
  return false;
};