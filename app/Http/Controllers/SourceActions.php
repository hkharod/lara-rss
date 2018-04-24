<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Job;
use App\Source;
use Feeds;
use Goutte;
use Symfony\Component\CssSelector\CssSelectorConverter;



trait SourceActions {


	/**
     * Read from Google Sheet & Save Jobs to Laravel Database.
     *
     * @return void
     */
    public function readSheet($source)
    {
        /*
         * We need to get a Google_Client object first to handle auth and api calls, etc.
         */
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheet Jobs');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');

        /*
         * The JSON auth file can be provided to the Google Client in two ways, one is as a string which is assumed to be the
         * path to the json file. This is a nice way to keep the creds out of the environment.
         *
         * The second option is as an array. For this example I'll pull the JSON from an environment variable, decode it, and
         * pass along.
         */
        $jsonAuth = file_get_contents("/home/forge/rl.launchstack.io/27bacfe8e74d.json");



        //echo '<pre>';
        // print_r($jsonAuth);

        //print_r($client->setAuthConfig(json_decode($jsonAuth, true)));

        $client->setAuthConfig(json_decode($jsonAuth, true));
        /*
         * With the Google_Client we can get a Google_Service_Sheets service object to interact with sheets
         */

        $sheets = new \Google_Service_Sheets($client);

        /*
         * To read data from a sheet we need the spreadsheet ID and the range of data we want to retrieve.
         * Range is defined using A1 notation, see https://developers.google.com/sheets/api/guides/concepts#a1_notation
         */
        $data = [];

        // No column titles so pull from row 1
        $currentRow = 1;

        // The range of A2:H will get columns A through H and all rows starting from row 2
        $spreadsheetId = $source->google_sheet_id;
        $range = 'A1:G';
        $rows = $sheets->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);

        //counter
        $i = 0;
        $j = 0;
        if (isset($rows['values']) ) {
            
            //Keeps a log of all the duplicate urls so we don't have to extract data from the same job. 
            $urls = array();
            
            foreach ($rows['values'] as $row) 
            {

            	if (empty($row[0])) 
                {
                    break;

                } else {

	                if( !in_array($row[2], $urls) ) 
	                {


	                    if( empty($row[6]) ) 
	                    {


	                        $source_title = $source->title;
	                        $post_date = $row[0];
	                        $job_title = $row[1];
	                        $url = $row[2];
	                        $job_html = $row[3];

	                        
	                        $urls[] = $row[2];

	                        $currentRow++;

	                        //Save Job into DB
	                        $job = new Job;
	                        $job->source = $source_title;
	                        $job->post_date = $post_date;
	                        $job->job_title = $job_title;
	                        $job->url = $url;
	                        $job->job_html = $job_html;

	                        $job->save();

	                        //Jobs Saved Count
	                        $j = $j + 1;
	                    }
	                }

	                //Row Count
	                $i = $i + 1;             
            	}
            }


            // The A1 notation of the values to clear.
			$range = 'A1:F'.$i;  // $i is total number of rows

			// TODO: Assign values to desired properties of `requestBody`:
			$requestBody = new \Google_Service_Sheets_ClearValuesRequest();

			$delete = $sheets->spreadsheets_values->clear($spreadsheetId, $range, $requestBody);
        }

        return 'Success: '.$j.' jobs have been saved';
        
    }



    /**
     * Parse feed with SimplePie Laravel library and save job.
     *
     * @return void
     */
    public function feedRun($source)
    {

        $feed = Feeds::make($source->rss_url);

        $jobs = Job::where('source', $source->title)->select('url')->get();

        $ex_urls = array();

        foreach($jobs as $job)
        {
            array_push($ex_urls, $job->url);
        }


        $i = 0;
        foreach( $feed->get_items(0, 50) as $item )
        {
            $url = $item->get_link();
            if( !in_array($url, $ex_url) )
            {
                $job = new Job;
                $job->source = $source->title;
                $job->post_date = $item->get_date();
                $job->title = $item->get_title();
                $job->job_html = $item->get_description();
                $job->save();

                $i++;
            }
        }
                
        return 'Success: '.$i.' jobs have been saved';
    }



    /**
     * Scrape the URL of all Job objects belonging to a particular source and scrape status.
     *
     * @return void
     */
    public function scrapeSource($source) 
    {

        $jobs = Job::whereNull('scrape_status')->where('source', '=', $source->title)->select('id', 'source', 'job_title', 'post_date', 'url', 'status', 'scrape_status')->get();

        $i = 0;
        $ids = [];
        foreach($jobs as $job)
        {
            
            $url = $job->url;

            $crawler = Goutte::request('GET', $url);

            //Switch Statement for every source
            
            switch ($job->source)
            {

            	case 'StackOverFlow':
		            //Company Name from StackOverFlow
		            $company = $crawler->filter('.employer')->text();
		            
		            //Job Type from StackOverFlow
		            $position = $crawler->filter('.-about-job-items')->each(function ($node) {
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

		            $job->position_tags = json_encode($position);
		            $job->tech_tags = json_encode($tech_tags);
		            $job->company = $company;
		            $job->scrape_status = 'scraped';

		            $job->save();


		        case 'WeWorkRemotely':

		        	//Company Name from WWR
            		$company = $crawler->filter('.company')->text();

            		//Contact Link from WWR
            		$contact_link = $crawler->filter('.apply > p > a')->attr('href');

		            $job->company = $company;
		            $job->contact_link = $contact_link;
		            $job->contact_text = 'Apply to '.$company;
		            $job->scrape_status = 'scraped';

		            $job->save();

		        
		        default: 

		        	$error = 'Could not identify source in job';
	        
	       	}
            

            $i++;

            $ids[] = $job->id;

         
        }

        $ids = json_encode($ids);
        return $ids;
        
    }





}