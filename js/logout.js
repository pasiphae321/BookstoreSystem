document.getElementById("link_one").addEventListener("click", function(event) {
    event.preventDefault();
    fetch("/v1/user/logout")
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status === 0) {
            alert(data.message);
        }
        window.location.href = "/login.html";
    })
    .catch(function(error) {
        console.log(error);
    });
});