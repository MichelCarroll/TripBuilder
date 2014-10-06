# Trip Builder

## API Routes

##### GET /airports

Get list of all airport. (alphabetically by city)

##### POST /trips

Create a new trip. Takes "name" as optional request parameter.

##### PUT /trips/{id}

Rename a trip, through the "name" request parameter.

##### GET /trips/{id}

View a trip, along with a list of all its flights.

##### PUT /trips/{id}/flights/{src},{trg}

Add a flight to a trip. The SRC and TRG are the three-letter airport codes.

##### DELETE /trips/{id}/flights/{src},{trg}

Remove a flight from a trip. The SRC and TRG are the three-letter airport codes.

### Installation

#### Prerequisites

Vagrant (at least v1.5) with hardware virtualization enabled.

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
14. Visit `http://tripbuilder.app:8000/` to check out the test harness
15. OR check out the live version at `http://ec2-54-69-221-31.us-west-2.compute.amazonaws.com/`


## Architectural Decisions

I decided to implement a RESTful webservice, because:
   - entities are simple, and most operations can easily be described by simple HTTP methods (GET, PUT, DELETE)
   - REST APIs are ubiquitous, and easy for API clients to adopt

I decided to use Laravel framework because:
   - implementing a RESTful webservice is rediculously easy within Laravel
   - it's lightweight, and the architecture is simple and easy to understand
 
I decided to use MongoDB for data persistance because:
   - it made developing the models very quick, because the schema is flexible
   - the objects were simple enough to represent in document form, and there were no need for complex joins


## What could be done better

- The Mongo ORM implementation includes many superfluous details, such as the _id of every embedded document in the trips. These should not be sent to the client because they don't need to know them, and might make the API's clients dependent on one of our implementation details, as opposed to a consistant interface.

- Some unit tests use Mongo queries. The objects that are doing so should be mocked, to eliminate the dependency on the database for unit testing.

- Some unit tests are incomplete. Example: the test for GET trips does not validate that the flight information is also returned
