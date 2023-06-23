
var admKardexValorado = new Object();
admKardexValorado.__proto__ = SystemSearch;

//declare var
admKardexValorado.nameView = "admKardexValorado";
admKardexValorado.url = "productonota/adminValorado";
admKardexValorado.idContainer = "";
admKardexValorado.model="Productonota";
admKardexValorado.productoSeleccionado = false;
admKardexValorado.titulo='';
//functions
admKardexValorado.init = function () {
    try {
        admKardexValorado.titulo=$('.SearchName').text();
        $('#Productonota_idalmacen').change(function () {
            document.getElementById("Productonota_idproducto").value = -1;
            document.getElementById("Productonota_nombreProducto").value = "";
            admKardexValorado.search();
        });

        $('#Productonota_nombreProducto').unbind("keyup");
        $('#Productonota_nombreProducto').keyup(function (e) {
            if (admKardexValorado.productoSeleccionado) {
                //verifica que exista un producto seleccionado a partir del autocomplete
                //en el textfield nombreProducto, de no ser asi, setea el id por defecto
                //-1 para que no muestre nada en el SGridView
                var nombreAutocomplete = document.getElementById("Productonota_nombreProducto").value;
                var nombreCorrecto = document.getElementById("Productonota_nombreCompletoProducto").value;
                if (nombreAutocomplete.trim() === "" || (nombreAutocomplete !== nombreCorrecto)) {
                    document.getElementById("Productonota_idproducto").value = -1;
                    admKardexValorado.search();
                    admKardexValorado.productoSeleccionado = false;
                }
            }
        });
  
    } catch (err) {
        alert('Error al cargar admKardexValorado.init()');
    }
}

admKardexValorado.options = function () {
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

admKardexValorado.actualizaTitulo= function (){    
    $(".SearchName").text(admKardexValorado.titulo+
            $('#Productonota_nombreCompletoProducto').
            val().substring(0,35)+' ...');
}