let target = document.querySelectorAll('.favourite-icon')

target.forEach(cat => {
    cat.addEventListener('click', function () {
        this.parentElement.submit()
    })})