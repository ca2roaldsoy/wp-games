let searchGame = document.querySelector('.searchGame');
const searchResultsTable = document.querySelector('.searchResults')
const searchResultsRow = document.querySelector('.searchResults__head')
let previousValue;
let valueTimer;
let loading = false;
console.log(searchGame);

searchGame.addEventListener("keyup", timer);

function timer() {

    if(loading) {
        searchResultsTable.classList.add('searchResultsDropDown');
        searchResultsRow.innerHTML = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`;
    }

    if(searchGame.value != previousValue) {
        clearTimeout(valueTimer);

        if(searchGame.value.length > 2) {
            loading = true;
            valueTimer = setTimeout(() => {
                getResults();
            }, 750);
        } else {
            searchResultsTable.classList.remove('searchResultsDropDown');
            searchResultsRow.innerHTML = "";
        }
    }

    previousValue = searchGame.value;
}

async function getResults() {

    try {
      const response = await fetch("http://gamerrevolution.local/wp-json/game/v1/search?value=" + searchGame.value);
      const results = await response.json();
      
        if(results.length > 0) {
            loading = false;
            if(!loading) {
                searchResultsRow.removeChild(searchResultsRow.childNodes[0]);
            }
            searchResultsTable.classList.add('searchResultsDropDown');

            for (let i=0; i < results.length; i++) {
                
                function gamePlatforms(platforms) {
                    return `
                        ${platforms.map(platform => 
                            `<span>${platform.platform.name}</span>
                            `
                        )}
                    `
                }

                function gameRating(rating) {
                   let ratings = Math.ceil(rating);

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
            loading = false;
            searchResultsRow.removeChild(searchResultsRow.childNodes[0]);
            searchResultsTable.classList.add('searchResultsDropDown');
            searchResultsRow.innerHTML += `
                <tr>
                    <td>Sorry, no games found</td>
                </tr>   
            `  
        }   
    }
    
    catch (e) {
        console.log(e)
    }
}
