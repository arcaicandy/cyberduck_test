# Dependancies...
## jwilsson/spotify-web-api-php
 - [https://github.com/jwilsson/spotify-web-api-php](https://github.com/jwilsson/spotify-web-api-php)
To install use - composer require jwilsson/spotify-web-api-php
# Module installation
Install the module as normal and enable
## Configure the module
1. As Admin configure the Spotify client id and client secret at Configuration &gt; Spotify Client Settings
/admin/config/spotify/client
2. Enter your developer client ID and secret and save
Example...
1301977f1a6a498b9e6088726ea29231 - Client ID
ba6c89f164d94310856a2446b0ace8b0 - Client secret
## Test the API is working
From the module configuration page - /admin/config/spotify/client
1. Expand the 'Test Spotify API' fieldset and click 'Test API'
Form will reload and the API response should have the response from Spotify.
## Add the 'Artist List Block'
Add the Artist List Block to the appropriate region at /admin/structure/block
## Configure the block
You can specify the search query to use and the number of artists to return/display in the block config
# Usage
The Artists list block should appear in your site/page/region and display the search results returned for the search query. The number of results will be limited to the limit specified in the block configuration.
Clicking on an Artist will take you to a page that displays the Spotify Artist information for the selected artist.
Users other than Admin will need the "View Spotify artist information" permission setting on the appropriate role.
