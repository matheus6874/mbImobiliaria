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

$paginaAtiva = 'listarInteresses';

try{
	$conn = conectaAoMySQL();
	$arrayPropostas = getPropostas($conn);  
}catch (Exception $e){
	$msgErro = $e->getMessage();
}

class Proposta {
	public $id;
	public $id_Imovel;
	public $nomeCliente;
	public $emailCliente;
	public $telefone;
	public $descricaoProposta;	
}

function getPropostas($conn){
	$arrayClientes = null;

	$SQL = "
		SELECT id,id_Imovel,nomeCliente,emailCliente,telefone,descricaoProposta
		FROM Propostas
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			$Proposta = new Proposta();
            $Proposta->id 	   		     = $row["id"];
			$Proposta->id_Imovel 	     = $row["id_Imovel"];
			$Proposta->nomeCliente       = $row["nomeCliente"];
			$Proposta->emailCliente      = $row["emailCliente"];
			$Proposta->telefone  		 =  $row["telefone"];
			$Proposta->descricaoProposta = $row["descricaoProposta"];
			$arrayPropostas[]   	     = $Proposta;
		}
	}
	return $arrayPropostas;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<title>MBImobiliaria - Propostas</title>
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
								<th scope="col">Id_Imóvel</th>
								<th scope="col">Nome Cliente</th>
								<th scope="col">Email Cliente</th>
								<th scope="col">Telefone</th>
								<th scope="col">Proposta</th>
							</tr>
						</thead>
						<tbody class="dados">
						<?php
						if ($arrayPropostas != null){
							foreach ($arrayPropostas as $proposta){       
								echo "
								<tr>
									<td>$proposta->id</td>	
									<td>$proposta->id_Imovel</td>
									<td>$proposta->nomeCliente</td>
									<td>$proposta->emailCliente</td>
									<td>$proposta->telefone</td>
									<td>$proposta->descricaoProposta</td>
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




