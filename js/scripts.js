const searchGame = document.querySelector('.searchGame');
const searchResultsTable = document.querySelector('.searchResults');
const searchResultsRow = document.querySelector('.searchResults__head');
const hamburger = document.querySelector(".hamburgerIcons");
const navMenu = document.querySelector("#menu");
let img = document.querySelector('.figure-img');
let previousValue;
let valueTimer;
let ItemMenu = true;

// remove search results if user click outside
window.addEventListener("mouseup", function(e) {

    if(e.target != searchResultsTable) {
        searchResultsTable.classList.remove('searchResultsDropDown');
        searchGame.value = "";
    }
});

// Hamburger toogle
hamburger.addEventListener("click", function (e){

    searchResultsTable.classList.remove('searchResultsDropDown');
    searchGame.value = "";

    if(ItemMenu) {
        navMenu.style.transform = "translate(-15px, 2.7%)";
        hamburger.childNodes[1].classList.add('barOne')
        hamburger.childNodes[3].classList.add('barTwo');
        hamburger.childNodes[5].classList.add('barThree');
        ItemMenu = false;
    } else if (!ItemMenu) {
        navMenu.style.transform = "translate(-15px, -125vh)";
        hamburger.childNodes[1].classList.remove('barOne')
        hamburger.childNodes[3].classList.remove('barTwo');
        hamburger.childNodes[5].classList.remove('barThree');
        ItemMenu = true;
    }
})

searchGame.addEventListener("keyup", timer);

// wait 750 ms before searching
function timer() {

    if(searchGame.value != previousValue) {
        clearTimeout(valueTimer);

        if(searchGame.value.length > 2) {
            searchResultsTable.classList.add('searchResultsDropDown');
            searchResultsRow.innerHTML = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`;
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

// get search results
async function getResults() {

    try {
      const response = await fetch("http://gamerrevolution.local/wp-json/game/v2/search?value=" + searchGame.value);
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
                            `<span>${platform.platform.name}</span>`
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
                                <td>${gamePlatforms(results[i].platforms)}</td>
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

// split url
let path = window.location.pathname.split('/');

// get "game"-part from url
let gamePathPart = path[1];

const gamePage = document.querySelector(".gamePage");

// add eventlistener if url contains game
if(window.location.href == gamePathPart) {

    img.addEventListener("click", (e) => {
        console.log(e.target.src);
            if(e.target.tagName == "img" && !e.target.hasAttribute("target")){
                img.setAttribute("target", "_blank")
            } 
    })
};