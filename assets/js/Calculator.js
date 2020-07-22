import {Cart} from "./Cart";
import {Ticket} from "./Ticket";

export class Calculator {
    constructor() {
        this.buttons = document.getElementsByClassName('number')
        this.quantityZone = document.getElementById('quantity')
        this.eraser = document.getElementById('eraser')
        this.validator = document.getElementById('valid-purchase-unit')
        this.cart = new Cart('cashboxpurchase')
        this.ticket = new Ticket('cashboxpurchase')
    }

    reset() {
        this.quantityZone.innerHTML = '0'
    }

    init() {
        this.validator.addEventListener('click', () => {
            this.validate()
            const sidenav = document.getElementById('adder');
            M.Sidenav.init(sidenav);
        })

        this.eraser.addEventListener('click', () => {
            this.resetQuantity()
        })

        const buttons = this.buttons
        for (let i = 0; i <buttons.length; i++) {
            buttons[i].addEventListener('click', () => {
                this.setQuantity(buttons[i].dataset.value)
            })
        }
    }

    validate() {
        const price = this.validator.dataset.price
        const quantity = this.validator.dataset.quantity
        const name = this.validator.dataset.name
        const id = this.validator.dataset.id
        const total = parseFloat(price) * parseFloat(quantity)

        const purchase = {
            price : price,
            quantity : quantity,
            name : name,
            id : id,
            total : total
        }

        this.cart.addToCart(purchase)
        this.ticket.update()
    }

    setQuantity(val) {
        if (this.quantityZone.innerHTML === '0') {
            this.quantityZone.innerHTML = val
        } else {
            this.quantityZone.innerHTML = this.quantityZone.innerHTML + val
        }
        this.validator.dataset.quantity = this.quantityZone.innerHTML
    }

    resetQuantity() {
        this.quantityZone.innerHTML = 0
    }
}
