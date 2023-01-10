const buttonDraft = document.getElementById("buttonDraft");
const buttonDog = document.getElementById("buttonDog");
const buttonQueue = document.getElementById("buttonQueue");

buttonDraft.onclick = function(){
    window.location.href = "draft/draft.html";
}

buttonDog.onclick = function(){
    window.location.href = "dog_tracker.html";
}

buttonQueue.onclick = function(){
    window.location.href = "queue_timer.html";
}
