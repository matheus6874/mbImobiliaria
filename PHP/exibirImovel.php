<?php

session_start();

if($_SESSION['usuario']=="" || $_SESSION['usuario']==null) {
	echo $_SESSION['loginErro'];
	unset($_SESSION['usuario']);
	session_destroy();
	@header("Location: index.php",TRUE);
}

$paginaAtiva = 'pesquisaImovel';

require 'classes/imovelClass.php';
$p = new Imovel_class('3169608_mbimobiliaria','fdb22.awardspace.net','3169608_mbimobiliaria','PPI20192');

if(isset($_GET['id']) && (!empty($_GET['id']))){
	$id = $_GET['id'];
}else{
	@header('location: pesquisaImovel.php',TRUE);
}

	$dadosImovel =  $p->buscarImoveisId($id);
	$imagensImovel = $p->buscarImagensPorId($id);

	require "conectaBanco.php";

	function filtraEntrada($dado) {
			$dado = trim($dado);              
			$dado = stripslashes($dado);     
			$dado = htmlspecialchars($dado); 	  
			return $dado;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$msgErro = "";

		$nomeCliente = $emailCliente = $telefone = $descricaoProposta = "";

		$id_Imovel         = filtraEntrada($_POST["id_Imovel"]);   
		$nomeCliente       = filtraEntrada($_POST["nome"]);     
		$emailCliente      = filtraEntrada($_POST["email"]);
		$telefone    	   = filtraEntrada($_POST["telefone"]);
		$descricaoProposta = filtraEntrada($_POST["descricaoProposta"]);

		try{    
			$conn = conectaAoMySQL();

			$sql = "
			INSERT INTO Propostas (id_Imovel, nomeCliente,emailCliente,telefone,descricaoProposta)
			VALUES ('$id_Imovel','$nomeCliente','$emailCliente','$telefone','$descricaoProposta')";

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
			include "navBar.php";
		?><br>
		<div class="container">
		<?php 
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{  
				if ($msgErro == "" )
					echo "<div class='alert alert-success' role='alert'><strong>Dados armazenados com sucesso!</strong></div>";
				else
					echo "<div class='alert alert-danger' role='alert'><strong>Cadastro não realizado: $msgErro</strong></div>";
			}
		?>
			<section>
				<div>
					<p><?php echo "<b>Código Imóvel: </b>".$dadosImovel['id']." ". "<b>Código Propietário: </b>".$dadosImovel['codProprietario'];?></p>
					<p><?php echo "<b>Descrição: </b>".$dadosImovel['descricao'];?> </p>
					<p><?php echo "<b>Tipo do Imóvel: </b>".$dadosImovel['tipoImovel']." "."<b>Categoria Imóvel: </b>".$dadosImovel['categoriaImovel'] ;?> </p>
					<p><?php echo "<b>Valor: </b>".$dadosImovel['valor']." "."<b>Bairro: </b>".$dadosImovel['bairro']." "."<b>Nº Quartos: </b>".$dadosImovel['qtdQuartos'] ;?> </p>
					<p><?php echo "<b>Nº Suítes: </b>".$dadosImovel['qtdSuites']." "."<b>Área: </b>".$dadosImovel['areaQuadrada']." Metros "."<b>Pscina?: </b>".$dadosImovel['qtdQuartos'] ;?> </p>
					<p><?php 
							if($dadosImovel['numeroApartamento'] != "" && $dadosImovel['numeroApartamento'] != 0){
								echo "<b>Nº Apartamento: </b>".$dadosImovel['numeroApartamento'];
							}
							if($dadosImovel['andar'] != "" && $dadosImovel['andar'] != 0){
								echo "<b>Nº Andar: </b>".$dadosImovel['andar'];
							}
							if($dadosImovel['valorCondominio'] != "" && $dadosImovel['valorCondominio'] != 0){
								echo "<b>Nº Valor Condomínio: </b>".$dadosImovel['valorCondominio'];
							}
						?></p>
				</div>
				<?php
					foreach($imagensImovel as $value){
						?>
						<div id="imagens">
							<div class="caixa-img">
								<img class="tamanhoImagem" src="imagens/<?php echo $value['nome_imagem'];?>">
							</div>
						</div>
					<?php
					}
				?>	
					<button type="button" name="btnEnviarMsg" id="btnEnviarMsg" class="btn btn-dark btn-sm" style="padding: 2px" data-toggle="modal" data-target="#formContato">Enviar Mensagem para o Vendedor</button>

			</section>
		</div>
		<?php
			include "rodape.php";
		?>
	</div>

	<div style="color: black" class="modal faden" id="formContato" tabindex="-1" aria-labelledby="formContato" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2>MB Imobiliaria - Enviar Mensagem</h2><br>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>				
				</div>
				<div class="modal-body">
					<div class="container-fluid contato">
						<div class="row">
							<div class="col">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST" accept-charset="UTF-8"  name="formularioContatoVendedor" id="formularioContatoVendedor">
									<input style="display: none" <?php echo "value='$dadosImovel[id]'";?> class="form-control" type="number" name="id_Imovel" id="id_Imovel" readonly />

								
									<div class="form-group">
										<label class="control-label" for="nome">Nome completo:</label>
										<div class="input-group">
											<input class="form-control" maxlength="150" type="text" name="nome" id="nome" placeholder="Digite seu nome...." required />
										</div>
									</div>	
									<div class="form-group">
										<label class="control-label" for="email">E-Mail:</label>
										<div class="input-group">
											<input maxlength="150" class="form-control" type="email" name="email" id="email" placeholder="Digite seu e-mail exemplo@exemplo.com...." required />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label" for="telefone">Telefone</label>
										<div class="input-group">
											<input class="form-control" maxlength="20" type="text" name="telefone" id="telefone" placeholder="Digite seu telefone...." required />
										</div>
									</div>	
									<div class="form-group">
										<label for="descricaoProposta">Descrição da Proposta:</label>
										<div class="input-group">
											<textarea  maxlength="255" required name="descricaoProposta" class="form-control" id="descricaoProposta"></textarea>
										</div>
									</div>	
									<div class="" role="group">
										<button class="btn btn-primary btn-block" name="btnEnviar" id="btnEnviar" type="submit">Enviar</button>	
									</div>
									<div class="">
										<button class="btn btn-default btn-block" name="btnLimpar" id="btnEnviarFormularioContato" type="reset">Limpar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<p class="text-center">Mb Imobiliária </p>
					</div>
				</div>		
			</div>
		</div>
	</div>

</body>
</html>










