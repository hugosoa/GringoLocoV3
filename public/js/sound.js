let audio = document.getElementById("myAudio");
let button = document.querySelector(".audio__container--player")
let isPlaying = false;
console.log('sound')

audio.volume = 0.5;

audio.onplaying = function() {
    isPlaying = true;
  };
audio.onpause = function() {
    isPlaying = false;
  };
button.addEventListener('click', function(){
    button.classList.toggle('active')
    isPlaying ? audio.pause() : audio.play();
})



audio.onplaying = function() {
    isPlaying = true;
  };
audio.onpause = function() {
    isPlaying = false;
  };