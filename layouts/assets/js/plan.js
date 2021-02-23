const placeCards = document.querySelectorAll('.choose-place .card');
const countryCards = document.querySelectorAll('.choose-country .card');
const countrySection = document.querySelector('.choose-country');
const cityCardSection = document.querySelector('.choose-city');
const cityCard = document.querySelectorAll('.choose-city .card');
const headers = document.querySelectorAll('.account-subheader');
const acceptButton = document.querySelector('.accept-section');


var selection = [];

placeCards.forEach((item,index) => {
    item.addEventListener('mouseenter', () => {
        placeCards.forEach((e,i) => {
            if(i!=index){
                e.style.opacity = 0.5;
            }
        });
    });
    item.addEventListener('mouseout', () => {
        placeCards.forEach(e => e.style.opacity = 1);
    });
    item.addEventListener('click', () => {
        var place = item.getAttribute('data-value');
        if(selection.indexOf(place) == -1){
            selection.push(place);
            console.log(selection);
        }
        headers[1].style.opacity = 1;
        countrySection.style.display = 'grid';
        placeCards.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none';
            } 
        });
    });
});

countryCards.forEach((item,index) => {
    item.addEventListener('mouseenter', () => {
        countryCards.forEach((e,i) => {
            if(i!=index){
                e.style.opacity = 0.5;
            }
        });
    });
    item.addEventListener('mouseout', () => {
        countryCards.forEach(e => e.style.opacity = 1);
    });
    item.addEventListener('click', () => {
        var country = item.getAttribute('data-value');
        if(selection.indexOf(country) == -1){
            selection.push(country);
            console.log(selection);
        }
        headers[2].style.opacity = 1;
        cityCardSection.style.display = 'grid';
        countryCards.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none';
            } 
        });
    });
});

cityCard.forEach((item,index) => {
    item.addEventListener('mouseenter', () => {
        cityCard.forEach((e,i) => {
            if(i!=index){
                e.style.opacity = 0.5;
            }
        });
    });
    item.addEventListener('mouseout', () => {
        cityCard.forEach(e => e.style.opacity = 1);
    });
    item.addEventListener('click', () => {
        var city = item.getAttribute('data-value');
        if(selection.indexOf(city) == -1){
            selection.push(city);
            console.log(selection);
        }
        acceptButton.style.display = 'block';
        cityCard.forEach((e,i) => {
            if(i!=index){
                e.style.display = 'none';
            } 
        });
    });
});