document.getElementById("password_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const password = document.getElementById("password").value;

    fetch("/v1/user/password", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "password": password
        })
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
        console.log(error);
    });
});