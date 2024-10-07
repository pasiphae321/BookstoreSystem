fetch("/v1/user/username")
.then(function(response) {
    return response.json();
})
.then(function(data) {
    if (data.status === 0)
        document.getElementById("username").textContent = data.username;
    else if (data.status === 1)
        window.location.href = "/login.html";
})
.catch(function(error) {
    console.log(error);
});