<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<?php if ( adminLoggedIn() || organizadorLoggedIn() ) : ?>

<main class="container-fluid " style="padding: 0; ">

  <div class="col section__panel" >
    <div class="p-2 col col-md-6 mx-auto bg-white rounded-3 shadow-sm">
      <?php
      // echo "<pre>";
      // print_r($_SESSION);
      // echo "</pre>";
      ?>

      <div class="col p-3">
        <a href="<?php setIndexPage() ?>" class="btn btn-primary p-2">Ir Atrás</a>
        <h2 class="text-center">Lista Categorias</h2>
      </div>

      <div class="row p-3 justify-content-end ">
        <button class="btn_crear col-12 col-md-5 btn btn-success " data-bs-toggle="modal" data-bs-target="#modal_custom"> <i class="fas fa-plus"></i> Nueva Categoria </button> 
      </div>

      <div id="tabla_categorias" class="col table-responsive"> </div>

    </div>
  </div>

</main>


<div class="modal fade mt-5" id="modal_custom" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">

        <form id="form_custom" action="#"  method="POST" >

          <div class="mb-4 row justify-content-between align-items-center">
            <div class="col-auto">
              <h4 id="modal_title" class="m-0"> </h4>
            </div>
            <div class="col-auto">
              <div class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </div>  
            </div>
          </div>

          <div class="form-floating mb-2" >
            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Categoria" required autocomplete="off">
            <label for="name">Categoria</label>
          </div>

          <button type="submit" class="mt-3 p-3 w-100 btn btn-primary " > </button>

        </form>

      </div>

    </div>
  </div>
</div>


<?php require_once 'partials/modal_success.php'; ?>

<script>
window.addEventListener('DOMContentLoaded', () => {

  // let userId = localStorage.getItem('userId');
  load_categories();

}) // end DOMContentLoaded

  const load_categories = () => {
    let categorias_total = [];

    $.ajax({
      url: 'https://culturalcompass.online/api/categories',
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
                  <th scope="col">id</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody >`;

          // ordenar de menor a mayor segun id
          response.sort(function (a, b) { return a.id - b.id }); 
          response.forEach( evento => {
            html += `
              <tr>
                <td> ${categ.id}</td>
                <td> ${categ.name}</td>
                <td>
                  <button class=" btn_editar btn btn-primary "  data-bs-toggle="modal" data-bs-target="#modal_custom" data-category="${categ.id},${categ.name}"> <i class="fas fa-edit"></i> Editar </button> 
                  <button class=" btn_eliminar btn btn-danger "  data-bs-toggle="modal" data-bs-target="#modal_custom" data-category="${categ.id},${categ.name}"> <i class="fas fa-trash"></i> Eliminar </button> 
                </td>
              </tr>`;

              categorias_total.push(categ.name);
          })

          html += `
              </tbody>
            </table>`

          document.querySelector('#tabla_categorias').innerHTML = html;

          initBtnCrear();
          initBtnEditar();
          initBtnEliminar();

        } else {
          html = '<h3>No hay categorias creadas.</h3>';
          document.querySelector('#tabla_categorias').innerHTML = html;
        }

      }
    })  
  }



  let initBtnCrear = () => {
    let btn_crear = document.querySelector('.btn_crear')
    btn_crear.addEventListener('click', e => {

      let form_custom = document.querySelector('#form_custom');
      form_custom.querySelector('#modal_title').innerHTML = "Crear Categoria";
      form_custom.reset();

      form_custom.querySelector('#name').parentElement.classList.remove('hidden')

      form_custom.querySelector('.subtitle')?.remove();

      let btn_form = form_custom.querySelector('button');
      btn_form.innerHTML = "Crear Categoria";
      btn_form.setAttribute('data-action', 'create')

      if ( btn_form.classList.contains('btn-danger') ) {
        btn_form.classList.toggle('btn-danger')
        btn_form.classList.toggle('btn-primary')
      }

      form_custom.querySelector('#name').required = true;


    })
  }

  let initBtnEditar = () => {
    let allBtnEdit = document.querySelectorAll('.btn_editar')
    allBtnEdit?.forEach( btn => {
      btn.addEventListener('click', e => {
        let row = e.currentTarget.getAttribute('data-category').split(',')

        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('#modal_title').innerHTML = "Editar Categoria";

        let btn_form = form_custom.querySelector('button');
        btn_form.innerHTML = "Guardar Cambios";
        btn_form.setAttribute('data-action', 'update')
        btn_form.setAttribute('data-id', row[0])

        form_custom.querySelector('#name').value = row[1];
        form_custom.querySelector('#name').required = true;

      })
    })

  }


  let initBtnEliminar = () => {
    let allBtnDelete = document.querySelectorAll('.btn_eliminar')
    allBtnDelete?.forEach( btn => {
      btn.addEventListener('click', e => {
        let row = e.currentTarget.getAttribute('data-category').split(',')

        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('#modal_title').innerHTML = "Eliminar Categoria";

        form_custom.querySelector('#name').required = false;
        form_custom.querySelector('#name').parentElement.classList.add('hidden')

        form_custom.querySelector('.subtitle')?.remove();


        let btn_form = form_custom.querySelector('button');
        btn_form.innerHTML = "Eliminar";
        btn_form.setAttribute('data-action', 'delete')
        btn_form.setAttribute('data-id', row[0])

        if ( btn_form.classList.contains('btn-primary') ) {
          btn_form.classList.toggle('btn-primary')
          btn_form.classList.toggle('btn-danger')
        }

        let subtitle = document.createElement('h2');
        subtitle.classList.add('subtitle', 'py-2', 'text-center');
        subtitle.innerHTML = row[1]

        btn_form.before(subtitle);


      })
    })

  }

  let form = document.querySelector('#form_custom');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {

    e.preventDefault();

    let formData = {
      "name" : form.querySelector('#name').value,
    }

    console.log(formData)

    let endpoint = '';
    let req_method = '';

    if ( btn.getAttribute('data-action') == 'create' ) {
      endpoint = 'https://culturalcompass.online/api/categories';
      req_method = 'POST';
    } else if (  btn.getAttribute('data-action') == 'update' && btn.getAttribute('data-id') ) {
      let cat_id = btn.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/categories/${cat_id}`
      req_method = 'PATCH';
    } else if (  btn.getAttribute('data-action') == 'delete' && btn.getAttribute('data-id') ) {
      let cat_id = btn.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/categories/${cat_id}`
      req_method = 'DELETE';
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
        load_categories();
      }
    })

    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })


btnLogout();
</script>
<?php else : ?>

  <?php header('location: login.php'); ?>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>

