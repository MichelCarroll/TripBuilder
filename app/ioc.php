<?php

App::bind('AirportRepositoryInterface', 'MongoAirportRepository');
App::bind('TripRepositoryInterface', 'MongoTripRepository');