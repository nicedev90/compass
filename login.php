<?php require_once 'helpers/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<main class="container-fluid " style="padding: 0; height:100vh">
  <div class="row " style=" margin: 0;">

    <div class="col-12 col-md-6 section__login " >
      <form id="formlogin" class="col col-md-6 mx-auto p-4 border border-2 rounded-4 bg-white" method="POST" >
        <div class="col col-md-8 mx-auto">
          <img src="./assets/images/logo.jpg" alt="Logo de Cultural Compass" class="rounded-3 d-block w-100" >  
        </div>

        <h3 class="text-center py-3 ">Iniciar sesion</h3>

        <div class="form-floating mb-2 " >
          <input type="text" class="form-control bg-light" id="username" name='username' placeholder="Username" required>
          <label for="username">Username</label>
        </div>

        <div class="form-floating mb-3 " >
          <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>

        <button class="btn btn__form--light text-center w-100 "> Login </button>
      </form>
    </div>

    <div class=" col col-md-6  section__welcome" >
      <h1>Bienvenido a <?php echo WEB_NAME ?> </h1>
      <p>Ingrese sus datos personales para utilizar todas las funciones del sitio y apuntarse a nuestros eventos</p>
      <a href="registro.php" class="btn btn__form--dark w-50 p-2 text-center text-white" id="register"> Registro</a>
    </div>

  </div>
</main>

<script>
window.addEventListener('DOMContentLoaded', () => {
  let form = document.querySelector('#formlogin');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    let formData = {
      "username" : document.querySelector('#username').value,
      "password" : document.querySelector('#password').value
    };

    $.ajax({
      url: 'https://culturalcompass.online/api/auth/login',
      type: 'POST',
      data: JSON.stringify(formData),
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response)
        response['action'] = "login";

        $.ajax({
          url: './helpers/session.php',
          type: 'POST',
          data: JSON.stringify(response),
          error: error => {
            console.log(error.responseText)
          },
          success: session => {
            // console.log(session)
            
            localStorage.setItem('accessToken', response.accessToken)
            localStorage.setItem('userId', response.roleId)

            switch (response.roleId) {
              case 1:
                window.location.href = 'usuario_panel.php';
                break;
              case 2:
                window.location.href = 'panelOrg.php';
                break;
              case 3:
                window.location.href = 'admin_panel.php';
                break;
            }

          }
        })
       
      }
    })

    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })
}) // end DOMContentLoaded
</script>

<?php require_once 'partials/footer.php'; ?>