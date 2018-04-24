<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $request['title']; ?></title>
    <meta name="description" content="Get free remote front-end freelance leads delivered to your inbox. Freelance leads for front-end developers with Vue, React, Angular, and JQuery skills.">
    <link rel="canonical" href="https://remoteleads.io/">

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="RemoteLeads">
    <meta property="og:description" content="Get free remote front-end freelance leads delivered to your inbox. Freelance leads for front-end developers with Vue, React, Angular, and JQuery skills.">
    <meta property="og:url" content="https://remoteleads.io/">
    <meta property="og:site_name" content="RemoteLeads">
    <meta property="og:image" content="https://remoteleads.io/assets/img/og-image.png" />

    <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/icons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">

    <link href="/assets/styles/styles.css" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110725416-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-110725416-1');
    </script>


    <!-- Drip -->
    <script type="text/javascript">
      var _dcq = _dcq || [];
      var _dcs = _dcs || {};
      _dcs.account = '3165292';
      (function() {
        var dc = document.createElement('script');
        dc.type = 'text/javascript'; dc.async = true;
        dc.src = '//tag.getdrip.com/3165292.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(dc, s);
      })();
    </script>
    <!-- end Drip -->

    <!-- Hotjar Tracking Code for www.remoteleads.io -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:712092,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>

  </head>
  <body>

    <div class="Container">
        <header>

          <div class="Grid Grid--spaceBetween">

            <div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">

              <div class="Grid Grid--guttersOneDown">
                <div class="Grid-cell Grid-cell--autoSize">
                  <img class="Logo-image" src="/assets/img/logo.jpg" alt="RemoteLeads Logo" />
                </div>
                <div class="Grid-cell Grid-cell--autoSize">
                  <span class="medium small black"><?php echo $request['type']; ?></span>
                </div>

              </div>

            </div>

          </div>

        </header>
    </div>

      <div id="job-html-container" class="JobHTMLContainer">

        <div class="Container Container--withOverflow TopSpacer up">
          <h2 class="js-text MainText mediumText black"><?php echo $request['title']; ?></h2>

          <div class="TopSpacer oneDown">
            <div class="Grid Grid--guttersDefault">

              <div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                <span class="black bold">Company:&nbsp;</span> <span class="black"><?php echo $request['company']; ?></span>
              </div>

              <div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                <span class="black bold">Original Source:&nbsp;</span> <span class="black"><?php echo $request['source']; ?></span>
              </div>

              <?php if($request['budget'] != null ): ?>
				<div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
	               <span class="black bold">Budget:&nbsp;</span> <span class="black"><?php echo $request['budget']; ?></span>
	            </div>
              <?php endif; ?>

              <?php if ($request['job_original_post_date'] != null): ?>
                <div class="Grid-cell Grid-cell--autoSize Grid-cell--flex Grid-cell--alignItemsCenter">
                  <span class="black bold">Job's Original Post Date:&nbsp;</span> <span class="black"><?php echo $request['job_original_post_date']; ?></span>
                </div>
              <?php endif; ?>
              
			  <?php foreach($request['tags'] as $tag): ?>

	              <div class="Grid-cell Grid-cell--autoSize">
	                <div class="Tag"><?php echo $tag; ?></div>
	              </div>

              <?php endforeach; ?>
            </div>

          </div>

        </div>


      <div class="Container TopSpacer twoUp">

        <div class="ExplainSection noborder last JobExplainerSection">


          <?php echo $request['body']; ?>


          <div class="TopSpacer">
            <a href="<?php echo $request['contact_link']; ?>"><h1 class="blue underline"><?php echo $request['contact_text']; ?></h1></a>
          </div>

        </div>
      </div>

      </div>


    <div class="Container TopSpacer up">
      <footer>

        <div class="Grid">
          <div class="Grid-cell Grid-cell--1of2 xs-Grid-cell--full xs-Mb(u1)">
            <span class="Logo-text black">RemoteLeads</span>
          </div>

          <div class="Grid-cell Grid-cell--1of6 xs-Grid-cell--1of2 xs-Mb(u3)">
            <a class="footer-link" href="/faq">FAQ</a>
            <a class="footer-link" href="/about">About</a>
            <a class="footer-link" href="#works">How it works</a>
          </div>

          <div class="Grid-cell Grid-cell--1of6 xs-Grid-cell--1of2 xs-Mb(u3)">
            <a class="footer-link" target="_blank" href="/privacypolicy">Privacy Policy</a>
            <a class="footer-link" target="_blank" href="/terms">Terms of Service</a>
          </div>

          <div class="Grid-cell Grid-cell--1of6 xs-Grid-cell--full sm-Mw(1of6)">
            <a class="footer-link footer-email-link" href="mailto:support@remoteleads.io">support@remoteleads.io</a>
            <a href="#leads" class="button small">Get free leads</a>
          </div>


        </div>

        <div class="TopSpacer up">
          <p class="footer-copy"> 🌏 &nbsp;&nbsp;&copy; 2017. Built by remote freelancers for remote freelancers.</p>
        </div>
      </footer>
    </div>

  </body>
</html>
