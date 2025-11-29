<?php
// include '../MODELO/lista.php';
// include '../MODELO/cancion.php';
// require_once '../MODELO/bd.php';


if (isset($_GET['accion'])) {
	$con = new mysqli("localhost", "root", "", "BDReproductor");
	$accion = $_GET['accion'];



	if ($accion == 'cargarCancionesLista') {
		try {
			include_once '../CONTROLLER/cancion.php';
			$listaId = $_GET['idLista'];
			$usuario = $_GET['username'];
			$tracks = cargarCancionesLista($listaId, $usuario);
			echo json_encode($tracks); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}



	if ($accion == 'agragarCacion') {
		try {
			include_once '../CONTROLLER/usuario.php';
			$ListaID = $_GET['ListaID'];
			$id_cancion = $_GET['id_cancion'];

			$id_usuario = obtenerIdUsuario($_SESSION['username']);
			$sql = "INSERT INTO anade (usuario ,lista, cacion)values ($id_usuario, $ListaID, $id_cancion)";
		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion == 'compartir') {
		try {
			include_once '../CONTROLLER/usuario.php';
			$conexion = new bd();
			$conexion->Conectar();

			$ListaID = $_GET['ListaID'];
			$id_cancion = $_GET['id_cancion'];
			$usuario = $_GET['username'];


			$id_usuario = obtenerIdUsuario($usuario);

			include_once '../CONTROLLER/lista.php';
			anadeCancion($id_usuario, $ListaID, $id_cancion);
		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion == 'mislistas') {
		try {
			include_once '../CONTROLLER/usuario.php';
			include_once '../CONTROLLER/lista.php';
			$username = $_GET['username'];
			$id_usuario = obtenerIdUsuario($username);
			$listas = obtenerListasUsuario($id_usuario); // Esta función debe retornar un array asociativo

			echo $listas;
		} catch (Exception $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion == 'cargarCanciones') {
		try {
			include_once '../CONTROLLER/cancion.php';
			$tracks = cancion::cargarCanciones();
			echo json_encode($tracks); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	if ($accion == 'filtrar') {
		try {
			$cat = $_GET["cat"];
			include_once '../CONTROLLER/cancion.php';
			$tracks = cancion::cargarCancionesPorCat($cat);
			echo json_encode($tracks); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion === 'buscar') {
		try {
			include_once '../CONTROLLER/cancion.php';
			$palabra = $_GET['palabra'] ?? '';
			$palabra = "%$palabra%";

			$tracks = cancion::cargarPorPalabra($palabra);
			echo json_encode($tracks); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	if ($accion === 'comentar') {
		session_start();
		include_once '../CONTROLLER/comentario.php';
		include_once '../CONTROLLER/usuario.php';

		$descripcion = $_POST['comentario'];
		$cancion = $_SESSION["cancion"];
		if(isset($_POST["parent_id"])){
			$parent_id=$_POST["parent_id"];
		}else{
			$parent_id=null;
		}

		// Crear comentario y relacionar en esde
		$idUsuario = usuario::obteneridUsuario(trim($_SESSION['usuario']));

		crearComentario($descripcion, $idUsuario, $cancion,$parent_id);

		// Traer comentarios actualizados
		$comentarios = cargarComentarios($_SESSION["cancion"]);

		echo json_encode($comentarios);
	}

	if ($accion === 'reportar') {
    session_start(); // opcional, por si necesitas el id_usuario o algo
		include_once '../CONTROLLER/comentario.php';
		include_once '../CONTROLLER/usuario.php';

		$id_comentario=$_POST["id_comentario"];
		$idUsuario = usuario::obteneridUsuario(trim($_SESSION['usuario']));

		reportar($id_comentario,$idUsuario);
}




	if ($accion == 'cargarAnuncios') {
		try {
			include_once '../CONTROLLER/cancion.php';
			$ads = cancion::cargarAnuncios();
			echo json_encode($ads); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion == 'registrar') {
		include_once '../CONTROLLER/cancion.php';
		$cantidad = $_GET['CantidadA'];
		$categoria = $_GET['categoria'];


		$i = 0;

		if ($cantidad == "" || $cantidad == 0) {
			echo "1";
			return false;
		}
		while ($i <= $cantidad - 1) {
			$ruta	 = $_FILES['files']['tmp_name'][$i];
			$titulo  = $_FILES['files']['name'][$i];
			$size  	 = $_FILES['files']['size'][$i];
			$tamaño = ($size / 1024) . " KB";


			if ($titulo == "") {
				echo "1";
			} else {


				$nuevaRuta = "../VIEWS/CANCIONES/audio/" . $titulo;

				try {
					move_uploaded_file($ruta, $nuevaRuta);
				} catch (Exception $e) {
					echo $e;
				}

				$array	= explode('.', $nuevaRuta);
				$ext 	= end($array);

				$cancion = new cancion($titulo, $tamaño, $categoria);
				$cancion->crearCancion($cancion->titulo, $cancion->size, $cancion->categoria);
			}

			$i++;
		}
	}
	if ($accion == 'mostrar') {
		try {
			include_once '../CONTROLLER/cancion.php';
			$ListaID = $_GET['ListaID'];
			$tracks = cancion::CancionesPorId($ListaID);
			echo json_encode($tracks); // Devuelve todas las canciones como JSON

		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	if ($accion == 'lista') {
		try {
			include_once '../CONTROLLER/lista.php';
			$lista = new lista("", "");
			$listas = $lista->mostrarListas(); // Esta función debe retornar un array asociativo

			echo json_encode($listas);
		} catch (Exception $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	if ($accion == 'addLista') {
		try {
			include_once '../CONTROLLER/usuario.php';
			include_once '../CONTROLLER/lista.php';

			$nombre = $_GET['lista'];
			$username = $_GET['username'];
			$crea = obtenerIdUsuario($username);
			$lista = new lista($nombre, $crea);
			$lista->crearLista();
			$lista->mostrarListas();
		} catch (Exception $e) {
			echo $e;
		}
	}
	if ($accion == 'editarIframe') {
		try {
			$ListaID = $_GET['lista'];

			$sql = "UPDATE listaiframe SET LISTA_id= $ListaID WHERE id=1";
			if (mysqli_query($con, $sql)) {
				echo "1";
			} else {
				echo "2";
			}
		} catch (Exception $e) {
			echo $e;
		}
	}
	if ($accion == 'CanLista') {
		include_once '../CONTROLLER/lista.php';
		$lista = new lista("", "");
		$lista->mostrarDetallesListas();
	}
	if ($accion == 'EliminarCancion') {
		include_once '../CONTROLLER/cancion.php';
		$id = $_GET['idCancion'];
		$cancion = new cancion("", "", "", "");
		$cancion->idCancion = $id;

		$cancion->eliminarCancion($cancion->idCancion);
	}

	if ($accion == 'EditarNombreLista') {
		include_once '../CONTROLLER/lista.php';
		$id = $_GET['idLista'];
		$nombre = $_GET['nombre'];
		$lista = new lista($id, $nombre);

		$lista->ActualizarLista($lista->idLista, $lista->nombre);
		$lista->mostrarDetallesListas();
	}

	if ($accion == 'EliminarListaConCanciones') {
		include_once '../CONTROLLER/lista.php';
		$id = $_GET['ListaID'];

		$lista = new lista($id, "");
		$lista->EliminarListaConCanciones($id);
	}

	if ($accion == 'obtenerUsername') {
		include_once '../CONTROLLER/usuario.php';
		$id_lista = $_GET['idLista'];
		$username = obtenerUsername($id_lista);
		echo json_encode($username);
	}
}
