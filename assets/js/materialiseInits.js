import axios from 'axios';

document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    const modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    const tooltipped = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltipped);

    if(document.getElementById('printer')) {
        document.getElementById('printer').addEventListener('click', () => {
            window.print();
        })
    }

   if(document.getElementById('cash-count-button')) {
       document.getElementById('cash-count-button').addEventListener('click', () => {
           axios.get('/cash/count/check')
               .then(response => {
                   if (response.status === 200) {
                       document.getElementById('count-check-alert').classList.remove('hide')
                       document.getElementById('last-count').innerText = response.data.count + ' €'
                   } else {
                       if(! document.getElementById('count-check-alert').classList.contains('hide')) {
                           document.getElementById('count-check-alert').classList.add('hide')
                       }
                   }
               })
       })
   }
});
