var admReceta = new Object();
admReceta.__proto__ = SystemSearch;

//declare var
admReceta.nameView = "admReceta";
admReceta.url = "receta/admin";
admReceta.idContainer = "";
admReceta.eventRow = "THIS.update();";
admReceta.nextView = "Receta";
//functions
admReceta.init = function () {
    try {
         var THIS=this;
        $('#'+this.Id('producto')).keyup(function(e){
                var k = (document.all) ? e.keyCode : e.which;
                if(k!=37 && k!=38  && k!=39  && k!=40  && k!=13  && k!=9) {
                    THIS.set('idproducto','');
                    THIS.ById('producto').style.background="";
                }
            });            
        $('#'+this.Id('producto')).blur(function(){
                    if(THIS.get('idproducto')==''){
                        this.value='';
                        THIS.ById('producto').style.background="";
                        THIS.search();

                    }
                });
    } catch (err) {
        alert('Error al cargar admReceta.init()');
    }
}

admReceta.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Receta.idKeySend());';
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
