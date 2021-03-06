<?php
if(!isset($_COOKIE['logged'])){
    header("Location:../login/");
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
        <a class="navbar-brand" href="../index.html">Clínica Popeye</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="../cadastro-funcionario">Cadastra Funcionário</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cadastro Paciente</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../search.php?query=Funcionario">Listagem de funcionários</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../search.php?query=Paciente">Listagem de pacientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../search.php?query=Endereco">Listagem de endereços</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../search.php?query=Agenda">Listagem de agendamentos</a>
            </li>
            <?php
              if(isset($_COOKIE['medico'])){
                        echo<<<HTML
                        <li class="nav-item">
                                <a class="nav-link" href="../search.php?query=Meus">Meus agendamentos</a>
                        </li>
                        HTML;
                }
            ?>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Sair</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="container">
    <main>
      <form name="paciente" method="POST" class="row g-2 my-2">
        <h1>Cadastro de Pacientes</h1>
        <div class="col-md-4 form-floating">
          <input required name="nome" type="text" placeholder="Digite o nome do paciente" class="form-control"
            id="nome" maxlength="50" />
          <label class="form-label" for="nome">Nome</label>
        </div>
        <div class="col-md-4 form-floating">
          <input required name="email" type="email" placeholder="john@doe.com" class="form-control" id="email"
            maxlength="50" />
          <label class="form-label" for="email">E-mail</label>
        </div>
        <div class="col-md-4 form-floating">
          <input required name="telefone" type="tel" placeholder="(##) #####-####" class="form-control" id="telefone"
            maxlength="30" />
          <label class="form-label" for="telefone">Telefone</label>
        </div>
        <div class="col-md-3 form-floating">
          <input required name="cep" type="text" placeholder="#####-##" class="form-control" id="cep" maxlength="10" />
          <label class="form-label" for="cep">CEP</label>
        </div>
        <div class="col-md-9 form-floating">
          <input required name="logradouro" type="text" placeholder="Av. João Naves" class="form-control"
            id="logradouro" maxlength="50" />
          <label class="form-label" for="logradouro">Logradouro</label>
        </div>
        <div class="col-md-6 form-floating">
          <input required name="bairro" type="text" placeholder="Santa Mônica" class="form-control" id="bairro"
            maxlength="50" />
          <label class="form-label" for="bairro">Bairro</label>
        </div>
        <div class="col-md-6 form-floating">
          <input required name="cidade" type="text" placeholder="Uberlândia" class="form-control" id="cidade"
            maxlength="50" />
          <label class="form-label" for="cidade">Cidade</label>
        </div>
        <div class="col-md-6 form-floating">
          <select required name="estado" class="form-select" id="estado">
            <option selected>Selecione</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RR">Roraima</option>
            <option value="RO">Rondônia</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantis</option>
          </select>
          <label class="form-label" for="estado">Estado</label>
        </div>
        <div class="col-md-6 form-floating">
          <input required name="peso" type="number" placeholder="## Kg" class="form-control"
            id="peso" min="0" />
          <label class="form-label" for="peso">Peso</label>
        </div>
        <div class="col-md-6 form-floating">
          <input required name="altura" type="number" placeholder="180 cm" class="form-control" id="altura" min="0" />
          <label class="form-label" for="altura">Altura (cm)</label>
        </div>
        <div class="col-md-6 form-floating">
          <input required name="tipo_sanguineo" type="text" placeholder="O +" class="form-control" id="tipo_sanguineo" maxlength="3" />
          <label class="form-label" for="tipo_sanguineo">Tipo Sanguineo</label>
        </div>

        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary">
            Cadastrar Paciente
          </button>
        </div>

        <div class="mt-2">
          <div style="display: none;" id="alertSuccessMsg" class="alert alert-success alert-dismissible" role="alert">
            <strong>Um novo paciente foi cadastrado!</strong>
            <button type="button" class="btn-close" onclick="closeSuccessAlert()"></button>
          </div>

          <div style="display: none;" id="alertErrorMsg" class="alert alert-danger alert-dismissible" role="alert">
            <span></span>
            <button type="button" class="btn-close" onclick="closeErrorAlert()"></button>
          </div>
        </div>
      </form>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy"
    crossorigin="anonymous"></script>
  <script src="./cadastra-paciente.js"></script>
</body>

</html>