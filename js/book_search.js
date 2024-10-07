document.getElementById("book_search_form").addEventListener("submit", function(event) {
    event.preventDefault();
    const book_name = document.getElementById("book_name").value;

    fetch("/v1/book/search", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json"
        },
        "body": JSON.stringify({
            "book_name": book_name
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        const strawberry = document.getElementById("strawberry");
        const TableBody = document.getElementById("book_table").getElementsByTagName("tbody")[0];
        if (data.status === 0) {
            TableBody.innerHTML = "";
            strawberry.textContent = "";
            data.result.forEach(function(book) {
                const row = document.createElement("tr");
                const BookNameCell = document.createElement("td");
                BookNameCell.textContent = book.name;
                row.appendChild(BookNameCell);
                const PriceCell = document.createElement("td");
                PriceCell.textContent = book.price;
                row.appendChild(PriceCell);
                TableBody.appendChild(row);
            });
        }
        else if (data.status === 1) {
            message = "没有名为" + data.message + "的书";
            strawberry.textContent = message;
        }
    })
    .catch(function(error) {
        console.log(error);
    });
});