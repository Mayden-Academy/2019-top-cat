let target = document.querySelectorAll('.favorite-icon')

target.forEach(cat => {
    cat.addEventListener('click', function () {

        this.parentElement.submit()

        //     let data = {
        //         "newFavorite": cat.dataset.catID,
        //         "breedID": cat.dataset.breedID
        //     }
        //     fetch('index.php', {
        //         method: 'POST',
        //         body: JSON.stringify(data),
        //         headers: {
        //             'Content-Type': 'application/json'
        //         }
        //     }).then(function (response) {
        //         console.log(response)
        //     })
        // })
    })})