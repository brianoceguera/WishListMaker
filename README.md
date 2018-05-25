# WishListMaker
A website to login and save links for future products they may wish to purchase. The home page to the site is the file christmaslist.php


# Features

* Accounts: Your username must be a minimum of 2 characters and passwords must be a minimum of 6 characters.

* JS: Login and dashboard pages use client side JS for form
validation + Ajax

* JS Events: On login page, events fire for invalid
login, for trying to register an existing username,
form validation for registration, and letting user
know if registration failed or passed. On
dashboard page, events fire for delete and submit
buttons

* SQLite3: Store all fields from registration
including login times (timestamp). Dynamically
creates a table when a new user registers, which
stores wish list item, link and price. Prepared
statements are used to prevent SQL injection.

* Sessions: To keep track of logins and usernames,
and redirect to dashboard or login depending on
login status. Users can see their last login time.

* Regular Expressions: Used on dashboard to
prevent users from entering <script> tags or html
tags in the item field.
