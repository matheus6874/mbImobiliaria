<?php
	$paginaAtiva = 'pesquisaImovel';

	$msgErro = "";
	require 'classes/imovelClass.php';
	$p2 = new Imovel_class('3169608_mbimobiliaria','fdb22.awardspace.net','3169608_mbimobiliaria','PPI20192');
	$listaDeBairros = $p2->buscarBairros();



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>MBImobiliaria - Buscar Imóvel</title>
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

		<div class="container">
			<form action="listarImoveis.php" method="POST" name="formPesquisaImovel" class="formPesquisaImovel" id="formPesquisaImovel">
				<h2>Infomações do Imóvel</h2><br> 

				<div class="row form-group">
					<div class="col-2">
						<label class="control-label" for="categoriaImovel">O que você precisa?</label><br>
						<select required name="categoriaImovel" id="categoriaImovel" class="custom-select form-control">
							<option value="" disabled selected>Selecionar</option> <!--Categoria do imóvel-->
							<option value="Venda">Comprar</option>
							<option value="Aluguel">Alugar</option>
						</select>
					</div>

					<div class="col-2">
					    <label class="control-label" for="bairro">Bairro:*</label>
					    <select required name="bairro" id="bairro" class="custom-select form-control">			
						    <?php				
							    if(empty($listaDeBairros)){
						            echo 'Nenhum bairro cadastrado';
					            }else{
							   
						  	   foreach($listaDeBairros as $value){
								?>						
								    <option value="<?php echo $value['bairro'];?>"><?php echo $value['bairro'];?></option>
								<?php
							}
						}
					?>		
					</select>							
					</div>

					<div class="col-2">
						<label class="control-label" for="valorMinimo">Qual valor mínimo?</label>
						<input required type="number" maxlength="14" class="form-control" name="valorMinimo" id="valorMinimo" placeholder="Mínimo"/>
					</div>

					<div class="col-2">
						<label class="control-label" >Qual valor máximo?</label>
						<input required type="number" maxlength="14" class="form-control" name="valorMaximo" id="valorMaximo" placeholder="Máximo"/>
					</div>

					<div class="col-4"> <!-- Verificar esse campo com o campo descrição da tabela -->
						<label class="control-label">Outras Infomações/Característica:</label>
						<input required type="text" maxlength="14" class="form-control" name="descricao" id="descricao" placeholder="Palavras chaves como (piscina, churrasqueira, etc.) " />
					</div>

					<div class="col"><br/>
						<button type="submit" name="btnPesquisaImovel" id="btnPesquisaImovel" class="btn btn-secondary btn-lg btn-block" >Buscar</button>
					</div>
				</div>
			</form>
		</div><br/>
	</div>
	<?php
		include "rodape.php";
	?>
</body>
</html>











