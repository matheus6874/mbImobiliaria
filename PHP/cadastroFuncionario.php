<?php

session_start();

if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
	echo $_SESSION['loginErro'];
	unset($_SESSION['usuario']);
	session_destroy();
	@header("Location: index.php",TRUE);
}

$paginaAtiva = 'cadastroFuncionario';

require "conectaBanco.php";

function filtraEntrada($dado) {
	$dado = trim($dado);              
	$dado = stripslashes($dado);     
	$dado = htmlspecialchars($dado); 
	  
		return $dado;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$msgErro = "";
	
		$nome = $telefone = $dataIngresso = $salario = $cargo = $cpf = $cep =  "";
		$logradouro = $numero = $complemento = $bairro = $estado = $cidade = $login = $senha = $statusFuncionario =  "";
	
		$nome           		     = filtraEntrada($_POST["nome"]);     
		$telefone       		     = filtraEntrada($_POST["telefone"]);
		$dataIngresso   			 = filtraEntrada($_POST["dataIngresso"]);     
		$salario    				 = filtraEntrada($_POST["salario"]);
		$cargo    	  	             = filtraEntrada($_POST["cargo"]);
		$cpf                         = filtraEntrada($_POST["cpf"]);     
		$cep                         = filtraEntrada($_POST["cep"]);
		$logradouro    	             = filtraEntrada($_POST["logradouro"]);
		$numero    	  	             = filtraEntrada($_POST["numero"]);
		$complemento                 = filtraEntrada($_POST["complemento"]);     
		$bairro                      = filtraEntrada($_POST["bairro"]);
		$estado    				     = filtraEntrada($_POST["estado"]);
		$cidade    	 				 = filtraEntrada($_POST["cidade"]);
		$login    	  				 = filtraEntrada($_POST["login"]);
		$senha    	  				 = filtraEntrada($_POST["senha"]);
		$confirmacaoSenhaFuncionario = filtraEntrada($_POST["confirmacaoSenhaFuncionario"]);
		$statusFuncionario = 'A';
		$senhaOk = false;
		$usuarioCadastro = false;
	
		$dataIngressoP = explode('/',$dataIngresso);
		$dataIngressoSql = $dataIngressoP[2].'-'.$dataIngressoP[1].'-'.$dataIngressoP[0];
		if($senha == $confirmacaoSenhaFuncionario){
			$senhaOk = true;
			try
			{    
				$conn = conectaAoMySQL();
				$sqlVerificaUsuario = " SELECT * FROM Funcionarios WHERE login = '$login'";
				$result = $conn->query($sqlVerificaUsuario);
				if (! $result)
					throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);
				if ($result->num_rows > 0){
					$usuarioCadastro = true;
				}else{
					$senhaHash = md5($senha);
					$sql = "
					INSERT INTO Funcionarios (nome, telefone,dataIngresso,salario,cargo,cpf,cep,
					logradouro,numero,complemento,bairro,estado,cidade,login,senha,statusFuncionario)
					VALUES ('$nome', '$telefone','$dataIngressoSql','$salario',
					'$cargo','$cpf','$cep','$logradouro','$numero','$complemento','$bairro','$estado','$cidade','$login','$senhaHash','$statusFuncionario');
					  ";
			
					if (! $conn->query($sql))
					  throw new Exception("Falha na inserção dos dados: " . $conn->error);
				}	
			}
			catch (Exception $e)
			{
				$msgErro = $e->getMessage();
			}
		}	
	}	  
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Cadastro de Funcionários</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<div class="container">
		<?php
			include "navBarRestrita.php";
		?><br>

		<div class="container">
			<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") {  
					if ($msgErro == "" && $senhaOk == true && $usuarioCadastro == false){
						echo "<div class='alert alert-success' role='alert'><strong>Dados armazenados com sucesso!</strong></div>";
					}
					elseif($senhaOk == false){
						echo "<div class='alert alert-danger' role='alert'><strong>Senhas não são iguais, favor digite senhas iguais</strong></div>";
					}	
					elseif($usuarioCadastro == true){
						echo "<div class='alert alert-danger' role='alert'><strong>Erro! Usuário já cadastrado, tente com outro login</strong></div>";
					}
					else{
						echo "<div class='alert alert-danger' role='alert'><strong>Cadastro não realizado: $msgErro</strong></div>";
					}	
				}
			?>
			<h2>Cadastro de Funcionários</h2><br>

			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-horizontal" class="formCadastroFuncionario" method = "POST">
				<h3>Dados Pessoais</h3><br>

				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="nome">Nome:*</label>
						<input maxlength="100" type="text" name="nome" id="nomeFunc" class="form-control" required placeholder="Nome do funcionário" />
					</div>

					<div class="form-group col-md-2">
						<label for="cpf">Cpf:*</label>
						<input type="text" maxlength="14" class="form-control cpf" name="cpf" required placeholder="xxx.xxx.xxx-xx" />
					</div>
					<div class="form-group col-md-2">
						<label for="telefone">Telefone:*</label>
						<input required maxlength="15" type="text" name="telefone" class="form-control telefone" placeholder="Telefone" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="dataIngresso">Data de Ingresso:*</label>
						<input maxlength="10" type="text" name="dataIngresso" required class="form-control data" required placeholder="dd/mm/aaaa" />
					</div>
					<div class="form-group col-md-2">
						<label for="cargo">Cargo:*</label>
						<select required name="cargo" id="cargoFunc" class="custom-select form-control">
								<option value="" disabled selected>Selecionar</option>
								<option value="Secretario(a)">Secretário(a)</option>
								<option value="Corretor(a)">Corretor(a)</option>
								<option value="Gerente(a)">Gerente(a)</option>
								<option value="Outros">Outros</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="salario">Salário:*</label>
						<input maxlength="10" type="text" name="salario" class="form-control salario" required placeholder="Salário" />
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
					<div class="form-group col-md-2">
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

				<h3>Dados do Sistema</h3>
				<br>
				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="login">Login:*</label>
						<input maxlength="50" class="form-control" type="text" name="login" id="loginFuncionrio" required placeholder="Login" />
					</div>
					<div class="form-group col-md-2">
						<label for="senha">Senha:*</label>
						<input class="form-control" type="password" name="senha" id="senhaFuncionario" required placeholder="Senha" />
					</div>
					<div class="form-group col-md-2">
						<label for="confirmacaoSenhaFuncionario">Senha:*</label>
						<input maxlength="32" class="form-control" type="password" name="confirmacaoSenhaFuncionario" id="confirmacaoSenhaFuncionario" required placeholder="Confirmar senha" onblur="verificaSenhas(this.value);"/>
					</div>
				</div><br>
				<br>
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