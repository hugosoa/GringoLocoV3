const nav = document.querySelector('nav');
let isScrolling = 0;
window.addEventListener("scroll", function() {
    let scrollDown = window.scrollY
    if (scrollDown > isScrolling) {
        nav.classList.add('fade--out')
        nav.classList.remove('fade--in')
    }
    if (scrollDown < isScrolling) {
        nav.classList.add('fade--in')
        nav.classList.remove('fade--out')
    }
    isScrolling = scrollDown

})
