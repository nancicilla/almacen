var admVistaordenpedido = new Object();
admVistaordenpedido.__proto__ = SystemSearch;

//declare var
admVistaordenpedido.nameView = "admVistaordenpedido";
admVistaordenpedido.url = "vistaordenpedido/admin";
admVistaordenpedido.idContainer = "";
admVistaordenpedido.eventRow = "THIS.update();";
admVistaordenpedido.nextView = "Vistaordenpedido";
//functions
admVistaordenpedido.init = function () {
    try {
        //keyup para cantidad hasta y cantidad desde para permitir la busqueda aunque este contenga errores de validacion
        $('#' + admVistaordenpedido.Id("cantidadHasta")).unbind("keyup");
        $('#' + admVistaordenpedido.Id("cantidadHasta")).keyup(function () {
            if ($('#' + admVistaordenpedido.Id("cantidadHasta")).val() != "" && $('#' + admVistaordenpedido.Id("cantidadDesde")).val() != "")
            {
                if (parseFloat($('#' + admVistaordenpedido.Id("cantidadHasta")).val()) < parseFloat($('#' + admVistaordenpedido.Id("cantidadDesde")).val()))
                {
                    $('#' + admVistaordenpedido.Id("cantidadHasta")).addClass("error");
                    $('#' + admVistaordenpedido.Id("cantidadHasta")).attr('title', 'La cantidad hasta tiene que ser mayor a la cantidad desde');
                } else
                {
                    $('#' + admVistaordenpedido.Id("cantidadHasta")).removeClass("error");
                    $('#' + admVistaordenpedido.Id("cantidadDesde")).removeClass("error");
                }
            } else {
                if ($('#' + admVistaordenpedido.Id("cantidadHasta")).val() == "")
                    $('#' + admVistaordenpedido.Id("cantidadHasta")).removeClass("error");
            }
        });
        //keyup para cantidad hasta y cantidad desde para permitir la busqueda aunque este contenga errores de validacion
        $('#' + admVistaordenpedido.Id("cantidadDesde")).unbind("keyup");
        $('#' + admVistaordenpedido.Id("cantidadDesde")).keyup(function () {
            if ($('#' + admVistaordenpedido.Id("cantidadHasta")).val() != "" && $('#' + admVistaordenpedido.Id("cantidadDesde")).val() != "")
                if (parseFloat($('#' + admVistaordenpedido.Id("cantidadHasta")).val()) < parseFloat($('#' + admVistaordenpedido.Id("cantidadDesde")).val()))
                {
                    $('#' + admVistaordenpedido.Id("cantidadDesde")).addClass("error");
                    $('#' + admVistaordenpedido.Id("cantidadDesde")).attr('title', 'La cantidad desde tiene que ser menor a la cantidad hasta');
                } else
                {
                    $('#' + admVistaordenpedido.Id("cantidadHasta")).removeClass("error");
                    $('#' + admVistaordenpedido.Id("cantidadDesde")).removeClass("error");
                }
        });
    } catch (err) {
        alert('Error al cargar admVistaordenpedido.init()');
    }
}

admVistaordenpedido.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Vistaordenpedido.idKeySend());';
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

/*
 *Esta funcíon se ejecuta cuando introduciomos la fecha de inicio para busqueda, y limita la fecha fin
 */
admVistaordenpedido.validarFechaInicio = function (selectedDate, options) {

    if (selectedDate !== "") {
        //alert('vo:'+admOrden.Id("fechaAl"));
        if ($('#' + admVistaordenpedido.Id("fechaAl")).datepicker("getDate") === null) {
            $('#' + admVistaordenpedido.Id("fechaAl")).datepicker("option", "maxDate", new Date());
        }
    }
    $('#' + admVistaordenpedido.Id("fechaAl")).datepicker("option", "minDate", selectedDate);
    admVistaordenpedido.search();
}
/*
 *Esta funcíon se ejecuta cuando introduciomos la fecha fin para busqueda, y limita la fecha inicio
 */
admVistaordenpedido.validarFechaFin = function (selectedDate, options) {
    if (selectedDate === "") {
        $('#' + admVistaordenpedido.Id("fechaDel")).datepicker("option", "maxDate", new Date());
    } else {
        $('#' + admVistaordenpedido.Id("fechaDel")).datepicker("option", "maxDate", selectedDate);
    }
    admVistaordenpedido.search();
}