<?php

/**
 * 
 */
class bd
{
        var $conexion;
        var $error;

        function Conectar()
        {
                try {
                        $this->conexion = new PDO('mysql:host=localhost;dbname=BDReproductor', 'root', '');
                } catch (PDOException $e) {
                        $this->error = $e->getMessage();
                }
                return $this->conexion;
        }

       public static function CrearBD()
{
    try {
        $host = 'localhost';
        $usuario = 'root';
        $clave = '';
        $nombreBD = 'BDReproductor';

        // 1. Conexión al servidor MySQL
        $conexion = new PDO("mysql:host=$host", $usuario, $clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 2. Crear base de datos si no existe
        $conexion->exec("CREATE DATABASE IF NOT EXISTS `$nombreBD` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base de datos '$nombreBD' creada correctamente.<br>";

        // 3. Conectarse a la base de datos creada
        $conexionBD = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8mb4", $usuario, $clave);
        $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 4. Borrar tablas existentes (orden correcto por FK)
        $tablas = ['esde','anade','comparte','reportes','formadepago','favorito','comentarios','canciones','listas','usuarios'];
        foreach ($tablas as $tabla) {
            $conexionBD->exec("DROP TABLE IF EXISTS `$tabla`");
        }

        // 5. Crear tablas (orden correcto)
        $tablaUsuarios = "
            CREATE TABLE IF NOT EXISTS `usuarios` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `email` VARCHAR(100) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaListas = "
            CREATE TABLE IF NOT EXISTS `listas` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `lis_nombre` VARCHAR(50) DEFAULT NULL,
                `crea` INT(11) DEFAULT NULL,
                `lis_activa` TINYINT(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`),
                KEY `idx_crea` (`crea`),
                CONSTRAINT `fk_listas_crea` FOREIGN KEY (`crea`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaCancion = "
            CREATE TABLE IF NOT EXISTS `canciones` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `can_titulo` VARCHAR(60) DEFAULT NULL,
                `can_size` VARCHAR(45) DEFAULT NULL,
                `categoria` VARCHAR(50) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaComentarios = "
            CREATE TABLE IF NOT EXISTS `comentarios` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `descripcion` VARCHAR(500) DEFAULT NULL,
                `activo` TINYINT(1) NOT NULL DEFAULT 1,
                `usuario` INT(11) DEFAULT NULL,
                `responde` INT(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk_usuarios_id` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT `fk_responde_id` FOREIGN KEY (`responde`) REFERENCES `comentarios`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaComparte = "
            CREATE TABLE IF NOT EXISTS `comparte` (
                `usuario` INT(11) NOT NULL,
                `lista` INT(11) NOT NULL,
                `compartido` INT(11) NOT NULL,
                PRIMARY KEY (`usuario`, `lista`, `compartido`),
                KEY `idx_comparte_lista` (`lista`),
                CONSTRAINT `fk_comparte_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_comparte_lista` FOREIGN KEY (`lista`) REFERENCES `listas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaAnade = "
            CREATE TABLE IF NOT EXISTS `anade` (
                `usuario` INT(11) NOT NULL,
                `lista` INT(11) NOT NULL,
                `cancion` INT(11) NOT NULL,
                PRIMARY KEY (`usuario`, `lista`, `cancion`),
                CONSTRAINT `fk_anade_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_anade_lista` FOREIGN KEY (`lista`) REFERENCES `listas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_anade_cancion` FOREIGN KEY (`cancion`) REFERENCES `canciones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaEsde = "
            CREATE TABLE IF NOT EXISTS `esde` (
                `cancion` INT(11) NOT NULL,
                `comentario` INT(11) NOT NULL,
                PRIMARY KEY (`cancion`, `comentario`),
                CONSTRAINT `fk_esde_cancion` FOREIGN KEY (`cancion`) REFERENCES `canciones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_esde_comentario` FOREIGN KEY (`comentario`) REFERENCES `comentarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaFavorito = "
            CREATE TABLE IF NOT EXISTS `favorito` (
                `usuario` INT(11) NOT NULL,
                `cancion` INT(11) NOT NULL,
                PRIMARY KEY (`usuario`, `cancion`),
                CONSTRAINT `fk_fav_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_fav_cancion` FOREIGN KEY (`cancion`) REFERENCES `canciones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaFormadepago = "
            CREATE TABLE IF NOT EXISTS `formadepago` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `usuario` INT(11) NOT NULL,
                `tipo` ENUM('tarjeta','paypal') NOT NULL,
                `tarjeta_num` VARCHAR(30) DEFAULT NULL,
                `tarjeta_exp` DATE DEFAULT NULL,
                `paypal_email` VARCHAR(100) DEFAULT NULL,
                PRIMARY KEY (`id`,`usuario`),
                CONSTRAINT `fk_fp_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $tablaReportes = "
            CREATE TABLE IF NOT EXISTS `reportes` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `comentario` INT(11) NOT NULL,
                `usuario` INT(11) NOT NULL,
                `estado` ENUM('pendiente','revisado') NOT NULL DEFAULT 'pendiente',
                PRIMARY KEY (`id`),
                CONSTRAINT `fk_report_coment` FOREIGN KEY (`comentario`) REFERENCES `comentarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_report_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        // 6. Ejecutar creación de tablas
        $conexionBD->exec($tablaUsuarios);
        $conexionBD->exec($tablaListas);
        $conexionBD->exec($tablaCancion);
        $conexionBD->exec($tablaComentarios);
        $conexionBD->exec($tablaComparte);
        $conexionBD->exec($tablaAnade);
        $conexionBD->exec($tablaEsde);
        $conexionBD->exec($tablaFavorito);
        $conexionBD->exec($tablaFormadepago);
        $conexionBD->exec($tablaReportes);

        // 7. Insertar usuarios de ejemplo
        include_once '../CONTROLLER/usuario.php';
        include_once '../CONTROLLER/cancion.php';
        registro('adminapp', 'domingocf2000@gmail.com', '123');
        registro('domi', 'domingocf@gmail.com', '123');
        

        // 8. Insertar canciones de ejemplo
        $cancion = new cancion("anuncio1.mp3", "", "");
        $cancion->crearCancion("anuncio1.mp3", "", "");
        $cancion = new cancion("anuncio2.mp3", "", "");
        $cancion->crearCancion("anuncio2.mp3", "", "");
        $cancion = new cancion("anuncio3.mp3", "", "");
        $cancion->crearCancion("anuncio3.mp3", "", "");

        echo "Tablas creadas correctamente.";

    } catch (PDOException $e) {
        echo "Error al crear la base de datos o tablas: " . $e->getMessage();
    }
}





        public static function BorrarBD()
        {
                try {
                        $sql = "
      Drop database if exists BDReproductor;
      ";
                        $conexion = new PDO('mysql:host=localhost;dbname=BDReproductor', 'root', '');
                        $conexion->exec($sql);
                        echo "Base de datos borrada correctamente.";
                } catch (PDOException $e) {
                        echo "Error al borrar la base de datos: " . $e->getMessage();
                }
        }
}
