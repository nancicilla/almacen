var admProyecto = new Object();
admProyecto.__proto__ = SystemSearch;

//declare var
admProyecto.nameView = "admProyecto";
admProyecto.url = "proyecto/admin";
admProyecto.idContainer = "";
admProyecto.eventRow = "THIS.update();";
admProyecto.nextView = "Proyecto";
//functions
admProyecto.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admProyecto.init()');
    }
}

admProyecto.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Proyecto.idKeySend());';
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
admProyecto.Asociar=function(){
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admProyecto.search();';
    options.idKey = id;
    Proyecto.Asociar(options);
}
