var admAlerta = new Object();
admAlerta.__proto__ = SystemSearch;

//declare var
admAlerta.nameView = "admAlerta";
admAlerta.url = "alerta/admin";
admAlerta.idContainer = "";
admAlerta.eventRow = "THIS.update();";
admAlerta.nextView = "Alerta";
//functions
admAlerta.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admAlerta.init()');
    }
}

admAlerta.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Alerta.idKeySend());';
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

admAlerta.realizarAccion=function(){
    var elementAlerts=$(document).find('div.Salerts');
    var id= SGridView.getSelected('id');      
    for(var i=0;i<elementAlerts.length;i++){
        if(elementAlerts[i].children[0].value==id){
            System.alertExecutionFunction(elementAlerts[i]);
            return;
        }
    }

    eval(SGridView.getSelected('function'));
}


admAlerta.registerView= function () {    //TEMPORALMENTE SOLO PARA PRUEBAS -- INTEGRACION CON ALMACEN boton  adm temporalmente pruebas

        this.executeAdmin({actionController:'registerView',
                           varSend:'&updateList=1'
                          });
        
    };
