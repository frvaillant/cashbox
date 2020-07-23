import {Validator} from "./Validator";

export class Ticket {
    constructor(localName) {
        this.validator = null
        this.localName = localName
        this.ticket = document.getElementById('ticket')
    }

    showActions() {
        const actions = document.getElementById('actions')
            if (actions.classList.contains('hide')) {
                actions.classList.remove('hide')
                new Validator(this.localName)
            }
    }

    generateHtml(elem) {
        return '<tr>' +
            '<td>' + elem.name + '</td>' +
            '<td>' + elem.price + '€</td>' +
            '<td> x ' + elem.quantity + '</td>' +
            '<td class="right-align">' + elem.quantity * elem.price + '€</td>' +
            '<td>' +
                //'<a href="#" class="delete-purchase-product" data-id="' + elem.id +'">' +
                //    '<i class="material-icons small red-text">delete</i>' +
                //'</a>' +
            '</td>' +
            '</tr>'
    }

    generateTotal(total) {
        document.getElementById('totalCell').innerHTML = total + '€'
    }

    getTotal() {
        let total = 0
        const purchases = JSON.parse('{' + localStorage.getItem(this.localName) + '}');
        for (let [key, purchase] of Object.entries(purchases)){
            total += purchase.quantity * purchase.price
        }
        return total
    }

    resetTicket() {
        document.getElementById('ticket').innerHTML = ''
        localStorage.removeItem(this.localName);
        document.getElementById('actions').classList.add('hide')
    }

    update() {
        this.ticket.innerHTML = ''
        const purchases = JSON.parse('{' + localStorage.getItem(this.localName) + '}');
        for (let [key, purchase] of Object.entries(purchases)){
            this.ticket.innerHTML = this.ticket.innerHTML + this.generateHtml(purchase)
        }
        this.showActions()
        this.generateTotal(this.getTotal())
        document.getElementById('undo-purchase-btn').addEventListener('click', () => {
            this.resetTicket()
        })
    }
}
