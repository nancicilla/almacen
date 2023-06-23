var Agrupacion = new Object();
Agrupacion.__proto__ = SystemWindow;
//variables
Agrupacion.nameView = "Agrupacion";
Agrupacion.url = "producto";
Agrupacion.idAlmacenSelec = "";
Agrupacion.correccion=false;

Agrupacion.init = function () {
    if(this.action === 'agrupacionProductoCreate')
    {
        $('#'+this.Id('producto')).keyup(function(e){
            var k = (document.all) ? e.keyCode : e.which;
            if(k!=37 && k!=38  && k!=39  && k!=40  && k!=13  && k!=9) {
                Agrupacion.set('idproductogrupo', '');
                Agrupacion.ById('producto').style.background="";
            }
        });
        $('#'+this.Id('producto')).blur(function(){
            if(Agrupacion.get('idproductogrupo') == ''){
                this.value = '';
                Agrupacion.ById('producto').style.background="";
            }
        });
    }
    
    if(this.action == 'agrupacionProductoUpdate')
    {
        this.gridSearchVars('gridAgrupacionproducto', '&precio=' + this.get('precio') + '&idproductoPadre=' + this.get('idproductogrupo'));
    }
}
Agrupacion.options = function() {
    this.setActions('agrupacionProductoCreate', {
        WindowTitle: 'Crear Agrupación Productos',
        initButtons: 'save,cancel',
        endButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('agrupacionProductoUpdate', {
        WindowTitle: 'Modificar Agrupación Productos',
        initButtons: 'save,cancel',
        endButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Agrupacion',
        WindowWidth: 800,
        WindowHeight: 380,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Agrupacion.beforeAgrupacionProductoCreate = function() {
    var error = false;//false es no existe error antes de crear formulario
    
    return error;
}
Agrupacion.agrupacionProductoCreate = function() {
    this.action = 'agrupacionProductoCreate';
    var options = this.getOptions();
    this.open(options);
}
Agrupacion.afterAgrupacionProductoCreate = function() {
    Agrupacion.reload();
    admAgrupacion.search();
}
Agrupacion.AgrupacionProductoUpdate = function(options) {
    this.action = 'agrupacionProductoUpdate';
    this.open(this.getOptions(options));
}
Agrupacion.afterAgrupacionProductoUpdate = function() {
    Agrupacion.closeWindow();
    admAgrupacion.search();
}
Agrupacion.setInformacionProductoPadre = function(data) {
    $('#' + this.Id("idproductogrupo")).val(data.id);
    $('#' + this.Id("precio")).val(data.precio);
    
    this.gridReset('gridAgrupacionproducto');
    this.gridSearchVars('gridAgrupacionproducto', '&precio=' + this.get('precio') + '&idproductoPadre=' + data.id);
}