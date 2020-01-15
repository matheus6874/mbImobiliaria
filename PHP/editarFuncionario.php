<?php
	session_start();

	if($_SESSION['usuario']=="" || $_SESSION['usuario']==null){
		echo $_SESSION['loginErro'];
		unset($_SESSION['usuario']);
		session_destroy();
		@header("Location: index.php",TRUE);
	}
?>

<?php

	require "conectaBanco.php";

	$paginaAtiva = 'editarFuncionario';

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$msgErro = "";
		$nome = $telefone = $dataIngresso = $salario = $cargo = $cpf = $cep = "";
		$logradouro = $numero = $complemento = $bairro = $estado = $cidade = $id = "";

		$id                          = filtraEntrada($_POST["id"]); 
		$nome           		     = filtraEntrada($_POST["nome"]);     
		$telefone       		     = filtraEntrada($_POST["telefone"]) ;
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

		$dataIngressoP = explode('/',$dataIngresso);
		$dataIngressoSql = $dataIngressoP[2].'-'.$dataIngressoP[1].'-'.$dataIngressoP[0];

		try{    
			$conn = conectaAoMySQL();
			$sql = "
				update Funcionarios
				set nome = '$nome',telefone = '$telefone',dataIngresso = '$dataIngressoSql',
				salario = '$salario',cargo = '$cargo', cpf = '$cpf', logradouro = '$logradouro', numero = '$numero', complemento = '$complemento',
				bairro = '$bairro',estado = '$estado',cidade = '$cidade'
				WHERE id = $id 
			";
				if (! $conn->query($sql))
					throw new Exception("Falha na atualização dos dos dados: " . $conn->error);
				else{
					@header("Location: listarFuncionario.php",TRUE);
				}
					
		}catch (Exception $e){
			$msgErro = $e->getMessage();
		}	
	}
?>

<?php

	$msgErro = "";
	
	function filtraEntrada($dado) {
		$dado = trim($dado);              
		$dado = stripslashes($dado);     
		$dado = htmlspecialchars($dado); 
		return $dado;
	}

	function formataData($data){
		$dataExplode = explode('-',$data);
		$dataNasimentoSql = $dataExplode[2].'/'.$dataExplode[1].'/'.$dataExplode[0];
		return $dataNasimentoSql;
	}

	if (isset($_GET["id"])){
		class Funcionario{
		public $id;
		public $nome;
		public $telefone;
		public $dataIngresso;
		public $salario;
		public $cargo;
		public $cpf;
		public $cep;
		public $logradouro;
		public $numero;
		public $complemento;
		public $bairro;
		public $estado;
		public $cidade;
	}	
    try{
        $conn = conectaAoMySQL();

        $id = filtraEntrada($_GET["id"]);
		$sql = "
			SELECT id,nome,telefone,dataIngresso,salario,cargo,cpf,Cep,logradouro,numero,complemento,bairro,estado,cidade
				FROM Funcionarios WHERE id = $id 
		";

		$result = $conn->query($sql);

		if (! $result)
			throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);
			
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$Funcionario = new Funcionario();
			$Funcionario->id 	   		  = $row["id"];
			$Funcionario->nome 	   		  = $row["nome"];
			$Funcionario->telefone 		  = $row["telefone"];
			$Funcionario->dataIngresso    = formataData($row["dataIngresso"]);
			$Funcionario->salario  		  = $row["salario"];
			$Funcionario->cargo 	      = $row["cargo"];
			$Funcionario->cpf             = $row["cpf"];
			$Funcionario->cep  			  = $row["Cep"];
			$Funcionario->logradouro  	  = $row["logradouro"];
			$Funcionario->numero          = $row["numero"];
			$Funcionario->complemento     = $row["complemento"];
			$Funcionario->bairro          = $row["bairro"];
			$Funcionario->estado          = $row["estado"];
			$Funcionario->cidade          = $row["cidade"];
		}
    }catch (Exception $e) {
        echo "Nao foi possivel editar o funcionário: ", $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title> MBImobiliaria - Edição de Funcionário</title>
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
		?><br>

		<div class="container">
			<h2>Edição de Funcionário</h2><br>
  			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="formCadastroFuncionario" class="formCadastroFuncionario">
				<h3>Dados Pessoais</h3><br>

				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="nome">Nome:*</label>
						<input <?php echo "value='$Funcionario->nome'";?>  maxlength="100" type="text" name="nome" id="nomeFunc" class="form-control" required placeholder="Nome do funcionário" />
					</div>

					<div class="form-group col-md-2">
						<label for="cpf">Cpf:*</label>
						<input <?php echo "value='$Funcionario->cpf'";?>  type="text" maxlength="14" class="form-control cpf" name="cpf" required placeholder="xxx.xxx.xxx-xx" />
					</div>

					<div class="form-group col-md-2">
						<label for="telefone">Telefone:*</label>
						<input <?php echo "value='$Funcionario->telefone'";?>  maxlength="12" type="text" name="telefone" class="form-control telefone" required placeholder="Telefone" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="dataIngresso">Data de Ingresso:*</label>
						<input <?php echo "value='$Funcionario->dataIngresso'";?> type="text" name="dataIngresso" required class="form-control data" required placeholder="dd/mm/aaaa" />
					</div>
					<div class="form-group col-md-2">
						<label for="cargo">Cargo:*</label>
						<select required name="cargo" id="cargoFunc" class="custom-select form-control">
							<option value="<?php echo "$Funcionario->cargo";?>" selected><?php echo "$Funcionario->cargo";?></option>
							<option value="Secretario(a)">Secretário(a)</option>
							<option value="Corretor(a)">Corretor(a)</option>
							<option value="Gerente(a)">Gerente(a)</option>
							<option value="Outros">Outros</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="salario">Salário:*</label>
						<input <?php echo "value='$Funcionario->salario'";?> maxlength="10" type="text" name="salario" class="form-control salario" required placeholder="Salário" />
					</div>
				</div><br>

				<h3>Dados de Endereço</h3><br>
				
				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cep">Cep:*</label>
						<input <?php echo "value='$Funcionario->cep'";?>  name="cep" class="form-control cep" required placeholder="00000-000" onblur="buscaEndereco(this.value);" />
					</div>
					<div class="form-group col-md-3">
						<label for="rua">Rua:*</label>
						<input <?php echo "value='$Funcionario->logradouro'";?> maxlength="50" type="text" name="logradouro" id="LogradouroFunc" required placeholder="Rua" class="form-control" />
					</div>
					<div class="form-group col-md-3">
						<label for="bairro">Bairro:*</label>
						<input <?php echo "value='$Funcionario->bairro'";?>  type="text" name="bairro" id="bairroFunc" placeholder="Bairro" required class="form-control" />
					</div>
					<div class="form-group col-md-1">
						<label for="telefone">Número:*</label>
						<input <?php echo "value='$Funcionario->numero'";?> type="number" min="-9999" max="9999" name="numero" id="numeroFunc" placeholder="Nº da casa" required class="form-control" />
					</div>
					<div class="form-group col-md-2">
						<label for="complemento">Complemento:</label>
						<input <?php echo "value='$Funcionario->complemento'";?>  maxlength="50" type="text" name="complemento" id="complementoFunc" placeholder="Complemento" class="form-control" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cidade">Cidade:*</label>
						<input <?php echo "value='$Funcionario->cidade'";?>  class="form-control" type="text" name="cidade" id="cidadeFunc" required placeholder="Cidade" readonly />						
					</div>
					<div class="form-group col-md-2">
						<label for="estado">Estado:*</label>
						<input <?php echo "value='$Funcionario->estado'";?>  maxlength="2" type="text" name="estado" id="estado" placeholder="UF" required class="form-control" readonly />
					</div>
					<input style="display:none" <?php echo "value='$Funcionario->id'";?>  class="form-control" type="text" name="id"/><br><br>

				</div><br>
				<div class="form-group"> 
        			<div class="col-sm-offset-1 col-sm-14">
						<button type="submit" name="btnEditaFormCadastroFuncionario" id="btnEditaFormCadastroFuncionario" class="btn btn-secondary btn-lg btn-block">Salvar</button>
						<a class="btn btn-light btn-lg btn-block" href="listarFuncionario.php">Voltar</a> 
        			</div>
      			</div>
			</form>
		</div>
		<?php  
			if ($msgErro != "")
				echo "<p class='text-danger'>A operação não pode ser realizada: $msgErro</p>";
		?>
		<?php
			include "rodape.php";
		?>
	</div>

</body>
</html>






 


