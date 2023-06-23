var Receta = new Object();
Receta.__proto__ = SystemWindow;
//variables
Receta.nameView = "Receta";
Receta.url = "receta";

Receta.init = function(){
    $("#" + this.Id("idalmacen")).change(function () {
        $("#" + Receta.Id("producto")).autocomplete({source: 'almacen/producto/autocompleteCodigoNombre?idalmacen=' + this.value});
        $("#" + Receta.Id("producto")).val('');
        $("#" + Receta.Id("idproducto")).val('');
        $("#" + Receta.Id("productoValido")).val('');
    });
    if(this.action === 'create')
    {
        $('#'+this.Id('producto')).keyup(function(e){
            var k = (document.all) ? e.keyCode : e.which;
            if(k!=37 && k!=38  && k!=39  && k!=40  && k!=13  && k!=9) {
                Receta.set('idproducto', '');
                Receta.ById('producto').style.background="";
            }
        });
        $('#'+this.Id('producto')).blur(function(){
            if(Receta.get('idproducto') == ''){
                this.value = '';
                Receta.ById('producto').style.background="";
            }
        });
    }
    if (this.action === 'update'){
        Receta.gridSearchVars('Producto','&idproductoreceta='+Receta.get('idproducto')+'&idalmacen=' + $('#' + Receta.Id('idalmacen')).val());
    }
}
Receta.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Receta',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Receta',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Receta',
        WindowWidth: 810,
        WindowHeight: 485,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Receta.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Receta.afterCreate = function () {
    Receta.reload();
}

Receta.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Receta.afterUpdate = function () {
    Receta.closeWindow();
}
