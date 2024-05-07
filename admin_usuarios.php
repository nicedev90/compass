<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( adminLoggedIn() || organizadorLoggedIn() ) : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel" >
    <div class="p-2 col col-md-10 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">
        <a href="<?php setIndexPage() ?>" class="btn btn-primary p-2">Ir Atrás</a>
        <h2 class="text-center">Lista Usuarios</h2>
      </div>

      <div id="tabla_usuarios" class="col table-responsive"> </div>

    </div>
  </div>

  <div class="col section__panel" >
    <div class="p-2 col col-md-10 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">

        <h2 class="text-center">Historial de compras de tickets</h2>
      </div>

      <div id="tabla_usuarios" class="col table-responsive"> </div>

    </div>
  </div>

  <div class="col section__panel" >
    <div class="p-2 col col-md-10 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">

        <h2 class="text-center">Historial de asistencia eventos</h2>
      </div>

      <div id="tabla_usuarios" class="col table-responsive"> </div>

    </div>
  </div>

</main>


<div class="modal fade mt-5" id="modal_custom" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">

        <form id="form_custom" action="#" class="pt-4 " method="POST" >

          <div class="mb-4 row justify-content-between align-items-center">
            <div class="col-auto">
              <h4 id="modal_title" class="m-0"> </h4>
            </div>
            <div class="col-auto">
              <div class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </div>  
            </div>
          </div>

          <div class="form-floating mb-2" >
            <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Username" required autocomplete="off">
            <label for="username">Username</label>
          </div>

          <div class="form-floating mb-2" >
            <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Email" required autocomplete="off">
            <label for="email">Email</label>
          </div>

          <div class="form-floating mb-2" >
            <select class='form-control' id='isActive' name='isActive' required> 
            </select> 
            <label for="isActive">Estado</label>
          </div>

          <div class="form-floating mb-2" >
            <select class='form-control' id='roleId' name='roleId' required> 
            </select> 
            <label for="roleId">Rol</label>
          </div>

          <div class="form-floating mb-2" >
            <input type="datetime-local" class="form-control bg-light" id="createdAt" name="createdAt" placeholder="createdAt" readonly required autocomplete="off">
            <label for="createdAt">Fecha</label>
          </div>

          <button type="submit" class="mt-3 p-3 w-100 btn btn-primary" > </button>

        </form>

      </div>

    </div>
  </div>
</div>


<?php require_once 'partials/modal_success.php'; ?>


<script>

window.addEventListener('DOMContentLoaded', () => {

  // let userId = localStorage.getItem('userId');
  load_usuarios();

})


  const load_usuarios = () => {
    let usuarios_total = [];

    // traer los eventos a los que esta apuntado el usuario
    $.ajax({
      url: 'https://culturalcompass.online/api/users',
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
                  <th scope="col">ID</th>
                  <th scope="col"> Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Rol</th>
                  <th scope="col">Fecha Registro</th>
                  <th scope="col">Acciones</th>
                </tr>

              </thead>
              <tbody >`;

          // ordenar de menor a mayor segun id
          response.sort(function (a, b) { return a.id - b.id }); 
          response.forEach( user => {
            html += `
              <tr>
                <td> ${user.id}</td>
                <td> ${user.username}</td>
                <td> ${user.email}</td>
                <td> ${setStatus(user.isActive)}</td>
                <td> ${setRole(user.roleId)}</td>
                <td> ${setTime(user.createdAt)}</td>
                <td>
                 <button class=" btn_editar btn btn-primary "  data-bs-toggle="modal" data-bs-target="#modal_custom" data-user="${[user.id,user.username,user.email,user.isActive,user.roleId,user.createdAt]}"> <i class="fas fa-edit"></i> Editar </button> 
                </td>
              </tr>`;

              usuarios_total.push(user.username);
          })

          html += `
              </tbody>
            </table>`

          document.querySelector('#tabla_usuarios').innerHTML = html;

          initBtnEditar();

        } else {
          html = '<h3>No hay Usuarios.</h3>';
          document.querySelector('#tabla_usuarios').innerHTML = html;
        }

      }
    })  
  }


  let initBtnEditar = () => {
    let allBtnEdit = document.querySelectorAll('.btn_editar')
    allBtnEdit?.forEach( btn => {
      btn.addEventListener('click', e => {

        let row = e.currentTarget.getAttribute('data-user').split(',')

        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('#modal_title').innerHTML = "Editar Usuario";

        let btn_form = form_custom.querySelector('button');
        btn_form.innerHTML = "Guardar Cambios";
        btn_form.setAttribute('data-action', 'update')
        btn_form.setAttribute('data-id', row[0])


        // form_custom.querySelector('#username').value = row[1].innerText.replace(/\s+/g, " ")
        form_custom.querySelector('#username').value = row[1]
        form_custom.querySelector('#email').value = row[2]

        setSelectStatus(form_custom.querySelector('#isActive'), row[3])
        setSelectRole(form_custom.querySelector('#roleId'), row[4])

        form_custom.querySelector('#createdAt').value = row[5].slice(0,16)


      })
    })

  }



  let form = document.querySelector('#form_custom');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {

    e.preventDefault();

    let formData = {
      "username" : form.querySelector('#username').value,
      "email" : form.querySelector('#email').value,
      "isActive" : form.querySelector('#isActive').value == 1 ? true : false,
      "roleId" : parseInt(form.querySelector('#roleId').value),
    }

    console.log(formData)

    let endpoint = '';
    let req_method = '';

    if ( btn.getAttribute('data-action') == 'create' ) {
      endpoint = 'https://culturalcompass.online/api/users';
      req_method = 'POST';
    } else if (  btn.getAttribute('data-action') == 'update' && btn.getAttribute('data-id') ) {
      let user_id = btn.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/users/${user_id}`
      req_method = 'PATCH';
    }

    $.ajax({
      url: endpoint,
      type: req_method,
      data: JSON.stringify(formData),
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        // console.log(response);   
        $("#modal_custom").modal('hide');
        $("#modal_success").modal('show');
        load_usuarios();
      }
    })

    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })



</script>
<?php else : ?>

  <?php header('location: login.php'); ?>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>

