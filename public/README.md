# PHP-SSR POC Implementation
This part of the repository displays real-world use cases of PHP-SSR. In a nutshell, it is used for prototyping and seeing if something is possible. It is not meant to be used in production.

## Stuff
I'm running out of ideas for headings. I'm sorry. Just some things to note:

- This directory should be served as the webroot of a virtual site.
- Parcel is used to bundle the client-side code.
  - We use Parcel's API to have better control over the build process.
  - This means some Parcel CLI options may not be available.
- Code in `resources/php-ssr` is mean to form part of the library itself.

Things being worked on:

> **Login**
> 
> Probably one of the first ideas I had for this project. A homepage with a login and
> signup form, with all components built in React, but the client side logic abstracted
> away into a PHP class. The class is then used to render the page on the server.
> 
> Actual SSR does not take place yet, but this will help us see if this project is worth
> pursuing!
