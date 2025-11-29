<?php
require_once '../MODELO/bd.php';

class cancion
{
	var $idCancion;
	var $titulo;
	var $size;
	var $lista;
	var $categoria;

	public function getIdCancion()
	{
		return $this->idCancion;
	}
	public function setIdCancion($idCancion)
	{
		$this->idCancion = $idCancion;
	}

	public function getTitulo()
	{
		return $this->titulo;
	}
	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function getSize()
	{
		return $this->size;
	}
	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getCategoria()
	{
		return $this->categoria;
	}
	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}

	public function __construct($titulo, $size, $categoria)
	{
		$this->titulo = $titulo;
		$this->size = $size;
		$this->categoria = $categoria;
	}

	public function crearCancion($titulo, $size, $categoria)
	{

		$con = new bd();
		$con->Conectar();

		$this->titulo = $titulo;
		$this->size = $size;
		$this->categoria = $categoria;

		try {
			$consulta = $con->conexion->prepare("INSERT INTO CANCIONES VALUES(NULL, :titulo, :size, :categoria)");
			$consulta->bindValue(':titulo', $this->titulo);
			$consulta->bindValue(':size', $this->size);
			$consulta->bindValue(':categoria', $this->categoria);
			$consulta->execute();

			return true;
		} catch (Exception $e) {
			echo $e;
		}
	}
	public function eliminarCancion($idCancion)
	{
		$con = new bd();
		$con->Conectar();

		$this->idCancion = $idCancion;

		try {
			$consulta = $con->conexion->prepare("DELETE FROM CANCIONES WHERE id = $this->idCancion ");
			$consulta->execute();

			return true;
		} catch (Exception $e) {
			echo $e;
		}
	}
	public static function CancionesPorLista($a)
	{
		$conexion = new bd();
		$conexion->Conectar();

		$consulta = $conexion->conexion->prepare("SELECT CANCIONES.id, can_titulo, can_size, LISTA_id FROM CANCIONES, LISTAS WHERE CANCIONES.LISTA_id = '$a' AND LISTA.id = '$a' AND listas.lis_activa='true' ");
		$consulta->execute();
		while ($rows = $consulta->fetchAll(\PDO::FETCH_OBJ)) {
			$tracks = $rows;
		}

		echo json_encode($tracks);
	}

	public static function CancionesPorId($listaId)
	{
		$conexion = new bd();
		$conexion->Conectar();

		// Selecciona todas las canciones de la lista indicada
		$consulta = $conexion->conexion->prepare(
			"SELECT id, can_titulo AS nombre, can_size AS size, lista
FROM CANCIONES join anade on canciones.id=cancion
where lista=:listaId"
		);
		$consulta->bindValue(':listaId', $listaId);
		$consulta->execute();

		$tracks = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}
	public static function cargarCanciones()
	{
		$conexion = new bd();
		$conexion->Conectar();

		// Selecciona todas las canciones
		$consulta = $conexion->conexion->prepare(
			"SELECT *
				FROM canciones
				WHERE can_titulo not LIKE '%anuncio%'
			"
		);
		$consulta->execute();

		$tracks = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}
	public static function cargarCancionesPorCat($cat)
	{
		$conexion = new bd();
		$conexion->Conectar();


		// Selecciona todas las canciones que no sean anuncios y filtradas por categoría
		$consulta = $conexion->conexion->prepare(
			"SELECT *
         FROM canciones
         WHERE can_titulo NOT LIKE '%anuncio%' AND categoria like :cat"
		);

		// Vincula el parámetro :cat con la variable $cat
		$consulta->bindParam(':cat', $cat, PDO::PARAM_STR);
		$consulta->execute();

		$tracks = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}

	public static function cargarAnuncios()
	{
		$conexion = new bd();
		$conexion->Conectar();

		// Selecciona todas las canciones
		$consulta = $conexion->conexion->prepare(
			"SELECT *
				FROM canciones
				WHERE can_titulo LIKE '%anuncio%' 
				"

		);
		$consulta->execute();

		$tracks = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}

	public static function cargarPorPalabra($palabra)
	{
		$conexion = new bd();
		$conexion->Conectar();

		$stmt = $conexion->conexion->prepare(
			"SELECT * 
			FROM canciones 
			WHERE can_titulo LIKE :palabra and can_titulo not like '%anuncio%' 
			LIMIT 5"
		);
		$stmt->bindParam(':palabra', $palabra, PDO::PARAM_STR);
		$stmt->execute();

		$tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}

	public static function cargarCancionesLista($listaId, $usuario)
	{
		include_once '../CONTROLLER/usuario.php';
		$conexion = new bd();
		$conexion->Conectar();
		$usuario = obtenerIdUsuario($usuario);

		// Selecciona todas las canciones
		$consulta = $conexion->conexion->prepare(
			"SELECT canciones.*
				FROM canciones
				join anade on id=cancion
				where usuario=:usuario and lista=:listaId"

		);
		$consulta->bindValue(':usuario', $usuario);
		$consulta->bindValue(':listaId', $listaId);
		$consulta->execute();

		$tracks = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $tracks;
	}

	public static function listarCanciones($pagina, $porPagina = 12, $lista)
	{
		if ($pagina < 1) $pagina = 1;

		$bd = new bd();
		$bd->Conectar();
		$conexion = $bd->conexion;

		$offset = ($pagina - 1) * $porPagina;
		// Mostrar input de filtro por lista
		$lista = $lista ?? '';
		echo '
<div class="mb-3 text-center">

    <input id="buscador" type="text" class="form-control mb-3" placeholder="Buscar cancion...">

     <div id="generos">
        <button class="btn btn-success m-1 pop">POP</button>
        <button class="btn btn-danger m-1 rock">ROCK</button>
        <button class="btn btn-warning m-1 hip-hop">Hip-Hop</button>
        <button class="btn btn-info m-1 jazz">Jazz</button>
        <button class="btn btn-warning m-1 clasica">Clásica</button>
        <button class="btn btn-info m-1 electronica">Electrónica</button>
        <button class="btn btn-danger m-1 regueton">Reguetón</button>
        <button class="btn btn-primary m-1 country">Country</button>
        <button class="btn btn-success m-1 blues">Blues</button>
        <button class="btn btn-danger m-1 metal">Metal</button>
    </div>

</div>';


		// Obtener total de canciones

		//añado el filtrar por lista y con mi usuario

		if ($lista) {
			$sqlTotal = "SELECT COUNT(*) as total FROM CANCIONES WHERE LISTA_id = :lista";
			$stmtTotal = $conexion->prepare($sqlTotal);
			$stmtTotal->bindValue(':lista', $lista, PDO::PARAM_INT);
		} else {
			$sqlTotal = "SELECT COUNT(*) as total FROM CANCIONES";
			$stmtTotal = $conexion->prepare($sqlTotal);
		}
		$sqlTotal = "SELECT COUNT(*) as total FROM CANCIONES";
		$stmtTotal = $conexion->prepare($sqlTotal);
		$stmtTotal->execute();
		$total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
		$totalPaginas = ceil($total / $porPagina);

		// Obtener canciones con limit y offset
		$sql = "SELECT * FROM CANCIONES LIMIT :offset, :porPagina";
		$stmt = $conexion->prepare($sql);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->bindValue(':porPagina', $porPagina, PDO::PARAM_INT);
		$stmt->execute();
		$canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Mostrar tarjetas
		echo "<div class='row' id='listaCanciones'>";
		foreach ($canciones as $cancion) {
			if ($cancion['id'] > 3) {
				$id = $cancion['id'];
				$audioId = 'audio' . $cancion['id'];
				echo "<div class='col-md-4 mb-4'>";
				echo "<div class='card h-100 cancion-card' data-audio='$audioId' style='cursor:pointer;'>";
				echo "<div class='card-body'>";
				echo "<h5 class='card-title'>
                <span style='font-size:24px;margin-right:10px;'>&#127925;</span>"
					. htmlspecialchars($cancion['can_titulo']) .
					"</h5>";
				echo "<a href='../include/funciones.php?favorito=$id'>♥️</a>";
				echo "<a href='../include/funciones.php?viewcomentar=$id'>📝</a>";
				echo "<a href='../include/funciones.php?viewañadir=$id'>➕</a>";

				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
		}
		echo "</div>";

		// Paginación "to molona"
		echo "<nav aria-label='Page navigation' class='mt-4'>";
		echo "<ul class='pagination justify-content-center'>";

		// Botón Anterior
		if ($pagina > 1) {
			$prev = $pagina - 1;
			echo "<li class='page-item'>
                <a class='page-link' href='?listarCanciones&pagina=$prev' style='color:#3b82f6; font-weight:600;'>&laquo; Anterior</a>
              </li>";
		} else {
			echo "<li class='page-item disabled'><span class='page-link'>&laquo; Anterior</span></li>";
		}

		// Números de página
		for ($i = 1; $i <= $totalPaginas; $i++) {
			$active = ($i == $pagina) ? 'active' : '';
			$color = ($i == $pagina) ? "background-color:#3b82f6; color:white; border:none;" : "color:#3b82f6;";
			echo "<li class='page-item $active'>
                <a class='page-link' href='?listarCanciones&pagina=$i' style='$color border-radius:8px; margin:0 3px;'>$i</a>
              </li>";
		}

		// Botón Siguiente
		if ($pagina < $totalPaginas) {
			$next = $pagina + 1;
			echo "<li class='page-item'>
                <a class='page-link' href='?listarCanciones&pagina=$next' style='color:#3b82f6; font-weight:600;'>Siguiente &raquo;</a>
              </li>";
		} else {
			echo "<li class='page-item disabled'><span class='page-link'>Siguiente &raquo;</span></li>";
		}

		echo "</ul>";
		echo "</nav>";

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

		// Scripts JS
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		  <script src="/programacion/Musica/js/reproducir.js"></script>';
	}
}
