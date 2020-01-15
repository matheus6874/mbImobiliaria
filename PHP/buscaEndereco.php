<?php

class Endereco
{
    public $rua;
    public $numero;
    public $bairro;
    public $estado;
}

try{
    require "conectaBanco.php";

    $conn = conectaAoMySQL();

    $endereco = "";
    $cep = "";
    if (isset($_POST["cep"]))
        $cep = $_POST["cep"];

    $SQL = "
		SELECT Rua, Bairro, Cidade, Estado
		FROM Endereco
		WHERE CEP = '$cep';
	";

    if (!$result = $conn->query($SQL))
        throw new Exception('Ocorreu uma falha ao buscar o endereco: ' . $conn->error);

    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $endereco = new Endereco();

        $endereco->rua = $row["Rua"];
        $endereco->bairro = $row["Bairro"];
        $endereco->cidade = $row["Cidade"];
        $endereco->estado = $row["Estado"];
    }

    if (! $jsonStr = json_encode($endereco))
        throw new Exception("Falha na funcao json_encode do PHP");
    
    echo $jsonStr;
}
catch (Exception $e)
{
    // altera o código de retorno de status para '500 Internal Server Error'.
    // A função http_response_code deve ser chamada antes do script enviar qualquer
    // texto para a saída padrão
    http_response_code(500);

    $msgErro = $e->getMessage();
    echo $msgErro;
}

if ($conn != null)
    $conn->close();

?>