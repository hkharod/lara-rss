<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Source;
use Feeds;
use Carbon\Carbon;

class FeedsController extends Controller
{
    

    /**
     * Parse feed with SimplePie Laravel library and save item.
     *
     * @return void
     */
    public function runFeed($id)
    {

        $source = Source::where('id', $id)->first();

        //Get the existing urls for this source to avoid duplicates
        $jobs = Item::where('source', $source->title)->select('url')->get();

        $ex_urls = array();

        foreach($items as $item)
        {
            array_push($ex_urls, $item->url);
        }

    	$feed = Feeds::make($source->rss_url);


    	foreach( $feed->get_items(0, 20) as $single )
    	{
    		
            $var = substr($single->get_date(), 0, strpos($single->get_date(), ",")); 
            $date = strtotime($var);
            $post_date = date('Y-m-d', $date);
            $item_title = $single->get_title();
            $job_html = $single->get_description();
            $url = $single->get_link();


            if( !in_array($url, $ex_urls) )
            {
                $job = new Job;
                $job->source = $source->title;
                $job->post_date = $post_date;
                $job->job_title = $job_title;
                $job->job_html = $job_html;
                $job->url = $url;

                $job->save(); 

            }

    	}

        $source->last_run = date("Y-m-d");
        $source->save();

        echo 'complete';
    }


}
