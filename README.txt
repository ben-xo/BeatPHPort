BeatPHPort v0.1
===============

BeatPHPort is an API client for the Beatport Catalog (http://api.beatport.com/) 
written in PHP.

0. CONTENTS
=============
1. USAGE EXAMPLE
2. DEVELOPERS
3. CREDITS & LICENSE


1. OPERATING SSLSCROBBLER
===========================

*** BeatPHPort IS CURRENTLY INCOMPLETE. ***

Only 1 API method is implemented: catalogue search for a single track, 
by artist and title. The only use-case I have in mind so far is to look up
a track on beatport in order to get its URL, although all data returned
is exposed (for example price and territory restrictions). I intend to
add the other methods at some point.

You should cache the results as far as possible!

1.1 Usage Example
-----------------

	require_once 'BeatPHPort/BeatportAPIClient.php';
	$api = new BeatportAPIClient();
	
	// if this fails, an exception will be thrown
	$track = $api->getTrackByArtist('ArtistName', 'TrackName');
	
	// get the URL
	echo $track->getURL() . "\n";
	
	// prices are in cents / pennies / etc
	printf("%0.2f", $track->getPrice('USD') / 100);


2. DEVELOPERS
=============

If you would like to contribute patches or improvements, please submit them
via http://github.com/ben-xo/BeatPHPort . Patches welcome.

2.1 Running Unit Tests
----------------------
Very simple:

	phpunit tests



3. CREDITS & LICENSE
======================

BeatPHPort is Free Open Source Software by Ben XO.
BeatPHPort is licensed under the MIT license.
