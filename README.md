
![presentation-picture](public/img/php.webp)


Report repo README
====================
[![Build Status](https://scrutinizer-ci.com/g/SamS-2024/mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/SamS-2024/mvc/build-status/main)

[![Code Coverage](https://scrutinizer-ci.com/g/SamS-2024/mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/SamS-2024/mvc/?branch=main)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SamS-2024/mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/SamS-2024/mvc/?branch=main)

Here are the necessary instructions on how to clone the repository and get started with running the website.

Prerequisites
--------------

You have installed PHP in the terminal.

You have installed Composer, the PHP package manager.


About this repo:
-----------------

This repo is part of the MVC course in the Web Development program. It contains solutions to all course modules (kmom01–kmom06) as well as a final project (kmom10).

Each module focuses on different parts of MVC architecture, Symfony, routing, templating, and working with databases using Doctrine ORM.

The final project is a standalone section of the website, accessible via the main site's navigation. It features its own layout and navigation bar. The project demonstrates how to build and provide access to a REST API with multiple GET and POST routes. The API connects to a database using Doctrine ORM and allows user interaction through a form.

JavaScript modules are used to fetch data from the API and visualize it in the form of charts.

Link to the repo:
https://github.com/SamS-2024/mvc


How to clone the repo:
-----------------------

To clone this repo, follow the steps below:

Go to the GitHub link above and click on the "Code" button. Select "SSH" and copy the address or
you can copy it directly from here: git@github.com:SamS-2024/mvc.git.

In the terminal, create a new directory:

mkdir report

Navigate to the new directory:

cd report

Clone the repository using the 'git clone' command and the SSH address copied from GitHub:

git clone git@github.com:SamS-2024/mvc.git

Navigate to the project directory:

cd mvc

Running the website locally
----------------------------

To get started with the website:

Install dependencies using Composer:

composer install

Start the Symfony server:

symfony server:start

Open the website by visiting the following address in your browser:

http://127.0.0.1:8000/

Thank you for checking out the project!
