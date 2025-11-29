<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reproductor - Mejorado</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f3f4f7;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .modal-content {
            border-radius: 1rem;
        }
    </style>
</head>
<body class="py-5">

<div class="container">

    <form id="Registrar" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="card p-4">
            <h3 class="text-center mb-4">AÑADIR A LISTA</h3>

            <div class="row mb-3">
                <div class="col-md-8 mx-auto text-center">
                    <label for="Lista" class="form-label fw-bold">Listas disponibles</label>
                    <div class="input-group">
                        <select name="Lista" id="Lista" class="form-select"></select>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLista">
                            + Añadir
                        </button>
                    </div>
                </div>
            </div>

            <hr />

            <?php
            $viewAñadir = isset($_GET["viewañadir"]) ? $_GET["viewañadir"] : '';
            $usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : '';
            ?>

            <!-- Elemento oculto -->
            <div id="datosSesion" data-viewañadir="<?= $viewAñadir ?>" data-usuario="<?= $usuario ?>" hidden></div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-check-circle"></i> Registrar
                </button>
                <button type="button" class="btn btn-danger" id="Cancelar">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
            </div>
        </div>

        <div class="AlertaE"></div>
        <div class="Alerta"></div>

    </form>
</div>


<!-- Modal para añadir lista -->
<div class="modal fade" id="addLista" tabindex="-1" aria-labelledby="addListaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="addListaLabel">Agregar nueva lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <label for="nombreLista" class="form-label">Nombre de la carpeta</label>
                <input type="text" id="nombreLista" name="nombreLista" class="form-control mb-3" />

                <div class="text-center">
                    <button class="btn btn-success" id="GuardarLista">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery opcional si tu JS lo necesita -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/compartidos.js"></script>

</body>
</html>
