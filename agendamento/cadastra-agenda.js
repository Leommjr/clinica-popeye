var flag = 0;

window.onload = function () {
  const form = document.querySelector("form[name=agenda]");
  insereEspecialidades();
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    cadastroAgenda(form);
  });
  const especialidade = document.getElementById("especialidade");
  especialidade.addEventListener('change', (event) => {
      var medicos = buscaMedicos(event.target.value);  
  });
  const data = document.getElementById("data_agendamento");
  data.addEventListener('change', (event) => {
      var disponiveis = buscaData(event.target.value);  
  });
  
};

function insereEspecialidades(){
  uri = "agenda.php";
  var xmlhttp =new XMLHttpRequest();
  xmlhttp.open("GET",uri,true);
  xmlhttp.onload=function(){
  if(xmlhttp.status==200){
     var arrayEspecialidade = JSON.parse(this.responseText);
     var arrayEspecialidades = arrayEspecialidade.filter(function(elem, pos, self) {
       return self.indexOf(elem) == pos;
     });
     var select = document.getElementById("especialidade");
     for(var i = 0; i < arrayEspecialidades.length; i++){
        var option = document.createElement("option");
        option.text = arrayEspecialidades[i];
        select.add(option);
        }

      }
      else{
        showErrorMessage(
        "Ocorreu uma falha inesperada - tecle F12 e veja a janela console"
      );
      }
    };
   xmlhttp.onerror=function(){
            alert("Ocorreu um erro ao processar a requisição");
    };
   xmlhttp.send();
}
function buscaMedicos(especialidade)
{
  if(flag != 0){
      var select = document.getElementById("medico");
      var length = select.options.length;
      for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
      }

  }
  flag = 1;
  uri = "agenda.php?especialidade="+especialidade;
  var xmlhttp =new XMLHttpRequest();
  xmlhttp.open("GET",uri,true);
  xmlhttp.onload=function(){
      if(xmlhttp.status==200){
        var arrayMedicos = JSON.parse(this.responseText);
        var select = document.getElementById("medico");
        for(var i = 0; i < arrayMedicos.length; i++){
          var option = document.createElement("option");
          option.text = arrayMedicos[i];
          select.add(option);
        }

      }
      else{
        showErrorMessage(
        "Ocorreu uma falha inesperada - tecle F12 e veja a janela console"
      );
      }
    };
  xmlhttp.onerror=function(){
    alert("Ocorreu um erro ao processar a requisição");
  };
  xmlhttp.send();
}

function buscaData(data)
{
  var medico = document.getElementById("medico");
  medico = medico.value;
  uri = "agenda.php?data="+data+"&nome="+medico;
  var xmlhttp =new XMLHttpRequest();
  xmlhttp.open("GET",uri,true);
  xmlhttp.onload=function(){
  if(xmlhttp.status==200){
     var arrayDatas = JSON.parse(this.responseText);
     var select = document.getElementById("horario");
     var length = select.options.length;
     for (i = length-1; i >= 0; i--) {
        if(arrayDatas.includes(select.options[i].label) || select.options[i].label == "Selecione") 
           select.options[i] = null;
      }
   }
      else{
        showErrorMessage(
        "Ocorreu uma falha inesperada - tecle F12 e veja a janela console"
      );
      }
    };
   xmlhttp.onerror=function(){
            alert("Ocorreu um erro ao processar a requisição");
    };
   xmlhttp.send();
}

function cadastroAgenda(form) {
  const url = "agenda.php";
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
