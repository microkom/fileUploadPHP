<?php


if ($_FILES['imagen']['error'] != UPLOAD_ERR_OK) { // Se comprueba si hay un error al subir el archivo
	echo 'Error: ';
	switch ($_FILES['imagen']['error']) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE: echo 'El fichero es demasiado grande'; break;
		case UPLOAD_ERR_PARTIAL: echo 'El fichero no se ha podido subir entero'; break;
		case UPLOAD_ERR_NO_FILE: echo 'No se ha podido subir el fichero'; break;
		default: echo 'Error indeterminado.';
	}
	exit();
}
if ($_FILES['imagen']['type'] != 'image/gif') { // Se comprueba que sea del tipo esperado
	echo 'Error: No se trata de un fichero .GIF.';
	exit();
}

// Si se ha podido subir el fichero se guarda
if (is_uploaded_file($_FILES['imagen']['tmp_name']) === true) {
	// Se comprueba que ese nombre de archivo no exista
	$nombre = './subidas/'.$_FILES['imagen']['name'];
	if (is_file($nombre) === true) {
		$idUnico = time();
		$nombre = $idUnico.'_'.$nombre;
	}
	// Se mueve el fichero a su nueva ubicación
	if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $nombre)) {
		echo 'Error: No se puede mover el fichero a su destino';
	}else{
		echo "subido ok";
	}
}
else
	echo 'Error: posible ataque. Nombre: '.$_FILES['imagen']['name'];

?>