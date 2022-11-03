let slideIndex = 0;
showSlides(slideIndex);

// Next Prev Controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function moveSlides(n) {
    tampilSlides(slideIndex += n);
}

function showSlides(n) {
    document.getElementById('first').style.display = 'none';

    let i;
    let slides = document.getElementsByClassName("my-slide");

    if (n > slides.length) {
        slideIndex = 0;
        document.getElementById('first').style.display = 'block';
    }
    if (n == 0) {
        document.getElementById('first').style.display = 'block';
    } else if (n < 0) {
        slideIndex = slides.length;
    }
    slides[slideIndex].style.display = "block";
}

function tampilSlides(n) {
    document.getElementById('awal').style.display = 'none';

    let i;
    let slides = document.getElementsByClassName("my-slide-a");

    if (n > slides.length) {
        slideIndex = 0;
        document.getElementById('awal').style.display = 'block';
    }
    if (n == 0) {
        document.getElementById('awal').style.display = 'block';
    } else if (n < 0) {
        slideIndex = slides.length;
    }
    slides[slideIndex].style.display = "block";
}

function inputNominal(metode) {
    var n = 0;

    n = prompt('Nominal Donasi ' + metode + ' : ', n);
    if (n <= 0) {
        alert('Donasi belum berhasil');
    } else {
        alert('Terimakasih Atas Donasi yang diberikan');
    }
}

function showInformations(idText) {
    document.getElementById(idText).style.display = 'block';
}