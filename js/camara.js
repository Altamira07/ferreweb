 window.URL = window.URL || window.webkitURL;
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || function(){alert('Su navegador no soporta navigator.getUserMedia().');};
        
        jQuery(document).ready(function(){
            window.datosVideo = {
                'StreamVideo': null,
                'url' : null
            };
            
            jQuery('#botonIniciar').on('click', function(e){
                //Pedimos al navegador que nos de acceso a
                //algún dispositivo de video (la webcam)
                navigator.getUserMedia({'audio':false, 'video':true}, function(streamVideo){
                    datosVideo.StreamVideo = streamVideo;
                    datosVideo.url = window.URL.createObjectURL(streamVideo);
                    jQuery('#camara').attr('src', datosVideo.url);
                }, function(){
                    alert('No fue posible obtener acceso a la cámara.');
                });
            });
         
            jQuery('#botonDetener').on('click', function(e){
                if(datosVideo.StreamVideo){
                    datosVideo.StreamVideo.stop();
                    window.URL.revokeObjectURL(datosVideo.url);
                };
            });
            $(".btn-foto" ).live( "click", function(e) {
            //jQuery('.btn-foto').on('click', function(e){
                 //alert('hola');
                 //alert($(this).attr("data"));
                 $("#email").val($(this).attr("data"));
                 $("#nombre").text($(this).attr("data2"));
            });

            jQuery('#botonFoto').on('click', function(e){
                //alert('Tomando foto');
                var oCamara,
                    oFoto,
                    oContexto,
                    w, h;
                     
                oCamara = jQuery('#camara');
                oFoto = jQuery('#foto');
                w = oCamara.width();
                h = oCamara.height();
                oFoto.attr({'width': w, 'height': h});
                oContexto = oFoto[0].getContext('2d');
                oContexto.drawImage(oCamara[0], 0, 0, w, h);

                var canvas = document.getElementById("foto");
                var img    = canvas.toDataURL("image/jpeg");
                email = $("#email").val();

                $.ajax({
                    type: "POST",
                    url: "inserta_camara.php",
                    data: { email: email, foto: img }
                    })
                    .done(function( msg ){
                        $("#consola").html("<pre>"+msg);
                });


                
            });


        });
