<?php print $embedded ? '' : '<div class="layout-container">'; ?>
<h1><?php heading(10) ?></h1>
<p>The body font is <em>Source Sans Pro</em>. This is a high quality font for screen and print available in many variants (including <em>italics</em>, <strong>bold</strong> and <strong><em>bold italic</em></strong>.</p>
<p>Headings are in <em>Contrail One</em>. This is a display-use web-font. Headings are CAPITALISED to give a sense of urgency and loudness.</p>
<p><?php lorem() ?></p>
<h2><?php heading(15) ?></h2>
<p><?php lorem() ?></p>
<h3><?php heading(15) ?></h2>
<p><?php lorem() ?></p>
<h1>Major heading</h1>
<h2>Sub heading</h2>
<h3>Sub sub heading</h3>
<h4>Sub sub sub heading</h4>
<h5>Sub sub sub sub heading</h5>
<h6>Sub sub sub sub sub heading</h6>

<?php print $embedded ? '' : '</div>'; ?>

