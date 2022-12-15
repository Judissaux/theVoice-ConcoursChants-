var video = document.getElementById("background-video");

var btn = document.getElementById("btnVideo");

 

function playAndPause () {

if (video.paused) {

video.play();

btn.innerHTML = "IIII";

} else {

video.pause();

btn.innerHTML = " ▶";

}

}