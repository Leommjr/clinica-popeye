<?php
require "../config.php";

class Endereco
{
  public $logradouro;
  public $bairro;
  public $cidade;
  public $estado;

  function __construct($logradouro, $bairro, $cidade, $estado)
  {
    $this->logradouro = $logradouro;
    $this->bairro = $bairro; 
    $this->cidade = $cidade;
    $this->estado = $estado;
  }
}

$cep = "";
if (isset($_GET['cep']))
  $cep = htmlspecialchars($_GET['cep']);

$pdo = connect();

$sql = <<<SQL
  SELECT *
  FROM base_enderecos_ajax
  WHERE cep = ?
SQL;

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cep]);

  if ($row = $stmt->fetch()) {
    echo json_encode(new Endereco($row['logradouro'], $row['bairro'], $row['cidade'], $row['estado']));
  } else {
    echo json_encode(new Endereco('', '', '', ''));
  }
} catch (Exception $e) {
  echo json_encode(new Endereco('', '', '', ''));
}
