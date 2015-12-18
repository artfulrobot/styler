<?php print $embedded ? '' : '<div class="layout-container">'; ?>
<p><a href='/styler/'>A link you have visited</a></p>
<p><a href='/styler<?php print rand(0,10000) ?>'>A link you have not visited</a></p>
<p><?php lorem(['strong' => FALSE]) ?></p>
<?php print $embedded ? '' : '</div>'; ?>
