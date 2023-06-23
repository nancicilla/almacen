var Proyecto = new Object();
Proyecto.__proto__ = SystemWindow;
//variables
Proyecto.nameView = "Proyecto";
Proyecto.url = "proyecto";
Proyecto.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'update'||this.action=='Asociar') {

        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
       
                  
    }
};
Proyecto.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Proyecto',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Proyecto',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Asociar', {        
        WindowTitle: 'Información',
        initButtons: 'save,cancel',
        WindowWidth: 550,
        WindowHeight: 555,
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Proyecto',
        WindowWidth: 550,
        WindowHeight: 555,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Proyecto.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Proyecto.afterCreate = function () {
    Proyecto.reload();
}

Proyecto.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Proyecto.afterUpdate = function () {
    Proyecto.closeWindow();
}
Proyecto.Asociar = function(options) {
    this.action = 'Asociar';
     this.open(this.getOptions(options));
}
Proyecto.beforeAsociar = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    Proyecto.preparaInformacion();
    return error;
}
Proyecto.afterAsociar = function () {
    Proyecto.closeWindow();
}
Proyecto.preparaInformacion=function(){
   var lista=document.querySelectorAll('#'+Proyecto.Id('informacion'+'>div>div[data-hijo]'));
   var vector=[];
   var aux=[];
   var hijo=[];
   console.log(lista);
   for(var x=0;x<lista.length;x++) 
  {
    
    tipo= lista[x].getAttribute('data-tipo');
    nombre=lista[x].getAttribute('data-nombre');
    numhijos=lista[x].getAttribute('data-hijo');
    aux=lista[x].querySelectorAll('input');
    hijos=[];
    valor='';
    if(numhijos=='1'){
     for (var h=0;h<aux.length;h++){
        hijos.push({"nombre":aux[h].getAttribute('data-nombre'),"tipovalor":aux[h].getAttribute('data-tipo'),"valor":aux[h].value});
     }}
     else{
    valor=aux[0].value;
     }
     vector.push({"nombre":nombre,"tipovalor":tipo,"valor":valor,"hijos":hijos});
  
  }
  
  $('#'+Proyecto.Id('nombre')).val(JSON.stringify(vector));
    //#collapsep2 > input:nth-child(2)
}