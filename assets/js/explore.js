document.onreadystatechange = function() { 
    if (document.readyState !== "complete") { 
        document.querySelector("body").style.visibility = "hidden"
        document.querySelector("#loader").style.visibility = "visible" 
    } else { 
        document.querySelector("#loader").style.display = "none"
        document.querySelector("body").style.visibility = "visible"
    } 
}; 

const placeCards = document.querySelectorAll('.card-section .card');

placeCards.forEach((item,index) => {
    item.addEventListener('click', () => {
        window.location.href = placeURL[index]
    })
})