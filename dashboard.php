<?php
if(!isset($_COOKIE['logged'])){
    header("Location:login/");
   }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous" />

  <title>Clínica Popeye</title>
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
  </body>
</html>