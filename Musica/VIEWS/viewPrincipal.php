<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Contenido - Reproductor de Música</title>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/responsive.css" rel="stylesheet" />
</head>

<body>
    <div class="hero_area">
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
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../index.php">Volver <span class="sr-only">(current)</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        </div>

    <div class="bg">
        <section class="content_section layout_padding">
            <div class="container text-center">
              

                <div class="main-content-wrapper layout_padding2-top">
                    <?php
                    // Función para cargar el contenido dinámico
                    seleccionarcontenido();
                    ?>
                </div>

                <div class="btn-box mt-5">
                    <a href="../index.php">
                        Volver al Inicio
                    </a>
                    <hr>
                </div>
            </div>
        </section>
        </div>

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