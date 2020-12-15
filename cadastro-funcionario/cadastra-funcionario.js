window.onload = function () {
  const form = document.querySelector("form[name=funcionario]");
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    cadastroFuncionario(form);
  });
  const inputCep = document.querySelector("#cep");
  inputCep.onkeyup = (e) => buscaEndereco(inputCep.value);
};

function buscaEndereco(cep) {
  if (cep.length != 9) return;

  let form = document.forms[0];
  let url = `busca-cep.php?cep=${cep}`;

  fetch(url)
    .then((response) => {
      if (response.ok) {
        return response.json();
      } else {
        return Promise.reject(response);
      }
    })
    .then((endereco) => {
      form.logradouro.value = endereco.logradouro;
      form.bairro.value = endereco.bairro;
      form.cidade.value = endereco.cidade;
      form.estado.value = endereco.estado;
    })
    .catch((error) => {
      console.warn("Falha inesperada: ", error);
    });
}

function cadastroFuncionario(form) {
  if (form.crm.value && !form.especialidade.value) {
    showErrorMessage(
      "Informe a especialidade",
    );
    return;
  }

  if (!form.crm.value && form.especialidade.value) {
    showErrorMessage(
      "Informe o CRM do médico",
    );
    return;
  }
  const url = "cadastra-funcionario.php";
  const body = new FormData(form);

  const options = {
    method: "POST",
    body,
  };

  fetch(url, options)
    .then((response) => {
      if (response.ok) {
        return response.json();
      } else {
        return Promise.reject(response);
      }
    })
    .then((responsePhp) => {
      if (responsePhp.success) {
        form.reset();
        document.querySelector("#alertSuccessMsg").style.display = "block";
      } else {
        showErrorMessage(
          "Ocorreu uma falha inesperada - tecle F12 e veja a janela console",
          responsePhp.message
        );
      }
    })
    .catch((error) => {
      console.log(error)
      showErrorMessage(
        "Ocorreu uma falha inesperada - tecle F12 e veja a janela console"
      );
    });
}

function showErrorMessage(messageUser, messageConsole) {
  document.querySelector("#alertErrorMsg > span").textContent = messageUser;
  document.querySelector("#alertErrorMsg").style.display = "block";

  if (messageConsole) {
    console.warn(messageConsole);
  }
}

function closeErrorAlert() {
  document.querySelector("#alertErrorMsg").style.display = "none";
}

function closeSuccessAlert() {
  document.querySelector("#alertSuccessMsg").style.display = "none";
}

function toggleCamposMedico() {
  const checkboxMedico = document.querySelector("input[name=medico]");

  if (checkboxMedico.checked) {
    document.querySelector(".container-medico").style.display = "flex";
  } else {
    document.querySelector(".container-medico").style.display = "none";
    document.querySelector("input[name=especialidade]").value = "";
    document.querySelector("input[name=crm]").value = "";
  }
}
