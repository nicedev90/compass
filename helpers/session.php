<?php

  define('WEB_NAME', 'Cultural Compass');
  
  if (session_status() == PHP_SESSION_NONE) {
    session_cache_limiter('private, must-revalidate');
    session_cache_expire(60);
    session_start();
  }
  
  function isIndexPage($script_name) {
    $arr = explode('/', $script_name);
    return end($arr) == 'index.php' ? true : false;
  }


  function setIndexPage () {

    $roleId = !empty($_SESSION['roleId']) ? $_SESSION['roleId'] : 0;

    switch ($roleId) {
      case 1:
        echo "usuario_panel.php";
        break;
      case 2:
        echo "panelOrg.php";
        break;
      case 3:
        echo "admin_panel.php";
        break;

      default:
        echo "index.php";
        break;
    }
    
  }


  function usuarioLoggedIn () {
    return !empty($_SESSION['roleId']) && $_SESSION['roleId'] == 1 ? true : false;
  }


  function organizadorLoggedIn () {
    return !empty($_SESSION['roleId']) && $_SESSION['roleId'] == 2 ? true : false;
  }


  function adminLoggedIn () {
    return !empty($_SESSION['roleId']) && $_SESSION['roleId'] == 3 ? true : false;
  }

  function notLoggedIn () {
    return empty($_SESSION['roleId']) ? true : false;
  }


  function createSession( $user = [] ) {
    $_SESSION['accessToken'] = $user['accessToken'];
    $_SESSION['expiresAt'] = $user['expiresAt'];
    $_SESSION['userId'] = $user['userId'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['roleId'] = $user['roleId'];
    $_SESSION['roleName'] = $user['roleName'];
  }


  function logout() {
    session_destroy();
  }



  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $json = json_decode(file_get_contents('php://input'));

    if (is_object($json)) {
      $data = get_object_vars($json);
    }

    switch ( $data['action'] ) {
      case "login":
        createSession($data);
        break;
      case "logout":
        logout();
        break;
    }
    
    // echo "<pre>";
    // print_r($data);
    // die();

  }