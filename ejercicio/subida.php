<?php

/*
● Se comprobará que la imagen sea de un tipo permitido: png o jpg.
● Se comprobará que el tamaño de la imagen, máximo (360x480px).
● Se guardarán dos versiones de la imagen:
		360x480px - se mostrará en la página de perfil
		72x96px - se mostrará junto al nombre de usuario
Los nombres de las imágenes pueden ser:
idUserBig.png y idUserSmall.png
● El directorio donde se guardarán las imágenes será: /img/usuarios
● En la tabla de usuarios de la base de datos se deberá guardar la ruta a la
imagen en un campo del usuario.
*/

//var_dump($_FILES['imagen']);exit();
/*
list($width, $height, $type, $attr) = getimagesize($_FILES['imagen']['name']);

echo "Image width " .$width;
echo "<BR>";
echo "Image height " .$height;
echo "<BR>";
echo "Image type " .$type;
echo "<BR>";

exit();*/
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
if ($_FILES['imagen']['type'] != 'image/jpg' || $_FILES['imagen']['type'] != 'image/jpeg' || $_FILES['imagen']['type'] != 'image/png') { // Se comprueba que sea del tipo esperado
	echo 'Error: El archivo no tiene el formato. (jpg, png)';
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
		
		$loadedImage = $_FILES['imagen']['name'];
		list($width, $height) = getimagesize($loadedImage);

		header('Content-Type: image/jpeg');

		$smallImage = imagecreatetruecolor(72,96);
		$newImage = imagecreatefromjpeg($loadedImage);

		imagecopyresized($smallImage, $newImage, 0,0,0,0,72,96, $width, $height);
		imagejpeg($smallImage);

		imagedestroy($smallImage);

		echo "subido ok";
	}
}
else
	echo 'Error: posible ataque. Nombre: '.$_FILES['imagen']['name'];

?>
