<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Source;

class HomeController extends Controller
{
    
    /**
     * This Controller handles everything related to individual Jobs including publishing, searching and displaying
     *
     */


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
     * Show the application dashboard with latest Feed Item Results.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = Item::select('id', 'source', 'job_title', 'post_date', 'url', 'status', 'tech_tags', 'position_tags')->get();

        foreach($items as $item){
            $item->tech_tags = json_decode($item->tech_tags);
            $item->position_tags = json_decode($item->position_tags);
        }

        return view('home', compact('items'));
    }



    /**
     * Delete a Feed Item.
     *
     * @return void
     */
    public function deleteItem($id)
    {

        if( Item::Destroy($id) ){
            return redirect()->back()->with(['success' => 'Feed Item Deleted.']);
        } else {
            return redirect()->back()->with(['fail' => 'Feed Item was not deleted.']);
        }
    }



    /**
     * Search Items Via Scout
     *
     * @return void
     */
    public function search(Request $request)
    {

        $items = Item::search($request->search)->get(); 

        foreach($items as $item){
            $item->tech_tags = json_decode($item->tech_tags);
            $item->position_tags = json_decode($item->position_tags);
        }

        $data = array('items' => $items, 'term' => $request->search);

        return view('search', compact('data'));
   
    }




}
