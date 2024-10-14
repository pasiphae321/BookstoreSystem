document.getElementById("login_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    fetch("/v1/user", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "action": "login",
            "username": username,
            "password": password
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status === 0) {
            window.location.href = "/index.html";
        }
        else if (data.status === 1) {
            alert(data.message);
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
        }
        else if (data.status === 2) {
            alert(data.message);
            window.location.href = "/index.html";
        }
        else if (data.status === 3) {
            alert(data.message);
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});