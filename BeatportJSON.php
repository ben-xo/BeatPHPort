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
require_once 'BeatportArtistPlaceholder.php';

class BeatportJSON
{
    /**
     * @var BeatportAPIClient
     */
    protected $apiClient;
    
    public function __construct(BeatportAPIClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    
    /**
     * Handles all the boilerplate JSON error checking for defined object types
     * 
     * @param array $json_data
     * @throws InvalidArgumentException
     */
    public function preprocessObject($json_data, $type)
    {
        $this->nullCheck($json_data);
        
        if(!isset($json_data['type']))
        {
            throw new InvalidArgumentException('Data did not contain "type" attribute');
        }
        
        if($json_data['type'] != $type)
        {
            throw new InvalidArgumentException("type {$json_data['type']} is not of expected type {$type}");
        }
        
        // data is a valid First Class object
        return $json_data;
    }

    /**
     * Handles all the boilerplate JSON error checking for search results
     * 
     * @param array $json_data
     * @throws InvalidArgumentException
     */
    public function preprocessAPISearchResult($json_data)
    {
        $this->nullCheck($json_data);
        
        if(!isset($json_data['results']))
        {
            throw new InvalidArgumentException('Data did not contain "results" attribute');
        }
        
        if(!is_array($json_data['results']))
        {
            throw new InvalidArgumentException('"results" attribute is not an array');
        }
        
        // Data is a valid API Response search result, so return just the results
        return $json_data['results'];
    }
    
    protected function nullCheck($json_data)
    {
        if($json_data === null) 
        {
            throw new InvalidArgumentException('Data is NULL or not valid JSON');   
        } 
    }
    
    /*
     * According to http://api.beatport.com/object-structures.html , 
     * Artists, Charts, Releases, Genres and Tracks are first class objects
     * (that have a JSON 'type' property).
     * 
     * There are also second class (simple) objects for Prices and Images.
     */
    
    public function createArtistPlaceholders(array $artists)
    {
        $placeholders = array();
        foreach($artists as $a)
        {
            $placeholders[] = new BeatportArtistPlaceholder($a['id'], $a['name']);
        }
        return $placeholders;
    }

    public function createChartPlaceholders(array $charts)
    {
        $placeholders = array();
        
        return $placeholders;
    }

    public function createReleasePlaceholders(array $releases)
    {
        $placeholders = array();
        
        return $placeholders;
    }
    
    public function createLabelPlaceholders(array $labels)
    {
        $placeholders = array();
        
        return $placeholders;
    }
    
    public function createTrackPlaceholders(array $tracks)
    {
        $placeholders = array();
        
        return $placeholders;
    }
    
    
    public function createGenrePlaceholders(array $genres)
    {
        $placeholders = array();
        
        return $placeholders;
    }    
}