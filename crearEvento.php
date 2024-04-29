<?php require_once 'controller/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( adminLoggedIn() || organizadorLoggedIn() ) : ?>

<main class="container-fluid " style="padding: 0; ">
  <div class="row " style=" margin: 0;">

    <div class="col px-2 section__panel " >

      <form id="formularioEvento" class="col col-md-6 mx-auto p-2 border border-2 rounded-4 bg-white" method="POST" enctype="multipart/form-data" >

        <div class="col py-4" >
          <a href="<?php setIndexPage() ?>" class="btn btn-primary p-2">Ir Atrás</a>
          <h1 class="py-3 text-center ">Crear nuevo Evento</h1>
        </div>

        <div class="form-floating mb-3 " >
          <input type="text" class="form-control bg-light" id="name" name='name' placeholder="Nombre evento" required>
          <label for="name">Nombre evento</label>
        </div>
        
        <div class="form-floating mb-3 " >
          <input type="datetime-local" class="form-control bg-light" id="startAt" name='startAt' placeholder="Inicio" required>
          <label for="startAt">Inicio</label>
        </div>
        
        <div class="form-floating mb-3 " >
          <input type="datetime-local" class="form-control bg-light" id="endAt" name='endAt' placeholder="Fin" required>
          <label for="endAt">Fin</label>
        </div>

        <div class="form-floating mb-3 " >
          <textarea class="form-control bg-light" id="description" name="description" required></textarea>
          <label for="description">Descripcion</label>
        </div>

        <div class="form-floating mb-3 " >
          <select class='form-control' id='status' name='status' required> 
            <option value="1" >Activo</option>
            <option value="0" >Inactivo</option>
            <option value="2" >Pasado</option>
            <option value="3" >Cancelado</option>
          </select> 
          <label for="status">Estado</label>
        </div>

        <div class="form-floating mb-3 " >
          <input type="file" accept=".jpg,.jpeg,.png" id="imagen" name="imagen" class="form-control w-100">
          <label for="imagen">Imagen</label>
        </div>

        <div class="form-floating mb-3 " >
          <textarea class="form-control bg-light" id="url" name="url" required></textarea>
          <label for="url">Url</label>
        </div>
    

        <div class="form-floating mb-3 " >
          <select class='form-control' id='categoryId' name='categoryId' required> 
          </select> 
          <label for="categoryId">Category</label>
        </div>

       
        <div class="form-floating mb-3 " >
          <select class='form-control' id='locationId' name='locationId' required> 
          </select> 
          <label for="locationId">Location</label>
        </div>

        <?php if ( adminLoggedIn() ) : ?>
        <div class="form-floating mb-3 " >
          <select class='form-control' id='organizerId' name='organizerId' required> 
          </select> 
          <label for="organizerId">Organizador</label>
        </div>
        <?php elseif ( organizadorLoggedIn() ) : ?>
        <input type='hidden' id='organizerId' value="<?php echo $_SESSION['userId'] ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-primary p-3 text-center w-100" >Guardar Evento</button>

      </form>

    </div>

  </div>
</main>



<script src="./assets/js/helper.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {

  let userId = "<?php echo $_SESSION['userId'] ?>"
  let token = "<?php echo $_SESSION['accessToken'] ?>"

  $.ajaxSetup({ headers: { 'Authorization': 'Bearer '+token } });


  $.ajax({
    url: 'https://culturalcompass.online/api/organizers',
    type: 'GET',
    dataType: 'json',
    data: {},
    error: error => {
      console.log(error.responseText)
    },
    success: response => {
      console.log(response)
      let html = '<option value="">Seleccionar...</option>';

      response.forEach( org => {
        html += `
          <option value="${org.id}">${org.name}</option>;
        `

        document.querySelector('#organizerId').innerHTML = html;
      })

    }
  })

  $.ajax({
    url: 'https://culturalcompass.online/api/locations',
    type: 'GET',
    dataType: 'json',
    data: {},
    error: error => {
      console.log(error.responseText)
    },
    success: response => {
      console.log(response)
      let html = '<option value="">Seleccionar...</option>';

      response.forEach( location => {
        html += `
          <option value="${location.id}">${location.name}</option>;
        `

        document.querySelector('#locationId').innerHTML = html;
      })

    }
  })

  $.ajax({
    url: 'https://culturalcompass.online/api/categories',
    type: 'GET',
    dataType: 'json',
    data: {},
    error: error => {
      console.log(error.responseText)
    },
    success: response => {
      console.log(response)
      let html = '<option value="">Seleccionar...</option>';

      response.forEach( category => {
        html += `
          <option value="${category.id}">${category.name}</option>;
        `

        document.querySelector('#categoryId').innerHTML = html;
      })

    }
  })



  let form = document.querySelector('#formularioEvento');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {

    e.preventDefault();

    let formData = {
      "name" : document.querySelector('#name').value,
      "startAt" : document.querySelector('#startAt').value,
      "endAt" : document.querySelector('#endAt').value,
      "description" : document.querySelector('#description').value,
      "status" : document.querySelector('#status').value,
      "url" : document.querySelector('#url').value,
      "categoryId" : Number(document.querySelector('#categoryId').value),
      "locationId" : Number(document.querySelector('#locationId').value),
      "organizerId" : Number(document.querySelector('#organizerId').value)
    }

    // cesar1  1112222
    // cesar2  222222
    // cesar3  222222

    let dat = JSON.stringify(formData)

    console.log(formData)
    console.log( 'Category Id type = ' + typeof formData.categoryId)
    console.log( 'Location Id type = ' + typeof formData.locationId)
    console.log( 'Organizador Id type = ' + typeof formData.organizerId)

    console.log( 'formData type = ' + typeof formData)

    console.log( 'JSON.stringify(formData) type = ' + typeof dat)
    console.log( 'Jquery version = 3.7.1')



    $.ajax({
      url: 'https://culturalcompass.online/api/events',
      type: 'POST',
      dataType: 'json',
      data: dat,
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response)
       
      }
    })


    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })





})


</script>

<?php else : ?>

  <?php header('location: login.php'); ?>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>

