# WishListMaker
A website for users to login and save links for future products they may wish to purchase. The home page to the site is the file christmaslist.php


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

# Server Structure
An SQL database with one starting table. This table, called logins, stores the username, password, and login time. Every time a new user registers on the website, a new table (uniquely bound to the user) is created with entries to store items and their corresponding link to purchase and cost.

# Compatibility

* In order to be compatible with PHP versions earlier than 5.5 (PHP 5.3.7 and later), I've added a library at the suggestion of http://php.net/manual/en/faq.passwords.php#faq.passwords.bestpractice. The code is available for free
usage under the MIT license.

* A few small changes to the codebase are needed to change the database from SQLite3 to another (MySQL, MariaDB).
