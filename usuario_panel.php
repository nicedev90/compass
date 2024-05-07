<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( usuarioLoggedIn() ) : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel" >
    <div class="p-2 col col-md-8 mx-auto bg-white rounded-3 shadow-sm">

      <?php
      // echo "<pre>";
      // print_r($_SESSION);
      // echo "</pre>";
      ?>

      <div class="col p-3">
        <h1 class="py-2">Hola <?php echo $_SESSION['username'] ?></h1>
        <h2 class="text-center">Lista de mis eventos</h2>
      </div>

      <div id="tabla_eventos" class="col table-responsive"> </div>

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

  <div class="col col-md-7 py-4 mx-auto " >
    <div id="calendar" class="p-2 bg-white rounded-3 border"></div>
  </div>

</main>


<script>
window.addEventListener('DOMContentLoaded', () => {

  let mis_eventos = [];

  // traer los eventos a los que esta apuntado el usuario
  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
    data: {},
    error: error => {
      console.log(error.responseText)
    },
    success: response => {
      // console.log(response)
      let html = '';

      if ( response.length > 0 ) {

        let html = `
          <table class="table table-striped border ">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Link</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha fin</th>
              </tr>
            </thead>
            <tbody >`;

        response.forEach( evento => {
          html += `
            <tr>
              <td> ${evento.name}</td>
              <td> <a href="${evento.url}" target="_blank" class="btn btn-sm btn-outline-secondary">Ir al enlace</a></td>
              <td> ${setTime(evento.startAt)}</td>
              <td> ${setTime(evento.endAt)}</td>
            </tr>`;

          mis_eventos.push(evento.name)
        })

        html += `
            </tbody>
          </table>`

        document.querySelector('#tabla_eventos').innerHTML = html;

      } else {
        html = '<h3>No estás apuntado a ningún evento</h3>';
        document.querySelector('#tabla_eventos').innerHTML = html;
      }

    }
  })


  // mostrar la lista de todos los eventos
  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
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
                <a href="EventoDetalle.php?id_evento=${evento.id}"  class="btn btn-sm btn-outline-secondary">Ver Evento</a>
                <span class="fs-6 text-body-secondary"> Fecha : ${setTime(evento.startAt)} </span>
              </div>

              <div class="d-flex justify-content-between align-items-center">`

              if ( mis_eventos.includes(evento.name) ) {
                html += `<button   class="btn btn-sm btn-outline-secondary" onclick="removeEvento(${evento.id})">Desapuntarme</button>`
              } else {
                html += `<button   class="btn btn-sm btn-outline-secondary" onclick="addEvento(${evento.id})">Apuntarme</button>`
              }
              
              html += `
              </div>

            </div>
          </div>
        </div>
        `

        document.querySelector('#lista_eventos').innerHTML = html;
      })

    }
  })




  $.ajax({
    url: 'https://culturalcompass.online/api/me/saved-events',
    type: 'GET',
    data : {},
    error: error => {
      console.log(error.responseText)
    },
    success: function(response){
      console.log(response)

      let data = response;
      let eventos = [];
      for(let i = 0; i < data.length; i++){
        eventos.push({
          title: data[i].title,
          start: data[i].start,
          end: data[i].end,
          color:'#000333'
        });
      }
     
      const calendarEl = document.getElementById("calendar");
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        // initialView: 'timeGridWeek',
        firstDay: 1,
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: eventos,
      });
      calendar.setOption('locale', 'es');
      calendar.render();

    }
  })



}) // end DOMContentLoaded

btnLogout();


</script>

<?php else : ?>
  <?php header('location: login.php'); ?>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>