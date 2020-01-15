<?php

require "conectaBanco.php";
$bairro = $_GET["nome"];

$msgErro = "";

try
{
	require "conectaBanco.php";
    $conn = conectaAoMySQL();
    $sugestoes = "";
    
	$SQL = "
        SELECT bairro FROM Imoveis WHERE categoriaImovel like '$bairro%'
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha, contate o administrador ' . $conn->error);

	if ($result->num_rows > 0)
	{
		$row = $result->fetch_row();
        $sugestoes = $row[0];
		
	}
 
}
catch (Exception $e)
{
	$msgErro = $e->getMessage();
}

if ($sugestoes === "")
    echo "nenhuma sugestao";
else
    echo $sugestoes;
?>