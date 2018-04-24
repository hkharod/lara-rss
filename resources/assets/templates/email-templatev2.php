{% if subscriber.tags contains "<?php echo $position_type; ?>" %}
  {% if subscriber.tags contains "<?php echo $keyword; ?>" %}
    <div class="job" style="background:#f0f0f0;border-top:2px solid #6534ff;line-height:1.4em;margin:12px 20px 20px 20px;max-width:640px;padding:12px 16px">
      <div class="title" style="margin-bottom: 10px;">
        <strong><?php echo $title; ?></strong>
      </div>
      <div class="description">
        <div style="margin-bottom: 5px;">
          <strong>Position Type: </strong>
          <?php if($position_type == 'freelance'): ?>
              Freelance
          <?php elseif($position_type == 'parttime'): ?>
              Part-time
          <?php elseif($position_type == 'fulltime'): ?>
              Full-time
          <?php endif; ?>
        </div>
        <div style="margin-bottom: 5px;">
          <strong>Skills: </strong> <?php echo $tech_tags; ?>
        </div>
        <div>
          <a href="<?php echo $url; ?>" class="details" style="text-align: center;"><strong>View Full Details</strong></a>
        </div>
      </div>
    </div>
  {% endif %}
{% endif %}
