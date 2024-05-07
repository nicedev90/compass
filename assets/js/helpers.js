  const setTime = (string_time) => {
    const options = {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
    };

    let date = new Date(string_time);
    return date.toLocaleDateString('es-ES', options);
  }

  const setDescription = (string) => {
    return string.length > 70 ? string.substring(0,70) + "..." : string+ "...";
  }

  const setStatus = (isActive) => {
    return isActive ? "<button class='btn btn-success'>Activo</button>" : "<button class='btn btn-danger'>Inactivo</button>";
  }

  const setRole = (roleId) => {
    if ( roleId == 3 ) {
      return "Admin";
    } else if ( roleId == 2) {
      return "Organizer"
    } else if ( roleId == 1 ) {
      return "Usuario"
    }

  }

  const btnLogout = () => {
    const btn_logout = document.querySelector('.btn_logout');
    btn_logout?.addEventListener('click', () => {
      // console.log('clicked')

      $.ajax({
        url: './helpers/session.php',
        type: 'POST',
        data: JSON.stringify({ action: "logout" }),
        error: error => {
          console.log(error.responseText)
        },
        success: session => {
          // console.log(session)
          
          localStorage.removeItem('accessToken');
          localStorage.removeItem('userId');
          window.location.href = 'index.php';

        }
      })

    })
  }


  let setSelectStatus = (element, isActive) => {
    if (isActive == "true" ) {
      element.innerHTML = `              
        <option value="1" selected >Activo</option>
        <option value="0" >Inactivo</option>`;
    } else if (isActive == "false" ) {
      element.innerHTML = `              
        <option value="1" >Activo</option>
        <option value="0" selected >Inactivo</option>`;
    }

  }

  let setSelectRole = (element, roleId) => {
    if (roleId == 1) {
      element.innerHTML = `              
        <option value="1" selected >Usuario</option>
        <option value="2" >Organizer</option>
        <option value="3" >Admin</option>`;
    } else if (roleId == 2) {
      element.innerHTML = `              
        <option value="1"  >Usuario</option>
        <option value="2" selected >Organizer</option>
        <option value="3" >Admin</option>`;
    } else if (roleId == 3) {
      element.innerHTML = `              
        <option value="1" >Usuario</option>
        <option value="2" >Organizer</option>
        <option value="3" selected >Admin</option>`;    }

  }



  let custom_headers = {
    "Accept":         "application/json, text/javascript, */*; q=0.01", // dataType
    "Content-Type":   "application/json; charset=UTF-8", // contentType
  };

  if ( localStorage.getItem('accessToken') ) {
    custom_headers["Authorization"] = `Bearer ${localStorage.getItem('accessToken')}`
  }

  // console.log(custom_headers)
  
  $.ajaxSetup({ headers: custom_headers });

