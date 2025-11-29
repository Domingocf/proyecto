<?php
// registro.php
$error = '';
$success = '';

// Validación PHP de errores (para mostrar antes de enviar a funciones.php si hay algo)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($username === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif ($password !== $confirmPassword) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
    } 
    // Nota: no hacemos header, dejamos que el formulario envíe a funciones.php
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    .register-container {
        max-width: 450px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
</style>
<script>
function validateForm(event) {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();
    let errors = [];

    if (!username) errors.push("El nombre de usuario es obligatorio.");
    if (!email) errors.push("El correo electrónico es obligatorio.");
    else {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) errors.push("El correo electrónico no es válido.");
    }

    if (!password) errors.push("La contraseña es obligatoria.");
    else {
        const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!pattern.test(password)) errors.push("La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
    }

    if (password !== confirmPassword) errors.push("Las contraseñas no coinciden.");

    if (errors.length > 0) {
        alert(errors.join("\n"));
        event.preventDefault();
        return false;
    }

    return true;
}
</script>
</head>
<body>

<div class="register-container">
    <h2 class="text-center mb-4">Registro de Usuario</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="../include/funciones.php?register" onsubmit="return validateForm(event);">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Introduce tu usuario" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña segura" required>
            <div class="form-text">Mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial.</div>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repite la contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
