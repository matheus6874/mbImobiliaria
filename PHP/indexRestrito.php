<?php
	
	session_start();

	if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
		echo $_SESSION['loginErro'];
		unset($_SESSION["usuario"]);
		
		session_destroy();
		@header("Location: index.php",TRUE);
	}

	$paginaAtiva = 'indexRestrito';
?>

<!DOCTYPE html>
<html>
<head>
	<title>MBImobiliaria - Área Restrita</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estiloRestrito.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../js/JavaScript.js"></script>
</head>

<body>
	<div class="container" >
		<?php
			include "navBarRestrita.php";
		?><br>

		<div id="conteudo">
			<h1 id="homeClick">MB Imobiliária</h1>

			<p id="homep">A More Bem Imobiliária tem como objetivo principal, atender as expectativas de proprietários de imóveis que necessitam de assessoria para a realização de seus negócios imobiliários.
				Trabalhando sempre baseados neste tripé: respeito, honestidade e competência, conseguiram, então, a credibilidade esperada de seus clientes.
				Esperamos que você encontre na More Bem Imobiliária tudo que você procura, pois esse é o nosso grande objetivo.
			</p>

			<h3 id="missaoClick" onmouseover="this.style.fontSize ='28px'" onmouseout="this.style.fontSize='24px'">Missão</h3>

			<p id="missao">
				Prestar serviços com qualidade, agilidade e segurança, superando as expectativas dos clientes, a fim de obter lucratividade com ética e respeito, proporcionando crescimento pessoal e profissional de todos 
				os colaboradores.<br>
			</p>

			<h3 id="valoresClick" onmouseover="this.style.fontSize ='28px'" onmouseout="this.style.fontSize='24px'">Valores</h3>

			<p id="valores">
				<strong>• Ética</strong> – atitudes pautadas no respeito, honestidade e transparência.<br><br>
				<strong>• Seriedade</strong> – comprometimento e profissionalismo, com foco na qualidade dos serviços prestados.<br><br>
				<strong>• Empreendedorismo</strong> – utilização da experiência, conhecimento e busca de soluções inovadoras e eficazes para a agilidade e qualidade de nossos resultados, com foco na sustentabilidade.<br><br>
			</p>

		</div><br>
		<?php
			include "rodape.php";
		?>
	</div>
</body>
</html>

