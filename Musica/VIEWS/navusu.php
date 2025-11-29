<li class="nav-item">
    <a class="nav-link" href="../index.php"></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?listarCanciones">Canciones</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?verlistas">ver mis listas</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?compartidas">ver listas compartidas</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?logout">Cerrar Sesión</a>
</li>
<?php 
include '../CONTROLLER/usuario.php';

$id=obteneridUsuario($_SESSION["usuario"]);

usuario::espremium($id);
?>
<li class="nav-item">
    <a class="nav-link" href="#">
        <?php
        usuario::imprimirSesion();
        ?>
