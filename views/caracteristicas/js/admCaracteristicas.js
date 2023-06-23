var admCaracteristicas = new Object();
admCaracteristicas.__proto__ = SystemSearch;

//declare var
admCaracteristicas.nameView = "admCaracteristicas";
admCaracteristicas.url = "caracteristicas/admin";
admCaracteristicas.idContainer = "";
admCaracteristicas.nextView = "Caracteristicas";
//functions
admCaracteristicas.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admCaracteristicas.init()');
    }
}


admCaracteristicas.options = function () {
    var afterFunction = '';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    var idKey = SGridView.getSelected('id');
    console.log("llave seleccionada--->"+idKey+"<-----");
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        varsSend: varsSend
    };

    return options;

}
admCaracteristicas.ActualizarCaracteristica=function(){
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admCaracteristicas.search();';
    options.idKey = id;
    console.log("este numero se envia--->"+id);
    console.log(options);
    Caracteristicas.ActualizarCaracteristica(options);
}
