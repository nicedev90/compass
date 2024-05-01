<?php require_once 'controller/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( !adminLoggedIn() ) : ?>
  <?php header('location: login.php'); ?>
<?php else : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel " >

    <div class="container ">
      <div class="col py-4" >
        <h1>Panel de Administrador : <?php echo $_SESSION['username'] ?></h1>
      </div>
      <div id="lista_eventos" class="row row-cols-1 row-cols-md-3"></div>
    </div>
  
  </div>

</main>

<input type="hidden" id="accessToken" value="<?php echo $_SESSION['accessToken'] ?>">

<script src="./assets/js/helper.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {

  let mis_eventos = [];


  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
    dataType: 'json',
    data: {},
    error: error => {
      console.log(error.responseText)
    },
    success: response => {
      // console.log(response)
      let html = '';

      response.forEach( evento => {
        html += `
        <div class="col p-4" > 
          <div class="card shadow-sm p-2" >
            <img src="./assets/images/logo.jpg" class=" img-fluid img-thumbnail">

            <div class="card-body">

              <h4 class="card-text"> ${evento.name} </h4>
              <p class="card-text"> ${setDescription(evento.description)} </p>
              <div class="mb-4 d-flex justify-content-between align-items-center">
                <span class="fs-6 text-body-secondary"> Fecha : ${setTime(evento.startAt)} </span>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <a href="EventoDetalle.php?id_evento=${evento.id}"  class="btn btn-sm btn-outline-secondary">Ver Evento</a>
                <a href="GestionEventos.php?id_evento=${evento.id}"  class="btn btn-sm btn-outline-secondary">Administrar Evento</a>
              </div>

            </div>
          </div>
        </div>
        `

        document.querySelector('#lista_eventos').innerHTML = html;
      })

    }
  })


})


</script>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>

          