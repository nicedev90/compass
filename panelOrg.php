<?php require_once 'controller/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( !organizadorLoggedIn() ) : ?>
  <?php header('location: login.php'); ?>
<?php else : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel" >
    <div class="p-2 col col-md-8 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">
        <h1 class="py-2">Panel de Organizador de <?php echo $_SESSION['username'] ?></h1>
        <h2 class="text-center">Lista de mis eventos</h2>
      </div>

      <div id="lista_mis_eventos" class="row row-cols-1 row-cols-md-3"></div>

    </div>
  </div>

  <div class="col py-4 bg-body-tertiary " >

    <div class="container ">
      <div class="col py-4" >
        <h2>Nuestros Eventos Recomendados</h2>
        <p>Explora nuestros eventos recomendados por tu ciudad </p>
      </div>
      <div id="lista_eventos" class="row row-cols-1 row-cols-md-3"></div>
    </div>
  
  </div>

</main>



<script src="./assets/js/helper.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {


  let userId = "<?php echo $_SESSION['userId'] ?>"
  let token = "<?php echo $_SESSION['accessToken'] ?>"

  $.ajaxSetup({ headers: { 'Authorization': 'Bearer '+token } });

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
        if ( evento.organizerId == userId ) {

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
          `;

          mis_eventos.push(evento.name);
        }

      })

      if ( mis_eventos.length < 1 ) {
        html = '<h3>No has creado ningun evento</h3>';
      }

      document.querySelector('#lista_mis_eventos').innerHTML = html;

    }
  })


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

        if ( evento.organizerId != userId ) {
          html += `

          <div class="col p-4" > 
            <div class="card shadow-sm p-2" >
              <img src="./assets/images/logo.jpg" class=" img-fluid img-thumbnail">

              <div class="card-body">

                <h4 class="card-text"> ${evento.name} </h4>
                <p class="card-text"> ${setDescription(evento.description)} </p>
                <div class="mb-4 d-flex justify-content-between align-items-center">
                  <a href="EventoDetalle.php?id_evento=${evento.id}"  class="btn btn-sm btn-outline-secondary">Ver Evento</a>
                  <span class="fs-6 text-body-secondary"> Fecha : ${setTime(evento.startAt)} </span>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                </div>

              </div>
            </div>
          </div>
          `
        }

      })

      document.querySelector('#lista_eventos').innerHTML = html;

    }
  })

console.log(mis_eventos)
})


</script>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>
