const buscador = document.getElementById("buscador");

buscador.addEventListener("input", function (e) {
    const palabra = e.target.value.trim();

    const contenedor = document.getElementById("listaCanciones");

    // Petición AJAX al servidor
    $.ajax({
        url: "../php/EjecutarQuery.php?accion=buscar&palabra="+palabra,
        type: "POST",

        success: function (dato) {
            tracks=JSON.parse(dato)
            contenedor.innerHTML = ""; // limpiar antes de mostrar

            if (!Array.isArray(tracks) || tracks.length === 0) {
                contenedor.innerHTML = "<p>No se encontraron resultados</p>";
                return;
            }

            tracks.forEach((cancion, i) => {
                const id = cancion.id;
                const audioId = 'audio' + id;

                const divCol = document.createElement("div");
                divCol.className = "col-md-4 mb-4";
                divCol.setAttribute("data-index", i);

                divCol.innerHTML = `
                    <div class="card h-100 cancion-card" data-audio="${audioId}" style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <span style="font-size:24px;margin-right:10px;">&#127925;</span>
                                ${cancion.can_titulo}
                            </h5>
                            <a href="../include/funciones.php?favorito=${id}">♥️</a>
                            <a href="../include/funciones.php?viewcomentar=${id}">📝</a>
                            <a href="../include/funciones.php?viewañadir=${id}">➕</a>
                        </div>
                    </div>`;

                contenedor.appendChild(divCol);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error AJAX buscador:", error);
        }
    });
});


document.getElementById("generos").addEventListener("click", function (e) {
    if (e.target.tagName === "BUTTON") {
        const cat = e.target.textContent.trim();  // Texto del botón pulsado

        // Buscar por categoría
        $.ajax({
            url: "../php/EjecutarQuery.php?accion=filtrar&cat=" + encodeURIComponent(cat),
            type: "POST",
            success: function (dato) {
                let tracks;
                try {
                    tracks = JSON.parse(dato);
                    console.log("Canciones recibidas:", tracks);
                } catch (err) {
                    console.error("❌ Error al parsear las canciones:", err);
                    console.log("Respuesta del servidor:", dato);
                    alert("Error: no se pudieron cargar las canciones correctamente.");
                    return;
                }

                const contenedor = document.getElementById("listaCanciones");
                contenedor.innerHTML = ""; // Limpiar antes de insertar

                tracks.forEach(cancion => {
                    const id = cancion.id;
                    const audioId = 'audio' + id;

                    const divCol = document.createElement("div");
                    divCol.className = "col-md-4 mb-4";

                    divCol.innerHTML = `
        <div class="card h-100 cancion-card" data-audio="${audioId}" style="cursor:pointer;">
            <div class="card-body">
                <h5 class="card-title">
                    <span style="font-size:24px;margin-right:10px;">&#127925;</span>
                    ${cancion.can_titulo}
                </h5>
                <a href="../include/funciones.php?favorito=${id}">♥️</a>
                <a href="../include/funciones.php?viewcomentar=${id}">📝</a>
                <a href="../include/funciones.php?viewañadir=${id}">➕</a>
            </div>
        </div>`;

                    contenedor.appendChild(divCol);
                });

            },
            error: function (xhr, status, error) {
                console.error("❌ Error en la petición AJAX:", error);
            }
        });
    }
});



$(window).on('load', function () {
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
    // Intervalo para reproducir anuncios (en milisegundos)
    const adInterval = 50000;
    let ads = [];

    $(Window).one('click', () => {
        // Aquí ya se puede reproducir audio y anuncios sin problema

        $.ajax({
            url: "../php/EjecutarQuery.php?accion=cargarAnuncios",
            type: "post",
            success: function (dato) {
                try {
                    ads = JSON.parse(dato);
                } catch (e) {
                    console.error("❌ Error al parsear anuncios:", e);
                    console.log("Respuesta del servidor:", dato);
                    return;
                }
                // Guardar en sessionStorage si quieres persistirlo
                sessionStorage.setItem("ads", JSON.stringify(ads));

                setInterval(() => {
                    let n_anuncio = Math.floor(Math.random() * 3) + 1;
                    // Cargar anuncio
                    audio.src = '../VIEWS/CANCIONES/ads/' + ads[n_anuncio].can_titulo;
                    audio.play().catch(err => console.error("Error al reproducir anuncio:", err));


                }, adInterval);
            },
            error: function (xhr, status, error) {
                console.error("❌ Error AJAX anuncios:", status, error);
            }
        });

        // audio.play().catch(err => console.error(err));
    });




    $.ajax({
        url: "../php/EjecutarQuery.php?accion=cargarCanciones",
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

            // Guardar en sessionStorage si quieres persistirlo
            sessionStorage.setItem("canciones", JSON.stringify(tracks));

            // Verificar soporte de audio
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (!supportsAudio) {
                alert("Tu navegador no soporta audio HTML5.");
                return;
            }

            // Variables iniciales
            var index = 4,
                playing = false,
                mediaPath = '../VIEWS/CANCIONES/audio/',
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

            // Detectar formato de audio soportado
            extension = audio.canPlayType('audio/mpeg') ? '.mp3' :
                audio.canPlayType('audio/ogg') ? '.ogg' : '';

            // Función para cargar una pista
            var loadTrack = function (id) {
                if (!tracks[id]) {
                    console.error("❌ No existe el índice de pista:", id);
                    return;
                }

                npTitle.text(tracks[id].can_titulo);
                index = id;
                audio.src = mediaPath + tracks[id].can_titulo;
            };

            // Cargar la primera pista
            loadTrack(index - 4);

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

            // Reproducir canción al hacer clic en la tarjeta (delegación de eventos)
            $('#listaCanciones').on('click', '.cancion-card', function () {
                var audioId = $(this).data('audio'); // ej: "audio0"

                var clickedIndex = parseInt(audioId.replace('audio', ''));

                clickedIndex = clickedIndex - 4; // Ajustar índice para que coincida con el array (si es necesario)
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
