const products = [
    { id: 1, name: "NARS Liquid BlushOn ", description: "BlushOn ", price: "Rp 200.000", image: "../img/liq.png" },
    { id: 2, name: "FIT ME Foundation", description: " Poreless Liquid Foundation  Makeup Ringan High Cover 16 Jam Oil Control", price: " Rp 150.000", image: "../img/fiit.png" },
    
    { id: 6, name: "Product 6", description: "Description for Product 6", price: "Rp 125.000", image: "../img/lip.png" },
    { id: 7, name: "Product 7", description: "Description for Product 7", price: "Rp 95.000", image: "../img/g2g.png" },
    
    { id: 11, name: "Product 11", description: "Description for Product 11", price: "$60.00", image: "../img/cust.png" },
    { id: 12, name: "Product 12", description: "Description for Product 12", price: "$65.00", image: "../img/bth.png" },

];


const productGrid = document.getElementById('productGrid');
const overlay = document.getElementById('overlay');
const popup = document.getElementById('popup');
const popupTitle = document.getElementById('popupTitle');
const popupDescription = document.getElementById('popupDescription');
const popupPrice = document.getElementById('popupPrice');
const closePopup = document.getElementById('closePopup');

function showPopup(product) {
    popupTitle.textContent = product.name;
    popupDescription.textContent = product.description;
    popupPrice.textContent = product.price;
    overlay.style.display = 'flex';
}

function hidePopup() {
    overlay.style.display = 'none';
}

products.forEach(product => {
    const productElement = document.createElement('div');
    productElement.classList.add('product');
    productElement.innerHTML = `
        <img src="${product.image}" alt="${product.name}">
        <div class="product-details">
            <h3>${product.name}</h3>
            <p>${product.description.substring(0, 20)}...</p>
            <p class="price">${product.price}</p>
        </div>
    `;

    productElement.addEventListener('click', () => showPopup(product));
    productGrid.appendChild(productElement);
});

closePopup.addEventListener('click', hidePopup);
overlay.addEventListener('click', hidePopup);