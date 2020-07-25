import {Cart} from "./Cart";
import {Calculator} from "./Calculator";

document.addEventListener('DOMContentLoaded', () => {

    const productsButtons = document.getElementsByClassName('product')
    const calculator = new Calculator();
    calculator.init();

    const cart = new Cart('cashboxpurchase')
    cart.deleteLocalCart()

    for (let i = 0; i < productsButtons.length; i++) {
        productsButtons[i].addEventListener('mousedown', () => {
            productsButtons[i].classList.add('active')
        })
        productsButtons[i].addEventListener('mouseup', () => {
            productsButtons[i].classList.remove('active')
        })
        productsButtons[i].addEventListener('mouseout', () => {
            productsButtons[i].classList.remove('active')
        })
    }

    for (let i = 0; i < productsButtons.length; i++) {
        productsButtons[i].addEventListener('click', () => {
            calculator.reset()
            const name = productsButtons[i].dataset.name
            const price = productsButtons[i].dataset.price
            const id = productsButtons[i].dataset.id
            const sidenav = document.getElementById('adder');

            const productNameZone = document.getElementById('adder-product-name');
            productNameZone.innerHTML = name

            const productPriceZone = document.getElementById('adder-product-price');
            productPriceZone.innerHTML = price + '€'

            const productValidator = document.getElementById('valid-purchase-unit');
            productValidator.dataset.price = price
            productValidator.dataset.id = id
            productValidator.dataset.name = name

            M.Sidenav.init(sidenav);
        })
    }
})
