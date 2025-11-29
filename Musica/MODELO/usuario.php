<?php

use usuario as GlobalUsuario;

class Usuario
{
    private $id;
    private $nombre;
    private $email;
    private $password;

    public function __construct($id = null, $nombre = null, $email = null, $password = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public static function registro($username, $email, $password)
    {
        try {
            $bd = new bd();
        $conexion = $bd->Conectar();

        // Verifica si el usuario ya existe
        if (self::comprobarUsuario($username)) {
            echo "Error: El usuario ya existe.";
            return;
        }

        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        $sql = "INSERT INTO usuarios (username,email, password) VALUES (:username,:email, :password)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        if ($stmt->execute()) {
            $_SESSION['usuario'] = $username;
            echo "<h2>Registro exitoso.</h2>";
        } else {
            echo "<h2>Error al registrar el usuario.</h2>";
        }
        } catch (\Throwable $th) {
            echo "<h2>error al registrar usuario</h2>";
        }
    }

    public static function iniciarSesion($username, $password)
    {
        $bd = new bd();
        $conexion = $bd->Conectar();
        $sql = "SELECT password FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $usuario['password'])) {

                $_SESSION['usuario'] = $username;
                echo "<h2>Inicio de sesión exitoso.</h2>";
            } else {
                echo "<h2>Contraseña incorrecta.</h2>";
            }
        } else {
            echo "El usuario no existe.";
        }
    }

    public static function comprobarUsuario($username)
    {
        $bd = new bd();
        $conexion = $bd->Conectar();

        $sql = "SELECT id FROM usuarios WHERE username = :username";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public static function imprimirSesion()
    {

        if (isset($_SESSION['usuario'])) {
            echo $_SESSION['usuario'];
        }
    }

    public static function listarCanciones($pagina, $porPagina)
    {

        $bd = new bd();
        $conexion = $bd->Conectar();

        // Calcular el offset
        $offset = ($pagina - 1) * $porPagina;

        // Obtener el total de canciones
        $sqlTotal = "SELECT COUNT(*) as total FROM canciones";
        $stmtTotal = $conexion->prepare($sqlTotal);
        $stmtTotal->execute();
        $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($total / $porPagina);

        // Obtener las canciones de la página actual
        $sql = "SELECT * FROM canciones LIMIT :offset, :porPagina";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();

        $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mostrar las canciones
        foreach ($canciones as $cancion) {
            echo "ID: " . $cancion['id'] . " - Título: " . $cancion['titulo'] . " - Artista: " . $cancion['artista'] . "<br>";
        }

        // Paginación Bootstrap
        echo '<nav aria-label="Page navigation"><ul class="pagination">';
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $active = ($i == $pagina) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul></nav>';
    }

    static function obteneridUsuario($usuario)
    {

        $bd = new bd();
        $conexion = $bd->Conectar();

        // Verifica si la conexión fue exitosa
        if (!$conexion) {
            var_dump("Error de conexión a la base de datos");
            return null;
        }

        $query = "SELECT id FROM usuarios WHERE username = :usuario LIMIT 1";
        $consulta = $conexion->prepare($query);
        $consulta->bindValue(':usuario', $usuario);

        if ($consulta->execute()) {
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['id'];
            }
        } else {
            var_dump("Error al ejecutar la consulta");
            return null;
        }
    }


    static function agregarFavorito($id_cancion)
    {
        if (!isset($_SESSION['usuario'])) {
            echo "Debes iniciar sesión para agregar favoritos.";
            return;
        }

        $bd = new bd();
        $conexion = $bd->Conectar();

        $id_usuario = self::obtenerIdUsuario($_SESSION['usuario']);

        // Insertar en la tabla de favoritos
        $sqlFavorito = "INSERT INTO favorito (usuario, cancion) VALUES (:id_usuario, :id_cancion)";
        $stmtFavorito = $conexion->prepare($sqlFavorito);
        $stmtFavorito->bindParam(':id_usuario', $id_usuario);
        $stmtFavorito->bindParam(':id_cancion', $id_cancion);

        if ($stmtFavorito->execute()) {
            echo "Canción agregada a favoritos.";
        } else {
            echo "Error al agregar la canción a favoritos.";
        }
    }

    static function getAllUsers($idUsuario)
    {
        $bd = new bd();
        $conexion = $bd->Conectar();

        $sql = "SELECT id, username
        FROM usuarios
        WHERE id not IN (1,:idUsuario)"; // Excluye al usuario actual y al admin;
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function obtenerUsername($id_lista)
    {
        $bd = new bd();
        $conexion = $bd->Conectar();

        $sql = "SELECT username
        from usuarios
        where id in(SELECT crea
                FROM listas
                where id=:id_lista)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_lista', $id_lista);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['username'];
    }
    public static function espremium($id_usu)
    {
        $bd = new bd();
        $conexion = $bd->Conectar();
        $sql = "SELECT *
                FROM formadepago
                where usuario=:id_usu
                LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_usu', $id_usu);
        $stmt->execute();
        if ($stmt->rowCount() <1) {
            echo'<li class="nav-item">
    <a class="nav-link" href="../include/funciones.php?viewpremium">hacerse premium</a>
</li>';
           
        } 
    }
}
