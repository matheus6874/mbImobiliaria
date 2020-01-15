<?php

session_start();  

require "conectaBanco.php";


function filtraEntrada($dado) 
{
  $dado = trim($dado);               // remove espaços no inicio e no final da string
  $dado = stripslashes($dado);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
  $dado = htmlspecialchars($dado);   // caracteres especiais do HTML (como < e >) são codificados
  
  return $dado;
}

if(isset($_POST["usuario"])){

  $msgErro = "";

  $usuario = filtraEntrada($_POST['usuario']);
  $senha	 = filtraEntrada($_POST['password']);
  
  $senhaHash = md5($senha);

  try
	{    
    // Função definida no arquivo conexaoMysql.php
    $conn = conectaAoMySQL();

    $SQL = "
      SELECT login, senha
      FROM Funcionarios
      WHERE	login = ? AND
      		senha = ? AND statusFuncionario = 'A'
    ";
    
    // Prepara a consulta
  if (! $stmt = $conn->prepare($SQL))
    throw new Exception("Falha na operacao prepare: " . $conn->error);

  if (! $stmt->bind_param("ss", $usuario, $senhaHash))
      throw new Exception("Falha na operacao bind_param: " . $stmt->error);
      
  // Executa a consulta
  if (! $stmt->execute())
    throw new Exception("Falha na operacao execute: " . $stmt->error);

  $stmt->store_result();
  
  if($stmt->num_rows > 0){
    $_SESSION['usuario'] = $_POST['usuario'];  
    echo 'Yes';
  }else{
    $_SESSION['loginErro'] = "Dados inválidos!";
    echo 'No'; 
  }

  }
	catch (Exception $e)
	{
		$msgErro = $e->getMessage();
	  echo $msgErro;
  }
}

?>
