document.querySelectorAll('.favorite-icon-container').forEach(favIcon => {
    favIcon.addEventListener('click', () => {
        let data = {
            breed: favIcon.dataset.breedid,
            catID: favIcon.dataset.catid
        }
        let body = JSON.stringify(data)
        console.log(body)
        fetch("src/api/addFavourite.php", {
            method: "POST",
            body: body
        }).then(response => {
            return response.json()
        }).then( thing => {
            console.log(thing)
        })
    })
})