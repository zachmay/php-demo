# PHP Demo

This makes use of [Vagrant](https://www.vagrantup.com/) and the [Scotchbox.io](https://box.scotch.io/) LAMP environment.

## Running the Demo

- Install Vagrant
- From the project root, run `vagrant up`
- Initialize the database:
    - Start an SSH session to the Vagrant box: `vagrant ssh`
    - Then, navigate to the project directory: `cd /var/www`
    - Run the database initialization script: `mysql -u root -p scotchbox < scripts/init-db.sql` (MySQL password is `root`)
- Ensure that [Composer](https://getcomposer.org/) is available (I did this locally, but you could do it on the Vagrant box) and 
  install Composer dependencies: `composer install`. Depending on how Composer is installed on your machine, you may need to 
  run `php composer.phar install`.
- The site should be available running at `http://192.168.33.10/`.

## Running the test suite

- From the root of the project directory, run `php vendor/bin/phpunit tests`

## Overview

The app uses the Slim framework to implement a simple MVC webapp with 3 pages (4 total routes):

- The homepage displays a message and some links to the other parts of the site.
- The voting page requires two routes: one to handle GET requests (the voting form), and one POST route for form submission.
- The results page displays the aggregate polling results.

These routes and some basic bootstrapping can be found in `public/index.php`.

Each route is handled by a separate controller class (in the `Demo\Controller` namespace). The voting and results page controllers
make use of a domain service class supporting the following API:

- Fetching the candidate list. The list is hard-coded here, but the app could be expanded to have database-driven.
candidate lists without changing the API of the domain service.
- Casting a vote. Given a user name and a candidate name, a vote is recorded in the `voters` table.
- Computing aggregate totals.

Architecturally, the app makes heavy use of dependency injection. Classes do not take on the responsibility for creating
the objects they need its job; instead, the dependency injection container (defined in `bootstrap/services.php`) declares
how the various objects in the system are created, usually in reference to other things in the container.

For example, the `GetVoteController` is responsible for fulfilling requests for the voting form. Its constructor takes
a `Twig` object to handle view templating and a `VoteService` object to retrieve the candidate list. Instead of 
creating these objects directly, when Slim needs a `GetVoteController`, the container creates one for it, by getting
its dependencies, by getting a `Twig` and `VoteService` objects from the container and instantiating the controller.
The logic for creating these objects is kept in one place and in unit testing, we know that all of an object's
dependencies come in through the constructor, so they can be easily mocked.


