Dependancies...
jwilsson/spotify-web-api-php - <https://github.com/jwilsson/spotify-web-api-php>
Installation
composer require jwilsson/spotify-web-api-php

Installation
Install the module as normal and enable
As Admin configure the Spotify client id and client secret at Configuration &gt; Spotify Client Settings
/admin/config/spotify/client
Enter your developer client ID and secret and save
Example...
1301977f1a6a498b9e6088726ea29231 - Client ID of Andy Jones if needed
ba6c89f164d94310856a2446b0ace8b0 - Client secret
Test the API is working
Expand the 'Test Spotify API' fieldset and click 'Test API'
Form will reload and the API response should have the response rom Spotify.
Add the 'Artist List Block' to the appropriate region at /admin/structure/block
Configure the block
You can specify the search query to use and the number of artists to return/display in the block config
