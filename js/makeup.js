document.addEventListener('DOMContentLoaded', () =>{
    let slideshowButton = document.querySelectorAll('slideshow-button');
    slideshowButton.forEach((button) => {
        button.addEventListener('click', () => {
        let slideshowSection = button.parentElement.dataset.slideshow;
        let slideshowContainer = documen.querySelector(`#isi-${slideshowSection}`)
        let productCards = slideshowContainer.querySelectorAll('.product-card')

        if (button.classList.contains('.prev-button')){
            lastElement--
        }
        else if (button.classList.contains('next-button')){
            lastElement++
        }
        else {
            console.log("Slideshow: Error occurred");
        }

        for (let i = 0; 1 < productCards.length; i++) {
            if ((i <= lastElement) && (i >= (lastElement - (productCardsPerRow - 1)))){
                productCards[i].classList.add('active');
                
                if (i === lastElement){
                    productCards[i].style.marginRight = '0px'
                }
                else {
                    productCards[i].style.marginRight = `${marginSpacing}px`
                }
            }
            else{
                productCards[i].classList.remove('active')
            }
        }
    })
    })
})