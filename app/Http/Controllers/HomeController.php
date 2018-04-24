<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Source;
use App\Email;
use JavaScript;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $jobs = Job::select('id', 'source', 'job_title', 'post_date', 'url', 'status', 'tech_tags', 'position_tags')->get();

        foreach($jobs as $job){
            $job->tech_tags = json_decode($job->tech_tags);
            $job->position_tags = json_decode($job->position_tags);
        }

        return view('home', compact('jobs'));
    }



    /**
     * Delete a Job.
     *
     * @return void
     */
    public function deleteJob($id)
    {

        if( Job::Destroy($id) ){
            return redirect()->back()->with(['success' => 'Job Deleted.']);
        } else {
            return redirect()->back()->with(['fail' => 'Job was not deleted.']);
        }
    }


    /**
     * Edit and prep for publishing a specific job.
     *
     * @return void
     */
    public function editJob($id)
    {
        if($id == 'new'){

            JavaScript::put([
            'job' => '',
            'tech' => '',
            'position' => ''
            ]);

            return view('editjob');

        } else {

            $job = Job::where('id', $id)->first();
       
            $tech = implode(', ', json_decode($job->tech_tags) );

            $position = implode('/ ', json_decode($job->position_tags) );

            JavaScript::put([
            'job' => $job,
            'tech' => $tech,
            'position' => $position
            ]);

            return view('editjob', compact('job'));
        }

        
    }



    /**
     * Publish a Job (Save Job HTML and generate email snippet for designated email).
     *
     * @return void
     */
    public function publishJob(Request $request)
    {

        $job_type = $request->type;

        $request = $request->toArray();

        $request['tags'] = explode(",", $request['tags'] );

        if($job_type === 'Pro Project')
        {
            //Generate GUID for this pro job
            $guid = bin2hex(openssl_random_pseudo_bytes(16));

            //Generate Pro Job HTML Empty File for public folder
            $fileLocation = base_path()."/storage/jobs/pro/" . $guid . ".html";

            ob_start();
            include base_path().'/resources/assets/templates/proJob-template.php';
            $file = ob_get_clean();

            $dirname = dirname($fileLocation);

            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }

            $handle = fopen($fileLocation, 'w') or die('Cannot open file:  ' . $fileLocation); //implicitly creates file
            fwrite($handle, $file);
            fclose($handle);

            //Generate ProJob HTML File
            $fileLocation = base_path()."/storage/jobs/proJobHTML/" . $guid . ".html";

            $dirname = dirname($fileLocation);

            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }

            ob_start();
            include base_path().'/resources/assets/templates/pro-job-container-template.php';
            $file = ob_get_clean();

            $handle = fopen($fileLocation, 'w') or die('Cannot open file:  ' . $fileLocation); //implicitly creates file
            fwrite($handle, $file);
            fclose($handle);

            /*Save Pro Job HTML Data to Firebase DB*/
           
        } else {
            
            $folderLocation = $request['folder_location'];
            $fileName = $request['file_name'];

            // Put into folder location
            $fileLocation = base_path()."/storage/jobs/free" . $folderLocation . $fileName . ".html";

            $freeFolderLocation = $folderLocation;
            $freeFileName = $fileName;

            ob_start();
            include base_path().'/resources/assets/templates/freeJob-template.php';
            $file = ob_get_clean();

            $dirname = dirname($fileLocation);

            if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
            }

            $handle = fopen($fileLocation, 'w') or die('Cannot open file:  ' . $fileLocation); //implicitly creates file
            fwrite($handle, $file);
            fclose($handle);

        }


        // This is when we send our emails so set the timezone to be this.
        date_default_timezone_set('America/New_York');
        $currentDate = date('m_d_Y', time());

        // Put into folder location
        $fileLocation = base_path()."/storage/emails/".$currentDate."/" ."email.html";

        ob_start();
        include base_path().'/resources/assets/templates/email-template.php';
        $file = ob_get_clean();

        $dirname = dirname($fileLocation);

        if (!is_dir($dirname)) {
          mkdir($dirname, 0755, true);
        }

        // Append the new block to the current email.
        $handle = fopen($fileLocation, 'a') or die('Cannot open file:  ' . $fileLocation); //implicitly creates file
        fwrite($handle, $file);
        fclose($handle);

        //return view('home', compact('job'));
        echo 'success';
    }



    /**
     * Search Jobs Via Scout
     *
     * @return void
     */
    public function search(Request $request)
    {

        $jobs = Job::search($request->search)->get(); 

        foreach($jobs as $job){
            $job->tech_tags = json_decode($job->tech_tags);
            $job->position_tags = json_decode($job->position_tags);
        }

        $data = array('jobs' => $jobs, 'term' => $request->search);

        return view('search', compact('data'));
   
    }




    /**
     * Edit a job to publish it to an email
     *
     * @return void
     */
    public function emailEdit($id)
    {
        if($id == 'new')
        {

            $job = '';

            //Get the latest email to publish to
            $email = Email::orderBy('created_at', 'desc')->first();

            JavaScript::put([
                'job' => $job,
                'email' => $email
            ]);

        } else {

            $job = Job::where('id', $id)->first();
            
            //Get the latest email to publish to
            $email = Email::orderBy('created_at', 'desc')->first();

            JavaScript::put([
                'job' => $job,
                'email' => $email
            ]);
        }

        return view('jobs/emailedit');
    }


    /**
     * Edit a job to publish it to an email
     *
     * @return void
     */
    public function emailPublish(Request $request)
    {   

        //Save the job id  //its notn getting the job id
        $job_id = $request->job_id;
        
        //Save the name of the published email
        $email_id = $request->email;

        //Save the job title
        $title = $request->title;

        //Save the URL
        $url = $request->contact_link;

        //Save the Budget
        if(isset($request->budget))
        {
            $budget = $request->budget;
        }

        //Save the keyword of the job
        $keyword = $request->jobKeyword;

        //Save the tech tags created
        $technologies = $request->technologies;
        $tech_tags = $technologies;

        //save the position type
        $positions = $request->positionType;
        $position_type = $positions;

        //Add the job block to the email
        $fileName = 'email-'.$email_id.'.html';

        // Put into folder location
        $fileLocation = base_path()."/storage/emails/".$fileName;

        ob_start();
        include base_path().'/resources/assets/templates/email-templatev2.php';
        $file = ob_get_clean();

        $dirname = dirname($fileLocation);

        if (!is_dir($dirname)) {
          mkdir($dirname, 0755, true);
        }

        // Append the new block to the current email.
        $handle = fopen($fileLocation, 'a') or die('Cannot open file:  ' . $fileLocation); //implicitly creates file
        fwrite($handle, $file);
        fclose($handle);

        //Save email id to job emails field
        $job = Job::where('id', $job_id)->first();

        $job->emails = $email_id; //its notn getting the job id
        
        echo 'complete';

    }



}
