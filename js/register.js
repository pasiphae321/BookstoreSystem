document.getElementById("register_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const email = document.getElementById("email").value;

    fetch("/v1/user/register", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "username": username,
            "password": password,
            "email": email,
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(dafunction(book)ta.message);
        if (data.status === 0) {
            window.location.href = "/login.html";
        }
        else if (data.status === 1) {
            document.getElementById("username").value = "";
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});