window.onload = function () {
  const form = document.querySelector("form[name=endereco]");
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    cadastraEndereco(form);
  })
}

function cadastraEndereco(form) {
  const url = 'cadastra-endereco.php';
  const body = new FormData(form);

  const options = {
    method: 'POST',
    body,
  };

  fetch(url, options)
    .then(response => {
      if (response.ok) {
        return response.json();
      } 
      else {
        return Promise.reject(response);
      }
    })
    .then(responsePhp => {
      if (responsePhp.success) {
        form.reset();
        document.querySelector("#alertSuccessMsg").style.display = 'block';
      }
      else {
        showErrorMessage('Ocorreu uma falha inesperada - tecle F12 e veja a janela console', responsePhp.message);
      }
    })
    .catch(error => {
      showErrorMessage('Ocorreu uma falha inesperada - tecle F12 e veja a janela console', error);
    });
}

function showErrorMessage(messageUser, messageConsole) {
  document.querySelector("#alertErrorMsg > span").textContent = messageUser;
  document.querySelector("#alertErrorMsg").style.display = 'block';

  if (messageConsole) {
    console.warn(messageConsole);
  }
}

function closeErrorAlert() {
  document.querySelector("#alertErrorMsg").style.display = 'none';
}

function closeSuccessAlert() {
  document.querySelector("#alertSuccessMsg").style.display = 'none';
}