function enviarMensaje(){
    const userInput = document.getElementById('user-input').value.trim();
    if(userInput === "") return;
    const chatBox = document.getElementById('chat-box');
    const userMensaje = document.createElement('div');
    userMensaje.className = 'user-mensaje';
    userMensaje.textContent = userInput;
    chatBox.appendChild(userMensaje);
}