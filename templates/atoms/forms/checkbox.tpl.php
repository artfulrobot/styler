<?php if (!isset($id)) {
  $id = 'cb' . rand(1,10000);
  $name = empty($name) ? $id : $name;
  $label_text = empty($label_text) ? 'Demo checkbox' : $label_text;
}
$checked = !empty($checked);
?>
<div class="form-item" >
  <input type="checkbox" <?php if ($checked) :?>checked="checked" <?php endif; ?>id="<?php print $id; ?>" > <label for="<?php print $id; ?>" ><?php print $label_text; ?></label>
</div>
