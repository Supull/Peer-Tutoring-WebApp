

document.addEventListener('DOMContentLoaded', function() {
    loadUsername();

    let loginedUser = document.getElementById('usernameDisplay').innerText

    console.log(loginedUser);

    loadOnlineUsers();
    loadIncomingRequests();
    loadAcceptedRequests();
});
