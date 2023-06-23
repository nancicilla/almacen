var Temporada = new Object();
Temporada.__proto__ = SystemWindow;
//variables
Temporada.nameView = "Temporada";
Temporada.url = "temporada";

Temporada.init = function () {
    
}
Temporada.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Temporada',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Temporada',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Temporada',
        WindowWidth: 800,
        WindowHeight: 500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Temporada.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Temporada.afterCreate = function () {
    Temporada.closeWindow();
}

Temporada.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Temporada.afterUpdate = function () {
    Temporada.closeWindow();
}

Temporada.verificarHabilitacionVentaTPV = function() {
    var grid = this.getSGridView('gridTemporadaproducto');
    
    for(var f = 1; f <= grid.rows; f++)
    {
        if(grid.row(f).get('ventatpvHidden') == 1)
            grid.row(f).set('ventatpv', 1);
        else
            grid.row(f).set('ventatpv', 0);
    }
}