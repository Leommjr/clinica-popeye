<?php

require "../config.php";
require "../RequestResponse.php";

$pdo = connect();

$nome = $email = $telefone = $cep = $logradouro = $bairro = $cidade = $estado = $peso = $altura = $tipo_sanguineo = "";

if (isset($_POST["nome"]))
  $nome = htmlspecialchars($_POST["nome"]);

if (isset($_POST["email"]))
  $email = htmlspecialchars($_POST["email"]);

if (isset($_POST["telefone"]))
  $telefone = htmlspecialchars($_POST["telefone"]);

if (isset($_POST["cep"]))
  $cep = htmlspecialchars($_POST["cep"]);

if (isset($_POST["logradouro"]))
  $logradouro = htmlspecialchars($_POST["logradouro"]);

if (isset($_POST["bairro"]))
  $bairro = htmlspecialchars($_POST["bairro"]);

if (isset($_POST["cidade"]))
  $cidade = htmlspecialchars($_POST["cidade"]);

if (isset($_POST["estado"]))
  $estado = htmlspecialchars($_POST["estado"]);

if (isset($_POST["peso"]))
  $peso = htmlspecialchars($_POST["peso"]);

if (isset($_POST["altura"]))
  $altura = htmlspecialchars($_POST["altura"]);

if (isset($_POST["tipo_sanguineo"]))
  $tipo_sanguineo = htmlspecialchars($_POST["tipo_sanguineo"]);

$sql1 = <<<SQL
  INSERT INTO pessoa (nome, email, telefone, cep, logradouro, bairro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
SQL;

$sql2 = <<<SQL
  INSERT INTO paciente (peso, altura, tipo_sanguineo, codigo) VALUES (?, ?, ?, ?)
SQL;

try {
  $pdo->beginTransaction();

  $stmt1 = $pdo->prepare($sql1);

  if (!$stmt1->execute([$nome, $email, $telefone, $cep, $logradouro, $bairro, $cidade, $estado])) {
    throw new Exception('Não foi possível inserir os dados na tabela Pessoa.');
  }

  $codigoPessoa = $pdo->lastInsertId();

  $stmt2 = $pdo->prepare($sql2);
  if(!$stmt2->execute([$peso, $altura, $tipo_sanguineo, $codigoPessoa])) {
    throw new Exception('Não foi possível inserir os dados na tabela Paciente.');
  }

  $pdo->commit();

  $response = new RequestResponse(true, "Funcionário cadastrado");
  echo json_encode($response);
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062) {
    $response = new RequestResponse(false,'Dados duplicados: ' . $e->getMessage());
    echo json_encode($response);
  }
  else {
    $response = new RequestResponse(false,'Falha ao cadastrar os dados: ' . $e->getMessage());
    echo json_encode($response);
  }
}
