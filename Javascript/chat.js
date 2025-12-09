function getUser() {
  // Return a Promise that resolves with the username
  return fetch('../includes/main/request/DOM/get_username.php')
    .then(response => response.json())
    .then(data => data.username)
    .catch(error => {
      console.error('Error fetching username:', error);
      return null; // Handle the error or return a default value
    });
}

function intiateWebSocket(username) {
  return new Promise((resolve, reject) => {
    const conn = new WebSocket(`ws://localhost:8080/?username=${username}`);

    conn.onopen = () => {
      console.log('WebSocket connection established');
      resolve(conn);
    };

    conn.onerror = (error) => {
      console.error('WebSocket error:', error);
      reject(error);
    };

    conn.onclose = () => {
      console.log('WebSocket connection closed');
    };
  });
}

async function setUpWebSocketConnection() {
  try {
    const username = await getUser(); // Await the username fetch
    if (username) {
      const conn = await intiateWebSocket(username); // Await WebSocket connection

      session = await getActiveSessionDetails();

      conn.onmessage = (e) => {
        const data = JSON.parse(e.data);
        if (data.type == 'msg') {
          if (session.recipient == data.source) {
            addMessageToDom(data.msg, data.source)
          }   
        }
      };

      document.getElementById('send').onclick = async (ev) => {
        var msg = document.getElementById('msg').value
        document.getElementById('msg').value = ''
        
        addMessageToDom(msg, 'You')
        
        if(session){
            const data = {
                type: 'msg',
                source: session.source,
                recipient: session.recipient,
                msg: msg
            }
            conn.send(JSON.stringify(data))
            console.log(data);
        }    
      }
    } else {
      console.error('Failed to fetch username; WebSocket connection not established');
    }
  } catch (error) {
    console.error('Failed to set up WebSocket connection:', error);
  }
}

setUpWebSocketConnection();


function addMessageToDom(msg, source) {
    var p = document.createElement('p')
    p.textContent = `${source}: ${msg}`
    document.getElementById('chats').appendChild(p)
}

function getChatHistory(recipient) {
    fetch('../includes/main/chat/get_chatHistory.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ recipient: recipient })
    })
    .then(response => response.text())
    .then(result => {
      console.log((JSON.parse(result)));
      
    })
    .catch(error => {console.log('Error making request', error);});    
}

//Set source ID
let source = null;

function setActiveSessionDetails(recipient){
    fetch('../includes/main/chat/set_active_session_details.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({recipient: recipient})
    })
    .then(response => response.text())
    .catch(error => {console.log('Error setting active session details', error);});  
}

async function getActiveSessionDetails() {
    try {
        const response = await fetch('../includes/main/chat/get_active_session_details.php')
        const data = await response.json();
        return data;
    } catch (error) {
        console.log('Error setting active session details', error);
    }
}

//Chat modal rilated code

function handleChat(e) {
    recipient = e.target.value

    getChatHistory(recipient)
     
    setActiveSessionDetails(recipient)
}