<?php require_once 'controller/session.php'; ?>
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

        <div class="row justify-content-between align-items-center">
          <!-- <div class="col-8 border bg-light  "> -->
          <div class="col-10">
            <h4 id="modal_custom_title" class="m-0"> </h4>
          </div>
          <div class="col-2">
            <button class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </button>  
          </div>
        </div>


        <!-- <form action="" class="pt-4 col-md-12 needs-validation" novalidate method="POST" > -->
        <form id="form_custom" action="#" class="pt-4 " method="POST" >

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


<div class="modal fade mt-5" id="modal_success" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">

        <div class="row justify-content-end align-items-center">
          <!-- <div class="col-8 border bg-light  "> -->
          <div class="col-2">
            <button class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </button>  
          </div>
        </div>

        <div class=" row text-center py-4">
          <h1 class="text-success py-3">Correcto</h1>
          <i class="fas fa-check fa-5x text-success"></i>
        </div>


      </div>

    </div>
  </div>
</div>


<div class="modal fade mt-5" id="modal_delete" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">

        <div class="row justify-content-between align-items-center">
          <!-- <div class="col-8 border bg-light  "> -->
          <div class="col-10">
            <h4 class="m-0"> Eliminar Usuario ? </h4>
          </div>
          <div class="col-2">
            <button class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </button>  
          </div>
        </div>


        <!-- <form action="" class="pt-4 col-md-12 needs-validation" novalidate method="POST" > -->
        <form id="form_delete" action="#" class="pt-4 " method="POST" >

          <div class="form-floating mb-2" >
            <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Username" required autocomplete="off">
            <label for="username">Username</label>
          </div>

          <button type="submit" class="mt-3 p-3 w-100 btn btn-danger" > </button>

        </form>

      </div>

    </div>
  </div>
</div>


<script src="./assets/js/helper.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {

  let userId = "<?php echo $_SESSION['userId'] ?>"
  let token = "<?php echo $_SESSION['accessToken'] ?>"

  let custom_headers = {
    "Accept":         "application/json, text/javascript, */*; q=0.01", // dataType
    "Content-Type":   "application/json; charset=UTF-8", // contentType
    "Authorization":  "Bearer "+token
  };
  

  $.ajaxSetup({ headers: custom_headers });

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
        console.log(response)
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
              <tr data-userId="${user.id}">
                <td> ${user.id}</td>
                <td> ${user.username}</td>
                <td> ${user.email}</td>
                <td> ${setStatus(user.isActive)}</td>
                <td> ${setRole(user.roleId)}</td>
                <td> ${setTime(user.createdAt)}</td>
                <td>
                 <button class=" btn_editar btn btn-primary "  data-bs-toggle="modal" data-bs-target="#modal_custom" data-id="${user.id}" data-user="${[user.isActive,user.roleId,user.createdAt]}"> <i class="fas fa-edit"></i> editar </button> 
                </td>
              </tr>`;

              usuarios_total.push(user.username);
          })

          html += `
              </tbody>
            </table>`

          document.querySelector('#tabla_usuarios').innerHTML = html;

          initBtnEditar();
          initBtnEliminar();


        } else {
          html = '<h3>No hay Usuarios.</h3>';
          document.querySelector('#tabla_usuarios').innerHTML = html;
        }

      }
    })  
  }

  load_usuarios();





  let initBtnEditar = () => {
    let allBtnEdit = document.querySelectorAll('.btn_editar')
    allBtnEdit?.forEach( btn => {
      btn.addEventListener('click', e => {
        let userId = e.currentTarget.getAttribute('data-id')
        let user = e.currentTarget.getAttribute('data-user')
        let row = document.querySelector(`[data-userId="${userId}"]`).children;

        console.log(typeof user)
        console.log(user)

        let data_user = user.split(',')
        // console.log(row[1].innerText.replace(/\s+/g, " "))

        document.querySelector('#modal_custom_title').innerHTML = "Editar Usuario";
        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('button').innerHTML = "Guardar Cambios";
        form_custom.querySelector('button').setAttribute('data-action', 'update')
        form_custom.querySelector('button').setAttribute('data-id', userId)
        form_custom.querySelector('#username').value = row[1].innerText.replace(/\s+/g, " ")
        form_custom.querySelector('#email').value = row[2].innerText.replace(/\s+/g, " ")

        setSelectStatus(form_custom.querySelector('#isActive'), data_user[0])
        setSelectRole(form_custom.querySelector('#roleId'), data_user[1])

        form_custom.querySelector('#createdAt').value = data_user[2].slice(0,16)

        console.log(form_custom.querySelector('button'))


      })
    })

  }


  let initBtnEliminar = () => {
    let allBtnDelete = document.querySelectorAll('.btn_eliminar')
    allBtnDelete?.forEach( btn => {
      btn.addEventListener('click', e => {
        let userId = e.currentTarget.getAttribute('data-id')
        let row = document.querySelector(`[data-userId="${userId}"]`).children;

        // console.log(row[0].innerText.replace(/\s+/g, " "))

        let form_delete = document.querySelector('#form_delete');
        form_delete.querySelector('button').innerHTML = "Eliminar Usuario";
        form_delete.querySelector('button').setAttribute('data-action', 'delete')
        form_delete.querySelector('button').setAttribute('data-id', userId)
        form_delete.querySelector('#username').value = row[1].innerText.replace(/\s+/g, " ")

        // console.log(form_delete.querySelector('button'))

      })
    })

  }


  let form_delete = document.querySelector('#form_delete');
  let btn_delete = form_delete.querySelector('button');

  form_delete.addEventListener('submit', (e) => {

    e.preventDefault();

    let endpoint = '';
    let req_method = '';

    if (  btn_delete.getAttribute('data-action') == 'delete' && btn_delete.getAttribute('data-id') ) {
      let user_id = btn_delete.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/users/${user_id}`
      req_method = 'DELETE';
    }


    $.ajax({
      url: endpoint,
      type: req_method,
      data: {},
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response);
        $.notify('Eliminado  ', "success");  
        // $("#myModal").modal('hide');
        setTimeout(() => {
          window.location.reload();
        }, 2000);


      }
    })

    btn_delete.disabled = true;
      setTimeout(() => {
        btn_delete.disabled = false;
      }, 3000);
  })




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


    // cesar1  1112222
    // cesar2  222222
    // cesar3  222222

    let endpoint = '';
    let req_method = '';

    if ( btn.getAttribute('data-action') == 'create' && !btn.getAttribute('data-id') ) {
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
        console.log(response);   
        // $.notify('Eliminado  ', "success");  
        $("#modal_custom").modal('hide');
        $("#modal_success").modal('show');
        // window.location.reload();
        load_usuarios();
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

