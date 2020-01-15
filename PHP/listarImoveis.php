<?php
	$paginaAtiva = 'pesquisaImovel';

	function filtraEntrada($dado) {
			$dado = trim($dado);              
			$dado = stripslashes($dado);     
			$dado = htmlspecialchars($dado); 	  
			return $dado;
	}
	
	$msgErro = "";

	$categoriaImovel = $bairro = $valorMinimo = $valorMaximo = $descricao = "";

	$categoriaImovel	= filtraEntrada($_POST["categoriaImovel"]);     
	$bairro       		= filtraEntrada($_POST["bairro"]);
	$valorMinimo    	= filtraEntrada($_POST["valorMinimo"]);
	$valorMaximo  		= filtraEntrada($_POST["valorMaximo"]);
	$descricao 			= filtraEntrada($_POST["descricao"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Cadastro de Funcionários</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			include "navBar.php";
		?><br>
		<div class="container">
			<section>
				<?php
					require 'classes/imovelClass.php';

					$p = new Imovel_class('3169608_mbimobiliaria','fdb22.awardspace.net','3169608_mbimobiliaria','PPI20192');
					$dadosImoveis = $p->buscarImoveis($categoriaImovel,$bairro,$valorMinimo,$valorMaximo,$descricao);
					if(empty($dadosImoveis)){
						echo 'Nenhum imóvel cadastrado';
					}else{
							foreach($dadosImoveis as $value){
								?>
								<a class="a" href="exibirImovel.php?id=<?php echo $value['id'];?>">
									<div>
										<img class="imagensMinhatura" src="imagens/<?php echo $value['foto_capa'];?>">
										<h2><?php echo "#".$value['id']." ". $value['descricao'];?></h2>
									</div>
								</a>
								<?php
							}
						}
					?>	
			</section>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>
</body>
</html>











