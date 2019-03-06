function openSwalPageLoader() {
  window.swal({
      title: "Carregando Página",
      text: "Por favor aguarde...",
      imageUrl: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif",
      showConfirmButton: false,
      allowOutsideClick: false
    });
}

//openSwalPageLoader();

function openSwalScreen() {
  window.swal({
      title: "Salvando Dados",
      text: "Por favor aguarde...",
      imageUrl: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif",
      showConfirmButton: false,
      allowOutsideClick: false
    });
}

function openSwalScreenProgress() {
  window.swal({
    title: "Pronto",
    text: "Os dados foram alterados!",
    showConfirmButton: false,
    timer: 10000
  });

  window.location.reload();
}

function openSwalMessage(titulo, mensagem) {

  swal({
    title: titulo,
    text: mensagem,
    showConfirmButton: true
  });

}

function openSwalPageLoaded() {

  swal({
    text: "Pagina carregada",
    showConfirmButton: false,
    timer: 1000
  });

}
