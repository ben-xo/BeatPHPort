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

class BeatportTrackTest extends PHPUnit_Framework_TestCase
{
    var $json;
    
    function setUp()
    {
        $this->json = file_get_contents(dirname(__FILE__) . '/BeatportTrack.json');
    }
    
    function test_from_json()
    {
        $api = new BeatportAPIClient();
        $bpj = new BeatportJSON($api);
        $t = new BeatportTrack();
        
        $t->fromJSON($this->json, $bpj);

        $this->assertSame(1043009, $t->getId());
        $this->assertSame(false, $t->getSelected());
        $this->assertSame('Wanderlust', $t->getName());
        $this->assertSame('Original Mix', $t->getMixName());
        $this->assertSame('2009-12-15', $t->getReleaseDate());
        $this->assertSame('2009-12-15', $t->getPublishDate());
        $this->assertSame('http://ak-samples.beatport.com/items/volumes/volume2/items/1000000/0/40000/3000/0/0/1043009.LOFI.mp3', $t->getSampleUrl());
        $this->assertSame(false, $t->getExclusive());
        $this->assertSame('General Content', $t->getCurrentStatus());
        $this->assertSame('06:54', $t->getLength());
        $this->assertSame('purchase', $t->getSaleType());
        $this->assertSame(true, $t->getAvailableWorldwide());
        $this->assertSame(array(), $t->getTerritories());
        $this->assertSame(9, $t->getPosition());

        $this->assertSame(149, $t->getPrice('usd'));
        $this->assertSame(149, $t->getPrice('USD'));
        $this->assertSame(130, $t->getPrice('eur'));
        $this->assertSame(130, $t->getPrice('EUR'));
        $this->assertSame(112, $t->getPrice('gbp'));
        $this->assertSame(112, $t->getPrice('GBP'));

        $this->assertSame(array('usd' => 149, 'eur' => 130, 'gbp' => 112), $t->getAllPrices());
        
        $this->assertSame('https://www.beatport.com/en-US/html/content/track/detail/1043009', $t->getUrl());
        $this->assertSame('https://www.beatport.com/en-US/html/content/track/detail/1043009', $t->getUrl('en-US'));
        $this->assertSame('https://www.beatport.com/fr-FR/html/content/track/detail/1043009', $t->getUrl('fr-FR'));
    }
}