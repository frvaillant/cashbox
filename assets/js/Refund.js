import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const showProductChoice = document.getElementById('refund-product-btn')
    const productRow = document.getElementById('refund-product-row')
    const productSelector = document.getElementById('refund_product')
    const quantityInput = document.getElementById('refund_quantity')
    const amount = document.getElementById('refund_amount');
    if (showProductChoice) {
        showProductChoice.addEventListener('click', () => {
            productRow.classList.remove('hide')
            amount.setAttribute('readonly', 'true')
        })
    }
    if (productSelector) {
        productSelector.addEventListener('change', (e) => {
            axios.get('/product/' + e.target.value + '/price')
                .then(response => {
                    if (response.status === 200) {
                        console.log(response.data)
                        document.getElementById('refund-product-price').value = response.data.price
                    } else {
                        M.toast({html: 'Impossible de trouver le prix du produit', classes: 'red'})
                    }
                })
        })
    }
    if (quantityInput) {
        quantityInput.addEventListener('keyup', () => {
            const price = document.getElementById('refund-product-price').value;
            const quantity = document.getElementById('refund_quantity').value;
            const total = quantity * price
            amount.value = total
        })
    }
})
