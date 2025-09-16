
async function addToCard(productId) {

        let response = await fetch(`/cart/add/${productId}`, {
            method: 'POST'
        });
    let data = await response.json();
    if (data.success) {
        // Update cart counter
        document.getElementById('cart-count').innerText = data.cartCount;

        // Show popup (simple example)
        alert(data.message);
                // Or use a nicer library like SweetAlert2 / Toastify
    }
        //
        // let data = await response.json();
        // document.getElementById('cart-count').innerText =
        //     Object.values(data.cart).reduce((a, b) => a + b, 0);

}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cart-button').addEventListener('click', async () => {
        const response = await fetch('/cart/modal');
        const html = await response.text();

        // inject Twig-rendered HTML into modal body
        document.getElementById('cart-modal-body').innerHTML = html;

        // show modal (Bootstrap 5 example)
        // const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        // cartModal.show();
    });
});

