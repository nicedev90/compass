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

        <div class="form-floating mb-3 " >
          <input type="file" accept=".jpg,.jpeg,.png" id="imagen" name="imagen" class="form-control w-100">
          <label for="imagen">Imagen</label>
        </div>

        <img src="" id="base64Img" width="500">

	<script>
		


window.addEventListener('DOMContentLoaded', () => {



  let token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjMsInVzZXJuYW1lIjoiYWRtaW4iLCJyb2xlIjozLCJpYXQiOjE3MTQ1NTEwODksImV4cCI6MTcxNDgxMDI4OX0.40SVQqML9YrCrweHtAOcw4w-b3x3q4a_l8wCM5VvwUQ';

  // $.ajaxSetup({ headers: { 'Authorization': 'Bearer '+token } });

  $.ajax({
    url: 'https://culturalcompass.online/api/events',
    type: 'GET',
		dataType: 'json',
    data: {},
    success: function(response){
      console.log(response)
     
    }
  })


// function getBase64(file) {
//    var reader = new FileReader();
//    reader.readAsDataURL(file);
//    reader.onload = function () {
//      console.log(reader.result);
//    };
//    reader.onerror = function (error) {
//      console.log('Error: ', error);
//    };
// }

// var file = document.querySelector('input[type="file"]').files[0];
// getBase64(file); // prints the base64 string

   function encodeImgtoBase64(element) {
    var file = element.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
      $("#base64Code").val(reader.result);
      $("#convertImg").text(reader.result);
      $("#base64Img").attr("src", reader.result);
    }
    reader.readAsDataURL(file);
  }

    let imageUrl = '';
    
    let input_image = document.querySelector('#imagen')
    input_image.addEventListener('change', (e) => {

      let reader = new FileReader();

      reader.onload = function () {
       console.log(reader.result);
        imageUrl = reader.result;
        console.log(typeof imageUrl)
        $("#base64Img").attr("src", reader.result);
      };
      reader.onerror = function (error) {
       console.log('Error: ', error);
      };

      reader.readAsDataURL(e.target.files[0]);

    })



  // $.ajax({
  //   url: 'https://culturalcompass.online/api/me/user',
  //   type: 'GET',
	// 	dataType: 'json',
  //   data: {},
  //   success: function(response){
  //     console.log(response)
     
  //   }
  // })

  // $.ajax({
  //   url: 'https://culturalcompass.online/api/events',
  //   type: 'GET',
	// 	dataType: 'json',
  //   data: {},
  //   success: function(response){
  //     console.log(response)
     
  //   }
  // })

  // $.ajax({
  //   url: 'https://culturalcompass.online/api/categories',
  //   type: 'GET',
	// 	dataType: 'json',
  //   data: {},
  //   success: function(response){
  //     console.log(response)
     
  //   }
  // })




  // $.ajax({
  //   url: 'https://culturalcompass.online/api/me/saved-events',
  //   type: 'POST',
  //   dataType: 'json',
  //   data: datos,
  //   error: function(err){
  //     console.log(err.responseText)
  //   },
  //   success: function(response){
  //     console.log(response)
     
  //   }
  // })


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