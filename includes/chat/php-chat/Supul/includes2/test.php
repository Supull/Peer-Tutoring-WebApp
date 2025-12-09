        function loadOnlineUsers() {
            fetch('includes2/get_online_users.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('onlineUsers').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching online users:', error);
            });
        }