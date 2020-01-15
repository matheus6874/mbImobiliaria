<?php
	$paginaAtiva = 'contato';

	require "conectaBanco.php";


function filtraEntrada($dado) {
	$dado = trim($dado);              
	$dado = stripslashes($dado);     
  	$dado = htmlspecialchars($dado); 
  
	return $dado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$msgErro = "";

	$nome = $email = $motivoContato = $mensagem = "";

	$nome             = filtraEntrada($_POST["nome"]);     
	$email            = filtraEntrada($_POST["email"]);
	$motivoContato    = filtraEntrada($_POST["motivoContato"]);
	$mensagem    	  = filtraEntrada($_POST["mensagem"]);

	try{    
		$conn = conectaAoMySQL();

		$sql = "
		INSERT INTO Contato (nome, email, motivoContato,mensagem)
		VALUES ('$nome', '$email', '$motivoContato','$mensagem');
	  	";

		if (! $conn->query($sql)){
			throw new Exception("Falha na inserção dos dados: " . $conn->error);
			$msgErro = $conn->error;
		}
		 
	}catch (Exception $e){
		$msgErro = $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>MBImobiliaria - Contato</title>
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
			<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") {  
					if ($msgErro == "")
						echo "<div class='alert alert-dismissible alert-success' role='alert'><strong>Dados armazenados com sucesso!</sgrong></div>";
					else
						echo "<div class='alert alert-danger' role='alert'><strong>Cadastro não realizado: $msgErro</strong></div>";
				}	
			?>
			<h2>Envie sua mensagem</h2><br>

			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="formContato">
				<div class="form-group">
    				<label for="nome">Nome:*</label>
    				<input maxlength="100" type="text" name="nome" class="form-control" required placeholder="Digite seu nome completo"/>
				</div>
				  
				<div class="form-group">
					<label for="email">Email:*</label>
					<input maxlength="50" type="text" name="email" class="form-control" required placeholder="E-mail para contato"/>
				</div>

				<label class="control-label">Motivo do contato:*</label>
				<div class="input-group">
					<select required class="form-control custom-select" name="motivoContato" id="motivoContato">
						<option value="" selected disabled>Selecionar</option>
						<option value="Reclamação">Reclamação</option>
						<option value="Sugestão">Sugestão</option>
						<option value="Elogio">Elogio</option>
						<option value="Dúvida">Dúvida</option>
					</select>
				</div><br>

				<div class="form-group">
					<label for="textareaMensagem">Mensagem:*</label><br>
					<textarea maxlength="255" cols="" rows="4" required name="mensagem" class="form-control" id="mensagem" placeholder="Digite sua mensagem com no máximo 255 caracteres"></textarea>
				</div>

				<button type="submit" class="btn btn-secondary">Enviar</button>
				<button type="reset" class="btn btn-default">Limpar</button>
			</form>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>
</body>
</html>