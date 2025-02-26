fetch("http://localhost/tiendamvc/api/categories")
.then(response => response.json())
.then(data => {
    let categories = data;
    let select = document.getElementById("category");
    categories.forEach(category => {
        let option = document.createElement("option");
        option.value = category.category_id;
        option.text = category.name;
        select.appendChild(option);
    });
})
.catch(error => console.error(error));

fetch("http://localhost/tiendamvc/api/providers")
.then(response => response.json())
.then(data => {
    let categories = data;
    let select = document.getElementById("provider");
    categories.forEach(provider => {
        let option = document.createElement("option");
        option.value = provider.provider_id;
        option.text = provider.name;
        select.appendChild(option);
    });
})
.catch(error => console.error(error));

document.getElementById("form").addEventListener("submit", function(e) {
    e.preventDefault();
    let product = {
        name: document.getElementById("name").value,
        price: document.getElementById("price").value,
        stock: document.getElementById("stock").value,
        category_id: document.getElementById("category").value,
        provider_id: document.getElementById("provider").value,
        description: document.getElementById("description").value}
        console.log(product);
    });