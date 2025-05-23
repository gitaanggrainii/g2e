const imgSlider = document.querySelector('.img-slider');
const imgstar = document.querySelectorAll('.img-item.star');

const nextBtn = document.querySelector('.next-btn');
const prevBtn = document.querySelector('.prev-btn');

let indexSlider = 0;
let index = 0;
nextBtn.addEventListener('click', () => {

    indexSlider++;
    imgSlider.style.transform = `rotate(${indexSlider * -90}deg)`;

    index++;
    if (index > imgstar.length - 1) {
        index = 0;
    }

    document.querySelector('.star-active').classList.remove('active');
    imgstar[index].classList.add('active');

});

prevBtn.addEventListener('click', () => {

    indexSlider--;
    imgSlider.style.transform = `rotate(${indexSlider * -90}deg)`;

    index--;
    if (index < 0) {
        index = imgstar.length - 1;
    }

    document.querySelector('.star-active').classList.remove('active');
    imgstar[index].classList.add('active');
});


 

 

   