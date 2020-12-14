<?php

require "../config.php";
require "../RequestResponse.php";

$pdo = mysqlConnect();

$CEP = $logradouro = $bairro = $cidade = $estado = "";

if (isset($_POST["CEP"]))
  $CEP = $_POST["CEP"];

if (isset($_POST["logradouro"]))
  $logradouro = $_POST["logradouro"];

if (isset($_POST["bairro"]))
  $bairro = $_POST["bairro"];

if (isset($_POST["cidade"]))
  $cidade = $_POST["cidade"];

if (isset($_POST["estado"]))
  $estado = $_POST["estado"];


$CEP = htmlspecialchars($CEP);
$logradouro = htmlspecialchars($logradouro);
$bairro = htmlspecialchars($bairro);
$cidade = htmlspecialchars($cidade);
$estado = htmlspecialchars($estado);

$sql = <<<SQL
  INSERT INTO base_enderecos_ajax (cep, logradouro, bairro, cidade, estado)
  VALUES (?, ?, ?, ?, ?)
  SQL;

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $CEP, $logradouro, $bairro, $cidade, $estado
  ]);

  $response = new RequestResponse(true, "Endereço cadastrado com sucesso");
  echo json_encode($response); 
} catch (Exception $e) {
  $response = new RequestResponse(false, $e->getMessage());
  echo json_encode($response);
}
