export class Cart {
    constructor(localName) {
        this.localName = localName;
    }

    deleteLocalCart() {
        localStorage.removeItem(this.localName);
    }

    getCart() {
        return localStorage.getItem(this.localName);
    }

    setCart(val) {
        if (!this.getCart()) {
            const key = val.id
            val = '"' + key + '" : ' + JSON.stringify(val);
        } else {
            const key = val.id
            val = this.getCart() + ', "' + key + '" : ' + JSON.stringify(val)

        }
        localStorage.setItem(this.localName, val);
    }

    addToCart(purchase) {
        this.setCart(purchase)
    }
}
