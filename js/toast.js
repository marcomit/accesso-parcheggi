function showToast(title, content, seconds = 3){
    const toast = document.getElementById('liveToast');
    toast.querySelector('#toast-title').innerHTML = title;
    toast.querySelector('#toast-body').innerHTML = content;
    toast.classList.add('show');
    setInterval(() => toast.classList.remove('show'), seconds * 1000);
}