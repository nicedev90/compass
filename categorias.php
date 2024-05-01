<?php require_once 'controller/session.php'; ?>
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


<input type="hidden" id="accessToken" value="<?php echo $_SESSION['accessToken'] ?>">

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
            <h4 class="m-0"> Eliminar Categoria ? </h4>
          </div>
          <div class="col-2">
            <button class=" w-100 btn btn-danger " data-bs-dismiss="modal"> <i class="fas fa-xmark"></i> </button>  
          </div>
        </div>


        <!-- <form action="" class="pt-4 col-md-12 needs-validation" novalidate method="POST" > -->
        <form id="form_delete" action="#" class="pt-4 " method="POST" >

          <div class="form-floating mb-2" >
            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Categoria" required autocomplete="off">
            <label for="name">Categoria</label>
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

  const load_categories = () => {
    let categorias_total = [];

    // traer los eventos a los que esta apuntado el usuario
    $.ajax({
      url: 'https://culturalcompass.online/api/categories',
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
              <tr data-categoryId="${evento.id}">
                <td> ${evento.id}</td>
                <td> ${evento.name}</td>
                <td>
                 <button class=" btn_editar btn btn-primary "  data-bs-toggle="modal" data-bs-target="#modal_custom" data-id="${evento.id}"> <i class="fas fa-edit"></i> editar </button> 
                  <button class=" btn_eliminar btn btn-danger "  data-bs-toggle="modal" data-bs-target="#modal_delete" data-id="${evento.id}"> <i class="fas fa-trash"></i> Eliminar </button> 
                </td>
              </tr>`;

              categorias_total.push(evento.name);
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

  load_categories();



  let initBtnCrear = () => {
    let btn_crear = document.querySelector('.btn_crear')
    btn_crear.addEventListener('click', e => {
      document.querySelector('#modal_custom_title').innerHTML = "Crear Categoria";

      let form_custom = document.querySelector('#form_custom');
      form_custom.querySelector('button').innerHTML = "Crear Categoria";
      form_custom.querySelector('button').setAttribute('data-action', 'create')

      console.log(form_custom.querySelector('button'))

    })
  }

  let initBtnEditar = () => {
    let allBtnEdit = document.querySelectorAll('.btn_editar')
    allBtnEdit?.forEach( btn => {
      btn.addEventListener('click', e => {
        let categoryId = e.currentTarget.getAttribute('data-id')
        let row = document.querySelector(`[data-categoryId="${categoryId}"]`).children;

        // console.log(categoryId)
        // console.log(row[1].innerText.replace(/\s+/g, " "))

        document.querySelector('#modal_custom_title').innerHTML = "Editar Categoria";
        let form_custom = document.querySelector('#form_custom');
        form_custom.querySelector('button').innerHTML = "Guardar Cambios";
        form_custom.querySelector('button').setAttribute('data-action', 'update')
        form_custom.querySelector('button').setAttribute('data-id', categoryId)
        form_custom.querySelector('#name').value = row[1].innerText.replace(/\s+/g, " ")

        console.log(form_custom.querySelector('button'))



      })
    })

  }


  let initBtnEliminar = () => {
    let allBtnDelete = document.querySelectorAll('.btn_eliminar')
    allBtnDelete?.forEach( btn => {
      btn.addEventListener('click', e => {
        let categoryId = e.currentTarget.getAttribute('data-id')
        let row = document.querySelector(`[data-categoryId="${categoryId}"]`).children;

        // console.log(row[0].innerText.replace(/\s+/g, " "))

        let form_delete = document.querySelector('#form_delete');
        form_delete.querySelector('button').innerHTML = "Eliminar Categoria";
        form_delete.querySelector('button').setAttribute('data-action', 'delete')
        form_delete.querySelector('button').setAttribute('data-id', categoryId)
        form_delete.querySelector('#name').value = row[1].innerText.replace(/\s+/g, " ")

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
      let cat_id = btn_delete.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/categories/${cat_id}`
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
      "name" : form.querySelector('#name').value,
    }


    // console.log(form.querySelector('#name').value)


    // cesar1  1112222
    // cesar2  222222
    // cesar3  222222

    let endpoint = '';
    let req_method = '';

    if ( btn.getAttribute('data-action') == 'create' && !btn.getAttribute('data-id') ) {
      endpoint = 'https://culturalcompass.online/api/categories';
      req_method = 'POST';
    } else if (  btn.getAttribute('data-action') == 'update' && btn.getAttribute('data-id') ) {
      let cat_id = btn.getAttribute('data-id');
      endpoint = `https://culturalcompass.online/api/categories/${cat_id}`
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
        load_categories();
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

