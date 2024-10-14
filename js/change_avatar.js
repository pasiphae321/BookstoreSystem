document.getElementById("avatar_upload_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const mercury = new FormData(this);
    
    fetch("/v1/user/avatar", {
        "method": "POST",
        "body": mercury
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.message);
        if (data.status === 8) {
            window.location.href = "/login.html";
        }
    })
    .catch(function(error) {
        console.error(error);
    });
});