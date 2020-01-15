<?php

	session_start();

	if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
	echo $_SESSION['loginErro'];
	unset($_SESSION['usuario']);
	session_destroy();
	@header("Location: index.php",TRUE);
}
?>

<?php

require "conectaBanco.php";

$paginaAtiva = 'listarFuncionario';

$msgErro = "";

try{
	$conn = conectaAoMySQL();
	$arrayFuncionarios = getFuncionarios($conn);  
}catch (Exception $e){
	$msgErro = $e->getMessage();
}

class Funcionario {
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
	public $login;
	public $senha;	
}

function formataData($data){
	$dataExplode = explode('-',$data);
	$dataNasimentoSql = $dataExplode[2].'/'.$dataExplode[1].'/'.$dataExplode[0];
	return $dataNasimentoSql;
}


function getFuncionarios($conn){
	$arrayFuncionarios = null;

	$SQL = "
		SELECT id,nome,telefone,dataIngresso,salario,cargo,cpf,Cep,logradouro,numero,complemento,bairro,estado,cidade,login,senha
		FROM Funcionarios WHERE statusFuncionario = 'A'
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$Funcionario = new Funcionario();
            $Funcionario->id 	   		  = $row["id"];
			$Funcionario->nome 	   		  = $row["nome"];
			$Funcionario->telefone 		  = $row["telefone"];
			$Funcionario->dataIngresso    = formataData($row["dataIngresso"]);
			$Funcionario->salario  		  = $row["salario"];
			$Funcionario->cargo 	      = $row["cargo"];
			$Funcionario->cpf             = $row["cpf"];
			$Funcionario->Cep  			  = $row["Cep"];
			$Funcionario->logradouro  	  = $row["logradouro"];
			$Funcionario->numero          = $row["numero"];
			$Funcionario->complemento     = $row["complemento"];
			$Funcionario->bairro          = $row["bairro"];
			$Funcionario->estado          = $row["estado"];
			$Funcionario->cidade          = $row["cidade"];
			$Funcionario->login  		  = $row["login"];
			$Funcionario->senha  		  = $row["senha"];
			$arrayFuncionarios[]   	      = $Funcionario;
		}
	}

	return $arrayFuncionarios;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Funcionários</title>
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
			include "navBarRestrita.php";
		?><br>
		<div class="container">
			<div class="dadosFuncionario">
				<div class="container">
					<table id="gridContato" class="table table-striped table-dark table-responsive-lg" >
						<thead class="thead-dark">
							<tr class="dados">
								<th scope="col">ID</th>
								<th scope="col">Nome</th>
								<th scope="col">Telefone</th>
								<th scope="col">Cpf</th>	
								<th scope="col">Ingresso</th>
								<th scope="col">Salario</th>
								<th scope="col">Cargo</th>
								<th scope="col">Login</th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody class="dados">
							<?php
								if ($arrayFuncionarios != null){
									foreach ($arrayFuncionarios as $funcionario){       
										echo "
										<tr >
											<td width='1'>$funcionario->id</td>	
											<td width='150'>$funcionario->nome</td>
											<td width='130'>$funcionario->telefone</td>
											<td width='140'>$funcionario->cpf</td>
											<td width='10'>$funcionario->dataIngresso</td>
											<td width='10'>$funcionario->salario</td>
											<td width='10'>$funcionario->cargo</td>
											<td width='10'>$funcionario->login</td>
											<td width='140'><a href='editarFuncionario.php?id=$funcionario->id' class='btn btn-secondary btn-sm'</a>Editar</td>
											<td width='140'><a href='excluirFuncionario.php?id=$funcionario->id' class='btn btn-danger btn-sm'</a>Excluir</td>
										</tr> 
										";
									}
								}
							?>    
						</tbody>	
					</table>
					<?php  
					if ($msgErro != "")
						echo "<p class='text-danger'><strong>A operação não pode ser realizada: $msgErro</strong></p>";
					?>
					<br><br>
				</div>
			</div>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>

</body>
</html>



