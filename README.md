Digital Scout Partner API PHP Client
====================================

This is a sample PHP library for partners to interact with the Digital Scout API for managing games, scores, and ID mappings.  

Feel free to provide pull requests, as this was written by someone with little PHP experience.

### Installation

The recommended way to install this library is through
[Composer](http://getcomposer.org).

```bash
# Install Composer (Linux/OSX)
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of this library:

```bash
composer.phar require digitalscout/api-client
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Usage

An API key is required to access this API.  Please contact Digital Scout if you require one.

```php
$client = new DigitalScout\Api("api.hsgamecenter.com", $apiKey);

//create a game
$newGame = new DigitalScout\Models\Game([
		"Sport" => "Football",
		"StartTime" => new DateTime("2015-09-01T23:00:00.000Z")
		"Participants" => [
			['SchoolId' => $school1Id, 'Level' => 'Varsity', 'Gender' => 'Male'],
			['SchoolId' => $school2Id, 'Level' => 'Varsity', 'Gender' => 'Male']
		], 
		"HomeSchoolId" => $school1Id
	]);
	
$createdGame = $client->games->createGame($newGame);

//load a game
$loadedGame = $client->games->getGame($createdGame->Id);

//change the time for a game
$loadedGame->StartTime = new DateTime("2015-10-01T23:00:00.000Z");
$updatedGame = $client->games->updateGame($loadedGame);

//add scores to a game
$scoreUpdate = new DigitalScout\Models\GameScores([
		"Scores" => [
			["SchoolId" => $school1Id, "Period" => 1, "Score" => 0 ],
			["SchoolId" => $school1Id, "Period" => 2, "Score" => 7 ],
			["SchoolId" => $school1Id, "Period" => 3, "Score" => 0 ],
			["SchoolId" => $school1Id, "Period" => 4, "Score" => 7 ],
			["SchoolId" => $school2Id, "Period" => 1, "Score" => 7 ],
			["SchoolId" => $school2Id, "Period" => 2, "Score" => 0 ],
			["SchoolId" => $school2Id, "Period" => 3, "Score" => 7 ],
			["SchoolId" => $school2Id, "Period" => 4, "Score" => 0 ]			
		]
	]);

$client->games->updateGameScore($updatedGame->Id, $scoreUpdate);
```

### Error Handling

Most common errors are handled and have custom error types.  The following types of custom exceptions can be thrown:
- DigitalScout\Models\Errors\UnprocessableEntityException
- DigitalScout\Models\Errors\UnauthorizedException
- DigitalScout\Models\Errors\ForbiddenException
- DigitalScout\Models\Errors\NotFoundException
- DigitalScout\Models\Errors\ApiClientException (catchall exception type)
