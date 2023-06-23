var ActualizaKardexAlmacen = new Object();
ActualizaKardexAlmacen.__proto__ = SystemWindow;
//variables
ActualizaKardexAlmacen.nameView = "ActualizaKardexAlmacen";
ActualizaKardexAlmacen.url = "producto";
//2CHOSMA001,2CHOLES001,2CHOAMG001,,2CHOSAB001
ActualizaKardexAlmacen.codigoproductokdm = '2CH-OSAB001-';
ActualizaKardexAlmacen.copyToClipboard=function(element) {
    //var element=$("#"+ide);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).attr( "titleattr" )).select();
    document.execCommand("copy");
    $temp.remove();
}
ActualizaKardexAlmacen.movimientos=[];
ActualizaKardexAlmacen.costosproductos=[];//<--costos actualizados de los productos

ActualizaKardexAlmacen.init = function () {
    SystemLoad.start();
    ActualizaKardexAlmacen.movimientos=[];
    ActualizaKardexAlmacen.costosproductos=[];   
ActualizaKardexAlmacen.rimificarModificarYMostrarKD = function(){
    
    $.post( "almacen/producto/ObtenerCostoInicialProducto?codigoproductokdm="+ActualizaKardexAlmacen.codigoproductokdm, function( data ) {
        ActualizaKardexAlmacen.costosproductos.push(data);
    });
    //
    //ActualizaKardexAlmacen.generarArbol([{key:5,txt:'hijo5 padre4 ',parent:4},{key:2,txt:'hijo2 padre1 ',parent:1},{key:4,txt:'hijo4 padre2',parent:2},{key:3,txt:'hijo3 padre1',parent:1},{key:1,txt:'padre'}]);
    $.post( "almacen/producto/ArbolMovimientoOrdenesProduccion?codigoproductokdm="+ActualizaKardexAlmacen.codigoproductokdm, function( data ) {
        var dataoriginal = data.slice();
        ActualizaKardexAlmacen.generarArbolList(data.slice());
        ActualizaKardexAlmacen.generarArbol(data);        
        var i=0;
        var modkdporc=0;
        $('#actualizarKardexProductoAlmacenCantidad').html('0/'+dataoriginal.length);
        var ramificar = function(){
            modkdporc=(i/dataoriginal.length)*100;
            $('#actualizarKardexProductoAlmacenCantidad').html(''+i+'/'+dataoriginal.length+"<>"+modkdporc.toFixed(2)+"%");
            
            if(i>=dataoriginal.length){
                SystemLoad.done(); 
                ActualizaKardexAlmacen.cambiarKardex(ActualizaKardexAlmacen.movimientos); 
                return;
            } 
            
            var padre = dataoriginal[i];
            if(padre.parent==undefined){                
                i++;
                ramificar();
            }else                
            if(!padre.sop || padre.idtipo!=2 || padre.costoconfirmado!=true){
                i++;
                ramificar();
            }            
            else{
            
                $.post( "almacen/producto/RamificarArbolMovimientoOrdenesProduccion?codigoproductokdm="+ActualizaKardexAlmacen.codigoproductokdm, padre)
                .done(function( dataRec ) {
                    ActualizaKardexAlmacen.generarArbolList(dataRec.slice());
                    ActualizaKardexAlmacen.generarArbol(dataRec);
                    i++;
                    ramificar();

                });
            }
            
        }
        
        ramificar();
        
    });
}
    bootbox.confirm("Se ramificará modificará y mostrará los ajustes del kardex de almacen.<br style='color:red;';><span>Está seguro que quiere continuar?</span>",function(conf){
        if(conf==true){
            ActualizaKardexAlmacen.rimificarModificarYMostrarKD();
        }
    });
    
}

/**
 * Retorna los ids de los productos a partir del array costosproductos
 */
ActualizaKardexAlmacen.obtenerArrayIDSProductos = function (){
    var arrayresp=[];
    for(var i = 0 ;i<ActualizaKardexAlmacen.costosproductos.length;i++){
        var item = ActualizaKardexAlmacen.costosproductos[i];
        arrayresp.push(item.idproducto);
    }
    return arrayresp;
}

/**
 * Busca el costo de un producto en el array de productos
 */
ActualizaKardexAlmacen.buscarCostoProducto = function (idproducto){
    for(var i = 0 ;i<ActualizaKardexAlmacen.costosproductos.length;i++){
        var item = ActualizaKardexAlmacen.costosproductos[i];
        if(item.idproducto==idproducto){
            return item;
        }
    }
    return null;
}

/**
 * Analiza y cambia el kardex, registro por registro en el arbol que se muestra
 * en el navegador. 
 */
ActualizaKardexAlmacen.cambiarKardex = function (lista){
    
    var getcolor = function (){
        return 'rgb(' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ')';
    }
    //var rand = back[Math.floor(Math.random() * back.length)];
    //var index=0;
    var ordenLista=[];//lista de claves ordenadas
        
    var eliminarRepetidosLista = function(listord,idproductonota){
        for(var i=0; i<listord.length ; i++){
            var item = listord[i];
            if(idproductonota==61841){
                var a=0;
            }
            /*if(item.sop===true && item.costoconfirmado==true){
                continue;
            }*/
            if(item.key==idproductonota){
                var longitudclave=item.keylist.length; 
                var j=i;
                var longitudclave2 = listord[j].keylist.length;
                while(longitudclave2>=longitudclave && j<listord.length){
                    
                    if(listord[j]==undefined){
                        var a=0;
                    }
                    longitudclave2 = listord[j].keylist.length;
                    
                    if(j+1<listord.length && listord[j+1].keylist.length<longitudclave){
                        listord.splice(j, 1);
                        break;
                    }
                    listord.splice(j, 1);
                }
                var a=0;
                /*for(var j=i; j<listord.length ; j++){
                    var item2 = listord[j];
                    if(){
                        
                    }
                }*/
                
                //llenarListaOrdena(item.childs,getcolor());            
            }
        }
    }
    
    var llenarListaOrdena = function(listord,colorget){
        for(var i=0; i<listord.length ; i++){        
            var item = listord[i];
            item.color = colorget;
            
            eliminarRepetidosLista(ordenLista,item.key);
            
            ordenLista.push(item);
            if(item.childs!=undefined){
                llenarListaOrdena(item.childs,getcolor());            
            }
        }
    }
    
    var extraerdatosenviar = function(itemlista){
        var obj=null;
        if(itemlista.sop){
            obj = {
            color:itemlista.color,
            key:itemlista.key,
            keylist:itemlista.keylist,
            fechamovimiento:itemlista.fechamovimiento,
            sop:itemlista.sop,
            iop:itemlista.iop,
            idproductonota:itemlista.idproductonota,
            idop:itemlista.idop,
            idnotaborrador:itemlista.idnotaborrador,
            costoconfirmado:itemlista.costoconfirmado
        };
        }else{
            obj = {
            color:itemlista.color,
            key:itemlista.key,
            keylist:itemlista.keylist,
            fechamovimiento:itemlista.fechamovimiento,
            sop:itemlista.sop,
            iop:itemlista.iop,
            idproductonota:itemlista.idproductonota
        };
        }
       
        return obj;
    }
    
    var modkdporc=0;
    
    var enviarFuncion = function(listaSend,indice){
        modkdporc=(indice/listaSend.length)*100;
        $('#actualizarKardexProductoAlmacenCantidadArbol').html('<>'+indice+'/'+listaSend.length+"<>"+modkdporc.toFixed(2)+"%");
            
        if(indice<listaSend.length){
            var item = extraerdatosenviar(listaSend[indice]);
            var costoProducto = ActualizaKardexAlmacen.buscarCostoProducto(item.idproductonota);
            if(costoProducto!=null){
                item.nuevocosto=costoProducto.costo;
            }else{
                item.nuevocosto=1;
            }
            if(item.key==42386){
                var it=0;
            }
            if(item.sop===true && item.costoconfirmado==true && item.idnotaborrador!=undefined){
                var datosmodiforden={
                    nuevocosto:item.nuevocosto,
                    idproducto:item.idproductonota,
                    idnotaborrador:item.idnotaborrador,
                    idop:item.idop
                };
                $.post( "costos/orden/ModificarCostoOP", datosmodiforden)
                .done(function( dataRec ) {   
                    if(dataRec.error===true){
                        $("#nohacer"+item.keylist).html("<span>*</span>");
                        return;
                    }
                    
                    costoProducto = ActualizaKardexAlmacen.buscarCostoProducto(dataRec.idproducto);
                    if(costoProducto!=null){
                        costoProducto.costo = dataRec.nuevocosto;
                        
                        //---item.nuevocosto = costoProducto.costo;
                        
                    }else{
                        ActualizaKardexAlmacen.costosproductos.push(
                        {
                            idproducto:dataRec.idproducto,
                            costo:dataRec.nuevocosto
                        });
                        //item.nuevocosto=dataRec.nuevocosto;
                    }                   
                    $("#costoanterior"+item.keylist).html("<span>ca:"+dataRec.costoanterior+"</span>");
                    webModfKardexREST(item,listaSend,indice);

                });
            }else{
                webModfKardexREST(item,listaSend,indice);
            }
        }else{
            var idsprod=ActualizaKardexAlmacen.obtenerArrayIDSProductos();
            $.post( "almacen/producto/ActualizarSaldosimportesProductosAlmacen", {idsproductos:idsprod})
            .done(function( dataRec ) {
                bootbox.alert(dataRec.mensaje);
            });
        }
    }
    
    var webModfKardexREST = function (itemparam,listaSend,indice){
        
        $.post( "almacen/producto/AjustarMovimientoAlmacen", itemparam)
                .done(function( dataRec ) {                        

                    $('#estadosListaActualizaKardexAlmacen'+itemparam.keylist).css({'background':itemparam.color});
                    if(dataRec.error===true){
                        $("#modkx"+itemparam.keylist).html("<span>error:"+dataRec.mensaje+"</span>");
                        return;
                    }else{
                        $("#modkx"+itemparam.keylist).html(dataRec.movimientohtml);
                        $("#newc"+itemparam.keylist).html(dataRec.nuevocosto);
                        $("#newUppMkd"+itemparam.keylist).html(dataRec.uppp);//
                        $("#salantmk"+itemparam.keylist).html(dataRec.saldoimporteanterior);
                        $("#idpnantmk"+itemparam.keylist).html(dataRec.idproductonotaanterior);
                        //
                    }

                    enviarFuncion(listaSend,indice+1);

                });
    }
    
    llenarListaOrdena(lista,getcolor());
    
    enviarFuncion(ordenLista,1);//<-- Comenzamos porque 0 es la raiz
    
}

/**
 * Busca una clave en el arbol
 */
ActualizaKardexAlmacen.searchOnKeylist = function (lista,keylist){
    
    for(var i=0; i<lista.length ; i++){        
        var item = lista[i];        
        if(item.keylist == keylist){            
            return item;
        }else{
            if(item.childs!=undefined){
                var resp = ActualizaKardexAlmacen.searchOnKeylist(item.childs,keylist);
                if(resp == null){
                    continue;
                }else{
                    return resp;
                }
            }
        }
    }
    return null;
}
ActualizaKardexAlmacen.generarArbolList = function (dataParam){
    var data = dataParam; 
    var i=0;
    while(data.length>0){
        var item = data[i];
        if(item==undefined){
            var as=0;
        }
        if(item.parent==undefined){
            ActualizaKardexAlmacen.movimientos.push(item);
            data.splice(i, 1);
            i=0;
            continue;
        }
        //buscamos el item con la clave
        var listpadre = ActualizaKardexAlmacen.searchOnKeylist(ActualizaKardexAlmacen.movimientos,item.parent);//divprincipal.find('#listaActualizaKardexAlmacen'+item.parent);   
        if(listpadre == null){
            i++; continue;
        }
       // var list = listpadre..last();  
        if(listpadre.childs==undefined){
            listpadre.childs = [];
        }
        listpadre.childs.push(item);
        data.splice(i, 1);
        i=0;
    }
}
/**
 * Agrega un array de hijos a la lista ActualizaKardexAlmacen.movimientos
 * Dependiendo del id padre que se le envie
 */
/*ActualizaKardexAlmacen.appendChildToList = function (arrayPrincipal,arrayChilds,keyparent){
    for(var i=0; i<arrayPrincipal.length ; i++){
        var item = arrayPrincipal[i];
        if(item.keylist == keyparent){
            item.childs=arrayChilds;
            return;
        }else{
            if(item.childs!=undefined){
                ActualizaKardexAlmacen.appendChildToList(item.childs,arrayChilds,keyparent);
            }else{
                item.childs=[];
            }
        }
    }
}*/
//:;
ActualizaKardexAlmacen.generarArbol = function (dataParam){
    var data = dataParam;
    var divprincipal=$("#actualizarKardexProductoAlmacen");
    
    var i=0;
    while(data.length>0){
        var item = data[i];        
        if(item.parent==undefined){
            var list = divprincipal.append("<ul class='listaActualizaKardexAlmacen'></ul>").find('ul');   
            list.append("<li id='listaActualizaKardexAlmacen"+item.keylist+"'>"+item.txt+'</li>');
            data.splice(i, 1);
            i=0;
            //item.childs=[];
            //ActualizaKardexAlmacen.movimientos.push(item);            
            continue;
        }
        var listpadre = divprincipal.find('#listaActualizaKardexAlmacen'+item.parent);   
        if(listpadre.length == 0){
            i++; continue;
        }
        var list = listpadre.append("<ul class='listaActualizaKardexAlmacen'></ul>").find('ul').last();   
        list.append("<li id='listaActualizaKardexAlmacen"+item.keylist+"'>"+ActualizaKardexAlmacen.agregarDivs(item)+'</li>');
        data.splice(i, 1);
        i=0;
    }
    
//    $('.listaActualizaKardexAlmacen').css('margin-left', '20px');
//    $('.listaActualizaKardexAlmacen').css('padding', '0px');
//    $('.contenidoListaActualizarAlmacen').css('display', 'inline');
//    $('.contenidoListaActualizarAlmacen').css('margin-right', '5px');
    
//    $('.iconIngresoActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(0,0));
//    $('.iconSalidaActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(-15,0));
//    $('.iconIngresoOActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(-30,0));
//    $('.iconSalidaOActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(-45,0));
//    //$('.iconIngresoOActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssAnimation());
//    //$('.iconSalidaOActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssAnimation());
//    $('.iconFechaActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(0,-15));
//    $('.iconNotaActualizarAlmacenKardex').css(ActualizaKardexAlmacen.generateCssIcon(-15,-15));
//    
    
    
//$('.listitemListaActualizarAlmacen').css('float', 'left');
    //$('.listitemListaActualizarAlmacen').css('display', 'list-item');
}
ActualizaKardexAlmacen.generateCssIcon = function(x,y){
    return {
        'display':'inline-block',
        'height':'15px',
        'width':'15px',
        'background-image':'url(images/modules/almacen/iconosmodkardex.png)',
        //'background-size':'cover',
        'background-repeat':'no-repeat',
        'background-position':''+x+'px '+y+'px'
    };    
}
ActualizaKardexAlmacen.generateCssAnimation = function(){
    return {
        '-webkit-animation':'fadeInFromNone 0.5s infinite alternate',
        '-moz-animation':'fadeInFromNone 0.5s infinite alternate',
        '-o-animation':'fadeInFromNone 0.5s infinite alternate',
        'animation':'fadeInFromNone 0.5s infinite alternate'
    };    
}
ActualizaKardexAlmacen.agregarDivs = function(item){
    //costo anterior, amarillo 
    //modificar orden de producción, celeste
    //modificar kardex, naranja
    //nuevo costo, verde
    //no hacer nada, rojo
    var iconIngreso = "";
    var iconSalida = "";
    var iconSalidaO = "<div class='iconSalidaOActualizarAlmacenKardex'></div>";
    var iconIngresoO = "<div class='iconIngresoOActualizarAlmacenKardex'></div>";
    if(item.idtipo==1){
        if(item.iop)
            iconIngreso = "<div class='iconIngresoActualizarAlmacenKardex'></div>";
        else{
            iconIngreso = iconIngresoO;
        }
    }
    if(item.idtipo==2){
        if(item.sop){
            var itemop = "idop:"+item.idop+" idprod:"+item.idproductonota+" idnb:"+item.idnotaborrador;
            iconSalida = "<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+itemop+"' title='Salida OP' class='iconSalidaActualizarAlmacenKardex'></div>";
        }else{
            iconSalida = iconSalidaO;
        }
        
    }
    
    
    
    var iconFecha = "<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.fechamovimiento+"' title='fecha movimiento:<"+item.fechamovimiento+">' class='iconFechaActualizarAlmacenKardex'></div>";
    var iconFechacierrre = "";
    if(item.costoconfirmado===true){
        iconFechacierrre = "<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.fechacierre+"' title='fecha cierre:<"+item.fechacierre+">' class='iconFechaActualizarAlmacenKardex'></div>";
    }
    var iconNota = "<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.glosa+"' title='"+item.glosa+"' class='iconNotaActualizarAlmacenKardex'></div>";
    var idlist=item.keylist;
    var textoKey="<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.key+"' title='idproductonota:<"+item.key+">'  class='contenidoListaActualizarAlmacen' id='keyActualizarAlmacen"+idlist+"'>"+item.key+"</div>";
    var textoIdP="<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.idproductonota+"' title='idproducto en productonota:<"+item.idproductonota+">'  class='contenidoListaActualizarAlmacen' id='idProductoActualizarAlmacen"+idlist+"'>IdProducto:"+item.idproductonota+"</div>";
    var texto="<div onclick='ActualizaKardexAlmacen.copyToClipboard(this)' titleattr='"+item.txt+"' title='cod:"+item.txt+"'  class='contenidoListaActualizarAlmacen' id='textoListaActualizarAlmacen"+idlist+"'>"+item.txt+"</div>";
    var costoanterior="<div title='costo anterior' class='contenidoListaActualizarAlmacen' id='costoanterior"+idlist+"'></div>";
    var modop="<div class='contenidoListaActualizarAlmacen' id='modop"+idlist+"'>mop</div>";
    var modkx="<div class='contenidoListaActualizarAlmacen' id='modkx"+idlist+"'>modkx</div>";
    var newc="<div class='contenidoListaActualizarAlmacen' title='Costo con el que se calculó' id='newc"+idlist+"'></div>";
    var uppp="<div class='contenidoListaActualizarAlmacen' title='UltimoPPP' id='newUppMkd"+idlist+"'></div>";
    var saldoAnterior="<div class='contenidoListaActualizarAlmacen' title='Saldo importe anterior' id='salantmk"+idlist+"'></div>";
    var idproductonotant="<div class='contenidoListaActualizarAlmacen' title='idproductonota anterior' id='idpnantmk"+idlist+"'></div>";
    var nohacer="<div class='contenidoListaActualizarAlmacen' id='nohacer"+idlist+"'>no</div>";
    return "<div class='listitemListaActualizarAlmacen' id='estadosListaActualizaKardexAlmacen"+idlist+"'>"+
            iconSalida+iconIngreso+iconNota+iconFecha+iconFechacierrre+
            textoKey+
            textoIdP+
            texto+
            costoanterior+
            modop+
            modkx+
            newc+
            uppp+
            saldoAnterior+
            idproductonotant+
            nohacer+"</div>";
    //return "<div><div>xtt1</div><div>ghsdg2</div></div>";
}

ActualizaKardexAlmacen.options = function () {   
    this.setActions('actualizarKardexProducto', {
             layerHeight: 356,
             WindowWidth: 1100,
             WindowHeight: 600,
             WindowTitle: 'Actualizar Kardex Producto',   
             initButtons: 'cancel',
             layerEndOn: false,
             ableBackWindow: true
    });
   
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Actualiza',
        WindowWidth: 930,
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


ActualizaKardexAlmacen.actualizarKardexProducto = function(){
    this.action = 'actualizarKardexProducto';
    this.open(this.getOptions());
}