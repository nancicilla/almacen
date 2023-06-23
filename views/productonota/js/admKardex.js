
var admKardex = new Object();
admKardex.__proto__ = SystemSearch;

//declare var
admKardex.nameView = "admKardex";
admKardex.url = "productonota/admin";
admKardex.idContainer = "";
admKardex.model="Productonota";
//admKardex.eventRow = "THIS.update();";
//admKardex.nextView = "Productonota";
admKardex.productoSeleccionado = false;
admKardex.titulo='';
//functions
admKardex.init = function () {
    try {
        admKardex.titulo=$('.SearchName').text();
        $('#Productonota_idalmacen').change(function () {
            document.getElementById("Productonota_idproducto").value = -1;
            document.getElementById("Productonota_nombreProducto").value = "";
            admKardex.search();
        });

        $('#Productonota_nombreProducto').unbind("keyup");
        $('#Productonota_nombreProducto').keyup(function (e) {
            if (admKardex.productoSeleccionado) {
                //verifica que exista un producto seleccionado a partir del autocomplete
                //en el textfield nombreProducto, de no ser asi, setea el id por defecto
                //-1 para que no muestre nada en el SGridView
                var nombreAutocomplete = document.getElementById("Productonota_nombreProducto").value;
                var nombreCorrecto = document.getElementById("Productonota_nombreCompletoProducto").value;
                if (nombreAutocomplete.trim() === "" || (nombreAutocomplete !== nombreCorrecto)) {
                    document.getElementById("Productonota_idproducto").value = -1;
                    admKardex.search();
                    admKardex.productoSeleccionado = false;
                }
            }
        });
        
    } catch (err) {
        alert('Error al cargar admKardex.init()');
    }
}

admKardex.options = function () {
    var afterFunction = '';
//    var updateFunction = 'THIS.search("&Sid="+Productonota.get("id"));';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        varsSend: varsSend
    };
    return options;
}

admKardex.actualizaTitulo= function (){    
    $(".SearchName").text(admKardex.titulo+
            $('#Productonota_nombreCompletoProducto').
            val().substring(0,42)+' ...');
}
