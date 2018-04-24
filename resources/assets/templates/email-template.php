<?php if ($request['type'] === 'Pro Project'): ?>
  {% if subscriber.tags contains "PRO" and subscriber.tags contains <?php echo '"' . $request['jobKeyword'] . '"'; ?> %}
  <span style="background: #3FD27B; border: 1px solid #185430; border-radius: 4px; box-sizing: border-box; color: #fff; display: inline-block; font-family: helvetica neue,helvetica,helvetica,arial,sans-serif; font-size: 14px; line-height: 1.5; padding: 4px; text-transform: capitalize">Pro</span>&nbsp;

<?php else: ?>

  

  {% if subscriber.tags contains <?php echo '"' . $request['jobKeyword'] . '"'; ?> %}

<?php endif; ?>

<?php if (!empty($request['location'])): ?>
  <?php echo "(" . $request['location'] . ")"; ?>
<?php endif; ?>
<strong><?php echo $request['title']; ?></strong>
<div style="background-color:hsl(210,70%,96%);border-left:3px solid hsl(210,70%,50%);line-height:1.4em;margin:12px 0;max-width:640px;padding:12px 16px">
  <div>
    <strong>Position Type:</strong> <?php echo $request['positionType']; ?>
  </div>
  <div>
    <strong>Required Skills:</strong> <?php echo $request['technologies']; ?>
  </div>

  <br />

  <div>

    <?php if ($request['type'] === 'Pro Project'): ?>
      <a href="https://remoteleads.io/pro/<?php echo $guid; ?>?k={{ subscriber.pro_key }}">
        <strong>View full project details</strong>
      </a>
    <?php else: ?>
      <a href="https://remoteleads.io<?php echo $folderLocation . $fileName; ?>">
        <strong>Contact <?php echo $request['company']; ?></strong>
      </a>
    <?php endif; ?>
  </div>

</div>
<?php if ($request['type'] === 'Pro Project'): ?>
{% endif %}
<?php else: ?>

  {%endif %}



<?php endif; ?>
