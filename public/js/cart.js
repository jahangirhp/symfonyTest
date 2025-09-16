
async function addToCard(productId) {

        let response = await fetch(`/cart/add/${productId}`, {
            method: 'POST'
        });
    let data = await response.json();
    if (data.success) {
        // Update cart counter
        // document.getElementById('cart-count').innerText = data.cartCount;

        // Show popup (simple example)
        alert(data.message);
        // Or use a nicer library like SweetAlert2 / Toastify
    }
        //
        // let data = await response.json();
        // document.getElementById('cart-count').innerText =
        //     Object.values(data.cart).reduce((a, b) => a + b, 0);

}
