import axios from "axios";
import {CashReturn} from "./CashReturn"

export class Validator {
    constructor(localName) {
        this.localName = localName
        this.button = document.getElementById('valid-purchase-btn')
        this.paymentModes = document.getElementsByClassName('pm')

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
                    const cashReturnModal = document.getElementById('cashreturn')
                    const cashId = cashReturnModal.dataset.trigger
                    if (cashId === this.getPaymentMode()) {
                        const cashReturn = new CashReturn()
                        cashReturn.init()
                        const modalcashReturn = M.Modal.init(cashReturnModal, {
                            onCloseEnd: function() {
                                window.location.href='/cashbox'
                            }
                        });
                        modalcashReturn.open();
                        document.getElementById('cash-client').value = ''
                        document.getElementById('cash-client').focus()
                    } else {
                        window.location.href='/cashbox'
                    }
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
