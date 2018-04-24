<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Goutte;
use Symfony\Component\CssSelector\CssSelectorConverter;
use JavaScript;

class TestController extends Controller
{
    // Used for testing reading and analyzing Source Actions and other methods in the application.



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
     * Read from Google Sheet & Save Jobs to Laravel Database.
     *
     * @return void
     */
    public function readFile()
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



        echo '<pre>';
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
        $stackoverflow = '18vFnJDfBV3gFM2emqk0iUVW-KyefU6B7rk2ERVUALts';
        $wwremotely = '10c1C3sxEAN_kjga_DlbwzllQD0hgBCcMVKvVKh8zxOY';


        $spreadsheetId = '18vFnJDfBV3gFM2emqk0iUVW-KyefU6B7rk2ERVUALts';
        $range = 'A1:D';
        $rows = $sheets->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);

        //testing counter
        $i = 0;
        if (isset($rows['values']) ) {
            
            //Keeps a log of all the duplicate urls so we don't have to extract data from the same job. 
            $urls = array();
            
            foreach ($rows['values'] as $row) 
            {
                /*
                 * If first column is empty, consider it an empty row and skip (this is just for example)
                 */
                if (empty($row[0])) 
                {
                    break;
                }

                if( !in_array($row[2], $urls) ) 
                {


                    if( empty($row[6]) ) 
                    {


                        $source = 'StackOverFlow';
                        $post_date = $row[0];
                        $job_title = $row[1];
                        $url = $row[2];
                        $job_html = $row[3];

                        
                        $urls[] = $row[2];

                        /*
                         * Now for each row we've seen, lets update the I column with the current date
                         */
                        $updateRange = 'G'.$currentRow;
                        $updateBody = new \Google_Service_Sheets_ValueRange([
                            'range' => $updateRange,
                            'majorDimension' => 'ROWS',
                            'values' => ['values' => date('c')],
                        ]);
                        
                        $sheets->spreadsheets_values->update(
                            $spreadsheetId,
                            $updateRange,
                            $updateBody,
                            ['valueInputOption' => 'USER_ENTERED']
                        );

                        $currentRow++;

                        //Save Job into DB
                        $job = new Job;
                        $job->source = $source;
                        $job->post_date = $post_date;
                        $job->job_title = $job_title;
                        $job->url = $url;
                        $job->job_html = $job_html;

                        $job->save();

                        //Job Count
                        $i++;

                    }

                }             
            }
        }

        
        // print_r($data);
        echo $i.' jobs have been saved';
        // print_r($urls);
    }





    /**
     * Extract the keywords from the saved jobs and update them with tags in the Laravel Database.
     *
     * @return void
     */
    public function extract() {

        //Keyword Arrays
        $tech = array('php', 'wordpress', 'html', 'html5', 'css', 'javascript', 'js', 'css3', 'react', 'reactjs', 'vue', 'vuejs','angular', 'angularjs', 'golang', 'node', 'nodejs', 'ruby', 'rails', 'sinatra', 'python', 'django', 'flask', 'go', 'es5', 'es6', '.net', 'net', 'sql', 'mysql', 'java', 'mobile', 'mongodb', 'c', 'meteor');
        
        $remote = array('remote', 'telecommute');
        
        $type = array('full-time', 'fulltime', 'permanent', 'part-time', 'flexible', 'flexible hours', 'freelance', 'contract');


        $jobs = Job::select('id', 'source', 'job_title', 'post_date', 'job_html', 'url', 'status')->get();

        $i = 0;

        foreach($jobs as $job){

            if($job->status != 'extracted' ){
                
                $html = $job->job_html;

                //Clean Job Html

                $doc = strip_tags($html);

                $doc = strtolower($doc);

                $doc = preg_replace("/[^a-z0-9_\s-]/", "", $doc);

                $doc = preg_split('/\s+/', $doc);

                // print_r($doc);

                // echo '<br/><br/><br/>';


                //Start Extraction
                
                $tech_tags = array();

                foreach($tech as $t ) {
                    if (in_array($t, $doc)) {
                        $tech_tags[] = $t;
                    }
                }

       

                $position_tags = array();

                foreach($type as $t ) {
                    if (in_array($t, $doc)) {
                        $position_tags[] = $t;
                    }
                }

                //Save Extracted Data

                $job->position_tags = json_encode($position_tags);
                $job->tech_tags = json_encode($tech_tags);
                $job->status = 'extracted';
                
                if( $job->save() ) {
                    echo $i;
                }

                $i++;

            }

        }

        echo 'All jobs extracted successfully';

    }




    /**
     * Scrape the URL of a Job object using Goutte/DOM Crawler and extract specific data based on the Job's source.
     *
     * @return void
     */
    public function scrapeTest() {

      
            // $url = 'https://weworkremotely.com/remote-jobs/car-next-door-full-stack-ruby-on-rails-engineer';

            // $crawler = Goutte::request('GET', $url);

            // //Company Name
            // $company = $crawler->filter('.company')->text();

            // $contact = $crawler->filter('.apply > p > a')->attr('href');

            // print_r($contact);


            //->attr('class');
            
            //Job Type from StackOverFlow
      //       $position = $crawler->filter('.-about-job-items')->each(function ($node) {
      //           $position = $node->filter('.-item')->first();
      //           $position = $node->filter('.-value')->text();
      //           return $position;
    		// });


            // //Technologies from StackOverFlow
            // $node = $crawler->filter('.-technologies');
            // $tech = $node->filter('.-tags');
            // $tech = $node->filter('p');
            
            // $tech_tags = $tech->filter('a')->each(function ($node) {
            //     $tech = $node->text();
            //     return $tech;
            // });

            //Company Name from StackOverFlow
            $jobs = Job::whereNull('scrape_status')->where('source', '=', 'StackOverFlow')->select('id', 'source', 'job_title', 'post_date', 'url', 'status', 'scrape_status')->get();

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
      
    }



}
