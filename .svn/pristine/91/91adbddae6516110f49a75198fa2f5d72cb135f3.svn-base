var Productonota = new Object();
Productonota.__proto__ = SystemWindow;
//ACCIONES DE FORMULARIO [this.action=create/update/delete/show/annul]
//variables
Productonota.nameView = "Productonota";
Productonota.url = "Productonota";
Productonota.idproductoGridKardex = 0; // Al hacer click en el Grid de items del formulario "kardex" va ser asignado a esta variable
Productonota.idproductoGridKardexValorado = 0; // Al hacer click en el Grid de items del formulario "kardexvalorado" va ser asignado a esta variable

//funciones
Productonota.init = function () {
    try {
        var THIS = this;
        this.showWarning = false;
        
        if (this.action == 'Kardex')
        {
            $('#' + this.Id('producto')).attr('disabled', true);
            $('#btnBuscarProductos').attr('disabled', true);
            
            $('#' + this.Id("idalmacen")).change(function () {
                if($(this).val() == '')
                {
                    $('#' + THIS.Id('producto')).attr('disabled', true);
                    $('#btnBuscarProductos').attr('disabled', true);
                }
                else
                {
                    $('#' + THIS.Id('producto')).attr('disabled', false);
                    $('#btnBuscarProductos').attr('disabled', false);
                }
                $('#' + THIS.Id('producto')).val('');
                THIS.cargarProductos($(this).val(), -1);
            });
            
            $('#' + this.Id("idtipomov")).change(function () {
                THIS.cargarProductoNota(2);
            });
            $('#' + this.Id("idorigen")).change(function () {
                THIS.cargarProductoNota(2);
            });

            $('#'+this.Id('producto')).keyup(function(e){
                var k = (document.all) ? e.keyCode : e.which;
                if(k == 13) {
                    var idalmacen = $('#' + THIS.Id('idalmacen')).val();
                    var producto = $(this).val();
                    THIS.cargarProductos(idalmacen, producto);
                    THIS.cargarProductoNota(2);
                }
            });

            $('#btnBuscarProductos').click(function(){
                var idalmacen = $('#' + THIS.Id('idalmacen')).val();
                var producto = $('#' + Productonota.Id('producto')).val();
                THIS.cargarProductos(idalmacen, producto);
                THIS.cargarProductoNota(2);
            });
            
            //------------- Muestra o Oculta el div de "SALDO" -----------------
            //this.gridEventClickRow('Productonota','Productonota.showDisponible();');
            this.gridEventBlur('Productonota','Productonota.hiddenDisponible();');
        }
        
        if (this.action == 'KardexValorado')
        {
            $('#' + this.Id('productoValorado')).attr('disabled', true);
            $('#btnBuscarProductosValorado').attr('disabled', true);
                    
            $('#' + this.Id("idalmacenValorado")).change(function () {
                if($(this).val() == '')
                {
                    $('#' + THIS.Id('productoValorado')).attr('disabled', true);
                    $('#btnBuscarProductosValorado').attr('disabled', true);
                }
                else
                {
                    $('#' + THIS.Id('productoValorado')).attr('disabled', false);
                    $('#btnBuscarProductosValorado').attr('disabled', false);
                }
                $('#' + THIS.Id('productoValorado')).val('');
                THIS.cargarProductosValorado($(this).val(),-1);
            });
            
            $('#' + this.Id("idtipomov")).change(function () {
                THIS.cargarValoradoProductoNota(2);
            });
            $('#' + this.Id("idorigen")).change(function () {
                THIS.cargarValoradoProductoNota(2);
            });
            
            $('#'+this.Id('productoValorado')).keyup(function(e){
                var k = (document.all) ? e.keyCode : e.which;
                if(k == 13) {
                    var idalmacen = $('#' + THIS.Id('idalmacenValorado')).val();
                    var producto = $(this).val();
                    THIS.cargarProductosValorado(idalmacen, producto);
                    THIS.cargarValoradoProductoNota(2);
                }
            });
            
            $('#btnBuscarProductosValorado').click(function(){
                var idalmacen = $('#' + THIS.Id('idalmacenValorado')).val();
                var producto = $('#' + THIS.Id('productoValorado')).val();
                THIS.cargarProductosValorado(idalmacen, producto);
                THIS.cargarValoradoProductoNota(2);
            });
        }
    } catch (err) {
        alert('Error al cargar Productonota.init()');
    }
};

Productonota.options = function () {
    var afterFunction = '';
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    this.setActions('Kardex', {layerHeight: 356,
            WindowWidth: 1270,
            WindowHeight: 575,
            WindowTitle: 'Kardex',
            ayerEndOn: false,
            ableBackWindow: true,
            initButtons: 'back,imprimirKardexExcel,imprimirKardex',
        });
        
    this.setActions('KardexValorado', {layerHeight: 356,
            WindowWidth: 1270,
            WindowHeight: 575,
            WindowTitle: 'Kardex Valorado',
            ayerEndOn: false,
            ableBackWindow: true,
            initButtons: 'back,imprimirKardexValoradoExcel,imprimirKardexValorado',
    });

    var options = {
        idKey: idKey,
        varsSend: varsSend
    };
    return options;
}

// -----------------------------------------------------------------------------
// -------------------------------- KARDEX -------------------------------------
Productonota.Kardex = function (options) {
    this.action = 'Kardex';
    this.open(this.getOptions(options));
};

Productonota.cargarProductos = function(idalmacen, producto) {
    var url = this.urlIni+this.url+'/loadProductos';
    var THIS = this;
    var nameView = $('#' + this.Id('nameView')).val();
    var data = 'idalmacen=' + idalmacen + '&producto=' + producto + '&nameView=' + nameView + this.gestionSchemaMain() +
                '&groupForm=' + this.groupForm;
    var container = 'kardex'+'container';
    
    SystemLoad.start();
    jQuery.ajax({
        url: url, 
        type:'get',
        data:data,
        success: function (data) {
           SystemLoad.done();
          THIS.ById(container).innerHTML=data;
          THIS.runScriptAjax(data);
        },
        error: function (jqXHR, status) {  
           SystemLoad.done();
            alert('error! ');
        }
      });
};

Productonota.cargarProductoNota = function(opcion) {
    var fechaInicio = $('#' + this.Id('fechaInicio')).val();
    var fechaFin = $('#' + this.Id('fechaFin')).val();
    var origen = $('#' + this.Id('idorigen')).val();
    var movimiento=$('#' + this.Id('idtipomov')).val();
    var grid = this.getSGridView('Productos');
    var idproducto = grid.rowSelected().get('id');

    this.idproductoGridKardex = idproducto;
    if(opcion == 2)
        idproducto = this.idproductoGridKardex;
    
    var url = this.urlIni+this.url+'/loadProductoNota';
    var THIS = this;
    var data = 'idproducto=' + idproducto + '&fechaInicio=' + fechaInicio +
               '&fechaFin=' + fechaFin + '&movimiento=' + movimiento + '&origen=' + origen +
               this.gestionSchemaMain() + '&groupForm=' + this.groupForm;
    var container = 'divProductoNota';
    
    if(idproducto > 0)
    {
        SystemLoad.start();
        jQuery.ajax({
            url: url, 
            type:'get',
            data:data,
            success: function (data) {
                SystemLoad.done();
                THIS.ById(container).innerHTML=data;
                THIS.runScriptAjax(data);
                THIS.getSumatoriaKardex();
            },
            error: function (jqXHR, status) {  
               SystemLoad.done();
                alert('error! ');
            }
        });
    }
};

Productonota.getSumatoriaKardex = function(){
    this.hiddenDisponible();
    var fechaInicio = this.get('fechaInicio');
    var idProducto = this.idproductoGridKardex;
    var total;
    var THIS=this;
    if(idProducto > 0)
    { 
        $.ajax({
            url: this.urlIni + 'productonota/getSumatoriaKardex',
            method: 'get',
            data: 
            {
                fechaInicio: fechaInicio,
                idProducto: idProducto
            }
        }).done(function (resultado) {
            THIS.showDisponible(resultado);
        });
        
    }
}

Productonota.showDisponible = function(total) {
    var divTotalOrden = this.ById('divSumatoriaProductoNota');
    divTotalOrden.innerHTML = total; //parseFloat(total).toFixed(2);
    divTotalOrden.parentElement.style.visibility = 'visible';
}

Productonota.hiddenDisponible = function(){
   var divTotalOrden = this.ById('divSumatoriaProductoNota');
   divTotalOrden.parentElement.style.visibility = 'hidden';
}

Productonota.imprimirKardex = function() {
    var fechaInicio = this.get('fechaInicio');
    var fechaFin = this.get('fechaFin');
    var url = 'ReporteKardex?fechas=' + fechaInicio + '*' + fechaFin;
    this.openUrl(url);
};
Productonota.KardexValorado = function (options) {
    this.action = 'KardexValorado';
    this.open(this.getOptions(options));
};

// -----------------------------------------------------------------------------
// -------------------------- KARDEX VALORADO ----------------------------------
Productonota.KardexValorado = function (options) {
    this.action = 'KardexValorado';
    this.open(this.getOptions(options));
};

Productonota.cargarProductosValorado = function(idalmacen, producto) {
    var url = this.urlIni+this.url+'/loadProductosValorado';
    var THIS = this;
    var nameView = $('#' + this.Id('nameView')).val();
    var data = 'idalmacen=' + idalmacen + '&producto=' + producto + '&nameView=' + nameView + this.gestionSchemaMain() +
                '&groupForm=' + this.groupForm;
    var container = 'kardexValorado'+'container';    
    
    SystemLoad.start();
    jQuery.ajax({
        url: url, 
        type:'get',
        data:data,
        success: function (data) {
           SystemLoad.done();
          THIS.ById(container).innerHTML=data;
          THIS.runScriptAjax(data);
        },
        error: function (jqXHR, status) {  
           SystemLoad.done();
            alert('error! '+container);
        }
      });
};

Productonota.cargarValoradoProductoNota = function(opcion) {
    var fechaInicio = $('#' + this.Id('fechaInicio')).val();
    var fechaFin = $('#' + this.Id('fechaFin')).val();
    var origen = $('#' + this.Id('idorigen')).val();
    var movimiento=$('#' + this.Id('idtipomov')).val();
    var grid = this.getSGridView('Productos');
    var idproducto = grid.rowSelected().get('id');
    
    this.idproductoGridKardexValorado = idproducto;
    if(opcion == 2)
        idproducto = this.idproductoGridKardexValorado;
  
    var url = this.urlIni+this.url+'/loadProductoNotaValorado';
    var THIS = this;
    var data = 'idproducto=' + idproducto + '&fechaInicio=' + fechaInicio +
               '&fechaFin=' + fechaFin + '&movimiento=' + movimiento + '&origen=' + origen +
               this.gestionSchemaMain() + '&groupForm=' + this.groupForm;
    var container = 'divProductoNota';
    
    if(idproducto > 0)
    {
        SystemLoad.start();
        jQuery.ajax({
            url: url, 
            type:'get',
            data:data,
            success: function (data) {
                SystemLoad.done();
                THIS.ById(container).innerHTML=data;
                THIS.runScriptAjax(data);
                THIS.getSumatoriaKardexValorado();
            },
            error: function (jqXHR, status) {  
               SystemLoad.done();
                alert('error! ');
            }
        });
    }
};

Productonota.getSumatoriaKardexValorado = function() {
    this.hiddenDisponibleValorado();
    var fechaInicio = this.get('fechaInicio');
    var idProducto = this.idproductoGridKardexValorado;
    var total;
    var THIS = this;
    if(idProducto > 0)
    { 
        $.ajax({
            url: this.urlIni + 'productonota/getSumatoriaKardexValorado',
            method: 'get',
            data: 
            {
                fechaInicio: fechaInicio,
                idProducto: idProducto
            }
        }).done(function (resultado) {
            THIS.showDisponibleValorado(resultado);
        });
        
    }
}

Productonota.showDisponibleValorado = function(total) {
    var divTotalOrden = this.ById('divSumatoriaProductoNotaValorado');
    divTotalOrden.innerHTML = total; //parseFloat(total).toFixed(2);
    divTotalOrden.parentElement.style.visibility = 'visible';
}

Productonota.hiddenDisponibleValorado = function(){
   var divTotalOrden = this.ById('divSumatoriaProductoNotaValorado');
   divTotalOrden.parentElement.style.visibility = 'hidden';
}

Productonota.imprimirKardexValorado = function() {
    var fechaInicio = this.get('fechaInicio');
    var fechaFin = this.get('fechaFin');
    
    var url = 'ReporteKardexValorado?fechas=' + fechaInicio + '*' + fechaFin;
    this.openUrl(url);
};
// -----------------------------------------------------------------------------
Productonota.imprimirKardexExcel = function() {
    var fechaInicio = this.get('fechaInicio');
    var fechaFin = this.get('fechaFin');
    var url = 'ReporteKardexExcel?fechas=' + fechaInicio + '*' + fechaFin;
    this.openUrl(url);
};
Productonota.imprimirKardexValoradoExcel = function() {
    var fechaInicio = this.get('fechaInicio');
    var fechaFin = this.get('fechaFin');
    
    var url = 'ReporteKardexValoradoExcel?fechas=' + fechaInicio + '*' + fechaFin;
    this.openUrl(url);
};
eval(Productonota.globalModule());
