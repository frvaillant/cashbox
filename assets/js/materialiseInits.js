document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    const modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    document.getElementById('printer').addEventListener('click', () => {
        window.print();
    })
});
