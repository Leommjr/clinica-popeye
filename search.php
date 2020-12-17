<?php
if(!(isset($_COOKIE['logged'])) && !(isset($_COOKIE['nome']))){
    header("Location:login/");
    exit();
}
?>
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
    <header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.html">Clínica Popeye</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="cadastro-funcionario/">Cadastro Funcionário</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro-paciente/">Cadastro Paciente</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php?query=Funcionario">Listagem de funcionários</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php?query=Paciente">Listagem de pacientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php?query=Endereco">Listagem de endereços</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php?query=Agenda">Listagem de agendamentos</a>
            </li>
            <?php
                if(isset($_COOKIE['medico'])){
                        echo<<<HTML
                        <li class="nav-item">
                                <a class="nav-link" href="search.php?query=Meus">Meus agendamentos</a>
                        </li>
                        HTML;
                }
            ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Sair</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
   </header>
    <div>
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
                        if($stmt === "None"){
                            echo "Tipo Inválido";
                            die();
                        }
                        
                        include 'ShowData.php';
                        $view = new ShowData($stmt);
                        $view->showTable($tipo); // imprime a tabela dinamica
                    }
                    catch (Exception $e){
                        exit('Ocorreu uma falha: ' . $e->getMessage());
                    }
    
                }
                else {
                    $query = "Funcionario";
                    if(isset($_GET["query"])) //O tipo de busca será definido pela query string. (ex: /search.php?query=Paciente)
                    //Funcionario, Medico, Paciente, Endereco, Agenda
                        $query = $_GET["query"];
                    $self = htmlspecialchars($_SERVER["PHP_SELF"]);
                    $query = htmlspecialchars($query);
                    $q = "*";
                    if($query === "Meus")
                        $q = $_COOKIE['nome'];
                    echo "<h1> Buscar $query: </h1>";
                    echo "<br>";
                    if($query === 'Endereco' or $query === 'Agenda' or $query === 'Meus'){
                        echo <<<FORM
                        <form action="$self" method="post" >
                            <div class="row g-1" >
                                <div class="col sm-10" >
                                    <input type="text" name="nome" id="nome" value="$q" class="form-control" placeholder="Todo(a)s o(a)s {$query}s" >
                                    <input type="text" name="tipo" value="$query" hidden >
                                </div>
                                <div class="col sm-2">
                                    <button type="submit" class="btn btn-success btn-sm ">
                                        <svg class="bi bi-chevron-right" width="20" height="28" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z"/></svg>Buscar
                                    </button>
                                    <script type ="text/javascript ">
                                        document.forms[0].submit();
                                    </script>
                                </div>
                            </div>
                        </form>
                        FORM;
                    }
                    else{
                        echo <<<FORM
                        <form action="$self" method="post" >
                            <div class="row g-1" >
                                <div class="col sm-10" >
                                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome do $query -- * para listar todos" >
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

                    }
                ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy"
    crossorigin="anonymous"></script>
</body>
</html>