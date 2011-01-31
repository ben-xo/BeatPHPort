<?php

/**
 *  @author      Ben XO (me@ben-xo.com)
 *  @copyright   Copyright (c) 2011 Ben XO
 *  @license     MIT License (http://www.opensource.org/licenses/mit-license.html)
 *  
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *  
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *  
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

require_once dirname(dirname(__FILE__)) . '/BeatportAPIClient.php';

class BeatportAPIClientTest extends PHPUnit_Framework_TestCase
{
    var $json;
    
    function setUp()
    {
        $this->json_empty = file_get_contents(dirname(__FILE__) . '/BeatportAPI_Track_Search_Empty.json');
        $this->json = file_get_contents(dirname(__FILE__) . '/BeatportAPI_Track_Search.json');
    }
    
    function test_getTrackByArtist()
    {
        /* @var $api BeatportAPIClient */
        $api = $this->getMock('BeatportAPIClient', array('getURL'));
        $api->expects($this->any()) 
            ->method('getURL') 
            ->will($this->returnValue($this->json));
        
        $t = $api->getTrackByArtist('Survival', 'High');

        $this->assertSame(1631765, $t->getId());
        $this->assertSame(false, $t->getSelected());
        $this->assertSame('High', $t->getName());
        $this->assertSame('Original Mix', $t->getMixName());
        $this->assertSame('2011-01-17', $t->getReleaseDate());
        $this->assertSame('2011-01-17', $t->getPublishDate());
        $this->assertSame('http://geo-samples.beatport.com/items/volumes/volume2/items/1000000/600000/30000/1000/700/60/1631765.LOFI.mp3', $t->getSampleUrl());
        $this->assertSame(false, $t->getExclusive());
        $this->assertSame('New Release', $t->getCurrentStatus());
        $this->assertSame('6:29', $t->getLength());
        $this->assertSame('purchase', $t->getSaleType());
        $this->assertSame(true, $t->getAvailableWorldwide());
        $this->assertSame(array(), $t->getTerritories());
        $this->assertSame(null, $t->getPosition());

        $this->assertSame(199, $t->getPrice('usd'));
        $this->assertSame(199, $t->getPrice('USD'));
        $this->assertSame(156, $t->getPrice('eur'));
        $this->assertSame(156, $t->getPrice('EUR'));
        $this->assertSame(130, $t->getPrice('gbp'));
        $this->assertSame(130, $t->getPrice('GBP'));

        $this->assertSame(array('usd' => 199, 'eur' => 156, 'gbp' => 130), $t->getAllPrices());
        
        $this->assertSame('https://www.beatport.com/en-US/html/content/track/detail/1631765', $t->getUrl());
        $this->assertSame('https://www.beatport.com/en-US/html/content/track/detail/1631765', $t->getUrl('en-US'));
        $this->assertSame('https://www.beatport.com/fr-FR/html/content/track/detail/1631765', $t->getUrl('fr-FR'));
    }
    
    function test_getTrackByArtist_no_result()
    {
        /* @var $api BeatportAPIClient */
        $api = $this->getMock('BeatportAPIClient', array('getURL'));
        $api->expects($this->any()) 
            ->method('getURL') 
            ->will($this->returnValue($this->json_empty));
        
        $track = $api->getTrackByArtist('Survival', 'High');
        $this->assertNull($track);
    }

    function test_getTrackByArtist_fail()
    {
        /* @var $api BeatportAPIClient */
        $api = $this->getMock('BeatportAPIClient', array('getURL'));
        $api->expects($this->any()) 
            ->method('getURL') 
            ->will($this->returnValue(''));
        
        try {
            $track = $api->getTrackByArtist('Survival', 'High');
            $this->fail('Expected an exception');
        } catch(InvalidArgumentException $e) {
        }
    }
}