<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ULCO_CHATBOT</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>


body {
  background: #835a9ebd;
  font-family: 'Helvetica', sans-serif;
}

.container {
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
}

#chatbox {
  height: 400px;
  overflow-y: scroll;
  background-color: #7295d7bd ;
  border: 1px solid #e6e6e6;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
  scrollbar-width: thin;
  scrollbar-color: #0099cc #f5f5f5;
}

#chatbox::-webkit-scrollbar {
  width: 12px;
}

#chatbox::-webkit-scrollbar-track {
  background: #f5f5f5;
}

#chatbox::-webkit-scrollbar-thumb {
  background-color: #0099cc;
  border-radius: 20px;
  border: 3px solid #f5f5f5;
}


#chatbox p {
  padding: 10px;
  border-radius: 5px;
  margin: 10px 0;
  background-color: #e6e6e6;
  animation: fadeIn 0.5s;
}

#chatbox p:nth-child(odd) {
  background-color: #0099cc;
  color: #fff;
}

#user-input {
  margin-top: 20px;
  border: 1px solid #e6e6e6;
  border-radius: 10px;
  padding: 10px;
}

#submit-btn {
  margin-top: 10px;
  border-radius: 10px;
  font-size: 20px;
  background-color: #0099cc;
  border: none;
  color: #fff;
  padding: 10px;
  transition: all 0.5s;
  cursor: pointer;
}

#submit-btn:hover {
  background-color: #007a99;
}

.typing {
  border-right: .15em solid;
  animation: typing 1s steps(1, end), blink-caret .5s step-end infinite;
}

@keyframes typing {
  from { width: 0 }
  to { width: 100% }
}

@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: inherit; }
}
#chatbot-container {
  display: none;
  transition: all 0.5s ease;
  position: relative; 
  z-index: 2;
}

#chatbot-toggle-button {
  cursor: pointer;
  padding: 10px 20px;
  font-size: 20px;
  background-color: #0099cc;
  border: none;
  color: #fff;
  border-radius: 10px;
  position: fixed;
  bottom: 50%;
    right: 42%;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
  transition: all 0.5s;
  z-index: 2;
}

#chatbot-toggle-button:hover {
  transform: scale(1.1);
}
#watermark {
  color: rgba(128, 128, 128, 0.5);
  height: 100%;
  left: 0;
  line-height: 2;
  margin: 0;
  position: fixed;
  top: 0;
  transform: rotate(-30deg);
  transform-origin: 0 100%;
  width: 100%;
  word-spacing: 10px;
  z-index: 1;
  pointer-events: none;
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
  supported by Chrome, Edge, Opera and Firefox */
  z-index: 1;
}


</style>

</head>

<body>
<p id="watermark"></p>
  <div id="chatbot-container">
  <div class="container p-5">
    
    <div class="row">
      <div class="col-md-12 mt-5 pt-5">
        <h2 class="text-center animate__animated animate__bounceInDown" style="color: #fff;">ULCO_GPT</h2>
        <div id="chatbox">
        </div>
        <input type="text" id="user-input" class="form-control" placeholder="Pose moi une question sur l'ULCO">
        <button id="submit-btn" class="btn btn-block btn-lg btn-primary animate__animated animate__fadeInUp">Submit</button>

      </div>
    </div>
  </div>
</div>
  <button id="chatbot-toggle-button" >Pose moi une question !</button>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" >
    //watermark------------------
    var textWatermark = 'Created by Haroun Joudi';
var fullTextWatermark = '';
var n = 1000;
for (var i = 0; i < n; i++) {
 fullTextWatermark+= ' ' + textWatermark;
}
document.getElementById('watermark').innerHTML = fullTextWatermark
//--------------------------------------------------------

  $('#submit-btn').click(function() {
    sendMessage();
  });

  // Send message when enter key is pressed
  $('#user-input').keypress(function(event){
    if(event.keyCode == 13){
      event.preventDefault();
      sendMessage();
    }
  });

  function sendMessage() {
    var userText = $('#user-input').val();
    $('#chatbox').append('<p class="animate__animated animate__fadeIn">' + 'Etudiant: ' + userText + '</p>');
    scrollToEnd();
    $('#user-input').val('');
    $('#user-input').prop('disabled', true);
    $('#submit-btn').prop('disabled', true);

    // Add "IA Thinking..." message
    var thinkingMessage = $('<p class="animate__animated animate__fadeIn">ULCO_GPT: <span class="typing">IA Thinking...</span></p>');
    $('#chatbox').append(thinkingMessage);
    scrollToEnd();

    $.post('source.php', {q: userText}, function(data) {
      // Replace "IA Thinking..." with actual response
      thinkingMessage.replaceWith('<p class="animate__animated animate__fadeIn">' + 'ULCO_GPT: ' + data.response + '</p>');
      scrollToEnd();
      $('#user-input').prop('disabled', false);
      $('#submit-btn').prop('disabled', false);
    });
  }

  function scrollToEnd() {
    setTimeout(function() {
      var chatbox = $('#chatbox');
      chatbox.scrollTop(chatbox[0].scrollHeight);
    }, 100);
  }
    // Add default welcome message
    $(document).ready(function() {
    const welcomeMessage = '<p class="animate__animated animate__fadeIn">ULCO_GPT: Bienvenu dans l ULCO Chatbot! <br> Pose moi une question!</p>';
    $('#chatbox').append(welcomeMessage);
  });
  const toggleButton = document.querySelector("#chatbot-toggle-button");
const chatbotContainer = document.querySelector("#chatbot-container");

toggleButton.addEventListener("click", () => {
  const isChatbotVisible = getComputedStyle(chatbotContainer).display !== "none";
  const toggleButton = document.querySelector("#chatbot-toggle-button");
  if (isChatbotVisible) {
    chatbotContainer.style.display = "none";
    toggleButton.style.left = "40%" ;
    toggleButton.style.position = "fixed " ;
    toggleButton.style.top = "207px" ;
    toggleButton.innerHTML = "Pose moi une question !"
  } else {
    chatbotContainer.style.display = "block";
    toggleButton.style.left = "887px" ;
    toggleButton.style.top = "-614px" ;
    toggleButton.style.position = "relative" ;
    toggleButton.innerHTML = "Close"
  }
});

</script>





</body>
</html>
