<?php
	session_start();

	if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
		echo $_SESSION['loginErro'];
		unset($_SESSION['usuario']);
		session_destroy();
		@header("Location: index.php",TRUE);
	}

	require "conectaBanco.php";

	$conn = conectaAoMySQL();
?>

<?php
	$paginaAtiva = 'cadastroImovel';
	$msgErro = "";
	require 'classes/imovelClass.php';
	$p2 = new Imovel_class('3169608_mbimobiliaria','fdb22.awardspace.net','3169608_mbimobiliaria','PPI20192');
	$listaDeClientes = $p2->buscarClientes();

	if(($_SERVER["REQUEST_METHOD"] == "POST")){

		$areaQuadrada = "";
		$numeroApartamento = "";
		$andar = "";
		$valorCondominio = "";

		$tipoImovelDivSelect = addslashes($_POST['tipoImovel']);
		$codProprietario = $_POST['codProprietario'];
		$categoriaImovel = $_POST['categoriaImovel'];
		$valor = $_POST['valor'];
		$bairro = addslashes($_POST['bairro']);
		$qtdQuartos = addslashes($_POST['qtdQuartos']);
		$qtdSuites = addslashes($_POST['qtdSuites']);
		$descricaoImovel = addslashes($_POST['descricaoImovel']);
		
		if(isset($_POST['piscina']))
			$piscina = $_POST['piscina'];
		else
			$piscina = 0;

		if($_POST['areaQuadrada'] == ""){
			$areaQuadrada = 0;
		}else{
			$areaQuadrada = $_POST['areaQuadrada'];
		}

		if(isset($_POST['numeroApartamento'])){
			$numeroApartamento = $_POST['numeroApartamento'];
		}


		if($_POST['andar'] == ""){
			$andar = 0;
		}else{
			$andar = $_POST['andar'];
		}

		if(($_POST['valorCondominio']) == ""){
			$valorCondominio = 0;
		}else{
			$valorCondominio = $_POST['valorCondominio'];
		}

	
		$fotos = array(); //Recebe o nome das imagens

		$tipoImovel = "";

		if($tipoImovelDivSelect == '1'){
			$tipoImovel = 'Casa';
		}else{
			$tipoImovel = 'Apartamento';
		}

		$verifica = 0;

		if(count($_FILES['foto']['name']) <= 6){
			if(isset($_FILES['foto'])){//Verifica se foi enviado alguma foto
				for($i=0;$i<count($_FILES['foto']['name']);$i++){//verifica a quantidade de fotos que foram enviadas
					$nome_arquivo = md5($_FILES['foto']['name'][$i].rand(1,999)).'.jpg';//pega a imavem na posicao I e gera o nome para a foto
					move_uploaded_file($_FILES['foto']['tmp_name'][$i],'imagens/'.$nome_arquivo); //Move a foto para a pasta imagens e coloca o nome gerado
					//Primeiro parametro é onde está a imagem atual o outro é o destino
					//Salva o nome para mandar para o banco
					array_push($fotos ,$nome_arquivo);
				}
			}
		}else{
			$verifica = 1;
		}

		if($verifica == 0){
			$p2->enviarImovel($tipoImovel,$codProprietario,$categoriaImovel,$valor,$bairro,$qtdQuartos,$qtdSuites,$descricaoImovel,$areaQuadrada,$piscina,
			$numeroApartamento,$andar,$valorCondominio,$fotos);
		}
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Cadastro de Funcionários</title>
	<meta charset="utf-8">
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estiloRestrito.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../js/jquery.mask.min.js"></script>
	<script src="../js/jquery.validate.min.js"></script>
	<script src="../js/additional-methods.min.js"></script>
	<script src="../js/localization/messages_pt_BR.js"></script>
	<script src="../js/JavaScript.js"></script>
</head>
<body>
	<div class="container" >
		<?php
			include "navBarRestrita.php";
		?><br>
		<div class="container">
			<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") 
				{  
					if ($msgErro == "" && $verifica == 0)
						echo "<div class='alert alert-success' role='alert'><strong>Dados armazenados com sucesso!</strong></div>";
					else
						echo "<div class='alert alert-danger' role='alert'>Cadastro não realizado: Cadastre no máximo 6 fotos</div>";
				}
			?>
			<h2 class="tituloFormaFuncionario">Cadastro Imovél</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="formCadastroImovel" class="cadastroImovelForm" method="POST" enctype="multipart/form-data"><br>
				<div class="form-row">
					<div class="form-group col-md-2">
						<label class="control-label" for="tipoImovelDivSelect">Tipo do imóvel:*</label>
						<select required name="tipoImovel" id="tipoImovelDivSelect" class="custom-select form-control">
							<option value="" selected >Selecionar</option>
							<option value="1" >Casa</option> <!--No back converter 1 para casa e 2 para apartamento-->
							<option value="2" >Apartamento</option>
						</select>
					</div>
				</div><br>

				<h3>Informações do imóvel</h3><br>

				<div class="form-row">
					<div class="form-group col-md-2">
					    <label class="control-label" for="codProprietario">Proprietário:*</label>
					    <select required name="codProprietario" id="codProprietario" class="custom-select form-control">			
						    <?php				
							    if(empty($listaDeClientes)){
						            echo 'Nenhum cliente cadastrado';
					            }else{
							   
						  	   foreach($listaDeClientes as $value){
								?>						
								    <option value="<?php echo $value['id'];?>"><?php echo $value['nome'];?></option>
								<?php
							}
						}
					?>		
					</select>							
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" >Categoria:*</label>
						<select required name="categoriaImovel" id="categoriaImovel" class="custom-select form-control">
							<option value="" selected disabled>Selecionar</option>
							<option value="Aluguel">Aluguel</option>
							<option value="Venda">Venda</option>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="valor">Valor:*</label>
						<input required type="number" class="form-control" name="valor" id="valor" />
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="bairro">Bairro:*</label>
						<input maxlength="50" required type="text" class="form-control" name="bairro" id="bairro" />
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="qtdQuartos">Número Quartos:*</label>
						<input required type="number" class="form-control" name="qtdQuartos" id="qtdQuartos"/>
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="qtdSuites">Nº Suítes:*</label>
						<input required type="number" class="form-control" name="qtdSuites" id="qtdSuites" />
					</div>

					<div class="form-group col-md-10">
						<label class="control-label" for="descricaoImovel">Descricao:*</label>
						<input  maxlength="255" required type="text" class="form-control" name="descricaoImovel" id="descricaoImovel" />
					</div>
				</div><br>

				<div class="form-row" id ="imovelCasa" style="display: none">

					<div class="form-group col-md-2">
						<label class="control-label" for="areaQuadrada">Área do Terreno:</label>
						<input type="number" class="form-control" name="areaQuadrada" id="areaQuadrada"/>
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="piscina">Possui piscina?</label>
						<select name="piscina" id="piscina" class="custom-select form-control">
							<option value="" selected disabled>Selecionar</option>
							<option value="Sim">Sim</option>
							<option value="Não">Não</option>
						</select>
					</div>
				</div><br>

				<div class="form-row" id="imovelApartamento" style="display: none">
					<div class="form-group col-md-2">
						<label class="control-label" for="numeroApartamento">Nº do Apartamento:</label>
						<input maxlength="10" type="text" class="form-control" name="numeroApartamento" id="numeroApartamento" />
					</div>

					<div class="form-group col-md-1">
						<label class="control-label" for="andar">Andar:</label>
						<input type="number" class="form-control" name="andar" id="andar" />
					</div>

					<div class="form-group col-md-2">
						<label class="control-label" for="valorCondominio">Valor condomínio:</label>
						<input type="number" class="form-control" name="valorCondominio" id="valorCondominio" />
					</div>
				</div><br>
		
				<div class="form-row">
					<div class="form-group col-md-4">
						<div class="custom-file">
								<input required type="file" class="custom-file-input" name="foto[]" multiple id="foto">
								<label class="custom-file-label" for="inputGroupFile02">Selecione 6 fotos no máximo</label>
							</div>
					</div>
				</div>

				<div class="row">
					<div class="col"><br/>
						<button type="submit" id="botao" class="btn btn-secondary btn-lg btn-block">Cadastrar Imovél</button>
						<button type="reset" class="btn btn-light btn-lg btn-block">Limpar formulário</button>
					</div>
				</div>
			</form>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>
	
</body>
</html>




							