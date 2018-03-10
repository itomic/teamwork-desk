# Laravel 5 TeamworkDesk PM API Bridge

![teamwork-graphic](https://cloud.githubusercontent.com/assets/2628905/7765016/853f462c-001e-11e5-90ac-389bf1a6c2fe.jpg)

[![Build Status](https://travis-ci.org/nigelheap/teamwork.svg?branch=master)](https://travis-ci.org/nigelheap/teamwork)
![Release](https://img.shields.io/github/release/nigelheap/teamwork.svg?style=flat)
![License](https://img.shields.io/packagist/l/nigelheap/teamwork.svg?style=flat)

This is a simple PHP Client that can connect to the [TeamworkDesk](http://www.teamwork.com) API. This package was developed to be used with [Laravel 5](http://www.laravel.com) but can also be used stand alone as well. I hope this helps you automate and extend TeamworkDesk to integrate even more into your business! Have fun and good luck. :metal:

This fork also includes updates for laravel 5.5 and 5.6

## Origional

Laravel 5 TeamworkDesk PM API Bridge http://rossedman.github.io/teamwork/


## Installation

Just add this to your `composer.json` and then run `composer update`.

```
"nigelheap/teamwork": "~5.5"
```

You can also simply add it like this

```
composer require "nigelheap/teamwork:~5.5"
```

## Laravel Setup

This wrapper comes with support for `Laravel 5`. This includes a service provider as well as a facade for easy access.
Once this package is pulled into your project just add this to your `config/app.php` file.
```php
'providers' => [
    ...
    'NigelHeap\TeamworkDesk\TeamworkDeskServiceProvider',
],
```

and then add the facade to your `aliases` array

```php
'aliases' => [
    ...
    'TeamworkDesk' => 'NigelHeap\TeamworkDesk\Facades\TeamworkDesk',
],
```

### Configuration

If you are using Laravel then add a `teamwork` array to your `config/services.php` file

```php
...
'teamwork-desk' => [
    'key'  => 'YourSecretKey',
    'url'  => 'YourTeamworkDeskUrl'
],
```

### Use

If you are using the Facade with Laravel youc an easily access TeamworkDesk like this

```php
TeamworkDesk::people()->all();
```

If you want to use dependency injection to make your application easy to test the Service Provider binds `NigelHeap\TeamworkDesk\Factory`. Here is an example of how to use it with dependency injection

```php
Route::get('/test', function(NigelHeap\TeamworkDesk\Factory $teamwork) {
   $activity = $teamwork->activity()->latest();
});
```

## Configuration Without Laravel

If you are not using Laravel you can instantiate the class like this

```php
require "vendor/autoload.php";

use GuzzleHttp\Client as Guzzle;
use NigelHeap\TeamworkDesk\Client;
use NigelHeap\TeamworkDesk\Factory as TeamworkDesk;

$client     = new Client(new Guzzle, 'YourSecretKey', 'YourTeamworkDeskUrl');
$teamwork   = new TeamworkDesk($client);
```

You are ready to go now!

* * *

## Examples

Not all of the TeamworkDesk API is supported yet but there is still a lot you can do! Below are some examples of how you can access Projects, Companies, and more. To work with a specific Object pass in the ID to perform actions on it. Data can be passed through for creating and editing.

**To see more examples [visit the docs](http://nigelheap.github.io/teamwork/)**

```php
// create a project
$teamwork->project()->create([
    "name" => "My New Amazing Project",
    "description" => "This is a project that I will dedicate my whole life too",
    "companyId" => "999"
]);

// get the latest activity on a project
$teamwork->project($projectID)->activity();
```

## Roadmap

#### 1.0 Release

- [X] Add Support For `Tickets`
- [X] Add Support For `Inboxes`
- [X] Add Support For `Customers`
- [X] Add Support For `Users`

#### 1.1 Release

- [ ] Add Support For `Threads`
- [ ] Add Support For `Happiness`
- [ ] Add Support For `Users` 


#### 1.2 Release

- [ ] Add Support For `Categories`
- [ ] Add Support For `People Status`
- [ ] Add Support For `Files`
- [ ] Add Support For `Features`

#### 1.3 Release

- [ ] Add Support For `HelpDocs`