## Trip Builder

### Installation

#### Prerequisites

Vagrant (at least v1.5) with hardware virtualization enabled

#### Procedure

1. `git clone https://github.com/MichelCarroll/TripBuilder.git tripbuilder`
2. `cd tripbuilder`
3. `cp vagrant/configs.dist.yaml vagrant/configs.yaml`
4. Inside `configs.yaml`, change `~/workspace/tripbuilder/` to where the project actually is
5. Change the IP from `192.168.10.10` to something else, if you want
6. Add `tripbuilder.app` to your hosts file
7. `vagrant up`
8. `vagrant ssh`
9. `cd workspace/tripbuilder`
10. `composer install`
11. `php artisan mongo:schema`
12. `php artisan mongo:seed`
13. `phpunit` (tests should all pass at this point)
14. Visit http://tripbuilder.app:8000/ to check out the test harness


architectural decisions:

- decided on implementing a RESTful webservice, because:
   - entities are simple, and most operations can easily be described by simple HTTP methods (GET, PUT, DELETE)
   - REST APIs are ubiquitous, and easy for API clients to adopt


what could be done better, and improved:

- the mongo orm implementation includes many superfluous details, such as the _id of every embedded document in the trips. these should not be sent to the client, as they're not necessary, and might make the API's clients dependend on one of our implementation details, as opposed to a consistant interface

- some unit tests use Mongo. the objects that are doing so should be mocked, to eliminate the dependency on the database for unit testing

- some unit tests are incomplete. example, the test for GET trips does not validate that the flight information is also returned
