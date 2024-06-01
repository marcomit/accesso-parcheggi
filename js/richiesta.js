document.querySelectorAll('table > tbody > tr').forEach(tr => {
    tr.addEventListener('click', e => {
        document.getElementById('id_richiesta').value = tr.querySelector('input').value
    })
})