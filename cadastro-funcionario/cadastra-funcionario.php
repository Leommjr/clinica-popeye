<?php

require "../config.php";
require "../RequestResponse.php";

$pdo = connect();

$nome = $email = $telefone = $cep = $logradouro = $bairro = $cidade = $estado = $data_contrato = $salario = $senha = $especialidade = $crm = "";

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

if (isset($_POST["data_contrato"]))
  $data_contrato = htmlspecialchars($_POST["data_contrato"]);

if (isset($_POST["salario"]))
  $salario = htmlspecialchars($_POST["salario"]);

if (isset($_POST["senha"])) {
  $senha = htmlspecialchars($_POST["senha"]);
  $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
}

if (isset($_POST["especialidade"]))
  $especialidade = htmlspecialchars($_POST["especialidade"]);

if (isset($_POST["crm"]))
  $crm = htmlspecialchars($_POST["crm"]);

$sql1 = <<<SQL
  INSERT INTO pessoa (nome, email, telefone, cep, logradouro, bairro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
SQL;

$sql2 = <<<SQL
  INSERT INTO funcionario (data_contrato, salario, senha_hash, codigo)
  VALUES (?, ?, ?, ?)
SQL;

$sql3 = <<<SQL
  INSERT INTO medico (especialidade, crm, codigo)
  VALUES (?, ?, ?)
SQL;

try {
  $pdo->beginTransaction();

  $stmt1 = $pdo->prepare($sql1);

  if (!$stmt1->execute([$nome, $email, $telefone, $cep, $logradouro, $bairro, $cidade, $estado])) {
    throw new Exception('Falha na primeira inserção');
  }

  $codigoPessoa = $pdo->lastInsertId();

  $stmt2 = $pdo->prepare($sql2);
  if (!$stmt2->execute([$data_contrato, $salario, $senha_hash, $codigoPessoa])) throw new Exception('Falha na segunda inserção');

  if (strlen($crm) > 0 && strlen($especialidade) > 0) {
    $stmt3 = $pdo->prepare($sql3);
    if (!$stmt3->execute([$especialidade, $crm, $codigoPessoa])) throw new Exception('Falha na terceira inserção');
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
