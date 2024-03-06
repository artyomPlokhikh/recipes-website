document.addEventListener('DOMContentLoaded', function () {

    var iconElements = document.querySelectorAll('.icon');
    iconElements.forEach(function (icon) {
        icon.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });



    var menuToggle = document.querySelector('.menu-toggle');
    menuToggle.addEventListener('click', function(){
        menuToggle.classList.toggle('active');
    })

})