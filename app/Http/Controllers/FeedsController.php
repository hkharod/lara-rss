<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Source;
use Feeds;
use Carbon\Carbon;

class FeedsController extends Controller
{
    

    /**
     * Parse feed with SimplePie Laravel library and save job.
     *
     * @return void
     */
    public function runFeed($id)
    {

        $source = Source::where('id', $id)->first();

        //Get the existing urls for this source to avoid duplicates
        $jobs = Job::where('source', $source->title)->select('url')->get();

        $ex_urls = array();

        foreach($jobs as $job)
        {
            array_push($ex_urls, $job->url);
        }

    	$feed = Feeds::make($source->rss_url);

        // echo '<pre>';
        // print_r($ex_urls);

    	foreach( $feed->get_items(0, 20) as $item )
    	{
    		
            $var = substr($item->get_date(), 0, strpos($item->get_date(), ",")); 
            $date = strtotime($var);
            $post_date = date('Y-m-d', $date);
            $job_title = $item->get_title();
            $job_html = $item->get_description();
            $url = $item->get_link();

            // echo $var .'<br/>';
            // echo '<pre>';
            // print_r($item);
            
            //If it doesn't exist in existing jobs, save it
            if( !in_array($url, $ex_urls) )
            {
                $job = new Job;
                $job->source = $source->title;
                $job->post_date = $post_date;
                $job->job_title = $job_title;
                $job->job_html = $job_html;
                $job->url = $url;

                $job->save(); 

                //echo 'saved';
            }

    	}

        $source->last_run = date("Y-m-d");
        $source->save();

        echo 'complete';
	    		
        //$date = Carbon::parse(date_format($date,'d m Y'));
    }


}
