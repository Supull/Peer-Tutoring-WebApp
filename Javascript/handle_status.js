document.getElementById('statusForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('includes2/update_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById('responseMessage').innerHTML = result;
        loadOnlineUsers();
        loadIncomingRequests();
        loadAcceptedRequests();
    })
    .catch(error => {
        document.getElementById('responseMessage').innerHTML = '<span class="error">An error occurred: ' + error.message + '</span>';
    });
});