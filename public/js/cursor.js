const coords = { x: 0, y: 0 };
const circles = document.querySelectorAll(".circle");
let animationId; // Stocke l'ID de l'animation pour pouvoir l'annuler

circles.forEach(function (circle) {
    circle.x = 0;
    circle.y = 0;
});
window.addEventListener("mousemove", function (e) {
    coords.x = e.clientX + window.scrollX;
    coords.y = e.clientY + window.scrollY;

    if (!animationId) {
        // Ne lance l'animation que si elle n'est pas déjà en cours
        animationId = requestAnimationFrame(animateCircles);
    }
});

function animateCircles() {
    let x = coords.x;
    let y = coords.y;

    circles.forEach(function (circle, index) {
        const circleRect = circle.getBoundingClientRect();

        circle.style.left = x - 12 + "px";
        circle.style.top = y - 12 + "px";

        circle.style.transform = `scale(${(circles.length - index) / circles.length})`;

        circle.x = x;
        circle.y = y;

        const nextCircle = circles[index + 1] || circles[0];
        x += (nextCircle.x - x) * 0.2;
        y += (nextCircle.y - y) * 0.2;
    });

    // Demande la prochaine frame d'animation
    animationId = requestAnimationFrame(animateCircles);
}

// Pour arrêter l'animation
function stopAnimation() {
    if (animationId) {
        cancelAnimationFrame(animationId);
        animationId = undefined;
    }
}