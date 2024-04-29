<?php require_once 'controller/session.php'; ?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/navbar.php'; ?>

<main class="container-fluid " style="padding: 0; height:100vh">
  <div class="row " style=" margin: 0;">

    <div class="col section__login " >

      <form id="registroForm" class="col col-md-3 mx-auto p-4 border border-2 rounded-4 bg-white" method="POST" enctype="multipart/form-data" >

        <div class="col col-md-8 mx-auto">
          <img src="./assets/images/logo.jpg" alt="Logo de Cultural Compass" class="rounded-3 d-block w-100" >  
        </div>

        <h2 class="text-center py-2" >Registro de Usuario</h2>
        <h3 class="text-center py-2" >Crea tu cuenta</h3>

        <div class="form-floating mb-3 " >
          <input type="text" class="form-control bg-light" id="username" name='username' placeholder="Username" required>
          <label for="username">Username</label>
        </div>
        
        <div class="form-floating mb-3 " >
          <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Email" required>
          <label for="email">Email</label>
        </div>

        <div class="form-floating mb-3 " >
          <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>
       
        <button type="submit" class="btn btn__form--light text-center w-100" >Registro</button>

      </form>

    </div>

  </div>
</main>

<script>

  let form = document.querySelector('#registroForm');
  let btn = form.querySelector('button');

  form.addEventListener('submit', (e) => {

    e.preventDefault();

    let formData = {
      "username" : document.querySelector('#username').value,
      "email" : document.querySelector('#email').value,
      "password" : document.querySelector('#password').value
    }

    // cesar1  1112222
    // cesar2  222222
    // cesar3  222222

    $.ajax({
      url: 'https://culturalcompass.online/api/auth/register',
      type: 'POST',
      dataType: 'json',
      data: formData,
      error: error => {
        console.log(error.responseText)
      },
      success: response => {
        console.log(response)
        window.location.href = 'login.php';
       
      }
    })

    btn.disabled = true;
      setTimeout(() => {
        btn.disabled = false;
      }, 3000);
  })

</script>

<?php require_once 'partials/footer.php'; ?>