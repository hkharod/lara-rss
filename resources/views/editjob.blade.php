<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Remote Hacker Job Creator</title>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <link href="/assets/styles/styles.css" rel="stylesheet">
    <link href="/assets/styles/job-creator.css" rel="stylesheet">
  </head>

  <body>



    <div id="JOBCREATOR">

      <div v-if="isShowingJobPreview">

        <button v-on:click="hideJobPreviewPage" class="submit black">Hide Job Page Preview</button>

        <div class="Container">
            <header>

              <div class="Grid Grid--spaceBetween">

                <div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">

                  <div class="Grid Grid--guttersOneDown">
                    <div class="Grid-cell Grid-cell--autoSize">
                      <img class="Logo-image" src="/assets/img/logo.jpg" alt="RemoteLeads Logo">
                    </div>
                    <div class="Grid-cell Grid-cell--autoSize">
                      <span class="medium small black" >@{{ projectType }}</span>
                    </div>

                  </div>

                </div>

              </div>

            </header>
        </div>

        <div class="Container Container--withOverflow TopSpacer up">
          <h2 class="js-text MainText mediumText black">@{{ jobTitle }}</h2>

          <div class="TopSpacer oneDown">
            <div class="Grid Grid--guttersDefault">

              <div v-if="company" class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                <span class="black bold">Company:&nbsp;</span> <span class="black"> @{{ company }}</span>
              </div>

              <div v-if="source" class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                <span class="black bold">Original Source:&nbsp;</span> <span class="black"> @{{ source }}</span>
              </div>

              <div v-if="budget" class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                <span class="black bold">Budget:&nbsp;</span> <span class="black"> @{{ budget }}</span>
              </div>

              <div v-if="tagsFormatted.length >= 1" v-for="tag in tagsFormatted" class="Grid-cell Grid-cell--autoSize">
                 <div class="Tag">@{{ tag }}</div>
              </div>

            </div>

          </div>

        </div>

        <div class="Container TopSpacer twoUp">

          <div class="ExplainSection noborder last">

            <div v-html="jobHTML"></div>

            <div class="TopSpacer">
              <a href="#"><h1 class="blue underline"> @{{ contactText }}</h1></a>
            </div>

          </div>
        </div>

      </div>

      <div v-else>
        <div class="Container TopSpacer twoUp">

          <h1>RemoteLeads Job Creator</h1>

          <div class="Grid Grid--guttersThreeUp">

            <div class="Grid-cell sm-Grid-cell--full sm-Grid-cell--order1 Grid-cell--62 Container-content Mw(100%)">

              <form method="POST" action="/job/publish">
              {{ csrf_field() }}
              <div class="input-group">
                <p>Job Type*</p>
                <select name="type" v-model="projectType" required>
                  <option value="Jobs">Jobs</option>
                  <option value="Pro Project">Pro Project</option>
                </select>
              </div>

              <div class="input-group">
                <p>Job's Original Post Date*</p>
                <input type="text" name="job_original_post_date" v-model="jobOriginalPostDate" required>
              </div>

              <div class="input-group">
                <p>Job keyword (For example: Node, PHP, Ruby)</p>
                <select v-model="jobKeyword" name="jobKeyword">
                  <option value="PHP">PHP</option>
                  <option value="Ruby">Ruby</option>
                  <option value="Front-end">Frontend</option>
                  <option value="Shopify">Shopify</option>
                  <option value="Python">Python</option>
                  <option value="Node">Node</option>
                  <option value="Blockchain">Blockchain</option>
                </select>
              </div>

              <div class="input-group">
                <p>Position Type* (Example: Freelance, Contract, Permanent, Full-time, etc.)</p>
                <input type="text" v-model="position_type" name="positionType" required />
              </div>

              <div v-if="projectType === 'Jobs'" class="input-group">
                <p>Folder Location* (Example: /remote/ruby/ or /remote/node/ or /remote/front-end/)</p>
                <input type="text" v-model="folderLocation" name="folder_location" required />
              </div>

              <div v-if="projectType === 'Jobs'" class="input-group">
                <p>File name for free job without HTML extension* (example: remote-ruby-rails-developer-lightstock)</p>
                <input type="text" v-model="fileName" name="file_name" required />
              </div>

              <div class="input-group">
                <p>Job Title*</p>
                <input type="text" v-model="jobTitle" name="title" required/>
              </div>

              <div class="input-group">
                <p>Company*</p>
                <input type="text" v-model="company" name="company" required/>
              </div>

              <div class="input-group">
                <p>Source*</p>
                <input type="text" v-model="source" name="source" required/>
              </div>

              <div class="input-group">
                <p>Budget (Optional)</p>
                <input type="text" v-model="budget" name="budget"/>
              </div>

              <div class="input-group">
                <p>Display Page Tags (Separate by comma)*</p>
                <input type="text" v-model="tags" name="tags" required/>
              </div>

              <div class="input-group">
                <p>Required technologies (Separate by comma)*</p>
                <input type="text" v-model="technologies" name="technologies" required />
              </div>

              <div class="input-group">
                <p>Location (optional) (Example: USA only)</p>

                <select name="location" v-model="location">
                  <option value="North America">North America</option>
                  <option value="South America">South America</option>
                  <option value="Oceania">Oceania</option>
                  <option value="Africa">Africa</option>
                  <option value="Europe">Europe</option>
                  <option value="Asia">Asia</option>
                </select>
              </div>

              <div class="input-group">
                <p>Should include this one for pro?</p>
                <input type="checkbox" name="should_include_for_pro" />
              </div>

              <div class="input-group">
                <p>Job Description (use <a href="http://htmltidy.net/">HTML Tidy to clean text</a>, html or copied text then paste here)</p>
                <textarea name="body" v-model="jobHTML" required></textarea>
              </div>


              <div class="input-group">
                <p>Contact Link*</p>
                <input type="text" v-model="contactLink" name="contact_link" required/>
              </div>

              <div class="input-group">
                <p>Contact Text*</p>
                <input type="text" v-model="contactText" name="contact_text" required/>
              </div>

              <button type="submit">Submit</button>

            </form>

            </div>

            <div class="Grid-cell Grid-cell--38 Grid-cell--justifyCenter sm-Grid-cell--order2 sm-Grid-cell--full">

              <div class="CallToActions">

                <div class="Preview Preview--fixed Preview--blue Preview--fullOpacity Preview--yourPreview">

                  <h3 class="your-job-preview-title">Email Preview</h3>

                  <div class="Preview-highlightText Preview-text Preview-info Preview-title">
                    <span class="ProLabel" v-if="projectType === 'Pro Project'">Pro</span> <span v-if="location">(@{{ location }})</span> @{{ jobTitle }}
                  </div>
                  <div class="Preview-body">
                    <div class="Preview-info Preview-text"><span class="Preview-highlightText">Position Type:</span> @{{ positionType }}</div>
                    <div class="Preview-info Preview-text"><span class="Preview-highlightText">Required Skills:</span> @{{ technologies }}</div>

                    <div class="Preview-links">
                      <div class="Grid Grid--guttersDefault">
                        <div class="Grid-cell Grid-cell--autoSize">
                          <a v-if="projectType === 'Pro Project'" href="#" class="Preview-contactLink Preview-text Preview-highlightText">View full project details</a>
                          <a v-else href="#" class="Preview-contactLink Preview-text Preview-highlightText">Contact @{{ company }}</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="TopSpacer">
                  <button v-on:click="showJobPreviewPage" class="submit black">Preview @{{ projectType }} page</button>
                </div>

              </div>

            </div>
          </div>

        </div>
      </div>
      @include ('footer')
    </div>

    <script src="/assets/js/vue.js"></script>
    <script src="/assets/js/job-creator.js"></script>


    <?php //print_r($job); ?>


    

  </body>
</html>
