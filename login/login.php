<?php

require "../config.php";
require "../RequestResponse.php";

$pdo = mysqlConnect();

$email = $senha = "";
if (isset($_POST['email']))
  $email = htmlspecialchars($_POST['email']);

if (isset($_POST['senha']))
  $senha = htmlspecialchars($_POST['senha']);

$sql = <<<SQL
  SELECT senha_hash
  FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
  WHERE email = ?
SQL;

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $row = $stmt->fetch();

  if (!$row) {
    $response = new RequestResponse(false, "Usuário não encontrado");
    echo json_encode($response);
  }
  else {
    if (!password_verify($senha, $row['hash_senha'])) {
      $response = new RequestResponse(false, "Senha inválida");
      echo json_encode($response);
    } else {
      $response = new RequestResponse(true, "Usuário encontrado");
      echo json_encode($response);
    }
  }
} catch (Exception $e) {
  $response = new RequestResponse(false, $e->getMessage());
  echo json_encode($response);
}
