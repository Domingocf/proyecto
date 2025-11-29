document.addEventListener('DOMContentLoaded', () => {
    const listaComentarios = document.getElementById('lista-comentarios');
    const botonComentar = document.getElementById('comentar');
    const textareaPrincipal = document.getElementById('comentario');

    // Función para renderizar comentarios o respuestas
    function renderComentario(comentario, contenedor) {
        const divComentario = document.createElement('div');
        divComentario.className = 'comentario card mb-3 shadow-sm border-0';
        divComentario.dataset.id = comentario.id;

        divComentario.innerHTML = `
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">${comentario.username}</h6>
                <p class="card-text">${comentario.descripcion}</p>
                <button type="button" class="btn btn-sm btn-link responder-btn">Responder</button>
                <div class="respuestas"></div>
            </div>
        `;

        contenedor.appendChild(divComentario);

        // Si hay respuestas, renderizarlas
        if (comentario.respuestas && comentario.respuestas.length > 0) {
            const divRespuestas = divComentario.querySelector('.respuestas');
            comentario.respuestas.forEach(respHijo => {
                renderComentario(respHijo, divRespuestas);
            });
        }
    }

    // Enviar comentario principal
    botonComentar?.addEventListener('click', () => {
        const texto = textareaPrincipal.value.trim();
        if (!texto) return alert('Escribe algo antes de enviar.');

        $.ajax({
            url: '../php/EjecutarQuery.php?accion=comentar',
            type: 'POST',
            data: { comentario: texto },
            dataType: 'json',
            success: function (resp) {
                // Renderizar todos los comentarios nuevos
                listaComentarios.innerHTML = '';
                resp.forEach(comentario => renderComentario(comentario, listaComentarios));
                textareaPrincipal.value = '';
            },
            error: function (xhr) {
                console.error('Error al enviar comentario:', xhr.responseText);
            }
        });
    });

    // Delegación de eventos para botones "Responder"
    listaComentarios?.addEventListener('click', (e) => {
        if (!e.target.classList.contains('responder-btn')) return;

        const comentarioCard = e.target.closest('.comentario');
        if (comentarioCard.querySelector('.form-respuesta')) return; // evitar duplicar

        // Crear formulario de respuesta
        const formRespuesta = document.createElement('form');
        formRespuesta.className = 'form-respuesta mt-2';
        formRespuesta.innerHTML = `
            <div class="mb-2">
                <textarea class="form-control" rows="2" placeholder="Escribe tu respuesta..." required></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Responder</button>
            <button type="button" class="btn btn-sm btn-secondary ms-2 cancelar-btn">Cancelar</button>
        `;
        comentarioCard.appendChild(formRespuesta);

        // Cancelar respuesta
        formRespuesta.querySelector('.cancelar-btn').addEventListener('click', () => formRespuesta.remove());

        // Enviar respuesta
        formRespuesta.addEventListener('submit', function (ev) {
            ev.preventDefault();
            const texto = formRespuesta.querySelector('textarea').value.trim();
            if (!texto) return alert('Escribe algo antes de enviar.');

            const parentId = comentarioCard.dataset.id;

            $.ajax({
                url: '../php/EjecutarQuery.php?accion=comentar',
                type: 'POST',
                data: { comentario: texto, parent_id: parentId },
                dataType: 'json',
                success: function (resp) {
                    // Renderizar todos los comentarios incluyendo la respuesta
                    listaComentarios.innerHTML = '';
                    resp.forEach(comentario => renderComentario(comentario, listaComentarios));
                },
                error: function (xhr) {
                    console.error('Error al enviar respuesta:', xhr.responseText);
                }
            });

            window.location.reload(true); // Obsoleto, algunos navegadores lo ignoran

            formRespuesta.remove();
        });
    });


    //hacer reporte
    // Delegación de eventos para "Reportar"
    listaComentarios?.addEventListener('click', (e) => {
    if (!e.target.classList.contains('reportar-btn')) return;

    const comentarioId = e.target.dataset.id;

    if (!confirm("¿Deseas reportar este comentario?")) return;

    $.ajax({
        url: '../php/EjecutarQuery.php?accion=reportar',
        type: 'POST',
        data: { id_comentario: comentarioId },
        success: function(resp) {
            alert("Comentario reportado.");
        },
        error: function(xhr) {
            console.error('Error al reportar:', xhr.responseText);
        }
    });
});


});
