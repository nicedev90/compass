<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/principal.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    <script src="./assets/js/helpers.js"></script>

    <?php if ( isIndexPage($_SERVER['SCRIPT_NAME']) ) : ?>
      <script src="./assets/js/google_maps.js" ></script>
      <script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
      <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvPUzlTWH-_xKiYcI7NW3R6U71Uhx94Wc&libraries=places,geometry&callback=initMap"></script>
      <script src="https://unpkg.com/@googlemaps/markerclustererplus"></script>
    <?php endif; ?>

    <?php if ( usuarioLoggedIn() ) : ?>
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script> 
   
    <?php elseif ( organizadorLoggedIn() ) : ?>
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script> 
      <script src="./assets/js/PanelAdmin.js" defer></script>

    <?php elseif ( adminLoggedIn() ) : ?>
<!--       <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script>  -->
      <!-- <script src="./assets/js/PanelAdmin.js" defer></script> -->

    <?php endif ?>

    <title> <?php echo WEB_NAME ?> </title>

  </head>
<body>
