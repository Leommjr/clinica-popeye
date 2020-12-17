<?php

if(isset($_COOKIE['logged'])){
    header("Location:../dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      outline: none;
    }

    html,
    body {
      height: 100%;
    }

    main {
      display: flex;
      align-items: center;
      height: calc(100% - 56px);
    }

    .form-container {
      margin: auto;
      width: 50%;
      min-width: 300px;
      max-width: 600px;
      border-radius: 15px;
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 24px;
    }

    .form-container form div+div {
      margin-top: 16px;
    }

    input {
      margin-top: 8px;
      display: block;
      width: 100%;
      padding: 8px;
      border: 0.5px solid #ccc;
      border-radius: 4px;
    }

    input:focus {
      outline: 0;
      border-color: rgb(61, 0, 230);
      box-shadow: 0px 0px 5px rgb(61, 0, 230);
    }

    button[type="submit"] {
      outline: 0;
      border: 0.5px solid #aaa;
      margin-top: 24px;
      padding: 2px 8px;
    }
  </style>

  <title>Clínica Popeye</title>
</head>

<body>
  <header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">Clínica Popeye</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../galeria">Galeria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../novo-endereco">Novo Endereço</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../agendamento">Agendamento</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="form-container">
      <form name="login" method="POST">
        <div>
          <label for="email">E-mail:</label>
          <input required type="email" id="email" name="email" autocomplete="off" />
        </div>
        <div>
          <label for="senha">Senha:</label>
          <input required type="password" id="senha" name="senha" />
        </div>

        <button class="btn btn-primary" type="submit">Entrar</button>

        <div class="mt-2">
          <div style="display: none;" id="alertErrorMsg" class="alert alert-danger alert-dismissible" role="alert">
            <span></span>
            <button type="button" class="btn-close" onclick="closeAlert()"></button>
          </div>
        </div>

      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy"
    crossorigin="anonymous"></script>
  <script src="./login.js"></script>
</body>

</html>