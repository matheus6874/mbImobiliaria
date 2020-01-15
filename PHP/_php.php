<?php

class contato 
{
  public $nome;
  public $email;
  public $motivo;
  public $mensagem;
}

function getContatos($conn)
{
  $arrayContatos = "";
  
  $SQL = "
    SELECT *
    FROM contato
  ";
  
  // Prepara a consulta
  if (! $stmt = $conn->prepare($SQL))
    throw new Exception("Falha na operacao prepare: " . $conn->error);
      
  // Executa a consulta
  if (! $stmt->execute())
    throw new Exception("Falha na operacao execute: " . $stmt->error);

  // Indica as variáveis PHP que receberão os resultados
  if (! $stmt->bind_result($nome, $email, $mensagem, $motivo))
    throw new Exception("Falha na operacao bind_result: " . $stmt->error);    
  
  // Navega pelas linhas do resultado
  while ($stmt->fetch())
  {
    $contato = new contato();
    
    $contato->nome          = $nome;
    $contato->email         = $email;
    $contato->motivo        = $motivo;
    $contato->mensagem      = $mensagem;

    $arrayContatos[] = $contato;
  }
  
  return $arrayContatos;
}

?>