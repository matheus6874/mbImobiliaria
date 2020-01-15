<?php

define("HOST", "fdb22.awardspace.net");
define("USER", "3169608_mbimobiliaria");
define("PASSWORD", "PPI20192");
define("DATABASE", "3169608_mbimobiliaria");

function conectaAoMySQL()
{
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conn->connect_error)
        throw new Exception('Falha na conexão com o MySQL: ' . $conn->connect_error);

    return $conn;
}

?>