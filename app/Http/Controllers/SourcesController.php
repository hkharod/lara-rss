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
     * Retrieve Source. (Ajax Route)
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
    	$source->rss_url = $request->rss_url;

    	if( $source->save() )
    	{
    		return redirect()->back()->with(['success' => 'Source created successfully']);
    	} else {
    		return redirect()->back()->with(['fail' => 'Source could not be created']);
    	}
    
    }


    /**
     * Saved Edited Source.
     *
     * @return boolean
     */
    public function editSource(Request $request)
    {

        $id = $request->id;

        $source = Source::where('id', $id)->first();

        $source->title = $request->title;
        $source->rss_url = $request->rss_url;

        if( $source->save() )
        {
            return redirect()->back()->with(['success' => 'Source updated successfully']);
        } else {
            return redirect()->back()->with(['fail' => 'Source could not be updated']);
        }
    
    }


    /**
     * Delete Source.
     *
     * @return boolean
     */
    public function deleteSource(Request $request)
    {

        $id = $request->id;

        $source = Source::where('id', $id)->first();

        if( $source->delete() )
        {
            return redirect()->back()->with(['success' => 'Source deleted successfully']);
        } else {
            return redirect()->back()->with(['fail' => 'Source could not be deleted']);
        }
    
    }



     /**
     * Execute operations from SourceActions Trait.
     *
     * @return void
     */
    public function executeSource($id)
    {

        $feed_run = $this->feedRun($id);

        if ($feed_run)
        {
            return redirect()->back()->with(['success' => 'Feed Successfully Executed']);
        } else {
            return redirect()->back()->with(['fail' => 'Feed could not be executed']);
        }

    }


     

}
