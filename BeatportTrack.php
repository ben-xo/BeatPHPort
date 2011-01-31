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

require_once 'BeatportPrice.php';

class BeatportTrack
{
    private $fields = array(
    	'id', 'selected', 'name', 'mixName', 'releaseDate', 'publishDate', 
    	'sampleUrl', 'exclusive', 'currentStatus', 'length', 'saleType',
        'availableWorldwide', 'label', 'position', 'territories'
    );
    
    protected $id;
    protected $selected;
    protected $name;
    protected $mixName;
    protected $releaseDate;
    protected $publishDate;
    protected $sampleUrl;
    protected $exclusive;
    protected $currentStatus;
    protected $length;
    protected $saleType;
    protected $availableWorldwide;
    protected $label;
    protected $position;
        
    /**
     * @var BeatportPrice
     */
    protected $price;
    
    /**
     * @var Array
     */
    protected $territories = array();

    /**
     * @var Array of BeatportArtistPlaceholder
     */
    protected $artists = array();

    /**
     * @var Array of BeatportGenrePlaceholder
     */
    protected $genres = array();
    
    /**
     * @var Array of BeatportChartPlaceholder
     */
    protected $charts = array();
    
    /**
     * @var Array of BeatportImage
     */
    protected $images = array();
    
    /**
     * @var BeatportRelease
     */
    protected $release;
    
    public function __construct($json=null)
    {    
        $this->price = new BeatportPrice();
        
        if(isset($json))
        {
            $this->fromJSON($json);
        }
    }
    
    public function getId() { return $this->id; }
    public function getSelected() { return $this->selected; }
    public function getName() { return $this->name; }
    public function getMixName() { return $this->mixName; }
    public function getReleaseDate() { return $this->releaseDate; }
    public function getPublishDate() { return $this->publishDate; }
    public function getSampleUrl() { return $this->sampleUrl; }
    public function getExclusive() { return $this->exclusive; }
    public function getCurrentStatus() { return $this->currentStatus; }
    public function getLength() { return $this->length; }
    public function getSaleType() { return $this->saleType; }
    public function getAvailableWorldwide() { return $this->availableWorldwide; }
    public function getLabel() { return $this->label; }
    public function getPosition() { return $this->position; }
    public function getTerritories() { return $this->territories; }
    
    public function getAllPrices()
    {
        return $this->price->getAllPrices();
    }
    
    public function getPrice($currency)
    {
        return $this->price->getPrice($currency);
    }
    
    public function getURL($language='en-US')
    {
        return 'https://www.beatport.com/' . $language . '/html/content/track/detail/' . $this->getId();         
    }
    
    public function setId($v) { $this->id = $v; }
        
    public function fromJSON($json, BeatportJSON $bpj)
    {
        $json_data = json_decode($json, true);
        $this->fromData($json_data, $bpj);
    }
    
    public function fromData($json_data, BeatportJSON $bpj)
    {
        $data = $bpj->preprocessObject($json_data, 'track');
        
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['selected'])) $this->selected = $data['selected'];
        if(isset($data['name'])) $this->name = $data['name'];
        if(isset($data['mixName'])) $this->mixName = $data['mixName'];
        if(isset($data['releaseDate'])) $this->releaseDate = $data['releaseDate'];
        if(isset($data['publishDate'])) $this->publishDate = $data['publishDate'];
        if(isset($data['sampleUrl'])) $this->sampleUrl = $data['sampleUrl'];
        if(isset($data['exclusive'])) $this->exclusive = $data['exclusive'];
        if(isset($data['currentStatus'])) $this->currentStatus = $data['currentStatus'];
        if(isset($data['length'])) $this->length = $data['length'];
        if(isset($data['saleType'])) $this->saleType = $data['saleType'];
        if(isset($data['availableWorldwide'])) $this->availableWorldwide = $data['availableWorldwide'];
        if(isset($data['label'])) $this->label = $data['label'];
        if(isset($data['position'])) $this->position = $data['position'];
        if(isset($data['territories'])) $this->territories = $data['territories'];
        
        if(is_array($data['price']))
        {
            $this->price->setPrices($data['price']);
        }

        if(is_array($data['images']))
        {
            $this->images = $data['images'];
        }
        
        if(is_array($data['artists']))
        {
            $this->artists = $bpj->createArtistPlaceholders($data['artists']);
        }

        if(is_array($data['genres']))
        {
            $this->artists = $bpj->createGenrePlaceholders($data['genres']);
        }
        
        if(is_array($data['charts']))
        {
            $this->artists = $bpj->createChartPlaceholders($data['charts']);
        }
        
        if(isset($data['release']))
        {
            $this->release = $bpj->createReleasePlaceholders(array($data['release']));
        }        
    }    
}