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
