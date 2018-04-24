<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Source;

class SourcesController extends Controller
{
     
    use SourceActions;


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


     /**
     * View All Sources.
     *
     * @return boolean
     */
    public function index(Request $request)
    {

        $sources = Source::all();

        return view('sources', compact('sources'));
    
    }


    /**
     * Retrieve Source.
     *
     * @return boolean
     */
    public function getSource(Request $request)
    {

        $id = $request->id;

        $source = Source::where('id', $id)->first();

        return $source;

    }

 
    /**
     * Add a new source.
     *
     * @return boolean
     */
    public function saveSource(Request $request)
    {

    	$source = New Source;

    	$source->title = $request->title;
    	$source->google_sheet_id = $request->google_sheet_id;
    	$source->rss_url = $request->rss_url;
        $source->type = $request->type;

    	if( $source->save() )
    	{
    		return redirect()->back()->with(['success' => 'Source created successfully']);
    	} else {
    		return redirect()->back()->with(['fail' => 'Source could not be created']);
    	}
    
    }


    /**
     * Saved Edited Source
     *
     * @return boolean
     */
    public function editSource(Request $request)
    {

        $id = $request->id;

        $source = Source::where('id', $id)->first();

        $source->title = $request->title;
        $source->google_sheet_id = $request->google_sheet_id;
        $source->rss_url = $request->rss_url;
        $source->type = $request->type;


        if( $source->save() )
        {
            return redirect()->back()->with(['success' => 'Source updated successfully']);
        } else {
            return redirect()->back()->with(['fail' => 'Source could not be updated']);
        }
    
    }


     /**
     * Execute Source - Pull from Google Sheet and run Scraper
     *
     * @return boolean
     */
    public function executeSource($id)
    {

        $source = Source::where('id', $id)->first();

        $execute = $this->readSheet($source);
        $scrapeSource = $this->scrapeSource($source);


        if( $scrapeSource )
        {
            return redirect()->back()->with(['success' => 'Success, following Jobs were added and scraped: '.$scrapeSource ]);
        } else {
            return redirect()->back()->with(['fail' => 'Source could not be executed']);
        }
    
    }






}
