var name = document.querySelector('title').innerHTML.split(" ",1)[0];

const burger = document.querySelector('.burger');
const popup = document.querySelector('.popup');
const exploreHero = document.querySelector('.explore-hero');
const exploreH1 = document.querySelector('.hero-header h1');
const exploreH3 = document.querySelector('.hero-header h3');
const exploreH4 = document.querySelector('.hero-header h4');
const heroButton = document.querySelectorAll('.explore-hero button');
const exploreButton = document.querySelectorAll('.explore-header-section button');
const cityButton = document.querySelectorAll('.city-card-section button');
const exploreCards = document.querySelectorAll('.category-card-section .card');
const cityCards = document.querySelectorAll('.city-card-section .city-card');
const cardSection = document.querySelector('.explore-popular .category-card-section');
const citySection = document.querySelector('.city-card-section .card-section');

const H1 = ['01','02'];
const H3 = ['Random Place Here','Random Second Place'];
const H4 = ['Location Here', 'Second Location Here'];
const back = ['card_back1.jpg', 'card_back2.jpg'];

const burgerMenu = () => {
    burger.addEventListener('click', () => {
        popup.classList.toggle('hide');
        burger.classList.toggle('burger-active');
    });
}

const hero = () => {
    let i = 0;
    heroButton[1].addEventListener('click', () => {
        if(i<1){
            i++;
        } else {
            i = 0;
        }        
        changeText(exploreH1,H1[i]);
        setTimeout(() => changeText(exploreH3,H3[i]), 150);
        setTimeout(() => changeText(exploreH4,H4[i]),300);
        changeBack(exploreHero,back[i]);
    });
    heroButton[0].addEventListener('click', () => {
        if(i>0){
            i--;
        } else {
            i = 1;
        }
        changeText(exploreH1,H1[i]);
        setTimeout(() => changeText(exploreH3,H3[i]), 150);
        setTimeout(() => changeText(exploreH4,H4[i]),300);
        changeBack(exploreHero,back[i]);
    });
}

const changeText = (elem,value) => {
    setTimeout(() => elem.classList.add('hide'), 0);
    setTimeout(() => elem.innerHTML = value, 600);
    setTimeout(() => elem.classList.remove('hide'), 600);
}

const changeBack = (elem,value) => {
    elem.style.backgroundImage = `url(${value})`;
}

const explore = () => {
    let i = 0;
    exploreButton[1].addEventListener('click', () => {
        if(i>=0 && (i+1)<exploreCards.length){
            i++;
            cardSection.scrollLeft += exploreCards[1].offsetWidth;
        }
    });
    exploreButton[0].addEventListener('click', () => {
        if(i>0 && (i+1)<=exploreCards.length){
            i--;
            cardSection.scrollLeft -= exploreCards[0].offsetWidth;
        }
    });
}

const cityHero = () => {
    let j = 0;
    cityButton[1].addEventListener('click', () => {
        if(j>=0 && (j+1)<=cityCards.length){
            j++;
            citySection.style.transform = `translate(-${cityCards[1].offsetWidth*j}px)`;
            cityCards.forEach((item,index) => {
                if(index<(j-1)){
                    item.style.opacity = 0;
                } else if(index == (j-1)){
                    item.style.opacity = 1;
                }
            })
        }
    });
    cityButton[0].addEventListener('click', () => {
        if(j>0 && (j+1)<=(cityCards.length+1)){
            j--;
            citySection.style.transform = `translate(-${cityCards[1].offsetWidth*j+5}px)`;
            cityCards.forEach((item,index) => {
                if(index>(j-1)){
                    item.style.opacity = 0.5;
                } else if(index == (j-1)){
                    item.style.opacity = 1;
                } else {
                    item.style.opacity = 0;
                }
            })
        }
    });
}

const start = () => {
    if(name=="Explore"){
        hero();
    }   
    if(name == "Explore" || name == "Home"){
        explore();
    }
    if(name == "City"){
        cityHero();
    }
    burgerMenu();
}

start();
