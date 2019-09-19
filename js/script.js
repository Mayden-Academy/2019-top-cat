let target = document.querySelectorAll('.favorite-icon-container')

target.forEach(cat => {
    cat.addEventListener('click', function () {

        window.location.href = 'index.php'

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