
window.addEventListener('DOMContentLoaded', () => {

  let token = document.querySelector('#accessToken').value;

  $.ajaxSetup({ headers: { 'Authorization': 'Bearer '+token } });

  $.ajax({
    url: 'https://culturalcompass.online/api/me/saved-events',
    type: 'GET',
    dataType: 'json',
    data : {},
    error: error => {
      console.log(error.responseText)
    },
    success: function(response){
      console.log(response)

      let data = response;
      let eventos = [];
      for(let i = 0; i < data.length; i++){
        eventos.push({
          title: data[i].title,
          start: data[i].start,
          end: data[i].end,
          color:'#000333'
        });
      }
     
      const calendarEl = document.getElementById("calendar");
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        // initialView: 'timeGridWeek',
        firstDay: 1,
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: eventos,
      });
      calendar.setOption('locale', 'es');
      calendar.render();

    }
  })


});
  

  function addEvento(id_evento,id_user){

    
    const evento = {
      id_evento: id_evento,
      idUsuario: id_user,
      action:'add_user_event'
  };

   $.post(`${apiUrl}`, {evento}).done(function(response){
      
    let object = JSON.parse(response);

    if(object.status == 'success'){

      $.notify(object.message, "success");
      window.location.reload();
    }else{
      $.notify(object.message, "error");

    }


    });
           
  
    
  }
function removeEvento(id_evento,id_user){
    const evento = {
      id_evento: id_evento,
      idUsuario: id_user,
      action:'remove_user_event'
  };

 $.post(`${apiUrl}`, {evento}).done(function(response){
    
  let object = JSON.parse(response);

  if(object.status == 'success'){

    $.notify(object.message, "success");
    window.location.reload();
  }else{
    $.notify(object.message, "error");

  }


  });
}