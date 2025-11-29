<?php

session_start();

function seleccionarcontenido()
{

    if (isset($_GET['crearBD'])) {
        include_once '../CONTROLLER/bd.php';
        crearBD();
        echo "Base de datos creada exitosamente.";
    }

    if (isset($_GET['borrarBD'])) {
        include_once '../CONTROLLER/bd.php';
        borrarBD();
        echo "Base de datos borrada exitosamente.";
    }

    if (isset($_GET['viewregister'])) {

        echo '<h2>Bienvenido al Reproductor de Música</h2>';
        echo '<p>Explora y disfruta de tu música favorita.</p>';
        include('../VIEWS/register.php');
    }

    if (isset($_GET['register'])) {
        include_once '../CONTROLLER/usuario.php';
        echo $_POST['username'], $_POST['email'], $_POST['password'];
        registro($_POST['username'], $_POST['email'], $_POST['password']);



        echo '<h2>Registro Exitoso</h2>';
        echo '<p>Tu cuenta ha sido creada exitosamente. Ahora puedes iniciar sesión.</p>';
    }

    if (isset($_GET['viewlogin'])) {

        echo '<h2>Bienvenido al Reproductor de Música</h2>';
        echo '<p>Explora y disfruta de tu música favorita.</p>';
        include('../VIEWS/login.php');
    }

    if (isset($_GET['login'])) {
        include_once '../CONTROLLER/usuario.php';

        iniciarSesion($_POST['username'], $_POST['password']);

        // header('Location:../VIEWS/viewindex.php');
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location:../VIEWS/viewindex.php');
    }
    if (isset($_GET['listarCanciones'])) {
        include_once '../CONTROLLER/cancion.php';
        $pagina = $_GET['pagina'] ?? 1;
        $lista = $_GET['lista'] ?? '';
        $_SESSION["pagina"]=$pagina;
        $_SESSION["lista"]=$lista;
        listarCanciones($pagina, $lista);
        
    }
    if (isset($_GET['favorito'])) {
        include_once '../CONTROLLER/usuario.php';
        $id_cancion = $_GET['favorito'];
        agregarFavorito($id_cancion);
    }
    //terminar los comentarios
    if (isset($_GET['viewcomentar'])) {
        $_SESSION["cancion"] = $_GET['viewcomentar'];
        include('../VIEWS/comentar.php');
    }
    // if (isset($_GET['comentar'])) {
    //     include_once '../CONTROLLER/comentario.php';
    //     $descripcion = $_POST['comentario'];
    //     crearComentario($descripcion);
    // }

    //añadir a lista
    if (isset($_GET['viewañadir'])) {
        $_SESSION["cancion"] = $_GET['viewañadir'];
        include('../VIEWS/añadir.php');
    }

    //ver mis listas


    if (isset($_GET['verlistas'])) {
        include_once '../CONTROLLER/lista.php';
        cargarMisListas();
    }


    //compartir lista con usuario
    if (isset($_GET['viewcompartir'])) {
        $_SESSION["lista"] = $_GET['viewcompartir'];
        include('../VIEWS/compartir.php');
    }

    if (isset($_GET['compartir'])) {
        include_once '../CONTROLLER/lista.php';
        include_once '../CONTROLLER/usuario.php';

        $username = $_SESSION['usuario'] ?? '';
        $id_usuario = obteneridUsuario($username);
        $idLista = $_SESSION["lista"];
        $compartido = $_POST['id_usuario'];

        comparte($id_usuario, $idLista, $compartido);
    }

    if (isset($_GET['compartidas'])) {
        include_once '../CONTROLLER/lista.php';
        cargarCompartidas();
    }

 if (isset($_GET['viewabout'])) {
        header('Location:../VIEWS/about.php');
        
    }
    if (isset($_GET['viewservice'])) {
        header('Location:../VIEWS/service.php');
    }
    if (isset($_GET['viewcontact'])) {
        header('Location:../VIEWS/contact.php');
    }

    if(isset($_GET['viewpremium'])){
        include('../VIEWS/premium.php');
    }
    if(isset($_GET['procesarPago'])){
         include_once '../CONTROLLER/pago.php';
           extract($_POST);
           if($tipo==='tarjeta'){
               
         guardarPago($usuario, $tipo, $tarjeta_num, $tarjeta_exp, $paypal_email);
           }else{
               guardarPago($usuario, $tipo, null, null, $paypal_email);
           }
      
    }

}



include('../VIEWS/viewPrincipal.php');
