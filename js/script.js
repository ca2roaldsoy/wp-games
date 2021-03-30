let searchGame = document.querySelector('#searchGame');
let previousValue;
let valueTimer;
console.log(searchGame);

searchGame.addEventListener("keyup", timer);

function timer() {
    if(searchGame.value != previousValue) {
        clearTimeout(valueTimer);

        if(searchGame.value) {
            valueTimer = setTimeout(() => {
                getResults();
            }, 750);
        }
    }
    previousValue = searchGame.value;
}

async function getResults() {
    try {
      const response = await fetch("http://gamerrevolution.local/wp-json/game/v1/search?value=" + searchGame.value);
      const results = await response.json();
      console.log(results);
    }
    
    catch (e) {
        console.log(e)
    }
}
