<?php

if(isset($_COOKIE['logged'])){
    header("Location:../dashboard.php");
    exit();
}
require "../config.php";
require "../RequestResponse.php";

$pdo = connect();

$email = $senha = "";
if (isset($_POST['email']))
  $email = htmlspecialchars($_POST['email']);

if (isset($_POST['senha']))
  $senha = htmlspecialchars($_POST['senha']);

$sql = <<<SQL
  SELECT nome, senha_hash
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
    if (!password_verify($senha, $row['senha_hash'])) {
      $response = new RequestResponse(false, "Senha inválida");
      echo json_encode($response);
    } else {
      $sqlm = "SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado,
               data_contrato, salario, senha_hash, 
               especialidade, crm
               FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
                INNER JOIN medico ON funcionario.codigo = medico.codigo WHERE nome LIKE :nome";
      try{
        $stmt2 = $pdo->prepare($sqlm);
        $stmt2->bindValue(':nome', "%{$row['nome']}%");
        $stmt2->execute();
      }
      catch (Exception $e)
      {
        $response = new RequestResponse(false, $e->getMessage());
        echo json_encode($response);
      }
      $row2 = $stmt2->fetch();
      if($row2){
       setcookie("medico", "true", time() + (86400 * 30), "/");
       setcookie("nome", "{$row['nome']}", time() + (86400 * 30), "/"); 
      }
      
      setcookie("logged", "true", time() + (86400 * 30), "/");
      $response = new RequestResponse(true, "Usuário encontrado");
      echo json_encode($response);
      
    }
  }
} catch (Exception $e) {
  $response = new RequestResponse(false, $e->getMessage());
  echo json_encode($response);
}
