<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forma de Pago - MusicConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function togglePaymentFields() {
      const tipo = document.getElementById('tipo').value;
      document.getElementById('cardFields').style.display = (tipo === 'tarjeta') ? 'block' : 'none';
      document.getElementById('cardFields2').style.display = (tipo === 'paypal') ? 'block' : 'none';
    }
  </script>
</head>

<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
      <h2 class="card-title text-center mb-4">Datos de Pago</h2>

      <form method="POST" action="../include/funciones.php?procesarPago">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
        </div>
        <div id="paypalFields">
          <div class="mb-3">
            <label for="paypal_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="paypal_email" name="paypal_email" placeholder="usuario@paypal.com">
          </div>
        </div>
        <div class="mb-3">
          <label for="tipo" class="form-label">Tipo de Pago</label>
          <select class="form-select" id="tipo" name="tipo" onchange="togglePaymentFields()" required>
            <option value="" selected disabled>Seleccione...</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="paypal">PayPal</option>
          </select>
        </div>

        <!-- Campos Tarjeta -->
        <div id="cardFields" style="display: none;">
          <div class="mb-3">
            <label for="tarjeta_num" class="form-label">Número de Tarjeta</label>
            <input type="text" class="form-control" id="tarjeta_num" name="tarjeta_num" placeholder="1234 5678 9012 3456">
          </div>
          <div class="mb-3">
            <label for="tarjeta_exp" class="form-label">Fecha de Expiración</label>
            <input type="month" class="form-control" id="tarjeta_exp" name="tarjeta_exp">
          </div>
        </div>
         <div id="cardFields2" style="display: none;">
          <div class="mb-3">
            <label for="tarjeta_exp" class="form-label">contraseña</label>
            <input type="password" class="form-control" id="tarjeta_exp" name="clave">
          </div>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Pagar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>