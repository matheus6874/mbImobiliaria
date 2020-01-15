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

$paginaAtiva = 'listarContatos';

try{
	$conn = conectaAoMySQL();
	$arrayContatos = getContatos($conn);  
}
catch (Exception $e){
	$msgErro = $e->getMessage();
}

class Contato {
	public $id;
	public $nome;
	public $email;
	public $motivoContato;
	public $mensagem;
}

function getContatos($conn){
	$arrayContatos = null;

	$SQL = "
		SELECT *
		FROM Contato
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$contato = new Contato();
            $contato->id 				   = $row["id"];
			$contato->nome 				   = $row["nome"];
			$contato->email        		   = $row["email"];
			$contato->motivoContato        = $row["motivoContato"];
			$contato->mensagem        	   = $row["mensagem"];
			$arrayContatos[] 			   = $contato;
		}
	}

	return $arrayContatos;
}

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
			include "navBarRestrita.php";
		?><br>
		<div class="container">
			<div class="container-fluid">
				<table id="gridContato" class="table table-striped table-dark table-responsive-lg">
					<thead class="thead-dark">
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nome completo</th>
							<th scope="col">E-Mail</th>
							<th scope="col">Motivo</th>
							<th scope="col">Mensagem</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if ($arrayContatos != null){
							foreach ($arrayContatos as $contato){       
								echo "
								<tr>
									<td>$contato->id</td>	
									<td>$contato->nome</td>
									<td>$contato->email</td>
									<td>$contato->motivoContato</td>
									<td>$contato->mensagem</td>
								</tr> 
								";
							}
						}
					?>    
					</tbody>
				</table>
				<?php  
					if ($msgErro != "")
						echo "<p class='text-danger'>A operação não pode ser realizada: $msgErro</p>";
				?><br><br>
			</div>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>

</body>
</html>



						
