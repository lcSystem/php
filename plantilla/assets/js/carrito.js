// script.js

// Datos de los productos
const products = [
    { id: 1, name: 'Producto 1', price: 10.00 },
    { id: 2, name: 'Producto 2', price: 20.00 },
    { id: 3, name: 'Producto 3', price: 30.00 }
];

// Carrito de compras
let cart = [];

// Referencias de elementos en el DOM
const cartItemsList = document.getElementById('cart-items');
const totalPriceElement = document.getElementById('total-price');
const checkoutButton = document.getElementById('checkout');

// Función para actualizar la vista del carrito
function updateCart() {
    // Limpiar los elementos de la lista
    cartItemsList.innerHTML = '';

    // Crear los elementos de la lista con los productos en el carrito
    let total = 0;
    cart.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `${item.name} - $${item.price.toFixed(2)} <button onclick="removeFromCart(${item.id})">Eliminar</button>`;
        cartItemsList.appendChild(li);
        total += item.price;
    });

    // Mostrar el total
    totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;

    // Habilitar/deshabilitar el botón de finalizar compra
    checkoutButton.disabled = cart.length === 0;
}

// Función para agregar productos al carrito
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    cart.push(product);
    updateCart();
}

// Función para eliminar productos del carrito
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId); // Filtra el carrito para eliminar el producto
    updateCart();
}

// Evento para los botones de agregar al carrito
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        const productId = parseInt(button.closest('.card').dataset.id);
        addToCart(productId);
    });
});

