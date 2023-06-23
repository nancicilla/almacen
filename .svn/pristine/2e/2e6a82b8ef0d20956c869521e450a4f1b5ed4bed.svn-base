var admAgrupacion = new Object();
admAgrupacion.__proto__ = SystemSearch;

//declare var
admAgrupacion.nameView = "admAgrupacion";
admAgrupacion.url = "producto/adminAgrupacion";
admAgrupacion.idContainer = "";
admAgrupacion.eventRow = "THIS.AgrupacionProductoUpdate();";
admAgrupacion.nextView = "Producto";
//functions
admAgrupacion.init = function() {
    
};

admAgrupacion.options = function() {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Agrupacion.idKeySend());';
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
};

admAgrupacion.AgrupacionProductoUpdate = function() {
    this.set_url();
    var THIS = this;
    
    Agrupacion.AgrupacionProductoUpdate(THIS.getOptions());
}