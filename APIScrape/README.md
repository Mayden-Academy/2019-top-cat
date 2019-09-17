TheCatApi // Developer Experience
https://docs.thecatapi.com/


## Authentication

**Request Header**
* The best & most secure way to send it
* Set your API Key as the x-api-key header on every request.
*e.g headers[“x-api-key”] = "ABC123"*

Api key `ec254e44-3996-458b-8522-4933954d8fcd`


**/breeds**

GET
https://api.thecatapi.com/v1/breeds/ populates select dropdown with all breeds.


**/images**

GET
https://api.thecatapi.com/v1/images/search?breed_ids={breed-id}&limit=9 gets the images for the selected cat.
* `limit=9` has been applied to return multiple images and return the right number of images for our page design. It also stops it giving us just one random image at a time - instead it gives us 9 random images (this will be a problem for favoriting. 
* `{breed id}` to be populated from breed-id selected in the dropdown.
