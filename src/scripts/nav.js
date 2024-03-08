let navigation = document.querySelector(".closed");
let navigationMobile = document.querySelector(".closed-mobile");
let mobileLinks = document.getElementById("mobile"); 

let isOpen = false;

function hamburger() {
    if(isOpen) {
        isOpen = false;
        navigationMobile.classList.add('closed-mobile');
        navigationMobile.classList.remove('open-mobile');

        navigation.classList.remove('open');
        navigation.classList.add('closed');

        mobileLinks.style.display = "none";
    } else if(!isOpen) {
        isOpen = true;
        navigationMobile.classList.remove('closed-mobile');
        navigationMobile.classList.add('open-mobile');

        navigation.classList.add('open');
        navigation.classList.remove('closed');

        mobileLinks.style.display = "block";
    }
}