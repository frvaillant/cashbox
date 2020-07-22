export class Cart {
    constructor(localName) {
        this.localName = localName;
    }

    createLocalCart() {
        localStorage.setItem(this.localName, []);
    }

    deleteLocalCart() {
        localStorage.removeItem(this.localName);
    }

    getCart() {
        return localStorage.getItem(this.localName);
    }

    setCart(val) {
        localStorage.setItem(this.localName, val);
    }

    addToCart(purchase) {
        let cart = this.getCart();
        purchase.key = cart.length;
        cart[purchase.key] = purchase;
        this.setCart(cart)
    }

    removeFromCart(key) {
        let cart = this.getCart();
        delete cart[key];
        this.setCart(cart)
    }
}
