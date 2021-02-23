const logOut = document.querySelector('.logout')

setCookie = (cname,cvalue) => {   
    document.cookie = cname + '='+ cvalue;
}

logOut.addEventListener('click', () => {
    setCookie("USLG",0)
    console.log("cookie destroyed")
    location.reload()
})