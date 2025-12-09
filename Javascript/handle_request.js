
function handleRequest(e){
    const username = e.target.value;
    console.log(username);
    
    
    fetch('../includes/main/request/backend/make_request.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tutor: username })
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        loadOnlineUsers();
        loadIncomingRequests();
    })
    .catch(error => {console.log('Error making request', error);});
    
}

function handleAcceptRequest(e){
    const username = e.target.value
    fetch('../includes/main/request/backend/accept_request.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ learner: username })
    })
    .then(response => response.text())
    .then(result => {
        console.log(result)
        loadIncomingRequests();
    })
    .catch(error => {console.log('Error making request', error);});
}

function handleCancelRequest(){

}