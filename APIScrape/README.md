# API Scraper

A command-line utility for creating the database for the Top Cat app.

* Makes API requests to get:
    * A list of cat breeds
    * Image URLs for cats from each breed

To use: 
1. Make sure you are in the APIScrape directory
2. `$ php scrape.php`

What follows is a description of how theCatAPI works.

## theCatApi

https://docs.thecatapi.com/

**Authentication (Request Header)**
* The best & most secure way to send it
* Set your API Key as the x-api-key header on every request.
*e.g headers[“x-api-key”] = "ABC123"*

Api key `ec254e44-3996-458b-8522-4933954d8fcd`

**Search**
* All Images are available via GET https://api.thecatapi.com/images/search
* You can use Query Parameters to filter by size, mime_types, order, limit, page, category_ids, format, breed_id

**Pagination & Ordering**

The results of /images/search or /images routes can be paginated through, using the limit and page query parameters.
* limit is the amount of images to return
* page is the results page to return, 0 is the first.

NOTE: pagination can only be performed when the order query parameter is Desc or Asc - Not the default Rand.

The total amount of Images available that match the query is returned as the Pagination-Count header.

Example:
https://api.thecatapi.com/v1/images/search?limit=5&page=10&order=Desc - would return 5 images, from page 10 of entire collection in Descending order.
You can change the order, page or limit to see the result for yourself.


**/breeds**

GET
https://api.thecatapi.com/v1/breeds/ populates select dropdown with all breeds.

Request parameters available:
* attach_breed - integer
* page - integer
* limit - integer

Response (key of interest):

An array of Breed Objects.
* array [object]
* id - string
* name - string

**/images**

GET
https://api.thecatapi.com/v1/images/search?breed_ids={breed-id}&limit=9 gets the images for the selected cat.
* `limit=9` has been applied to return multiple images and return the right number of images for our page design. It also stops it giving us just one random image at a time - instead it gives us 9 random images (this will be a problem for favoriting. 
* `{breed id}` to be populated from breed-id selected in the dropdown.

Request parameters available:
* size - string
* mime-types - array[string]
* order - string
* limit - integer
* page - integer
* category_ids - array[integer]
* format - string
* breed_id - string

Response (key of interest):
An array of image objects matching the query sent. Relevant query below.

array[object]
* id - string
* url - string