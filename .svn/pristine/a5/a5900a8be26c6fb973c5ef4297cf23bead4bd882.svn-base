var admReproceso = new Object();
admReproceso.__proto__ = SystemSearch;

//declare var
admReproceso.nameView = "admReproceso";
admReproceso.url = "reproceso/admin";
admReproceso.idContainer = "";
admReproceso.eventRow = "THIS.update();";
admReproceso.nextView = "Reproceso";
//functions
admReproceso.init = function () {
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
        alert('Error al cargar admReproceso.init()');
    }
}

admReproceso.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Reproceso.idKeySend());';
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
