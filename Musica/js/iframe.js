$(document).ready(function () {
    cargarLista();

    function cargarLista(idLista) {
        $('#idHidden').val(idLista);
        $('#plList').html("");

        $.ajax({
            url: "../../php/EjecutarQuery.php?accion=mostrar&ListaID=" + idLista,
            type: "post",
            success: function (dato) {
                DATO = JSON.parse(dato);
                var supportsAudio = !!document.createElement('audio').canPlayType;
                if (supportsAudio) {
                    var index = 0,
                        playing = false,
                        mediaPath = '../CANCIONES/audio/',
                        extension = '',
                        tracks = DATO,
                        cont = 1;
                    $.each(tracks, function (key, value) {
                        var trackNumber = cont,
                            trackName = value.nombre,
                            trackLength = '00:00';
                        if (trackNumber.toString().length === 1) {
                            trackNumber = '0' + trackNumber;
                        } else {
                            trackNumber = '' + trackNumber;
                        }
                        cont += 1;
                    });
                    var trackCount = tracks.length,
                        npAction = $('.info'),
                        npTitle = $('#npTitle'),
                        audio = $('#audio1').unbind().bind('play', function () {
                            playing = true;
                            npAction.text('Now Playing...');
                        }).bind('pause', function () {
                            playing = false;
                            npAction.text('Paused...');
                        }).bind('ended', function () {
                            npAction.text('Paused...');
                            if ((index + 1) < trackCount) {
                                index++;
                                loadTrack(index);
                                audio.play();
                            } else {
                                audio.pause();
                                index = 0;
                                loadTrack(index);
                            }
                        }).get(0),
                        btnPrev = $('#btnPrev').unbind().click(function () {
                            if ((index - 1) > -1) {
                                index--;
                                loadTrack(index);
                                if (playing) {
                                    audio.play();
                                }
                            } else {
                                audio.pause();
                                index = 0;
                                loadTrack(index);
                            }
                        }),
                        btnNext = $('#btnNext').unbind().click(function () {
                            if ((index + 1) < trackCount) {
                                index++;
                                loadTrack(index);
                                if (playing) {
                                    audio.play();
                                }
                            } else {
                                audio.pause();
                                index = 0;
                                loadTrack(index);
                            }
                        }),
                        li = $('#plList li').unbind().click(function () {
                            var id = parseInt($(this).index());
                            if (id !== index) {
                                playTrack(id);
                            }
                        }),
                        li = $('.playlist-track').click(function () {
                            var id = parseInt($(this).index());
                            if (id !== index) {
                                playTrack(id);
                            }
                        })
                        loadTrack = function (id) {
                            try {
                                $('.plSel').removeClass('plSel');
                            $('#plList li:eq(' + id + ')').addClass('plSel');
                            npTitle.text(tracks[id].nombre);
                            index = id;
                            audio.src = mediaPath + tracks[id].nombre;
                            } catch (error) {
                                
                            }
                        },
                        playTrack = function (id) {
                            loadTrack(id);
                            audio.play();
                        };
                    extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
                    loadTrack(index);
                }
            }
        });
    }
    // Inicializa con el valor actual
    var idListaInicial = $('#idHidden').val();
    // cargarLista(idListaInicial);

    // Cuando cambias de lista en el select
    $('#filtroLista').change(function () {
        var nuevaLista = $(this).val();
        if (nuevaLista && nuevaLista !== "Seleccionar lista de reproducción") {
            cargarLista(nuevaLista);
        }
    });
});