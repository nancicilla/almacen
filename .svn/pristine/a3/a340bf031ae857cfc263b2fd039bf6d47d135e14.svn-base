var Reproceso = new Object();
Reproceso.__proto__ = SystemWindow;
//variables
Reproceso.nameView = "Reproceso";
Reproceso.url = "reproceso";

Reproceso.init = function (){
    if(this.action === 'update'){
        this.gridSearchVars('gridProducto', '&idproductoPadre=' + $('#' + this.Id("idproducto")).val());
    }
}
Reproceso.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Reproceso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Reproceso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Reproceso',
        WindowWidth: 800,
        WindowHeight: 460,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
};

Reproceso.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
};
Reproceso.afterCreate = function () {
    Reproceso.reload();
};

Reproceso.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
};
Reproceso.afterUpdate = function () {
    Reproceso.closeWindow();
};
Reproceso.setInformacionProducto = function(data) {
    $('#' + this.Id("idproducto")).val(data.id);
    
    this.gridReset('gridProducto');
    this.gridSearchVars('gridProducto', '&idproductoPadre=' + data.id);
};