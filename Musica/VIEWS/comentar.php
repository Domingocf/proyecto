<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4">
            <h4 class="card-title text-center mb-4 text-primary">Deja tu comentario</h4>

            <!-- FORMULARIO PRINCIPAL -->

              <div class="mb-3">
                <label for="comentario" class="form-label fw-semibold">Comentario</label>
                <textarea id="comentario" name="comentario" class="form-control rounded-3 shadow-sm" rows="5" placeholder="Escribe aquí tu comentario..." required></textarea>
              </div>
              <div class="d-grid">
                <button id="comentar" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                  <i class="bi bi-chat-dots me-2"></i> Publicar comentario
                </button>
              </div>

            <!-- CONTENEDOR PARA LISTAR COMENTARIOS -->
            <div id="lista-comentarios" class="mt-4">
              <?php
              include_once '../CONTROLLER/comentario.php';

              // listarComentarios debe generar comentarios con clase 'comentario' y data-id
              listarComentarios($_SESSION["cancion"]);
             

              ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Incluye Bootstrap JS y tu script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../js/comentario.js"></script>
</body>
