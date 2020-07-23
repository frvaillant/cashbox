import {Validator} from "./Validator";

export class Ticket {
    constructor(localName) {
        this.validator = null
        this.localName = localName
        this.ticket = document.getElementById('ticket')
    }

    generateHtml(elem) {
        return '<tr>' +
            '<td>' + elem.name + '</td>' +
            '<td>' + elem.price + '€</td>' +
            '<td> x ' + elem.quantity + '</td>' +
            '<td class="right-align">' + elem.quantity * elem.price + '€</td>' +
            '<td>' +
                '<a href="#" class="delete-purchase-product" data-id="' + elem.id +'">' +
                    '<i class="material-icons small red-text">delete</i>' +
                '</a>' +
            '</td>'
            '</tr>'
    }

    generateTotal(total) {
        return '<tr>' +
            '<td colspan="3" class="left-align"><a class="btn purchase pink" id="valid-purchase-btn">valider</a></td>' +
            '<td class="right-align bolder total-ticket">' + total + '€</td>' +
            '</tr>'
    }


    initializeSelect() {
        const selector = document.getElementById('payment-modes')
        const row = document.getElementById('row-select')
        row.appendChild(selector)
        M.FormSelect.init(selector);
    }

    generateUndo() {
        return '<tr>' +
            '<td colspan="5" class="right-align"><a class="btn purchase black" id="undo-purchase-btn">annuler</a></td>' +
            '</tr>'
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
    }

    update() {
        this.ticket.innerHTML = ''
        const purchases = JSON.parse('{' + localStorage.getItem(this.localName) + '}');
        for (let [key, purchase] of Object.entries(purchases)){
            this.ticket.innerHTML = this.ticket.innerHTML + this.generateHtml(purchase)
        }
        this.ticket.innerHTML += this.generateTotal(this.getTotal())
        this.initializeSelect()
        this.ticket.innerHTML += this.generateUndo()
        this.validator = new Validator(this.localName)
        document.getElementById('undo-purchase-btn').addEventListener('click', () => {
            this.resetTicket()
        })
    }
}
