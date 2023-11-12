const content = document.querySelectorAll('div:not(.loader), nav, footer')
const loader = document.querySelector('.loader');

console.log('test')

content.forEach(function (e) {
    e.classList.add('display--none');
});
window.addEventListener('load', function () {
    loader.style.display = 'none';
    content.forEach(function (e) {
        e.classList.remove('display--none');
    })
});