document.getElementById("login_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    fetch("/v1/user/login", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "username": username,
            "password": password
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status === 0 || data.status === 2) {
            window.location.href = "/index.html";
        }
        else if (data.status === 1) {
            alert(data.message);
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});