<?php
	$paginaAtiva = 'galeria';
?>

<!DOCTYPE html>
<html>
<head>
	<title>MBImobiliaria - Galeria</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../css/estilo.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../js/JavaScript.js"></script>
</head>

<body>
	<div class="container">
		<?php
			include "navBar.php";
		?><br>
		
		<div id="galeria" class="container">
			<div style="overflow-x:auto;">
				<table class="center">
					<tr>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/fachada.jpg" id="img01" alt="fachada"></td>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/escritorio1.jpg" id="img02" alt="escritorio"></td>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/escritorio2.jpg" id="img03" alt="escritorio"></td>			
					</tr>
					<tr>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/escritorio3.jpg" id="img04" alt="negocio"></td>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/negocio.jpg" id="img05" alt="negocio"></td>
						<td class="col-sm-4"><img onmouseenter="destaca(this)" onmouseleave="destaca_n(this)" class="imgGalery" src="../images/negocio2.jpg" id="img06" alt="negocio"></td>
					</tr>		
				</table>
			</div>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>
</body>
</html>

