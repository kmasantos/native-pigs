#!/bin/sh
php artisan migrate:refresh
php artisan tinker
$user = new User
$farm = new Farm

$farm->name = "Sample Farm"
$farm->code = "QUEBAI"
$farm->address = "Quezon Province"
$farm->save()

$user->name = "Sample User"
$user->email = "sfretuerma@gmail.com"
$user->isadmin = false
$user->farmprofile = true

$farm->users()->save($user)

$animaltype = new AnimalType
$animaltype->species = "duck"
$animaltype->save();
