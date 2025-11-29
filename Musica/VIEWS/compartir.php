<?php

include_once '../CONTROLLER/usuario.php';

// Obtén todos los usuarios
$username = $_SESSION['usuario'] ?? '';
$id_usuario = obteneridUsuario($username);
$usuarios = getAllUsers($id_usuario); 

// Sanea el id de la canción
$song_id_value = isset($song['id']) ? (int)$song['id'] : (isset($old['song_id']) ? (int)$old['song_id'] : '');

// Sanea el token CSRF
$csrf = htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4 text-primary">Compartir canción con un usuario</h4>
                    <form method="post" action="../include/funciones.php?compartir" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                        <input type="hidden" name="song_id" value="<?= $song_id_value ?>">
                        <div class="mb-3">
                            <label for="usuario" class="form-label fw-semibold">Selecciona un usuario</label>
                            <select id="usuario" name="id_usuario" class="form-select rounded-3 shadow-sm" required>
                                <option value="">-- Selecciona --</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= htmlspecialchars($usuario['id']) ?>">
                                        <?= htmlspecialchars($usuario['username']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-share me-2"></i> Compartir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
