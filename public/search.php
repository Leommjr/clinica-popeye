<?php declare(strict_types=1);?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <title>Search</title>
</head>
<body>
    <div class="container">
        <main>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    include 'ExtractData.php';
                    $nome = "";
                    $tipo = "";
                    if(isset($_POST["nome"]))
                        $nome = $_POST["nome"];
                    if(isset($_POST["tipo"]))
                        $tipo = $_POST["tipo"];

                    require_once "config.php";
                    $pdo = connect();
                    $data = new ExtractData($pdo, $tipo);
                    
                    try{
                        $stmt = $data->getData($nome); //$data = statement | Query feita usando o nome informado
                        include 'ShowData.php';
                        $view = new ShowData($stmt);
                        echo $view->showTable(); // imprime a tabela dinamica
                    }
                    catch (Exception $e){
                        exit('Ocorreu uma falha: ' . $e->getMessage());
                    }
    
                }
                else {
                    $query = "Funcionario";
                    if(isset($_GET["query"])) //O tipo de busca será definido pela query string. (ex: /search.php?query=Paciente)
                        $query = $_GET["query"];
                    $self = htmlspecialchars($_SERVER["PHP_SELF"]);
                    $query = htmlspecialchars($query);
                    echo "<h1> Buscar $query: </h1>";
                    echo "<br>";
                    echo <<<FORM
                    <form action="$self" method="post" >
                        <div class="row g-1" >
                            <div class="col sm-10" >
                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome do $query" >
                                <input type="text" name="tipo" value="$query" hidden >
                            </div>
                            <div class="col sm-2">
                                <button type="submit" class="btn btn-success btn-sm ">
                                    <svg class="bi bi-chevron-right" width="20" height="28" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z"/></svg>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                    FORM;

                    }
                ?>
        </main>
    </div>
</body>
</html>