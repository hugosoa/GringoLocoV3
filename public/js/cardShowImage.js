// const hoverReveal = document.querySelectorAll('.hover--reveal');
// const images = document.querySelectorAll('.hidden--img');
// const cardItem = document.querySelectorAll('.cocktails');

// cardItem.forEach(element => {
//     element.addEventListener("mousemove", (e) => {
//         hoverReveal.forEach(image => {
//             console.log("in")
//             image.style.opacity = "1";
//         });
//     });
//     element.addEventListener("mouseleave", (e) => {
//         hoverReveal.forEach(image => {
//             console.log("out")
//             image.style.opacity = "0";
//         });
//     });
// });
const cardItems = document.querySelectorAll('.card--item');
const images = document.querySelectorAll('.hover--reveal');

cardItems.forEach((cardItem, index) => {
    cardItem.addEventListener("mousemove", (e) => {
        // const xOffset = 50;
        // const yOffset = 50;

        const elementRect = cardItem.getBoundingClientRect();
        const elementX = elementRect.left;
        const elementY = elementRect.top;

        const imageX = e.clientX - elementX;
        const imageY = e.clientY - elementY;

        images[index].style.opacity = "1";
        images[index].style.transform = 'translate(1%, 1%) rotate(5deg)';
        images[index].style.left = `${imageX}px`;
        images[index].style.top = `${imageY}px`;

        console.log("in");
    });

    cardItem.addEventListener("mouseleave", () => {
        images[index].style.opacity = "0";
        images[index].style.transform = 'translate(0%, 0%) rotate(0deg)';
        images[index].style.left = 0 + 'px';
        images[index].style.top = 0 + 'px';

        console.log("out");
    });
});