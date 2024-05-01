

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