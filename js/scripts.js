let searchGame = document.querySelector('.searchGame');
const searchResultsTable = document.querySelector('.searchResults')
const searchResultsRow = document.querySelector('.searchResults__head')
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

    const api = "http://gamerrevolution.local/wp-json/game/v1/search?value=" + searchGame.value;
    console.log(api);

    try {
      const response = await fetch("http://gamerrevolution.local/wp-json/game/v1/search?value=" + searchGame.value);
      const results = await response.json();
      console.log(response);

        if(results.length > 0) {
            searchResultsTable.classList += ' searchResultsDropDown';
            for (let i=0; i < results.length; i++) {
                

                function gamePlatforms(platforms) {
                    return `
                        ${platforms.map(platform => 
                            `<span>${platform.platform.name}</span>`
                        )}
                    `
                }

                function gameRating(rating) {
                   let ratings = Math.floor(rating);

                   for(let i=1; i <= ratings; i++) {

                        if(i == ratings) {
                            const stars = `<span><i class='bi bi-star-fill'></i></span>`
                            return stars.repeat(i);
                        } 
                    }
                }

                function gameResultsTable() {
                    return `
                            <tr id='row-${i}'>
                                <td><img src=${results[i].image} width='64px' alt='${results[i].title}'></td>
                                <td><a href='${results[i].link}'>${results[i].title}</a></td>
                                <td>${gamePlatforms(results[i].platform)}</td>
                                <td>${gameRating(results[i].rating)}</td>
                            </tr>
                       
                    `
                }
                searchResultsRow.innerHTML += `
                ${gameResultsTable()}
                `  
            }
        } else {
            return;
        }   
    }
    
    catch (e) {
        console.log(e)
    }


}
