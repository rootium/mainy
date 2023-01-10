const buttonA = document.getElementById("buttonA");
const buttonG = document.getElementById("buttonG");
const input = document.getElementById("input");
const select = document.getElementById("select");
const listE = document.getElementById("listE");

let item = document.createElement("li");

var players = [];

var player = ""

buttonA.onclick = function(){
    if (input.value != ""){
        item.textContent = `${select.options[select.selectedIndex].text}# ${input.value}`;
        item.addEventListener('click', event => {
            listE.removeChild(event.target);
            const index = players.indexOf(event.target.textContent);
            players.splice(index, 1);
        });
        listE.appendChild(item);
        item = document.createElement("li");
        players.push(`${input.value}`);
        input.value = "";
    }
    else {
        alert("Input box is empty!");
    }
}

input.addEventListener("keypress", function(event){
    if (event.key === "Enter"){
        event.preventDefault();
        buttonA.click();
    }
});

buttonG.onclick = function(){
    if (players.length > 0){
        window.location.href = `result/result.php?players=${players.join(",")}`;
    }
    else {
        alert("Player list is empty!");
    }
}