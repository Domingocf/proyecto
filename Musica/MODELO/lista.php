<?php
require_once '../MODELO/bd.php';

class lista
{
    public $idLista;
    public $nombre;
    public $crea;
    public $activa;

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function __construct($nombre = null, $crea = null)
    {
        $this->nombre = $nombre;
        $this->crea = $crea;
        $this->activa = 1;
    }

    public function crearLista()
    {
        $conexion = new bd();
        $conexion->Conectar();


        $query = "INSERT INTO listas (lis_nombre, crea, lis_activa) VALUES (:nombre, :crea, :activa)";
        $stmt = $conexion->conexion->prepare($query);
        $stmt->bindValue(':nombre', $this->nombre);
        $stmt->bindValue(':crea', $this->crea);
        $stmt->bindValue(':activa', $this->activa);
        return $stmt->execute(); // true o false
    }

    public static function ActualizarLista($idLista, $nombre)
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "UPDATE listas SET lis_nombre = :nombre WHERE id = :id";
        $consulta = $conexion->conexion->prepare($query);
        $consulta->bindValue(':nombre', $nombre);
        $consulta->bindValue(':id', $idLista);
        return $consulta->execute(); // true o false
    }

    public static function mostrarListas()
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "SELECT * FROM listas WHERE lis_activa = :activa";
        $consulta = $conexion->conexion->prepare($query);
        $consulta->bindValue(':activa', "true");
        $consulta->execute();

        $rows = $consulta->fetchAll(\PDO::FETCH_OBJ);
        // Retorna las listas activas como array de objetos (puedes json_encode si lo necesitas)
        return $rows;
    }

    public static function mostrarDetallesListas()
    {
        $conexion = new bd();
        $conexion->Conectar();

        $sql = "SELECT listas.id,
                       listas.lis_nombre,
                       (SELECT COUNT(*) FROM canciones WHERE canciones.id = listas.id) AS cantcanciones
                FROM listas
                WHERE lis_activa = 1
                GROUP BY listas.id, listas.lis_nombre";

        $consulta = $conexion->conexion->prepare($sql);
        $consulta->execute();

        $rows = $consulta->fetchAll(\PDO::FETCH_OBJ);
        echo json_encode($rows);
    }

    public static function EliminarListaConCanciones($idLista)
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "UPDATE listas SET lis_activa = 'false' WHERE id = :id";
        $consulta = $conexion->conexion->prepare($query);
        return $consulta->execute([':id' => $idLista]);
    }

    public static function obtenerListasUsuario($idUsuario)
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "SELECT id, lis_nombre 
                 FROM listas 
                 WHERE crea = :idUsuario ";

        $consulta = $conexion->conexion->prepare($query);
        $consulta->bindValue(':idUsuario', $idUsuario);
        $consulta->execute();

        $row = $consulta->fetchAll(\PDO::FETCH_OBJ);

        echo json_encode($row);
    }

    public static function misListas($idUsuario)
    {

        $conexion = new bd();
        $conexion->Conectar();

        $query = "SELECT id, lis_nombre 
              FROM listas 
              WHERE crea = :idUsuario";

        $consulta = $conexion->conexion->prepare($query);
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();

        $resultados = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $resultados ? $resultados : null;
    }


    public static function anadeCancion($id_usuario, $ListaID, $id_cancion)
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "INSERT INTO anade (usuario, lista, cancion) 
              VALUES (:usuario, :lista, :cancion)";

        $consulta = $conexion->conexion->prepare($query);

        $consulta->bindValue(':usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':lista', $ListaID, PDO::PARAM_INT);
        $consulta->bindValue(':cancion', $id_cancion, PDO::PARAM_INT);

        if (!$consulta->execute()) {
            echo "ERROR SQL:";
            print_r($consulta->errorInfo());
            return false;
        }

        return true;
    }

    public static function cargarMisListas()
    {
        include_once '../CONTROLLER/usuario.php';

        echo '<h2 class="text-center my-4 text-primary">Mis Listas de Reproducción</h2>'; // Título más destacado

        // Recuperar usuario de sesión
        $usuario = $_SESSION['usuario'];

        // Obtener ID de usuario
        $id_usuario = obteneridUsuario($usuario);

        // Obtener listas de reproducción del usuario
        $listas = self::misListas($id_usuario);

        if (is_array($listas) && count($listas) > 0) {
            echo '<div class="container">';
            echo '<div class="row row-cols-1 row-cols-md-3 g-4">'; // Grid con 3 columnas para pantallas grandes

            foreach ($listas as $lista) {
                // Card para cada lista
                echo '<div class="col mb-4">';
                echo '<div class="card shadow-lg border-light rounded">';

                // Imágenes de fondo de cada lista
                echo '<div class="card-header bg-primary text-white text-center">';
                echo '<h5 class="card-title">' . htmlspecialchars($lista->lis_nombre) . '</h5>';
                echo '</div>';

                echo '<div class="card-body">';

                // Botones estilizados
                echo '<div class="d-grid gap-2">';

                // Asegúrate de escapar correctamente el ID de la lista en el atributo 'data-idLista'
                echo '<a href="#" class="btn btn-outline-primary btnEscuchar" data-idLista="' . $lista->id . '">Escuchar</a>';
                echo '<a href="../include/funciones.php?viewcompartir=' . $lista->id . '" class="btn btn-outline-secondary btnCompartir" data-idLista="' . $lista->id . '">Compartir</a>';


                echo '</div>'; // Cierre de d-grid
                echo '</div>'; // Cierre de card-body

                echo '</div>'; // Cierre de card
                echo '</div>'; // Cierre de col
            }

            echo '</div>'; // Cierre del grid
            echo '</div>'; // Cierre del contenedor
        } else {
            echo '<div class="alert alert-warning text-center" role="alert">No tienes listas disponibles.</div>';
        }

        // Reproductor central
        echo '<div class="jumbotron mt-4">
            <div id="mainwrap">
                <div id="audiowrap">
                    <div id="audio0">
                        <audio preload id="audioPlayer" controls>¡Su navegador no soporta Audio HTML5!</audio>
                    </div>
                    <div id="npTitle" class="mt-2"></div>
                    <div class="info mb-2"></div>
                    <div id="tracks">
                        <a id="btnPrev" class="btn btn-custom" style="background:#3b82f6; color:#fff; margin-right:10px;">&lArr;</a>
                        <a id="btnNext" class="btn btn-custom" style="background:#3b82f6; color:#fff;">&rArr;</a>
                    </div>
                </div>
            </div>
          </div>';


        //inserto datos para luego regogerlos con js

        echo '<?php $usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : ""; ?>';

        echo '<div id="datosSesion"
     data-usuario="' . $usuario . '"
     style="display:none;"></div>';

        // Scripts JS
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="/programacion/Musica/js/mi_lista.js"></script>';
    }

    static function comparte($id_usuario, $idLista, $compartido)
    {
        try {
            $conexion = new bd();
            $conexion->Conectar();

            $query = "INSERT INTO comparte (usuario, lista, compartido) 
              VALUES (:usuario, :lista, :compartido)";

            $consulta = $conexion->conexion->prepare($query);

            $consulta->bindValue(':usuario', $id_usuario, PDO::PARAM_INT);
            $consulta->bindValue(':lista', $idLista, PDO::PARAM_INT);
            $consulta->bindValue(':compartido', $compartido, PDO::PARAM_INT);

            if (!$consulta->execute()) {
                echo "ERROR SQL:";
                print_r($consulta->errorInfo());
                return false;
            }

            echo "Lista compartida con éxito.";
            return true;
        } catch (Exception $e) {
            echo "La lista ya estaba compartida" ;
            return false;
        }
    }

    public static function obtenerListasCompartidas($id_usuario)
    {
        $conexion = new bd();
        $conexion->Conectar();

        $query = "SELECT listas.id, listas.lis_nombre 
                  FROM listas 
                  JOIN comparte ON listas.id = comparte.lista 
                  WHERE comparte.compartido = :id_usuario";

        $consulta = $conexion->conexion->prepare($query);
        $consulta->bindValue(':id_usuario', $id_usuario);
        $consulta->execute();

        $rows = $consulta->fetchAll(\PDO::FETCH_OBJ);

        return $rows;
    }

    static function cargarCompartidas(){
          include_once '../CONTROLLER/usuario.php';

        echo '<h2 class="text-center my-4 text-primary">Mis Listas de Reproducción</h2>'; // Título más destacado

        // Recuperar usuario de sesión
        $usuario = $_SESSION['usuario'];

        // Obtener ID de usuario
        $id_usuario = obteneridUsuario($usuario);

        // Obtener listas de reproducción del usuario
        $listas = self::obtenerListasCompartidas($id_usuario);

        if (is_array($listas) && count($listas) > 0) {
            echo '<div class="container">';
            echo '<div class="row row-cols-1 row-cols-md-3 g-4">'; // Grid con 3 columnas para pantallas grandes

            foreach ($listas as $lista) {
                // Card para cada lista
                echo '<div class="col mb-4">';
                echo '<div class="card shadow-lg border-light rounded">';

                // Imágenes de fondo de cada lista
                echo '<div class="card-header bg-primary text-white text-center">';
                echo '<h5 class="card-title">' . htmlspecialchars($lista->lis_nombre) . '</h5>';
                echo '</div>';

                echo '<div class="card-body">';

                // Botones estilizados
                echo '<div class="d-grid gap-2">';

                // Asegúrate de escapar correctamente el ID de la lista en el atributo 'data-idLista'
                echo '<a href="#" class="btn btn-outline-primary btnEscuchar" data-idLista="' . $lista->id . '">Escuchar</a>';
                echo '<a href="../include/funciones.php?viewcompartir=' . $lista->id . '" class="btn btn-outline-secondary btnCompartir" data-idLista="' . $lista->id . '">Compartir</a>';


                echo '</div>'; // Cierre de d-grid
                echo '</div>'; // Cierre de card-body

                echo '</div>'; // Cierre de card
                echo '</div>'; // Cierre de col
            }

            echo '</div>'; // Cierre del grid
            echo '</div>'; // Cierre del contenedor
        } else {
            echo '<div class="alert alert-warning text-center" role="alert">No tienes listas disponibles.</div>';
        }

        // Reproductor central
        echo '<div class="jumbotron mt-4">
            <div id="mainwrap">
                <div id="audiowrap">
                    <div id="audio0">
                        <audio preload id="audioPlayer" controls>¡Su navegador no soporta Audio HTML5!</audio>
                    </div>
                    <div id="npTitle" class="mt-2"></div>
                    <div class="info mb-2"></div>
                    <div id="tracks">
                        <a id="btnPrev" class="btn btn-custom" style="background:#3b82f6; color:#fff; margin-right:10px;">&lArr;</a>
                        <a id="btnNext" class="btn btn-custom" style="background:#3b82f6; color:#fff;">&rArr;</a>
                    </div>
                </div>
            </div>
          </div>';


        //inserto datos para luego regogerlos con js

        echo '<?php $usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : ""; ?>';

        echo '<div id="datosSesion"
     data-usuario="' . $usuario . '"
     style="display:none;"></div>';

        // Scripts JS
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="/programacion/Musica/js/mi_lista.js"></script>';
    }


}
