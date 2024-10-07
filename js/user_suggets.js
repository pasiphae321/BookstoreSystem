function GetSuggestions() {
    fetch("/v1/suggestion/fetch")
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        const strawberry = document.getElementById("strawberry");
        const TableBody = document.getElementById("suggestion_table").getElementsByTagName("tbody")[0];
        if (data.status === 0) {
            strawberry.textContent = "";
            TableBody.innerHTML = "";
            data.result.forEach(function(suggestion1) {
                const row = document.createElement("tr");
                const UsernameCell = document.createElement("td");
                UsernameCell.textContent = suggestion1.username;
                row.appendChild(UsernameCell);
                const ContentCell = document.createElement("td");
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
    const suggestion = document.getElementById("content").value;

    fetch("/v1/suggestion/add", {
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
    })
    .catch(function(error) {
        console.log(error);
    });
});