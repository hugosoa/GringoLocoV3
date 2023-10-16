const gallery = document.querySelector('#selector--gallery')
const article = document.querySelector('#selector--article')
const comment = document.querySelector('#selector--comment')
// const profilGalery = document.querySelector('.profil__gallery')
// const profilArticle = document.querySelector('.profil__articles')
// const profilComment = document.querySelector('.profil__comment')
const profilContainer = document.querySelector('.container--slider')

console.log('1')

gallery.addEventListener('click', (e) => {
    console.log('1')
    profilContainer.style.transform = `translateX(66.8%)`
    gallery.classList.add('active')
    article.classList.remove('active')
    comment.classList.remove('active')

})
article.addEventListener('click', (e) => {
    console.log('2')
    profilContainer.style.transform = `translateX(0%)`
    article.classList.add('active')
    gallery.classList.remove('active')
    comment.classList.remove('active')
})
comment.addEventListener('click', (e) => {
    profilContainer.style.transform = `translateX(-70%)`
    comment.classList.add('active')
    gallery.classList.remove('active')
    article.classList.remove('active')
})



