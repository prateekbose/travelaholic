const cityTitle = document.querySelector('.city-hero-section .details h1')
const countryTitle = document.querySelector('.city-hero-section .details h3')
const heroBackgroundImage = document.querySelector('.city-hero-section')

console.log(DATA)

cityTitle.innerHTML = DATA["Name"]
countryTitle.innerHTML = DATA["Country"]
heroBackgroundImage.style.backgroundImage = `url('./images/${place}/${country}/${index+1}.jpg')`