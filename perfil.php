<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( adminLoggedIn() || organizadorLoggedIn()  || usuarioLoggedIn()) : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel" >
    <div class="p-2 col col-md-6 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">
        <a href="<?php setIndexPage() ?>" class="btn btn-primary p-2">Ir Atrás</a>
        <h2 class="py-3 text-center">Información Personal de: <?php echo $_SESSION['username'] ?></h2>
      </div>

      <div class="col col-md-8 p-2 mx-auto">
        <form id="form_custom" action="#" class="py-3 " method="POST" >

          <div class="form-floating mb-2" >
            <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Username" required readonly autocomplete="off">
            <label for="username">Username</label>
          </div>

          <div class="form-floating mb-2" >
            <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Email" required autocomplete="off">
            <label for="email">Email</label>
          </div>

          <div class="form-floating mb-2" >
            <select class='form-control' id='isActive' name='isActive' required> 
            </select> 
            <label for="isActive">Estado (aquí puedes desactivar tu cuenta) </label>
          </div>

          <div class="form-floating mb-2" >
            <?php if ( adminLoggedIn() ) : ?>
            <select class='form-control' id='roleId' name='roleId' required> 
            </select> 
            <label for="roleId">Rol ID: </label>
            <?php else : ?>
            <input type="text" class="form-control bg-light" id="roleId" name="roleId" placeholder="roleId" required readonly autocomplete="off">
            <label for="roleId">Rol ID: Solicita un cambio de Rol en Contacto</label>
            <?php endif; ?>

          </div>

          <div class="form-floating mb-2" >
            <input type="datetime-local" class="form-control bg-light" id="createdAt" name="createdAt" placeholder="createdAt" readonly required autocomplete="off">
            <label for="createdAt">Fecha Registro</label>
          </div>

          <button type="submit" class="mt-3 p-3 w-100 btn btn-primary"> </button>

        </form>
      </div>

    </div>
  </div>

  <div class="col section__panel" >
    <div class="p-3 col col-md-10 mx-auto bg-white rounded-3 shadow-sm">

      <h2 class="text-center">Preferencias e Intereses</h2>

      <div id="lista_preferencias" class="p-3 row row-cols-1 row-cols-md-4"> </div>
      <div class="p-2 row justify-content-center mt-4 ">
        <button id="btn_save" class="p-2 col-auto btn btn-primary">Guardar Preferencias</button>
      </div>

    </div>
  </div>

  <div class="col section__panel" >
    <div class="p-2 col col-md-10 mx-auto bg-white rounded-3 shadow-sm">

      <div class="col p-3">

        <h2 class="text-center">Historial de Compras</h2>
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
            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Categoria" required autocomplete="off">
            <label for="name">Categoria</label>
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

  load_perfil();
  load_preferencias();
  load_categories();



}) // end DOMContentLoaded

  let userId = localStorage.getItem('userId');
  let mis_categorias = [];
  let total_categorias = [];

  const load_categories = () => {
    $.ajax({
      url: 'https://culturalcompass.online/api/categories',
      type: 'GET',
      data: {},
      error: error => {
        console.log(error.responseText)
      },
      success: response => {

        let html = '';

        response.sort(function (a, b) { return a.id - b.id }); 
        response.forEach( categ => {
          html += `
            <label for="category_${categ.id}" class="p-2">
              <input type="checkbox" id="category_${categ.id}" name="categories" value="${categ.id}" ${mis_categorias.includes(categ.id) ? 'checked' : ''}>
              ${categ.name}
            </label>`;

          total_categorias.push(categ.id);
        })

        document.querySelector('#lista_preferencias').innerHTML = html;


        let allCheckboxes = document.querySelectorAll('input[name="categories"]');

        if ( allCheckboxes.length > 0 ) {
          allCheckboxes.forEach( checkbox => {
            checkbox.addEventListener('change', (e) => {
              if ( e.target.checked == true ) {
                console.log(e.target.value)
                add_categ(parseInt(e.target.value))
              } else if ( e.target.checked == false ) {
                console.log(e.target.value)
                remove_categ(parseInt(e.target.value))
              }
            })
          });
        } 


      }
    })



  }

  const load_preferencias = () => {
    $.ajax({
      url: 'https://culturalcompass.online/api/me/saved-categories',
      type: 'GET',
      data: {},
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response) 
        response.forEach( categ => {
          mis_categorias.push(categ.id);
        })
      }
    })  
  }


  const load_perfil = () => {

    $.ajax({
      url: 'https://culturalcompass.online/api/me/user',
      type: 'GET',
      data: {},
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        // console.log(response)
        let html = '';

        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('button').innerHTML = "Guardar Cambios";
        form_custom.querySelector('button').setAttribute('data-action', 'update')
        form_custom.querySelector('button').setAttribute('data-id', response.id)
        form_custom.querySelector('#username').value = response.username
        form_custom.querySelector('#email').value = response.email

        setSelectStatus(form_custom.querySelector('#isActive'), response.isActive ? "true" : "false")

        if ( response.roleId == 3 ) {
          setSelectRole(form_custom.querySelector('#roleId'), response.roleId);
        } else {
          form_custom.querySelector('#roleId').value = setRole(response.roleId);
        }

        form_custom.querySelector('#createdAt').value = response.createdAt.slice(0,16)

      }
    })  
  }
  


  let form = document.querySelector('#form_custom');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {

    e.preventDefault();

    let formData = {
      "email" : form.querySelector('#email').value,
    }


    let endpoint = 'https://culturalcompass.online/api/me/user';
    let req_method = 'PATCH';


    $.ajax({
      url: endpoint,
      type: req_method,
      data: JSON.stringify(formData),
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response);   
        $("#modal_success").modal('show');
        load_perfil();
      }
    })

    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })


  const btn_save = document.querySelector('#btn_save')
  btn_save.addEventListener('click', () => {
    $("#modal_success").modal('show');
    load_categories();
  })

  const add_categ = (categ_id) => {
    $.ajax({
      url: 'https://culturalcompass.online/api/users/me/saved-categories',
      type: 'POST',
      data: JSON.stringify( { "categoryId" : categ_id, } ),
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response);   
      }
    }) 
  }


  const remove_categ = (categ_id) => {
    $.ajax({
      url: 'https://culturalcompass.online/api/users/me/saved-categories/'+categ_id,
      type: 'DELETE',
      data: {},
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response);   
      }
    }) 
  }



btnLogout();
</script>
<?php else : ?>
  <?php header('location: login.php'); ?>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>

