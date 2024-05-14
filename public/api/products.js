document.addEventListener("DOMContentLoaded" , function (){
    const getProducts = async () =>{
            const ProductContainer = document.getElementById("products");
            let col = "";
            const res = await fetch("http://localhost:8000/api/products" , {
                method:"GET",
                headers:{
                  "Content-Type": "application/json",
                },
            });
            const result = await res.json();
            result.data.map((product) =>{
               col = `<div class="bg-red-100">${product.name}</div>`;
               ProductContainer.innerHTML += col;
            });

    }
    getProducts();
});
