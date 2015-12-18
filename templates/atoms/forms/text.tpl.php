<?php if (!isset($id)) {
  $id = 'ti' . rand(1,10000);
  $name = empty($name) ? $id : $name;
  $label_text = empty($label_text) ? 'Demo text input' : $label_text;
};?>
<div class="form-item" >
  <label for="<?php print $id; ?>" ><?php print $label_text; ?></label>
  <input type="text" id="<?php print $id; ?>" > 
</div>

