<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<main class="container-fluid" style="padding: 0;">
    
  <div class="row " style="padding-top: 40px; margin: 0;">
    <div class="col col-md-6 py-4 ">
      <div class="p-4 " >
        <h2>Bienvenido a <?php echo WEB_NAME ?></h2>
        <p>En Cultural Compass, exploramos y promovemos una amplia variedad de eventos culturales en diferentes categorías, desde música hasta teatro y gastronomía.</p>
      </div>

      <div class="col col-md-8 p-2 mx-auto">
        <img src="./assets/images/logo.jpg" alt="Logo de Cultural Compass" class=" w-100 " > 
      </div>

    </div>

    <div class="col col-md-6 py-4">
      <div class="p-4" >
        <h3>¿Quiénes somos?</h3>
        <p>Somos un equipo apasionado por la cultura y las artes, comprometidos en conectar a las personas con eventos culturales en sus comunidades y más allá.</p>
      </div>
      <div id="map" class="mx-auto"></div>
    </div>
  </div>

  <div class="col py-4 bg-body-tertiary">
    <div class="container ">
      <div class="col py-4" >
        <h2>Nuestros Eventos Recomendados</h2>
        <p>Explora nuestros eventos recomendados por tu ciudad </p>
      </div>
      <div id="lista_eventos" class="row row-cols-1 row-cols-md-3"></div>
    </div>
  </div>

</main>

<script>
window.addEventListener('DOMContentLoaded', () => {

  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
    dataType: 'json',
    data: {},
    success: response => {
      console.log(response)
      let html = '';

      response.forEach( evento => {
        html += `
        <div class="col p-4" > 
          <div class="card shadow-sm p-2" >
            <img src="./assets/images/logo.jpg" class=" img-fluid img-thumbnail">

            <div class="card-body">

              <h4 class="card-text"> ${evento.name} </h4>
              <p class="card-text"> ${setDescription(evento.description)} </p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="EventoDetalle.php?id_evento=${evento.id}"  class="btn btn-sm btn-outline-secondary">Ver Evento</a>
                <span class="fs-6 text-body-secondary"> Fecha : ${setTime(evento.startAt)} </span>
              </div>

            </div>
          </div>
        </div>
        `

        document.querySelector('#lista_eventos').innerHTML = html;
      })

    }
  })

}) // end DOMContentLoaded
</script>
<?php require_once 'partials/footer.php'; ?>