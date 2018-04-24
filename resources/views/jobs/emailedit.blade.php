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

          <h1>Remote Hacker Email Creator</h1>

          <div class="Grid Grid--guttersThreeUp">

            <div class="Grid-cell sm-Grid-cell--full sm-Grid-cell--order1 Grid-cell--62 Container-content Mw(100%)">

              <form method="POST" action="/job/emailpublish">
              {{ csrf_field() }}
             
              
              <div class="input-group">
                <a :href="contactLink">@{{contactLink}}</a>
              </div>

              <input type="hidden" name="job_id" :value="job_id"/>


              <div class="input-group">
                <p>Technology</p>
                <select v-model="jobKeyword" name="jobKeyword">
                  <option value="php">PHP</option>
                  <option value="ruby">Ruby</option>
                  <option value="frontend">Frontend</option>
                  <option value="shopify">Shopify</option>
                  <option value="python">Python</option>
                  <option value="node">Node</option>
                  <option value="blockchain">Blockchain</option>
                  <option value="copywriting">Copywriting</option>
                  <option value="net">.Net</option>
                  <option value="csharp">C#</option>
                  <option value="design">Web Design</option>
                  <option value="go">Go</option>
                  <option value="ios">iOS/Swift</option>
                  <option value="java">Java</option>
                  <option value="seo">SEO/Content Marketing</option>
                </select>
              </div>

              <div class="input-group">
                <p>Position Type*</p>
                <select v-model="position_type" name="positionType">
                  <option value="freelance">freelance</option>
                  <option value="parttime">part-time</option>
                  <option value="fulltime">full-time</option>
                  
                </select>
              </div>

              
              <div class="input-group">
                <p>Job Title*</p>
                <input type="text" v-model="jobTitle" name="title" required/>
              </div>


              <div class="input-group">
                <p>Budget (Optional)</p>
                <input type="text" v-model="budget" name="budget"/>
              </div>



              <div class="input-group">
                <p>Required Skills (Separate by comma)*</p>
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
                <p>Full Details URL*</p>
                <input type="text" v-model="contactLink" name="contact_link" required/>
              </div>


              <div class="input-group">
                <p>Publish to Email</p>
                <select name="email" v-model="email" required>
                  <option :value="email_id">@{{email_title}}</option>
                </select>
              </div>


              <button type="submit">Publish to Email</button>

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
                    <div class="Preview-info Preview-text"><span class="Preview-highlightText">Position Type:</span> @{{ position_type }}</div>
                    <div class="Preview-info Preview-text"><span class="Preview-highlightText">Required Skills:</span> @{{ technologies }}</div>

                    <div class="Preview-links">
                      <div class="Grid Grid--guttersDefault">
                        <div class="Grid-cell Grid-cell--autoSize">
                          <a href="#" class="Preview-contactLink Preview-text Preview-highlightText">View Full Details</a>
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
      @include('footer')
    </div>

    <script src="/assets/js/vue.js"></script>
    <script src="/assets/js/email-creator.js"></script>


    <?php //print_r($job); ?>


    

  </body>
</html>
