const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var players = urlParams.get('players');

players = players.split(",");

const label = document.getElementById("label");
label.textContent = players;