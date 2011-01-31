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

require_once 'BeatportJSON.php';
require_once 'BeatportTrack.php';

class BeatportAPIClient
{
    const BASE = 'http://api.beatport.com/';
    
    /**
     * @return BeatportArtist
     */
    public function getArtist($id)
    {
        
    }
    
    /**
     * @return BeatportTrack
     */
    public function getTrack($id)
    {
        
    }
    
    /**
     * @return BeatportChart
     */
    public function getChart($id)
    {
        
    }
    
    /**
     * @return BeatportRelease
     */
    public function getRelease($id)
    {
        
    }
    
    /**
     * @return BeatportGenre
     */
    public function getGenre($id)
    {
        
    }
    
    /**
     * @return BeatportLabel
     */
    public function getLabel($id)
    {
        
    }
    
    public function getTrackByArtist($artistName, $trackName)
    {
        $url = self::BASE . 'catalog/search' . implode('&', array(
            'v=2.0',
            'format=json',
            'query=' . urlencode($trackName),
            'facets=fieldType:track,performerName:' . urlencode($artistName),
            'perPage=1',
            'page=1'
        ));
        
        $json = $this->getURL($url);
        $json_data = json_decode($json, true);        
        
        $bpj = $this->newBeatportJSON();
        
        $results = $bpj->preprocessAPISearchResult($json_data);
        
        if(empty($results))
        {
            // Not Found.
            return null;
        }
        
        $track = $this->newBeatportTrack();
        $track->fromData($results[0], $bpj);
        return $track;
    }
    
    protected function newBeatportTrack()
    {
        return new BeatportTrack();
    }
    
    protected function newBeatportJSON()
    {
        return new BeatportJSON($this);
    }
    
    protected function getURL($url)
    {
        return file_get_contents($url);
    }
}