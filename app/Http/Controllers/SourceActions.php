<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Item;
use App\Source;
use Feeds;

trait SourceActions {

    /**
     * Parse feed with SimplePie Laravel library and save Item.
     *
     * @return void
     */
    public function feedRun($id)
    {
        $source = Source::where('id', $id)->first();

        //Get the existing urls for this source to avoid duplicates.
        $items = Item::where('source_id', $source->id)->select('link')->get();

        $ex_urls = array();

        foreach($items as $item)
        {
            array_push($ex_urls, $item->link);
        }

        $feed = Feeds::make($source->rss_url);

        foreach( $feed->get_items(0, 20) as $single )
        {
            
            //Change post_date to consistent format
            $raw_date = substr($single->get_date(), 0, strpos($single->get_date(), ",")); 
            $date = strtotime($raw_date);
            $post_date = date('Y-m-d', $date);
            
            $title = $single->get_title();
            $description = $single->get_description();
            $link = $single->get_link();
            $category = $single->get_category()->get_label();
            $author = $single->get_author()->get_name();

            if( !in_array($link, $ex_urls) )
            {         
                $item = New Item;
                $item->source_id = $source->id;
                $item->source_title = $source->title;
                $item->title = $title;
                $item->description = $description;
                $item->link = $link;
                $item->post_date = $post_date;
                $item->category = $category;
                $item->author = $author;
        
                $item->save(); 
            }
        }

        $source->last_run = date("Y-m-d");
        $source->save();

        return true;
    }



   





}