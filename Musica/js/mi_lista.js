$('.btnEscuchar').click(function () {
    // Obtener el ID de la lista del atributo 'data-idLista'
    var idLista = $(this).data('idlista');  // Utilizando jQuery para acceder a 'data-idLista'
 
    const datos = document.getElementById('datosSesion');
   function getUsername() {
    $.ajax({
        url: "../php/EjecutarQuery.php?accion=obtenerUsername&idLista="+idLista,
        type: "post",
        async: false, // Hacer la solicitud síncrona 
        success: function (response) {
            username = response.trim(); // Almacenar el nombre de usuario
        },
        error: function (xhr, status, error) {
            console.error("❌ Error al obtener el nombre de usuario:", status, error);
            alert("Error al obtener el nombre de usuario.");
        }
    });
    return username;   
   } 
    var username = getUsername();
username = username.replace(/"/g, "");

    $.ajax({
        url: "../php/EjecutarQuery.php?accion=cargarCancionesLista&idLista=" + idLista + "&username=" + username,
        type: "post",
        success: function (dato) {
            // Parsear respuesta JSON desde PHP
            var tracks;
            try {
                tracks = JSON.parse(dato);
            } catch (e) {
                console.error("❌ Error al parsear las canciones:", e);
                console.log("Respuesta del servidor:", dato);
                alert("Error: no se pudieron cargar las canciones correctamente.");
                return;
            }

            // Guardar las canciones en sessionStorage si lo deseas
            sessionStorage.setItem("canciones", JSON.stringify(tracks));

            // Verificar si el navegador soporta audio HTML5
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (!supportsAudio) {
                alert("Tu navegador no soporta audio HTML5.");
                return;
            }

            // Variables iniciales para el reproductor
            var index = 0,
                playing = false,
                mediaPath = '../VIEWS/CANCIONES/audio/',
                extension = '',
                npAction = $('.info'),
                npTitle = $('#npTitle'),
                audio = $('#audioPlayer').unbind()
                    .bind('play', function () {
                        playing = true;
                        npAction.text('🎵 Reproduciendo...');
                    })
                    .bind('pause', function () {
                        playing = false;
                        npAction.text('⏸️ Pausado...');
                    })
                    .bind('ended', function () {
                        npAction.text('✅ Finalizado');
                        if ((index + 1) < tracks.length) {
                            index++;
                            loadTrack(index);
                            audio.play();
                        } else {
                            index = 0;
                            loadTrack(index);
                        }
                    })
                    .get(0);

            if (!audio) {
                console.error("❌ No se encontró el elemento #audioPlayer en el DOM.");
                alert("Error al cargar el reproductor de audio.");
                return;
            }


            // Función para cargar una pista
            var loadTrack = function (id) {
                if (!tracks[id]) {
                    console.error("❌ No existe el índice de pista:", id);
                    return;
                }

                npTitle.text(tracks[id].can_titulo);
                index = id;
                audio.src = mediaPath + tracks[id].can_titulo ;
            };

            // Cargar la primera pista
            loadTrack(index);

            // Botón anterior
            $('#btnPrev').click(function () {
                if ((index - 1) >= 0) {
                    index--;
                    loadTrack(index);
                    if (playing) audio.play();
                }
            });

            // Botón siguiente
            $('#btnNext').click(function () {
                if ((index + 1) < tracks.length) {
                    index++;
                    loadTrack(index);
                    if (playing) audio.play();
                }
            });

            // Reproducir canción al hacer clic en la tarjeta
            $('.cancion-card').click(function () {
                var audioId = $(this).data('audio');  // Ej: "audio0"
                var clickedIndex = parseInt(audioId.replace('audio', ''));  // Ajustar índice si es necesario
                clickedIndex = clickedIndex - 1;  // Ajuste del índice para el array

                if (!isNaN(clickedIndex) && clickedIndex < tracks.length) {
                    loadTrack(clickedIndex);
                    audio.play();
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("❌ Error AJAX:", status, error);
            alert("Error al cargar las canciones desde el servidor.");
        }
    });
});
