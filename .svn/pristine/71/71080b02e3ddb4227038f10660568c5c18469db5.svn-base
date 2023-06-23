<div class="form">
    <?php $form=$this->beginWidget('CActiveForm'); ?>
        <div class="formWindow">
            <style>
                .ulIndice
                {   
                    list-style-type: none; 
                    margin: 0; 
                    padding: 0; 
                    margin-bottom: 10px;
                    left: 20px;
                    position: absolute;
                }
                
                .indice
                {
                    margin: 5px; 
                    padding: 5px; 
                    width: 30px;
                    height: 13.5px;
                    border-radius: 6px 6px 6px 6px;
                    background-color: #F5D6CC;
                    
                    font-weight: bold;
                    font-style: normal;;
                    letter-spacing:1px;
                    font-family: Arial;
                    font-size: 10px;
                    color: #86554A;
                }
                
                .sortable
                {
                    list-style-type: none; 
                    margin: 0; 
                    padding: 0; 
                    margin-bottom: 10px;
                    background-color: #E6F2FF;
                    left: 15px;
                    position: absolute;
                }

                .elemento
                {
                    margin: 5px; 
                    padding: 5px; 
                    width: 355px;
                    height: 13.5px;
                    border-radius: 6px 6px 6px 6px;
                    background-color: #F5D6CC;
                    cursor: pointer;
                    
                    font-weight: bold;
                    font-style: normal;;
                    letter-spacing:1px;
                    font-family: Arial;
                    font-size: 10px;
                    color: #86554A;
                }
            </style>

            <script>
                $(function() 
                {
                    $(".sortable").sortable
                    ({
                        revert: true,
                        stop: function(event, ui) 
                        {
                            var caracteristica = [], contador = 0;
                            var orden = 1;
                            $('#AlmacenListaCaracteristica').each(function()
                            {
                               $(this).find('li').each(function() {
                                    caracteristica[contador] = $(this).find('input').first().val()+"-"+orden;
                                    contador++;
                                    orden++;
                                });
                            });

                            $.post("almacen/Caracteristica/MetodoAjax",
                            {
                                caracteristica: caracteristica
                            }, 
                            function(result) 
                            {
                                //alert(result);
                            });
                        }
                    });

                    $( "ul, li" ).disableSelection();
                });
            </script>
            
            <ul class="ulIndice">
                <?php
                //for($i = 1; $i <= count($caracteristica); $i++)
                  //  echo '<li class="indice">'.$i.'</li>';
                ?>
            </ul>
            
            <ul id="AlmacenListaCaracteristica" class="sortable" style="height: 480px; overflow-y: scroll;">
                <?php
                    $posicion = 0;
                    for($i = 0; $i < count($caracteristica); $i++)
                    {
                        echo '<li class="elemento">'.
                                '<input type="hidden" value="'.$caracteristica[$i]['id'].'">'.
                                ($i + 1).': '.$caracteristica[$i]['nombre'].
                            '</li>';
                    }
                ?>
            </ul>
 
            <?php
                echo System::Buttons(
                    array(
                        'nameView' => 'Caracteristica',
                        'buttons' => array(
                            'back' => array(
                                        'align' => 'right', 
                                        //'width' => '100px', 
                                        'label' => 'Salir', 
                                        'icon' => 'arrow-left',
                                        'click' => 'Caracteristica.closeWindow(this)',
                                    ),
                        )
                    )
                );
            ?>
        </div>
    <?php $this->endWidget(); ?>
</div>