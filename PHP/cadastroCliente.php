<?php

	session_start();

	if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
		echo $_SESSION['loginErro'];
		unset($_SESSION['usuario']);
		session_destroy();
		@header("Location: index.php",TRUE);
	}

	$paginaAtiva = 'cadastroCliente';
	
	require "conectaBanco.php";

	function filtraEntrada($dado) {
			$dado = trim($dado);              
			$dado = stripslashes($dado);     
			$dado = htmlspecialchars($dado); 	  
			return $dado;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$msgErro = "";

		$nome = $cpf = $telefone = $dataNascimento = $sexo = $profissao = $estadoCivil = $email = $cep = "";
		$logradouro = $numero = $complemento = $bairro = $estado = $cidade = $statusCliente =  "";

		$nome           = filtraEntrada($_POST["nome"]);     
		$cpf       		= filtraEntrada($_POST["cpf"]);
		$telefone    	= filtraEntrada($_POST["telefone"]);
		$dataNascimento = filtraEntrada($_POST["dataNascimento"]);
		$sexo   		= filtraEntrada($_POST["sexo"]);     
		$profissao      = filtraEntrada($_POST["profissao"]);
		$estadoCivil   	= filtraEntrada($_POST["estadoCivil"]);
		$email    	  	= filtraEntrada($_POST["email"]);
		$cep            = filtraEntrada($_POST["cep"]);     
		$logradouro    	= filtraEntrada($_POST["logradouro"]);
		$numero    	  	= filtraEntrada($_POST["numero"]);
		$complemento    = filtraEntrada($_POST["complemento"]);     
		$bairro         = filtraEntrada($_POST["bairro"]);
		$estado    		= filtraEntrada($_POST["estado"]);
		$cidade    	 	= filtraEntrada($_POST["cidade"]);
		$statusCliente 	= 'A';

		$dataNascimentoP = explode('/',$dataNascimento);
		$dataNasimentoSql = $dataNascimentoP[2].'-'.$dataNascimentoP[1].'-'.$dataNascimentoP[0];

		try{    
			$conn = conectaAoMySQL();

			$sql = "
			INSERT INTO Clientes (nome, cpf, telefone,dataNascimento,sexo,profissao,estadoCivil,email,cep,logradouro,
			numero,complemento,bairro,estado,cidade,statusCliente)
			VALUES ('$nome', '$cpf', '$telefone','$dataNasimentoSql','$sexo','$profissao','$estadoCivil',
			'$email','$cep','$logradouro','$numero','$complemento','$bairro','$estado','$cidade','$statusCliente');
				";

			if (! $conn->query($sql))
				throw new Exception("Falha na inserção dos dados: " . $conn->error);
		}catch (Exception $e){
			$msgErro = $e->getMessage();
		}
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>MBImobiliaria - Cadastro de Clientes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
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
		?>
		<div class="container"><br>
		<?php 
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{  
				if ($msgErro == "" )
					echo "<div class='alert alert-success' role='alert'><strong>Dados armazenados com sucesso!</strong></div>";
				else
					echo "<div class='alert alert-danger' role='alert'><strong>Cadastro não realizado: $msgErro</strong></div>";
			}
		?>
			<h2>Cadastro de Clientes</h2><br> 
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-horizontal" class="formCadastroFuncionario" method = "POST">
				<h3>Dados Pessoais</h3><br>
				
				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="nome">Nome:*</label>
						<input maxlength="150" type="text" name="nome" class="form-control" required placeholder="Digite o nome do cliente"/>
					</div>
					<div class="form-group col-md-1">
						<label for="sexo">Sexo:*</label>
						<select required class="form-control custom-select" name="sexo" id="sexoFuncionario">
							<option value="" selected disabled>Sexo</option>
							<option value="M">M</option>
							<option value="F">F</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="cpf">Cpf:*</label>
						<input type="text" class="form-control cpf" required name="cpf" placeholder="000.000.000-00"/>
					</div>
					<div class="form-group col-md-2">
						<label for="telefone">Telefone:*</label>
						<input type="text" name="telefone" required class="form-control telefone" placeholder="(00)0000-0000" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="dataNascimento">Data de Nascimento:*</label>
						<input type="text" name="dataNascimento" required class="form-control data" placeholder="dd/mm/aaaa"/>
					</div>
					<div class="form-group col-md-2">
						<label for="estadoCivil">Estado Cívil:*</label>
						<select required name="estadoCivil" class="custom-select form-control" required >
							<option value="" disabled selected>Estado Cívil</option>
							<option value="Solteiro(a)">Solteiro(a)</option>
							<option value="Casado(a)">Casado(a)</option>
							<option value="Gerente(a)">Viúvo(a)</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="profissao">Profissao:</label>
						<input type="text" name="profissao" class="form-control" placeholder="Profissão" />
					</div>
					<div class="form-group col-md-3">
						<label for="email">E-mail:</label>
						<input maxlength="150" type="text" name="email" class="form-control" placeholder="E-mail" />
					</div>
				</div><br>
					
				<h3>Dados de Endereço</h3>
				<br>
				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cep">Cep:*</label>
						<input maxlength="10" name="cep" class="form-control cep" required placeholder="00000-000" onblur="buscaEndereco(this.value);" />
					</div>
					<div class="form-group col-md-3">
						<label for="rua">Rua:*</label>
						<input  maxlength="50" type="text" name="logradouro" id="LogradouroFunc" required placeholder="Rua" class="form-control" />
					</div>
					<div class="form-group col-md-3">
						<label for="bairro">Bairro:*</label>
						<input  maxlength="50" type="text" name="bairro" id="bairroFunc" placeholder="Bairro" required class="form-control" />
					</div>
					<div class="form-group col-md-1">
						<label for="telefone">Número:*</label>
						<input type="number" min="-9999" max="9999" name="numero" id="numeroFunc" placeholder="Nº" required class="form-control" />
					</div>
					<div class="form-group col-md-3">
						<label for="complemento">Complemento:</label>
						<input maxlength="50" type="text" name="complemento" id="complementoFunc" placeholder="Complemento" class="form-control" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cidade">Cidade:*</label>
						<input maxlength="50" class="form-control" type="text" name="cidade" id="cidadeFunc" required placeholder="Cidade" readonly />
					</div>
					<div class="form-group col-md-2">
						<label for="estado">Estado:*</label>
						<input maxlength="2" type="text" name="estado" id="estado" placeholder="UF" required class="form-control" readonly />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-12">
						<button type="submit" name="btnEnviarFormCadastroFuncionario" id="btnEnviarFormCadastroFuncionario" class="btn btn-secondary btn-lg btn-block">Cadastrar Funcionário</button>
						<button type="reset" class="btn btn-light btn-lg btn-block">Limpar formulário</button>
					</div>
				</div><br>
			</form>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>
</body>
</html>