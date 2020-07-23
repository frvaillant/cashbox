import axios from "axios";

export class Validator {
    constructor(localName) {
        this.localName = localName
        this.button = document.getElementById('valid-purchase-btn')
        this.deletors = document.getElementsByClassName('delete-purchase-product')

        if (this.deletors.length > 0) {
            for (let i = 0; i < this.deletors.length; i++) {
                this.deletors[i].addEventListener('click', () => {
                    const purchaseId = this.deletors[i].dataset.id
                    alert(purchaseId)
                })
            }
        }
        if (this.button) {
            this.button.addEventListener('click', () => {
                const data = JSON.parse(this.getPurchase())
                const url = '/purchase/add';
                this.registerPurchase(url, data)
            })
        }
    }

    registerPurchase(url, data) {
        axios.post(url, data)
            .then(response => {
            })
    }

    getPurchase() {
        return '{' + localStorage.getItem(this.localName) + '}';
    }
}
