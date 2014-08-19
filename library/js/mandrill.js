requestInstructor = function() {

  uuid = generateUUID();

  fullname = $('#fullname').val();
  mobile = $('#mobile').val();
  email = $('#email').val();
  activity = $('#activity').val();
  place = $('#place').val();
  priority = $('#criteria').val();

  if(activity == "" || activity == undefined) {
    alert("Informe o seu objetivo");
    return;
  }
  if(place == "" || place == undefined) {
    alert("Informe o bairro onde deseja treinar");
    return;
  }
  if(fullname == "" || fullname == undefined) {
    alert("Informe seu nome completo");
    return;
  }
  if(mobile == "" || mobile == undefined) {
    alert("Informe seu celular para que possamos entrar em contato");
    return;
  }

  now = new Date();
  metadata = "";

  subject = "[Treinar.me] "+fullname+" buscou um personal trainer em "+place
  body = "<h2>"+fullname+" buscou um personal trainer em "+place+"</h2>";
  body+= "<h3>ID: "+uuid+"</h3>"
  body+= "<ul>";
  body+= "<li>Nome: "+fullname+"</li>";
  body+= "<li>Telefone: "+mobile+"</li>";
  body+= "<li>E-mail: "+email+"</li>";
  body+= "<li>Objetivo: "+activity+"</li>";
  body+= "<li>Local: "+place+"</li>";
  body+= "<li>Prioridade: "+priority+"</li>";
  body+= "<li>Data: "+now+"</li>";
  body+= "<li>ID: "+uuid+"</li>";
  body+= "<li>Metadata: "+metadata+"</li>";
  body+= "</ul>";

  $.ajax({
    type: "POST",
    url: 'https://mandrillapp.com/api/1.0/messages/send.json',
    data: {
      "key": "J7vV51qW1OC7TmmE0W-EdA",
      "message": {
        "html": body,
        "subject": subject,
        "from_email": "ola@treinar.me",
        "from_name": "Treinar.me",
        "to": [
          {
            "email": "mauro.kobayashi@gmail.com",
            "name": "Mauro Kobayashi",
            "type": "to"
          }
        ],
        "important": true
      },
      "async": true,
      "ip_pool": "Main Pool"
    },
    success: function(data) {
      alert("E-mail enviado");
    },
    error: function() {
      alert("Deu algum rolo...");
    }
  });
};

generateUUID = function() {
  var d = new Date().getTime();
  var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = (d + Math.random()*16)%16 | 0;
      d = Math.floor(d/16);
      return (c=='x' ? r : (r&0x7|0x8)).toString(16);
  });
  return uuid;
};
