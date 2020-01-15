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

$paginaAtiva = 'editarCliente';


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$msgErro = "";

	$nome = $cpf = $telefone = $dataNascimento = $sexo = $profissao = $estadoCivil = $email = $cep = "";
	$logradouro = $numero = $complemento = $bairro = $estado = $cidade = $statusCliente =  "";

	$id             = filtraEntrada($_POST["id"]); 
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

	$dataNascimentoP = explode('/',$dataNascimento);
	$dataNasimentoSql = $dataNascimentoP[2].'-'.$dataNascimentoP[1].'-'.$dataNascimentoP[0];

	try{    
		$conn = conectaAoMySQL();
		$sql = "
			update Clientes
			set nome = '$nome',cpf = '$cpf',telefone = '$telefone',dataNascimento = '$dataNasimentoSql',
			sexo = '$sexo',profissao = '$profissao',estadoCivil = '$estadoCivil',email = '$email',cep = '$cep', logradouro = '$logradouro', numero = '$numero', complemento = '$complemento',
			bairro = '$bairro',estado = '$estado',cidade = '$cidade'
			WHERE id = $id 
		";
			if (! $conn->query($sql))
				throw new Exception("Falha na atualização dos dos dados: " . $conn->error);
			else{
				@header("Location: listarCliente.php",TRUE);
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
	class Cliente {
		public $id;
		public $nome;
		public $cpf;
		public $telefone;
		public $dataNascimento;
		public $sexo;
		public $profissao;
		public $estadoCivil;
		public $email;
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
			SELECT id,nome,cpf,telefone,dataNascimento,sexo,profissao,estadoCivil,email,cep,logradouro,numero,complemento,bairro,estado,cidade
				FROM Clientes WHERE id = $id 
		";

		$result = $conn->query($sql);

		if (! $result)
			throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);
			
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$Cliente = new Cliente();
			$Cliente->id 	   		  = $row["id"];
			$Cliente->nome 	   		  = $row["nome"];
			$Cliente->cpf 		  	  = $row["cpf"];
			$Cliente->telefone  	  = $row["telefone"];
			$Cliente->dataNascimento  = formataData($row["dataNascimento"]);
			$Cliente->sexo 	 		  = $row["sexo"];
			$Cliente->profissao  	  = $row["profissao"];
			$Cliente->estadoCivil 	  = $row["estadoCivil"];
			$Cliente->email           = $row["email"];
			$Cliente->cep  			  = $row["cep"];
			$Cliente->logradouro  	  = $row["logradouro"];
			$Cliente->numero          = $row["numero"];
			$Cliente->complemento     = $row["complemento"];
			$Cliente->bairro          = $row["bairro"];
			$Cliente->estado          = $row["estado"];
			$Cliente->cidade          = $row["cidade"];
		}
    }catch (Exception $e) {
        echo "Nao foi possivel editar o cliente: ", $e->getMessage();
	}
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title> MBImobiliaria - Edição de Cliente</title>
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
			<h2>Edição de Cliente</h2><br>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formCadastroFuncionario"> 
			<h3>Dados Pessoais</h3><br>
			<div class="form-row">
					<div class="form-group col-md-3">
						<label for="nome">Nome:*</label>
						<input  <?php echo "value='$Cliente->nome'";?> maxlength="100" type="text" name="nome" class="form-control" required placeholder="Digite o nome do cliente"/>
					</div>
					<div class="form-group col-md-1">
						<label for="sexo">Sexo:*</label>
						<select required class="form-control custom-select" name="sexo" id="sexoFuncionario">
							<option value="<?php echo $Cliente->sexo;?>" selected><?php echo $Cliente->sexo;?></option>
							<option value="M">M</option>
							<option value="F">F</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="cpf">Cpf:*</label>
						<input  <?php echo "value='$Cliente->cpf'";?>  maxlength="15" type="text" class="form-control cpf" required name="cpf" placeholder="000.000.000-00"/>
					</div>
					<div class="form-group col-md-2">
						<label for="telefone">Telefone:*</label>
						<input <?php echo "value='$Cliente->telefone'";?> maxlength="15" type="text" name="telefone" required class="form-control telefone" placeholder="(00)0000-0000" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="dataNascimento">Data de Nascimento:*</label>
						<input <?php echo "value='$Cliente->dataNascimento'";?> type="text" name="dataNascimento" required class="form-control data" placeholder="dd/mm/aaaa"/>
					</div>
					<div class="form-group col-md-2">
						<label for="dataIngresso">Data de Ingresso:*</label>
						<input maxlength="10" type="text" name="dataIngresso" required class="form-control data" required placeholder="dd/mm/aaaa" />
					</div>
					<div class="form-group col-md-2">
						<label for="estadoCivil">Estado Cívil:*</label>
						<select required name="estadoCivil" class="custom-select form-control" required >
							<option value="<?php echo $Cliente->estadoCivil;?>"selected><?php echo $Cliente->estadoCivil;?></option>
							<option value="Solteiro(a)">Solteiro(a)</option>
							<option value="Casado(a)">Casado(a)</option>
							<option value="Gerente(a)">Viúvo(a)</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="profissao">Profissao:</label>
						<input  <?php echo "value='$Cliente->profissao';"?> type="text" maxlength="100" name="profissao" class="form-control" placeholder="Profissão" />
					</div>
					<div class="form-group col-md-3">
						<label for="email">E-mail:</label>
						<input  <?php echo "value='$Cliente->email'";?> maxlength="50" type="text" name="email" class="form-control" placeholder="E-mail" />
					</div>
				</div><br>
					
				<h3>Dados de Endereço</h3>
				<br>
				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cep">Cep:*</label>
						<input <?php echo "value='$Cliente->cep'";?>  maxlength="10" type="text" name="cep" class="form-control cep" required placeholder="00000-000" onblur="buscaEndereco(this.value);" />
					</div>
					<div class="form-group col-md-3">
						<label for="rua">Rua:*</label>
						<input  <?php echo "value='$Cliente->logradouro'";?> maxlength="50" type="text" required name="logradouro" id="LogradouroFunc" placeholder="Rua" class="form-control" />
					</div>
					<div class="form-group col-md-3">
						<label for="bairro">Bairro:*</label>
						<input <?php echo "value='$Cliente->bairro'";?> maxlength="50" type="text" name="bairro" id="bairroFunc" placeholder="Bairro" required class="form-control" />
					</div>
					<div class="form-group col-md-1">
						<label for="telefone">Número:*</label>
						<input <?php echo "value='$Cliente->numero'";?> type="number" name="numero" placeholder="Nº" required class="form-control" />
					</div>
					<div class="form-group col-md-2">
						<label for="complemento">Complemento:</label>
						<input  <?php echo "value='$Cliente->complemento'";?>  maxlength="50" type="text" name="complemento" placeholder="Complemento" class="form-control" />
					</div>
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-2">
						<label for="cidade">Cidade:*</label>
						<input <?php echo "value='$Cliente->cidade'";?>  maxlength="50" class="form-control" type="text" name="cidade" id="cidadeFunc" required placeholder="Cidade" readonly />					
					</div>
					<div class="form-group col-md-2">
						<label for="estado">Estado:*</label>
						<input <?php echo "value='$Cliente->estado'";?> maxlength="2" type="text" name="estado" id="estado" placeholder="UF" required class="form-control" readonly />
					</div>
					<input style="display:none" <?php echo "value='$Cliente->id'";?>  class="form-control" type="text" name="id"/>	
				</div><br>

				<div class="form-row">
					<div class="form-group col-md-12">
						<button type="submit" name="btnEditaCliente" id="btnEditaCliente" class="btn btn-secondary btn-lg btn-block">Salvar</button>
						<a class="btn btn-light btn-lg btn-block" href="listarCliente.php">Voltar</a> 
					</div>
				</div><br>
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





	



 


