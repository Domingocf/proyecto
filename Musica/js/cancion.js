$(document).ready(function () {
    $(".can").addClass("act");
    $(".lis").removeClass("act");

    cargarListas();

    


    let list = "";
    let cantidadArchivos = 0;
    let song;
    let i = 0;

    $('#Cancion').on('change', function (e) {
        song = e.target.files;
        if (song) {
            cantidadArchivos = song.length;

            if (cantidadArchivos > 5) {
                alert("Error. Has seleccionado más de 5 canciones");
                return;
            }

            if (cantidadArchivos < 1) {
                alert("Error. Debes seleccionar al menos un archivo de audio/mp3 para realizar un registro.");
                return;
            }

            $('#Maximo').html(`<br>Cantidad de archivos seleccionados: ${cantidadArchivos}`);

            while (i < song.length) {
                list += `
                    <div class='col-sm-9'>
                        <div class='btn btn-default' style='width:500px; word-wrap: break-word;overflow:auto'>
                            <b>
                                <span class='glyphicon glyphicon-music'></span> ${song[i].name} |
                                <a id='song${i}' class='btn btn-danger' style='float:right'>X</a>
                            </b>
                        </div>
                    </div>`;
                i++;
            }

            $('.DivCanciones').html(list + "<br><br><br><hr>");
            i = 0;
            list = "";
        } else {
            showAlert("SELECCIONE AL MENOS UN ARCHIVO MP3", "error");
        }
    });

    $("#Registrar").on("submit", function (e) {
        e.preventDefault();

        const categoria = $('#categoria').val();
        const accion = "registrar";
        const formData = new FormData(document.getElementById("Registrar"));

        $.ajax({
            url: `../../php/EjecutarQuery.php?accion=${accion}&CantidadA=${cantidadArchivos}&categoria=${categoria}`,
            type: "POST",
            dataType: "HTML",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (response) {
            if (response == 1) {
                showAlert("NO SE PUDO REGISTRAR", "error");
                return false;
            }

            resetForm();
            showAlert("REGISTRADO CON ÉXITO", "success");
        }).fail(function (error) {
            console.error(error);
            showAlert("NO SE PUDO REGISTRAR", "error");
        });
    });

    $('#GuardarLista').click(function () {
        const accion = "addLista";
        const lista = $('#nombreLista').val();

        if (!lista) {
            alert("Ingrese lista");
            return;
        }

        $.ajax({
            url: `../../php/EjecutarQuery.php?accion=${accion}&lista=${lista}&username=${username}`,
            type: "POST",
            dataType: "HTML",
            cache: false,
            contentType: false,
            processData: false
        }).done(function (response) {
            alert("LISTA REGISTRADA EXITOSAMENTE");
            $('#Lista').html(response);
            $('#iframe').html(response);
            $('#nombreLista').val("");
            cargarListas();
        }).fail(function (error) {
            console.error(error);
            alert("Error al registrar la lista");
            
        });

        $('#addLista').modal('toggle');
    });

    $('#Establecer').click(function () {
        const idIframe = $('#filtroLista').val();
        if (idIframe) {
            const codigo = `<iframe src='iframe.php?id=${idIframe}'></iframe>`;
            alert(`CODIGO: ${codigo}`);
        } else {
            alert("SELECCIONE UNA LISTA DE REPRODUCCIÓN");
        }
    });

    $("#Cancelar").click(function () {
        resetForm();
    });

    $('#filtroLista').change(function () {
        const idLista = $('#filtroLista').val();
        $('#plList').html("");

        const accion = "mostrar";

        $.ajax({
            url: `../../php/EjecutarQuery.php?accion=${accion}&ListaID=${idLista}`,
            type: "POST",
            dataType: "HTML",
            cache: false,
            processData: false,
            success: function (data) {
                const tracks = JSON.parse(data);
                initializePlaylist(tracks);
            }
        });
    });

   function cargarListas() {
    const accion = "lista";

    $.ajax({
        url: `../../php/EjecutarQuery.php?accion=${accion}`,
        type: "POST",
        dataType: "json", 
        success: function (rows) {
            let options = "<option value=''>SELECCIONAR LISTA</option>";

            rows.forEach(row => {
                options += `<option value='${row.id}'>${row.lis_nombre}</option>`;
            });

            $('#Lista').html(options);
            $('#filtroLista').html(options);
            $('#iframe').html(options);
        },
        error: function (xhr, status, error) {
    console.error("Estado:", status);
    console.error("Error:", error);
    console.error("Respuesta del servidor:", xhr.responseText);
    alert("No se pudieron cargar las listas. Detalles en consola.");
}

    });
}


    function resetForm() {
        $('#Artista').val("");
        $('#Album').val("");
        $('#Cancion').val("");
        $('#nombreCancion').html("No hay archivo seleccionado");
        $('.DivCanciones').html("");
        $('#Maximo').html("<br>Seleccione un máximo de 10 canciones");
    }

    function showAlert(message, type) {
        const alertClass = type === "success" ? "#0AC847" : "#EE7F6F";
        $('.AlertaE').html(`
            <div class='alerta' style='background: ${alertClass}; padding: 0.01%; color: #000'>
                <center><h4><b>${message}</b></h4></center>
            </div>
        `);
        setTimeout(() => $(".AlertaE").fadeOut(1500), 3000);
    }

    function initializePlaylist(tracks) {
        if (!Array.isArray(tracks) || tracks.length === 0) {
            $('#plList').html("<div class='playlist-track'>No hay canciones en esta lista.</div>");
            $('#audio1').attr('src', ''); // Limpia el reproductor
            $('#npTitle').text('');
            return;
        }

        let html = "";
        tracks.forEach((track, idx) => {
            html += `
                <div class='playlist-track' data-src='../CANCIONES/audio/${track.archivo}' data-title='${track.nombre}'>
                    <span class='glyphicon glyphicon-music'></span>
                    <b>${track.nombre}</b> - ${track.size} 
                </div>
            `;
        });

        $('#plList').html(html);

        // Reproduce la primera canción por defecto
        $('#audio1').attr('src', `../CANCIONES/audio/${tracks[0].archivo}`);
        $('#npTitle').text(tracks[0].nombre);

        // Evento click para cada canción
        $('.playlist-track').click(function () {
            
        });
    }
});
