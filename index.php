<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>File Upload</title>
		<style>
			*{
				text-align: center;
			}
			
		</style>
	</head>
	<body>
		<form action="subida.php" method="post" enctype="multipart/form-data">
			Selecciona el archivo a subir:
			<input type="file" name="imagen" id="imagen">
			<input type="submit" value="Enviar">
		</form>
	</body>
</html>


