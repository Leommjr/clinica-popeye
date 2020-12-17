<?php

require "../config.php";
require "../RequestResponse.php";

$pdo = connect();

if($_SERVER["REQUEST_METHOD"] == "POST"){
      $especialidade = $medico = $data_agendamento = $horario= $nome = $email = $telefone = "";

      if (isset($_POST["especialidade"]))
        $especialidade = htmlspecialchars($_POST["especialidade"]);

      if (isset($_POST["medico"]))
        $medico = htmlspecialchars($_POST["medico"]);

      if (isset($_POST["data_agendamento"]))
        $data_agendamento = htmlspecialchars($_POST["data_agendamento"]);

      if (isset($_POST["horario"]))
        $horario = htmlspecialchars($_POST["horario"]);

      if (isset($_POST["nome"]))
        $nome = htmlspecialchars($_POST["nome"]);

      if (isset($_POST["email"]))
        $email = htmlspecialchars($_POST["email"]);

      if (isset($_POST["telefone"]))
        $telefone = htmlspecialchars($_POST["telefone"]);

      $sql1 = "SELECT medico.codigo FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo INNER JOIN medico ON
              funcionario.codigo = medico.codigo WHERE nome LIKE :nome";
      $sql2 = <<<SQL
        INSERT INTO agenda (data_agendamento, horario, nome, email, telefone, codigo_medico)
        VALUES (?, ?, ?, ?, ?, ?)
      SQL;
      try{
        $stmt = $pdo->prepare($sql1);
        $stmt->bindValue(':nome', "%{$medico}%");
        $stmt->execute();
        $row = $stmt->fetch();
        $codigo = $row['codigo'];
        $stmt = $pdo->prepare($sql2);
        $stmt->execute(array($data_agendamento, $horario, $nome, $email, $telefone, $codigo));
      }
      catch(Exception $e)
      {
        $response = new RequestResponse(false,'Erro: ' . $e->getMessage());
        echo json_encode($response);  
      }
      $response = new RequestResponse(true, "Consulta agendada");
      echo json_encode($response);
}
else{
    $especialidade = "";
    $data = "";
    $nome = "";
    if(isset($_GET["especialidade"]) or isset($_GET["data"]))
    {
      if(isset($_GET["data"]) && isset($_GET["nome"]))
      {
          $data = htmlspecialchars($_GET["data"]);
          $nome = htmlspecialchars($_GET["nome"]);
          $sql = "SELECT data_agendamento, horario, agenda.nome, agenda.email, agenda.telefone, pessoa.nome as nome_medico
FROM agenda INNER JOIN pessoa ON agenda.codigo_medico = pessoa.codigo WHERE pessoa.nome LIKE ? AND data_agendamento = ?";
          try{
              $stmt = $pdo->prepare($sql);
              $stmt->execute(array($nome, $data));
          }
          catch(Exception $e)
          {
              $response = new RequestResponse(false,'Erro: ' . $e->getMessage());
              echo json_encode($response);
          
          }
          $horarios = array();
          while($row = $stmt->fetch())
          {
             array_push($horarios, $row['horario']);
          }
          header('Content-Type: application/json');
          echo json_encode($horarios);
      }
      else
      {
          if(isset($_GET["especialidade"]))  
              $especialidade = htmlspecialchars($_GET["especialidade"]);
            
            
          $sql = "SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado, data_contrato, salario, senha_hash, especialidade, crm FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo INNER JOIN medico ON funcionario.codigo = medico.codigo WHERE especialidade LIKE :especialidade";
              
          try{
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':especialidade', "%{$especialidade}%");
            $stmt->execute();
          }
          catch (Exception $e){
             $response = new RequestResponse(false,'Erro: ' . $e->getMessage());
             echo json_encode($response);
          }
          $medicos = array();
          while($row = $stmt->fetch())
          {
             array_push($medicos, $row['nome']);
          }
          header('Content-Type: application/json');
          echo json_encode($medicos);
      }
    }
    else {
      $sql = "SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado, data_contrato, salario, senha_hash, especialidade, crm FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo INNER JOIN medico ON funcionario.codigo = medico.codigo";
      try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }
      catch (Exception $e){
        $response = new RequestResponse(false,'Erro: ' . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode($response); 
      }
      $medicos = array();
      while($row = $stmt->fetch())
      {
          array_push($medicos, $row['especialidade']);
      }
      header('Content-Type: application/json');
      echo json_encode($medicos);
    }
}
