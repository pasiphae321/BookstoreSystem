document.getElementById("link_one").addEventListener("click", function(event) {
    event.preventDefault();
    fetch("/v1/user", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "action": "logout",
        })
    })
    .then(function(response) {
        return response.json();
    }) 
    .then(function(data) {
        if (data.status === 0 || data.status === 8) {
            alert(data.message);
            window.location.href = "/login.html";
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});