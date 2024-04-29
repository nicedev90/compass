<?php
  require_once 'Controller.php';

  $control = new Controller;

  define('WEB_ROOT', dirname(dirname(__FILE__)));
  // define('URL_ROOT', 'http://192.168.8.100/yassir/front2');
  define('WEB_NAME', 'Cultural Compass');
  
  session_cache_limiter('private, must-revalidate');
  session_cache_expire(60);
  session_start();

  function createdAlert() {
      if (isset($_SESSION['alerta'])) {
          echo 'success_modal';
          unset($_SESSION['alerta']);
      }
  }
  
  function isIndexPage($script_name) {
      $arr = explode('/', $script_name);

      return end($arr) == 'index.php' ? true : false;
  }


  function setIndexPage () {

    $roleId = !empty($_SESSION['roleId']) ? $_SESSION['roleId'] : 0;

    switch ($roleId) {
      case 1:
        echo "panelUsuario.php";
        break;
      case 2:
        echo "panelOrg.php";
        break;
      case 3:
        echo "panelAdmin.php";
        break;

      default:
        echo "index.php";
        break;
    }
    
  }



  function fixedFecha($date) {
      setlocale(LC_TIME, "es_AR");
      $fecha = $date;
      $fecha = str_replace("/", "-", $fecha); 
      $fecha = date("d-m-Y", strtotime($fecha));
      return $fecha;
  }

  function loginAlert() {
      if (isset($_GET['err']) && $_GET['err'] == 1) {
          echo "¡Error! Contraseña incorrecta.";
      }

      if (isset($_GET['err']) && $_GET['err'] == 2) {
          echo "¡Error! Usuario no registrado.";
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



  if (isset($_POST['logout'])) {
    $control->logout();
  }


  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accessToken'])) {
    // echo "<pre>";
    // print_r($_POST);
    // die();

    $control->createSession($_POST);
  }