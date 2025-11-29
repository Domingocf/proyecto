<?php
class Comentario
{
    private $id;
    private $descripcion;
    private $activo;

    public function __construct($id = null, $descripcion = '', $activo = false)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->activo = (bool)$activo;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function isActivo()
    {
        return $this->activo;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setActivo($activo)
    {
        $this->activo = (bool)$activo;
    }

    // Obtener último ID de comentario
    public static function obtenerUltimoIdComentario()
    {
        $con = new bd();
        $conexion = $con->Conectar();

        try {
            $consulta = $conexion->prepare("SELECT MAX(id) AS ultimo_id FROM comentarios");
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado['ultimo_id'] ?? null;
        } catch (Exception $e) {
            echo "Error al obtener el último ID: " . $e->getMessage();
            return null;
        }
    }

    // Crear nuevo comentario
    public static function crearComentario($descripcion, $usuario, $cancion, $parent_id)
    {
        $con = new bd();
        $conexion = $con->Conectar();

        try {

            if ($parent_id == null) {
                // Insertar comentario
                $consulta = $conexion->prepare("INSERT INTO comentarios (descripcion, activo, usuario)
                                        VALUES (:descripcion, :activo, :usuario)");
                $consulta->bindValue(':descripcion', $descripcion);
                $consulta->bindValue(':activo', 1, PDO::PARAM_INT);
                $consulta->bindValue(':usuario', $usuario);
                $consulta->execute();
            } else {
                $consulta = $conexion->prepare("INSERT INTO comentarios (descripcion, activo, usuario, responde)
                                VALUES (:descripcion, :activo, :usuario, :parent_id)");
                $consulta->bindValue(':descripcion', $descripcion);
                $consulta->bindValue(':activo', 1, PDO::PARAM_INT);
                $consulta->bindValue(':usuario', $usuario);
                $consulta->bindValue(':parent_id', $parent_id, PDO::PARAM_INT); // ahora sí
                $consulta->execute();
            }


            // ID del comentario recién insertado
            $comentario = $conexion->lastInsertId();

            $consulta2 = $conexion->prepare("INSERT INTO esde (cancion, comentario)
                                         VALUES (:cancion, :comentario)");
            $consulta2->bindValue(':cancion', $cancion, PDO::PARAM_INT);
            $consulta2->bindValue(':comentario', $comentario, PDO::PARAM_INT);
            $consulta2->execute();

            return true;
        } catch (Exception $e) {
            echo "Error al crear comentario: " . $e->getMessage();
            return false;
        }
    }

    // Listar comentarios activos (puedes adaptarlo a una canción concreta si lo deseas)
    public static function listarComentarios($idCancion)
    {
        $con = new bd();
        $conexion = $con->Conectar();

        try {
            // Traer todos los comentarios de la canción
            $sql = "SELECT c.id, c.descripcion, c.responde, u.username
                FROM comentarios c
                INNER JOIN esde e ON e.comentario = c.id
                INNER JOIN usuarios u ON u.id = c.usuario
                WHERE c.activo = 1 AND e.cancion = :idCancion
                ORDER BY c.id ASC";

            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(':idCancion', $idCancion, PDO::PARAM_INT);
            $consulta->execute();
            $todos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $comentarios = [];
            $respuestas = [];

            foreach ($todos as $fila) {
                if ($fila['responde'] === null) {
                    $fila['respuestas'] = [];
                    $comentarios[$fila['id']] = $fila;
                } else {
                    $respuestas[] = $fila;
                }
            }

            // Asignar respuestas a cada comentario padre
            foreach ($respuestas as $r) {
                $padreId = $r['responde'];
                if (isset($comentarios[$padreId])) {
                    $comentarios[$padreId]['respuestas'][] = $r;
                }
            }

            if (empty($comentarios)) {
                echo "<p>No hay comentarios todavía.</p>";
                return;
            }

            echo "<div id='lista-comentarios'>";
            $num=10;
            foreach ($comentarios as $c) {
                // Comentario principal
                echo "<div class='card mb-3 shadow-sm border-0 comentario' data-id='{$c['id']}'>";
                echo "  <div class='card-body'>";
                echo "    <h6 class='card-subtitle mb-2 text-muted'>" . htmlspecialchars($c['username'], ENT_QUOTES, 'UTF-8') . "</h6>";
                echo "    <p class='card-text'>" . nl2br(htmlspecialchars($c['descripcion'], ENT_QUOTES, 'UTF-8')) . "</p>";
                echo "    <button class='btn btn-sm btn-link responder-btn'>Responder</button>";
                echo "<button class='btn btn-sm btn-link text-danger reportar-btn' style='float: right;' data-id='{$c['id']}'>Reportar</button>";
                
                // Respuestas del comentario
                if (!empty($c['respuestas'])) {
                    echo "    <div class='respuestas mt-2'>";
                    foreach ($c['respuestas'] as $r) {
                        echo "<div class='card mb-2 shadow-sm border-0 ms-4'>";
                        echo "  <div class='card-body p-2' style='margin-left: {$num}%;'>";
                        echo "    <h6 class='card-subtitle mb-1 text-muted small'>" . htmlspecialchars($r['username'], ENT_QUOTES, 'UTF-8') . "</h6>";
                        echo "    <p class='card-text small mb-0'>" . nl2br(htmlspecialchars($r['descripcion'], ENT_QUOTES, 'UTF-8')) . "</p>";
                        echo "  </div>";
                        echo "<button class='btn btn-sm btn-link text-danger reportar-btn' style='float: right;' data-id='{$r['id']}'>Reportar</button>";

                        echo "</div>";

                        if($num<70){
                        $num+=10;
                    }
                    }
                    echo "    </div>";
                    
                }
              
                echo "  </div>";
                echo "</div>";
            }
            echo "</div>";
        } catch (Exception $e) {
            echo "Error al listar comentarios: " . $e->getMessage();
        }
    }

    public static function cargarComentarios($idCancion)
    {
        $con = new bd();
        $conexion = $con->Conectar();
        $comentariosArray = [];

        try {
            $sql = "SELECT c.id, c.descripcion, u.username
                FROM comentarios c
                INNER JOIN esde e ON e.comentario = c.id
                INNER JOIN usuarios u ON u.id = c.usuario
                WHERE c.activo = 1 AND e.cancion = :idCancion
                ORDER BY c.id DESC";

            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(':idCancion', $idCancion, PDO::PARAM_INT);
            $consulta->execute();
            $comentarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

            foreach ($comentarios as $fila) {
                $comentariosArray[] = [
                    'id' => $fila['id'],
                    'username' => $fila['username'],
                    'descripcion' => $fila['descripcion'],
                    'respuestas' => [] // si quieres manejar subcomentarios
                ];
            }
        } catch (Exception $e) {
            // manejar error si quieres
        }

        return $comentariosArray;
    }

    public static function anadirReporte($comentario,$usuario){
        $con = new bd();
        $conexion = $con->Conectar();

        try {

                // Insertar comentario
                $consulta = $conexion->prepare("INSERT INTO reportes (comentario, usuario ,estado) VALUES (:comentario,:usuario,:estado)");
                $consulta->bindValue(':comentario', $comentario);
                $consulta->bindValue(':usuario', $usuario);
                $consulta->bindValue(':estado', 'pendiente');
                $consulta->execute();
            

            return true;
        } catch (Exception $e) {
            echo "Error al crear comentario: " . $e->getMessage();
            return false;
        }
    }
}
