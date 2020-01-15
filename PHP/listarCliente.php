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

$msgErro = "";

$paginaAtiva = 'listarCliente';

try{
	$conn = conectaAoMySQL();
	$arrayClientes = getClientes($conn);  
}catch (Exception $e){
	$msgErro = $e->getMessage();
}

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

function formataData($data){
	$dataExplode = explode('-',$data);
	$dataNasimentoSql = $dataExplode[2].'/'.$dataExplode[1].'/'.$dataExplode[0];
	return $dataNasimentoSql;
}


function getClientes($conn){
	$arrayClientes = null;

	$SQL = "
		SELECT id,nome,cpf,telefone,dataNascimento,sexo,profissao,estadoCivil,email,cep,logradouro,numero,complemento,bairro,estado,cidade
		FROM Clientes WHERE statusCliente = 'A'
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			$Cliente = new Cliente();
            $Cliente->id 	   		  = $row["id"];
			$Cliente->nome 	   		  = $row["nome"];
			$Cliente->cpf             = $row["cpf"];
			$Cliente->telefone 		  = $row["telefone"];
			$Cliente->dataNascimento  = formataData($row["dataNascimento"]);
			$Cliente->sexo 	 		  = $row["sexo"];
			$Cliente->profissao  	  = $row["profissao"];
			$Cliente->estadoCivil 	  = $row["estadoCivil"];
			$Cliente->email 	      = $row["email"];
			$Cliente->cep  			  = $row["cep"];
			$Cliente->logradouro  	  = $row["logradouro"];
			$Cliente->numero          = $row["numero"];
			$Cliente->complemento     = $row["complemento"];
			$Cliente->bairro          = $row["bairro"];
			$Cliente->estado          = $row["estado"];
			$Cliente->cidade          = $row["cidade"];
			$arrayClientes[]   	      = $Cliente;
		}
	}
	return $arrayClientes;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Clientes</title>
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
			<div class="dadosClientes">
				<div class="container-fluid">
					<table id="gridContato" class="table table-striped table-dark table-responsive-lg">
						<thead class="thead-dark">
							<tr class="dados">
								<th scope="col">Id</th>
								<th scope="col">Nome</th>
								<th scope="col">Cpf</th>
								<th scope="col">Telefone</th>
								<th scope="col">Sexo</th>
								<th scope="col">Nascimento</th>
								<th scope="col">Profissão</th>
								<th scope="col">Estado Cívil</th>
								<th scope="col">E-mail</th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody class="dados">
						<?php
						if ($arrayClientes != null){
							foreach ($arrayClientes as $cliente){       
								echo "
								<tr>
									<td>$cliente->id</td>	
									<td>$cliente->nome</td>
									<td>$cliente->cpf</td>
									<td>$cliente->telefone</td>
									<td>$cliente->sexo</td>
									<td>$cliente->dataNascimento</td>
									<td>$cliente->profissao</td>
									<td>$cliente->estadoCivil</td>
									<td>$cliente->email</td>
									<td width='140'><a href='editarCliente.php?id=$cliente->id' class='btn btn-secondary btn-sm'</a>Editar</td>
									<td width='140'><a href='excluirCliente.php?id=$cliente->id' class='btn btn-danger btn-sm'</a>Excluir</td>
								</tr> 
								";
							}
						}
						?>    
					</table>
					<?php  
					if ($msgErro != "")
						echo "<p class='text-danger'>A operação não pode ser realizada: $msgErro</p>";
					?><br><br>
				</div>
			</div>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>

</body>
</html>




