export class CashReturn {
    constructor() {
        this.total = null
    }

    init() {
        this.totalPurchaser()
        this.clientCash = document.getElementById('cash-client')
        this.CashReturnTarget = document.getElementById('cash-return')
        this.clientCash.addEventListener('keyup', () => {
            this.calculateChange()
        })
    }

    totalPurchaser() {
        const target = document.getElementById('cart-amount')
        const totalZone = document.getElementById('totalCell')
        let total = totalZone.innerHTML.split('€')
        total = parseFloat(total[0])
        target.value = total
        this.total = total
    }

    calculateChange() {
        console.log(this.CashReturnTarget, this.clientCash, this.total)
        let diff = parseFloat(this.clientCash.value) - parseFloat(this.total)
        if (diff > 0) {
            this.CashReturnTarget.value = diff + '€'
        } else {
            this.CashReturnTarget.value = 0 + '€'
        }
    }
}
