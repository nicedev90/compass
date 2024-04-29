<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


	<title>Document</title>
</head>
<body>
	<h1>TEsting </h1>

	<script>
		


window.addEventListener('DOMContentLoaded', () => {



  let token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjcsInVzZXJuYW1lIjoiY2VzYXIyIiwicm9sZSI6MSwiaWF0IjoxNzE0Mzc5MTk3LCJleHAiOjE3MTQ2MzgzOTd9.XDczncmx_TVd1FElC69bYz_6_xHlqJ1uoJvGG0ibUto';

  $.ajaxSetup({ headers: { 'Authorization': 'Bearer '+token } });

  $.ajax({
    url: 'https://culturalcompass.online/api/me/saved-events',
    type: 'GET',
		dataType: 'json',
    data: {},
    success: function(response){
      console.log(response)
     
    }
  })

  $.ajax({
    url: 'https://culturalcompass.online/api/me/user',
    type: 'GET',
		dataType: 'json',
    data: {},
    success: function(response){
      console.log(response)
     
    }
  })

  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
		dataType: 'json',
    data: {},
    success: function(response){
      console.log(response)
     
    }
  })

  $.ajax({
    url: 'https://culturalcompass.online/api/categories',
    type: 'GET',
		dataType: 'json',
    data: {},
    success: function(response){
      console.log(response)
     
    }
  })


  let datos = {
	  "vin": "1FMDU34X8RUC54412"
  }


  $.ajax({
    url: 'https://culturalcompass.online/api/me/saved-events',
    type: 'POST',
    dataType: 'json',
    data: datos,
    error: function(err){
      console.log(err.responseText)
    },
    success: function(response){
      console.log(response)
     
    }
  })


});




// Appending the JSON object options to the FormData works.

// var formData = new FormData();
// formData.append('file', $('#fileUpload')[0].files[0]);
// options = JSON.stringify(options);
// formData.append('options', options); //append it with the form data and take it apart on the server

// $.ajax({
//     url: "url",
//     type: "POST",
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function (data) {

//     },
//     error: function (msg) {
//         showMsg("error", msg.statusText + ". Press F12 for details");
//         console.log(msg);
//     }
// });




	</script>
</body>
</html>