import axios from "axios";

export class Validator {
    constructor(localName) {
        this.localName = localName
        this.button = document.getElementById('valid-purchase-btn')
        this.deletors = document.getElementsByClassName('delete-purchase-product')
        this.paymentModes = document.getElementsByClassName('pm')

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
                if (this.getPaymentMode()) {
                    this.registerPurchase(url, data)
                } else {
                    M.toast({html:'Choisir un moyen de paiement', classes:'red'})
                }
            })
        }
    }

    getPaymentMode() {
        for(let i = 0; i < this.paymentModes.length; i++) {
            if (this.paymentModes[i].checked) {
                return this.paymentModes[i].value
            }
        }
        return null
    }

    registerPurchase(url, data) {
        axios.post(url, data)
            .then(response => {
                if (response.status === 200) {
                    window.location.href='/cashbox'
                }
                else {
                    M.toast({html:'Une erreur est survenue', classes:'red'})
                }
            })
    }

    getPurchase() {
        return '{ "pm" : { "payment_mode" : "' + this.getPaymentMode() + '"}, ' + localStorage.getItem(this.localName) + '}';
    }
}
