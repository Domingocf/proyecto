<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Heustonn</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="../index.php">
            <span>
              <!-- MODIFICACIÓN: Cambiado nombre -->
              MusicConnect
            </span>
          </a>
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon " style="color:blue"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav ">
         <?php
session_start();
                                // Aquí insertamos tu sistema de navegación dinámico
                                if (isset($_SESSION['usuario'])) {
                                    if ($_SESSION['usuario'] === 'adminapp') {
                                        include '../VIEWS/navadmin.php';
                                    } else {
                                        include '../VIEWS/navusu.php';
                                    }
                                } else {
                                    include '../VIEWS/navnoconectado.php';
                                }
                                ?>
       </ul>

            </div>
          </div>
          <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
            <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
          </form>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="slider_item-box layout_padding2">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="img-box">
                      <div>
                        <img src="img/11.jpg" alt="" class="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-box">
                      <div>
                        <h1 class="text-primary font-weight-bold">
                        <!-- MODIFICACIÓN: Nuevo eslogan -->
                        MusicConnect  
                        <br>
                        <span class="text-dark">Tu música, tu comunidad</span>
                      </h1>
                      <p>
                        <!-- MODIFICACIÓN: Texto real -->
                        Una plataforma donde escuchar música, crear playlists y conectar con otros usuarios mediante comentarios, valoraciones y mucho más.
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="slider_item-box layout_padding2">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="img-box">
                      <div>
                        <img src="img/5.jpg" alt="" class="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-box">
                      <div>
                        <h1 class="text-primary font-weight-bold">
                        <!-- MODIFICACIÓN: Nuevo eslogan -->
                        MusicConnect  
                        <br>
                        <span class="text-dark">Tu música, tu comunidad</span>
                      </h1>
                      <p>
                        <!-- MODIFICACIÓN: Texto real -->
                        Una plataforma donde escuchar música, crear playlists y conectar con otros usuarios mediante comentarios, valoraciones y mucho más.
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="slider_item-box layout_padding2">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="img-box">
                      <div>
                        <img src="img/3.jpg" alt="" class="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-box">
                      <div>
                       <h1 class="text-primary font-weight-bold">
                        <!-- MODIFICACIÓN: Nuevo eslogan -->
                        MusicConnect  
                        <br>
                        <span class="text-dark">Tu música, tu comunidad</span>
                      </h1>
                      <p>
                        <!-- MODIFICACIÓN: Texto real -->
                        Una plataforma donde escuchar música, crear playlists y conectar con otros usuarios mediante comentarios, valoraciones y mucho más.
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="container">
        <div class="slider_nav-box">
          <div class="btn-box">
            <a href="about.php">
              Read More
            </a>
            <hr>
          </div>
          <div class="custom_carousel-control">
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
     <main class="container py-4">
        <?php

        if (isset($_SESSION['usuario'])) {

            if ($_SESSION['usuario'] == 'adminapp') {

                echo "
                <div class='row justify-content-center'>
                    <div class='col-md-6'>
                        <div class='card text-center shadow-lg border-primary'>
                            <div class='card-header bg-primary text-white'>
                                <h4 class='m-0'><i class='fas fa-user-shield'></i> Panel de Administración</h4>
                            </div>

                            <div class='card-body'>
                                <a href='../VIEWS/CANCIONES/index.php' class='btn btn-lg btn-success btn-block mb-3'>
                                    <i class='fas fa-upload mr-2'></i> Subir Canciones y Ver Listas
                                </a>

                                <img src='musica.png' class='img-fluid rounded-circle mb-3 border border-dark' style='max-width:150px;border-width:5px!important;'>

                                <p class='text-muted'>
                                    Descubre y organiza tus canciones con nuestro reproductor profesional.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>";
            }

        } else {

            echo "
            <div class='jumbotron jumbotron-fluid text-center bg-white shadow-sm'>
                <div class='container'>
                    <h2 class='text-danger'><i class='fas fa-lock mr-2'></i> Acceso Restringido</h2>
                    <p class='lead'>Por favor, inicia sesión o regístrate para acceder a todas las funcionalidades.</p>
                </div>
            </div>
            ";
        }

        ?>
    </main>
  </div>
  <div class="bg">

    

    <!-- work section -->

    <section class="work_section layout_padding">
      <div class="container">
        <div class="custom_heading-container">
          <h3 class=" ">
            COMO TRABAJAMOS
          </h3>
        </div>
      </div>
      <div class="work_container ">
        <div class="box b-1">
          <div class="img-box">
            <img src="img/p1.jpg" alt="">
          </div>
          <div class="name">
            <h6>
              LOS MEJORES PROFESIONALES
            </h6>
          </div>
        </div>
        <div class="box b-2">
          <div class="img-box ">
            <img src="img/p5.jpg" alt="">
          </div>
          <div class="name">
            <h6>
              ATENCIÓN PERSONALIZADA
            </h6>
          </div>
        </div>
        <div class="box b-3">
          <div class="img-box ">
            <img src="img/p3.jpg" alt="">
          </div>
          <div class="name">
            <h6>
              TECNOLOGÍA AVANZADA
            </h6>
          </div>
        </div>
        <div class="box b-4">
          <div class="img-box ">
            <img src="img/p4.jpg" alt="">
          </div>
          <div class="name">
            <h6>
              RESULTADOS GARANTIZADOS
            </h6>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="btn-box">
          <a href="">
            Read More
          </a>
          <hr>
        </div>
      </div>
    </section>


    <!-- end work section -->

    <!-- contact section -->

    <section class="contact_section layout_padding">
      <div class="custom_heading-container">
        <h3 class=" ">
          CONSULTA Online
        </h3>
      </div>
      <div class="container layout_padding2-top">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <form action="">
              <div>
                <input type="text" placeholder="NOMBRE">
              </div>
              <div>
                <input type="email" placeholder="EMAIL">
              </div>
              <div>
                <input type="text" placeholder="TELEFONO">
              </div>
              <div>
                <select name="" id="">
                  <option value="" disabled selected>TIPO DE SERVICIO</option>
                  <option value="">SERVICIO 1</option>
                  <option value="">SERVICIO 2</option>
                  <option value="">SERVICIO 3</option>
                </select>
              </div>
              <div>
                <input type="text" class="message-box" placeholder="MENSAJE">
              </div>
              <div class="d-flex justify-content-center ">
                <button>
                  ENVIAR
                </button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </section>

    <!-- end contact section -->

    <section class="client_section layout_padding-bottom">
      <div class="container">
        <div class="custom_heading-container">
          <h3 class=" ">
            QUE DICEN NUESTROS CLIENTES
          </h3>
        </div>
        <div class="layout_padding2-top">
          <div class="client_container">
            <div class="detail-box">
              <p>
              ESTA APLICACIÓN HA TRANSFORMADO MI EXPERIENCIA MUSICAL. LA INTERFAZ ES INTUITIVA Y LA CALIDAD DEL SONIDO ES EXCEPCIONAL. ¡LA RECOMIENDO TOTALMENTE!
            </p>
            </div>
            <div class="client_id">
              <div class="img-box">
                <img src="images/client.png" alt="">
              </div>
              <div class="name">
                <h5>
                  RAÚL
              </h5>
                <h6>
                  USUARIO
                </h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- info section -->
    <section class="info_section layout_padding">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="info-logo">
              <h2>
                MUSSICCONNECT
              </h2>
              <p>
                Tu plataforma definitiva para descubrir, compartir y disfrutar de la música en comunidad.
            </p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-nav">
              <h4>
                NAVEGACION
              </h4>
              <ul>
                <li>
                  <a href="../index.php">
                    Home
                  </a>
                </li>
                <li>
                  <a href="about.php">
                    About
                  </a>
                </li>
                <li>
                  <a href="service.php">
                    Services
                  </a>
                </li>
                <li>
                  <a href="contact.php">
                    Contact Us
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-contact">
              <h4>
                INFORMACION DE CONTACTO
              </h4>
              <div class="location">
                <h6>
                  CORREO CORPORATIVO:
              </h6>
                <a href="">
                  <img src="images/location.png" alt="">
                  <span>
                    Loram ipusm New York, NY 36524
                  </span>
                </a>
              </div>
              <div class="call">
                <h6>
                  Customer Service:
                </h6>
                <a href="">
                  <img src="images/telephone.png" alt="">
                  <span>
                    ( +01 1234567890 )
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="discover">
              <h4>
                DESCUBRE MÁS
              </h4>
              <ul>
                <li>
                  <a href="">
                    AYUDA
                  </a>
                </li>
                <li>
                  <a href="">
                    COMO TRABAJAMOS
                  </a>
                </li>
                <li>
                  <a href="">
                    SUSCRIBETE
                  </a>
                </li>
                <li>
                  <a href="contact.html">
                    CONTACTANOS
                  </a>
                </li>
              </ul>
              <div class="social-box">
                <a href="">
                  <img src="images/facebook.png" alt="">
                </a>
                <a href="">
                  <img src="images/twitter.png" alt="">
                </a>
                <a href="">
                  <img src="images/google-plus.png" alt="">
                </a>
                <a href="">
                  <img src="images/linkedin.png" alt="">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- end info_section -->

    

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
</body>

</html>