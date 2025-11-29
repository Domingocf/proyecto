<li class="nav-item">
    <a class="nav-link" href="../VIEWS/index.php"></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?verReportes">ver reportes</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?logout">Cerrar Sesión</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="#">
        <?php
        include '../MODELO/usuario.php';
        usuario::imprimirSesion();
        ?>
    </a>
</li>

