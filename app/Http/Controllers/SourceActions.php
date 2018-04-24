<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Item;
use App\Source;
use Feeds;
use Goutte;
use Symfony\Component\CssSelector\CssSelectorConverter;



trait SourceActions {


	
    /**
     * Parse feed with SimplePie Laravel library and save Item.
     *
     * @return void
     */
    public function feedRun($source)
    {

        $feed = Feeds::make($source->rss_url);

        $items = Item::where('source', $source->title)->select('url')->get();

        $ex_urls = array();

        foreach($items as $item)
        {
            array_push($ex_urls, $item->url);
        }


        $i = 0;
        foreach( $feed->get_items(0, 50) as $item )
        {
            $url = $item->get_link();
            if( !in_array($url, $ex_url) )
            {
                $item = new Item;
                $item->source = $source->title;
                $item->post_date = $item->get_date();
                $item->title = $item->get_title();
                $item->item_html = $item->get_description();
                $item->save();

                $i++;
            }
        }
                
        return 'Success: '.$i.' Items have been saved';
    }



    /**
     * Scrape the URL of all Item objects belonging to a particular source and scrape status.
     *
     * @return void
     */
    public function scrapeSource($source) 
    {

        $items = Item::whereNull('scrape_status')->where('source', '=', $source->title)->select('id', 'source', 'Item_title', 'post_date', 'url', 'status', 'scrape_status')->get();

        $i = 0;
        $ids = [];
        foreach($items as $item)
        {
            
            $url = $item->url;

            $crawler = Goutte::request('GET', $url);

            //Switch Statement for every source
            
            switch ($item->source)
            {

            	case 'StackOverFlow':
		            //Company Name from StackOverFlow
		            $company = $crawler->filter('.employer')->text();
		            
		            //Item Type from StackOverFlow
		            $position = $crawler->filter('.-about-Item-items')->each(function ($node) {
		                $position = $node->filter('.-item')->first();
		                $position = $node->filter('.-value')->text();
		                return $position;
		    		});

		            //Technologies from StackOverFlow
		            $node = $crawler->filter('.-technologies');
		            $tech = $node->filter('.-tags');
		            $tech = $node->filter('p');
		            
		            $tech_tags = $tech->filter('a')->each(function ($node) {
		                $tech = $node->text();
		                return $tech;
		            });

		            $item->position_tags = json_encode($position);
		            $item->tech_tags = json_encode($tech_tags);
		            $item->company = $company;
		            $item->scrape_status = 'scraped';

		            $item->save();


		        case 'WeWorkRemotely':

		        	//Company Name from WWR
            		$company = $crawler->filter('.company')->text();

            		//Contact Link from WWR
            		$contact_link = $crawler->filter('.apply > p > a')->attr('href');

		            $item->company = $company;
		            $item->contact_link = $contact_link;
		            $item->contact_text = 'Apply to '.$company;
		            $item->scrape_status = 'scraped';

		            $item->save();

		        
		        default: 

		        	$error = 'Could not identify source in Item';
	        
	       	}
            

            $i++;

            $ids[] = $item->id;

         
        }

        $ids = json_encode($ids);
        return $ids;
        
    }





}