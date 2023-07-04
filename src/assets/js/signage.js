
function openCover() {
    const cover = document.getElementById('cover');
    cover.classList.remove('cover-close');
    cover.classList.add('cover-open');
}
function closeCover() {
    const cover = document.getElementById('cover');
    cover.classList.add('cover-close');
    setTimeout(function() {
        cover.classList.remove('cover-open');
    }, 1200)
}


window.onload = () => {

    posters = document.getElementsByClassName('poster');
    viewPoster = 0;
    Array.prototype.forEach.call(posters, (poster) => {
        poster.style.display = "none"
    })

    posters[0].style.display = "flex";
    openCover();

    function next() {
        closeCover();
        setTimeout(function() {
            posters[viewPoster].style.display = "none";
            viewPoster = ++viewPoster % posters.length;
            posters[viewPoster].style.display = "flex";
            openCover();
        }, 1500);
    }


    setInterval(function() {
        next()
    }, 5000)

}