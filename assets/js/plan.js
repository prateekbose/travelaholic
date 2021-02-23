const placeCards = document.querySelectorAll('.choose-place .card')
const countryCards = document.querySelectorAll('.choose-country .card')
const countrySection = document.querySelector('.choose-country')
const cityCardSection = document.querySelector('.choose-city')
const cityCard = document.querySelectorAll('.choose-city .card')
const headers = document.querySelectorAll('.account-subheader')
const acceptButton = document.querySelector('.accept-section')


var selection = []
var country
var place
var PLACE
console.log(SPIRITUAL)

document.onreadystatechange = function() { 
    if (document.readyState !== "complete") { 
        document.querySelector("body").style.visibility = "hidden"
        document.querySelector("#loader").style.visibility = "visible" 
    } else { 
        document.querySelector("#loader").style.display = "none"
        document.querySelector("body").style.visibility = "visible"
    } 
}; 


placeCards.forEach((item,index) => {
    item.addEventListener('click', () => {
        place = item.getAttribute('data-value')
        switch(place){
            case "BEACHES":
                PLACE = BEACHES                
                break
            case "URBAN":
                PLACE = URBAN
                break
            case "MOUNTAIN":
                PLACE = MOUNTAIN
                break
            case "SPIRITUAL":
                PLACE = SPIRITUAL
                break
        }
        if(selection.indexOf(place) == -1){
            selection.push(place);
            console.log(selection)
        }
        headers[1].style.opacity = 1;
        countrySection.style.display = 'grid';
        countrySection.scrollIntoView({behavior: "smooth",inline: "nearest"})
        placeCards.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none';
            } 
        });
    });
});

countryCards.forEach((item,index) => {
    item.addEventListener('click', () => {
        country = item.getAttribute('data-value')
        if(selection.indexOf(country) == -1){
            selection.push(country);
            console.log(selection)
        }
        headers[2].style.opacity = 1
        cityCardSection.style.display = 'grid';
        cityCardSection.scrollIntoView({behavior: "smooth",inline: "start"})
        countryCards.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none';
            } 
        });
        cityCard.forEach((item,index) => {
            item.firstElementChild.firstElementChild.innerHTML = PLACE[country][index][0]
            item.firstElementChild.lastElementChild.innerHTML = PLACE[country][index][1]
            item.setAttribute('data-name', `${PLACE[country][index][0]}`)
            item.style.backgroundImage = `url('./images/${place}/${country}/${index+1}.jpg')`
        })
    });
});

cityCard.forEach((item,index) => {
    item.addEventListener('click', () => {
        var city = item.getAttribute('data-value')
        var cityName = item.getAttribute('data-name')
        if(selection.indexOf(city) == -1){
            selection.push(city);
        }
        acceptButton.style.display = 'block';
        changeLink(`./city?name=${btoa(cityName)}&p=${btoa(place)}&c=${btoa(country)}&i=${index+1}`,acceptButton)
        cityCard.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none'
            } 
        });
    });
});

const changeLink = (link,button) => {
    button.addEventListener('click', () => {
        window.location.href = link
    })
}