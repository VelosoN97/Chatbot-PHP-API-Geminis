function enviarMensaje(){
    const userInput = document.getElementById('user-input').value.trim();
    if(userInput === "") return;
    const chatBox = document.getElementById('chat-box');
    const userMensaje = document.createElement('div');
    userMensaje.className = 'user-mensaje';
    userMensaje.textContent = userInput;
    chatBox.appendChild(userMensaje);

    fetch("chatbot.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({mensaje: userInput})
    }).then( respose=> respose.json())
        .then(data => {
            const botMensaje = document.createElement('div');
            botMensaje.className = 'bot-mensaje';
            botMensaje.textContent = data.error ? `Bot: ${data.error}`: `Bot: ${data.response}`;
            chatBox.appendChild(botMensaje);
            document.getElementById('user-input').value='';
            chatBox.scrollTop = chatBox.scrollHeight;
        }).catch(error => {
            const errorMensaje = document.createElement('div');
            errorMensaje.className = 'bot-mensaje';
            errorMensaje.textContent = 'Bot: No se pudo obtener la respuesta.';
            chatBox.appendChild(errorMensaje);
        });
}