function GetSuggestions() {
    fetch("/v1/suggestion")
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        strawberry = document.getElementById("strawberry");
        TableBody = document.getElementById("suggestion_table").getElementsByTagName("tbody")[0];
        if (data.status === 0) {
            strawberry.textContent = "";
            TableBody.innerHTML = "";
            data.result.forEach(function(suggestion1) {
                row = document.createElement("tr");
                UsernameCell = document.createElement("td");
                UsernameCell.textContent = suggestion1.username;
                row.appendChild(UsernameCell);
                ContentCell = document.createElement("td");
                ContentCell.textContent = suggestion1.content;
                row.appendChild(ContentCell);
                TableBody.appendChild(row);
            });
        }
        else if (data.status === 1) {
            TableBody.innerHTML = "";
            strawberry.textContent = data.message;
        }
    })
    .catch(function(error) {
        console.log(error);
    });
}

GetSuggestions();
document.getElementById("suggest_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const content = document.getElementById("content").value;

    fetch("/v1/suggestion", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "content": content
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.message);
        if (data.status === 0) {
            GetSuggestions();
        }
        else if (data.status === 8) {
            window.location.href = "/login.html";
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});