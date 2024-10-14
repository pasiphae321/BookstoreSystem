document.getElementById("book_search_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const book_name = document.getElementById("book_name").value;

    fetch(`/v1/book?book_name=${book_name}`)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        strawberry = document.getElementById("strawberry");
        TableBody = document.getElementById("book_table").getElementsByTagName("tbody")[0];
        if (data.status === 0) {
            TableBody.innerHTML = "";
            strawberry.textContent = "";
            data.result.forEach(function(book) {
                row = document.createElement("tr");
                BookNameCell = document.createElement("td");
                BookNameCell.textContent = book.name;
                row.appendChild(BookNameCell);
                PriceCell = document.createElement("td");
                PriceCell.textContent = book.price;
                row.appendChild(PriceCell);
                TableBody.appendChild(row);
            });
        }
        else if (data.status === 1) {
            TableBody.innerHTML = "";
            strawberry.textContent = "";
            message = "没有名为" + data.message + "的书";
            strawberry.innerHTML = message;
        }
        else if (data.status === 8) {
            alert(data.message);
            window.location.href = "/login.html";
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});