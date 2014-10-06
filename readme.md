## Trip Builder

# Installation

make sure you have at least  vagrant 1.5, or apt-get install vagrant if you need it
make sure "virtualization technology" is enabled on your bios. otherwise, vm won't boot

git clone https://github.com/MichelCarroll/TripBuilder.git tripbuilder
cd tripbuilder
cp vagrant/configs.dist.yaml vagrant/configs.yaml
change the ~/workspace/tripbuilder/ to where the project actually is
change the ip, if you want
add tripbuilder.app to your hosts file
vagrant up
vagrant ssh
cd workspace/tripbuilder
composer install
php artisan mongo:schema
php artisan mongo:seed
phpunit   (tests should all pass)
visit http://tripbuilder.app:8000/ to see the test harness


architectural decisions:

- decided on implementing a RESTful webservice, because:
   - entities are simple, and most operations can easily be described by simple HTTP methods (GET, PUT, DELETE)
   - REST APIs are ubiquitous, and easy for API clients to adopt


what could be done better, and improved:

- the mongo orm implementation includes many superfluous details, such as the _id of every embedded document in the trips. these should not be sent to the client, as they're not necessary, and might make the API's clients dependend on one of our implementation details, as opposed to a consistant interface

- some unit tests use Mongo. the objects that are doing so should be mocked, to eliminate the dependency on the database for unit testing

- some unit tests are incomplete. example, the test for GET trips does not validate that the flight information is also returned