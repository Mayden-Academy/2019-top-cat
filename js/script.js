let target = document.querySelectorAll('.favorite-icon')

target.forEach(cat => {
    cat.addEventListener('click', function () {
        this.parentElement.submit()
    })})