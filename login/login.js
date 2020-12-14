window.onload = function () {
  const loginForm = document.querySelector("form[name=login]");
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    verificaCredenciais(loginForm)
  })
}

function verificaCredenciais(form) {
  if (!form.email.value || !form.senha.value) {
    return;
  }

  const url = 'login.php';
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
        // TODO: Redirecionar para a area privada do sistema.
      }
      else {
        showErrorMessage(responsePhp.message);
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