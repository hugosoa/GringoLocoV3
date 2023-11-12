const parallax_el = document.querySelectorAll(".parallax");

let xValue = 0, yValue = 0;

window.addEventListener("mousemove", (e) => {
    xValue = e.clientX - window.innerWidth / 2;
    yValue = e.clientY - window.innerHeight / 2;
    
    parallax_el.forEach((el) => {
        let speedx = el.dataset.speedx;
        let speedy = el.dataset.speedy;
        let speedz = el.dataset.speedz;

        let isInLeft = 
        parseFloat(getComputedStyle(el).left) < window.innerWidth / 2 ? 1 : -1;
        let zValue = (e.clientX - parseFloat(getComputedStyle(el).left)) * isInLeft * 0.1;

        el.style.pointer = "none"
        el.style.transform = `translateX(calc(-50% + ${(-xValue * speedx)}px / 10)) translateY(calc(-50% + ${-yValue * speedy}px / 10)) perspective(2300px) translateZ(${zValue * speedz}px)`;
    })
})
// el.style.transform = "translateY(-50%) translateX(-50%)"


