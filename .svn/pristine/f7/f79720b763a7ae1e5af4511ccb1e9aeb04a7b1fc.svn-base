var admInventario = new Object();
admInventario.__proto__ = SystemSearch;

//declare var
admInventario.nameView = "admInventario";
admInventario.url = "inventario/admin";
admInventario.idContainer = "";
admInventario.eventRow = "THIS.update();";
admInventario.nextView = "Inventario";
//functions
admInventario.init = function () {
    try {
         var THIS=this;
    } catch (err) {
        alert('Error al cargar admInventario.init()');
    }


}

admInventario.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Inventario.idKeySend());';
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
admInventario.editar = function () {
    Inventario.editar(this.options());
};
admInventario.actualizar = function () {
    var id = SGridView.getSelected('id');
    Inventario.actualizar(id);
    //Inventario.actualizar(this.options());
};