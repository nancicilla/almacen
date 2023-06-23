var Caracteristicas = new Object();
Caracteristicas.__proto__ = SystemWindow;
//variables
Caracteristicas.nameView = "Caracteristicas";
Caracteristicas.url = "caracteristicas";

Caracteristicas.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'update'||this.action=='ActualizarCaracteristica') {

        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
       
             if ( this.action == 'ActualizarCaracteristica') {
        //Persona.gridSearchVars('gridPorcentajespago', +SGridView.getAllData(this.getSGridView('gridPorcentajespago').idempresasubempleadora,'idempresasubempleadora'));
          Caracteristicas.Escucha();
        }        
    }
};

Caracteristicas.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Caracteristicas',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Caracteristicas',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ActualizarCaracteristica', {

        WindowWidth: 550,
        WindowHeight: 550,
        WindowTitle: 'Actualizar Caracteristicas',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Caracteristicas',
        WindowWidth: 550,
        WindowHeight: 550,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Caracteristicas.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    this.guardarInformacion('registrar',new Array());
    return error;
}
Caracteristicas.afterCreate = function () {
    Caracteristicas.reload();
}

Caracteristicas.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Caracteristicas.afterUpdate = function () {
    Caracteristicas.closeWindow();
}
Caracteristicas.beforeActualizarCaracteristica = function() {
    var error = false; //false es no existe error antes de crear formulario
    this.guardarInformacion('actualizar',new Array());
    return error;
}
Caracteristicas.afterActualizarCaracteristica = function() {
    Caracteristicas.closeWindow();
}
Caracteristicas.ActualizarCaracteristica = function(options) {
    this.action = 'ActualizarCaracteristica';
     this.open(this.getOptions(options));
}
Caracteristicas.Escucha=function(){
     const todos= document.querySelectorAll('.todo');
   const togglers= document.querySelectorAll('.toggler');
   todos.forEach(todo=>{
    todo.addEventListener('click',()=>{
        todo.classList.toggle("active");
    });
   });
   togglers.forEach(toggler=>{
    toggler.addEventListener('click',()=>{
        toggler.classList.toggle("active");
        toggler.nextElementSibling.classList.toggle("active");
    });
   });
}
Caracteristicas.crearNodo=function (elemento){
        let padre=elemento.parentNode;
        let abuelo =padre.parentNode;
        let input=padre.querySelector('input');
        let tipo=padre.querySelector('select');
        if (input.value!==''){
            var nodo=document.createElement('li');                        
            var ul=document.createElement('ul');
            var div= document.createElement('div');           
            var lidefecto=document.createElement('li');  
            lidefecto.classList.add('todo');
            div.innerHTML=input.value+'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)">';
            div.classList.add('toggler');
             
            div.addEventListener('click',()=>{
            div.classList.toggle("active");
            div.nextElementSibling.classList.toggle("active")
            });
            if(tipo.value==='1'){
                div.classList.add('imagen');
            } 
            ul.classList.add('toggler-target');
            var a = document.createAttribute("data-tipo");
            a.value = tipo.value;
            nodo.setAttributeNode(a);
            var espadre = document.createAttribute("data-nodo");
            espadre.value ='si';
            nodo.setAttributeNode(espadre);
            nodo.addEventListener('click',()=>{
        nodo.classList.toggle("active")
        })
            lidefecto.innerHTML='<input  placeholder="escriba el nombre de la Caracteristica..."  > <select ><option value="0"> Texto  </option><option value="1"> Imagen </option> </select> <span class="guardar" onclick="Caracteristicas.crearNodoHermano(this)" ></span>';
            ul.appendChild(lidefecto);
            nodo.appendChild(div);
            nodo.appendChild(ul);
            abuelo.insertBefore(nodo, padre)
            input.value='';
  


        }else{
            alert("Debe introducir el nombre de la Caracteristica!!")
        }

        
    
   }
 Caracteristicas.crearNodoHermano=  function (elemento){
    let padre;    
        padre =elemento.parentNode;
        let abuelo =padre.parentNode;
        let input=padre.querySelector('input');
        let tipo=padre.querySelector('select');
        if (input.value!==''){
            var nodo=document.createElement('li'); 
            var a = document.createAttribute("data-tipo");
            a.value = tipo.value;
            nodo.setAttributeNode(a);
            nodo.classList.add('todo');
            if(tipo.value==='1'){
                nodo.classList.add('imagen');
            } 
            var espadre = document.createAttribute("data-nodo");
            espadre.value ='no';
            nodo.setAttributeNode(espadre);
            nodo.addEventListener('click',()=>{
        nodo.classList.toggle("active")
        });
            nodo.innerHTML=input.value+'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)">';           
            abuelo.insertBefore(nodo, padre);
            input.value='';

        }else{
            alert("Debe introducir el nombre de la Caracteristica!!")
        }

        
    
   }
Caracteristicas.eliminarNodo= function (elemento){
    let espadre;
    let padre;    
        padre =elemento.parentNode;//div
        espadre=padre.getAttribute('data-nodo');
        let abuelo =padre.parentNode;//li
         if(espadre==='no'){
            abuelo.removeChild(padre);
         }else{         
        abuelo.parentNode.removeChild(abuelo);
            
         }
   }
  Caracteristicas.guardarInformacion= function (ruta,vector){
    let lista= document.querySelectorAll('#'+Caracteristicas.groupForm+'_contenedor >ul.todos>li[data-tipo]');
    var hijos=[];
    var aux=[];// new Array()
    let tipo;
    let nombre;
    let error=true;
    let id=$('#'+Caracteristicas.Id('id')).val();
    vector=[];

    
  for(var x=0;x<lista.length;x++) 
  {
    
    tipo= lista[x].getAttribute('data-tipo');
    nombre=lista[x].querySelector(':nth-child(1)').innerText;
    aux=lista[x].querySelectorAll('ul>li[data-nodo]');
    
    hijos=[];
     for (var h=0;h<aux.length;h++){
        hijos.push({"nombre":aux[h].innerText,"tipo":aux[h].getAttribute('data-tipo')})
     }
    vector.push({"nombre":nombre,"tipo":tipo,"hijos":hijos});
    
  }
  let opcion=$('input[type=radio][name=paraenvase]:checked').val();
   if (opcion ||$('#'+Caracteristicas.Id('nombre')).val()!==''||vector.length>0) {
            $.ajax({     
        'type':'post',
        'url':'almacen/caracteristicas/'+ruta,
        'data':{ vector:vector,paraenvase:opcion,nombre:$('#'+Caracteristicas.Id('nombre')).val(),id:id},
        success:function (resp) {  
           error=false;                
                  
          vector=[];
       },
        error:function () {
            alert('ocurrio un error ');
        }

    }); 
        }
        else {
            if($('#'+Caracteristicas.Id('nombre')).val()==''){
              Caracteristicas.showMessageError('Debe llenar el nombre !! ');
          }else if(vector.length==0){
              Caracteristicas.showMessageError('Debe registrar al menos una Caracteristica... !! ');
          }else{
              Caracteristicas.showMessageError('Debe seleccionar una Opcion !!');
          }
        }
    
   
  return error;
   }

