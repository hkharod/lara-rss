<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Source;

class ItemsController extends Controller
{
    

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

        $items = Item::select('id', 'source_title', 'title', 'description', 'author', 'post_date', 'link', 'post_date')->get();

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

        $data = array('items' => $items, 'term' => $request->search);

        return view('search', compact('data'));
   
    }




}
