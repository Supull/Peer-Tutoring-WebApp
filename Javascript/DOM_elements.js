function loadUsername() {
    fetch('../includes/main/request/DOM/get_username.php') 
    .then(response => response.json())
    .then(data => {
        if (data.username) {
            document.getElementById('usernameDisplay').innerHTML = `<h1>${data.username}<h1>`;                       
        }
        else {document.getElementById('usernameDisplay').innerHTML = '<h1>Not available</h1>';}
    })
    .catch(error => {
        console.error('Error fetching username:', error);
        document.getElementById('usernameDisplay').innerText = 'Error fetching username';
    });
    
}

function loadOnlineUsers() {
    fetch('../includes/main/request/DOM/get_online_users.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('onlineUsers').innerHTML = data;
    })
    .catch(error => {console.error('Error fetching online users:', error);});
}

function loadIncomingRequests() {
    fetch('../includes/main/request/DOM/get_incoming_requests.php')
    .then(response => response.text())
    .then(data => {document.getElementById('incomingRequests').innerHTML = data;})
    .catch(error => {console.error('Error fetching incoming requests:', error);});
}

function loadAcceptedRequests() {
    fetch('../includes/main/request/DOM/get_accepted_requests.php')
    .then(response => response.text())
    .then(data => {document.getElementById('info').innerHTML = data;})
    .catch(error => {console.error('Error fetching accepted requests:', error);});
}
