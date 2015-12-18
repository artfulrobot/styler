<?php print $embedded ? '' : '<div class="layout-container">'; ?>
<h1>Colours</h1>
<h2>Primary</h2>
<div class="swatch">
<?php swatch('Near Black Text', 'white', '#222222' ); ?>
<?php swatch('Purple Text', 'white', '#662a73' ); ?>
<?php swatch('Dark Grey Text', 'white', '#383838'); ?>
</div>
<div class="swatch">
<?php swatch('Purple', '#662a73', 'white' ); ?>
<?php swatch('Dark Grey', '#383838', 'white' ); ?>
<?php swatch('Neutral Light Bg', '#f4eef6', 'inherit' ); ?>
<?php swatch('Amber', '#ffa018', '#222' ); ?>
</div>
<h2>Secondary</h2>
<p>Secondary colours may be used as a pallette to theme various projects but are not to be generally used. Some of these are not WCAG2 AAA compliant used small.</p>
<div class="swatch">
<?php swatch('Earth', '#58452b', 'white' ); ?>
<?php swatch('Green', '#46851f', 'white' ); ?>
<?php swatch('Green Light Bg', '#c8dcbb', '#222' ); ?>
<?php // swatch('Green Text', 'white', '#315f16' ); ?>
</div>
<div class="swatch">
<?php swatch('Grue', '#435d66', 'white' ); ?>
<?php swatch('Grue Light Bg', '#bad5dc', '#222' ); ?>
<?php swatch('Red', '#dd3333', '#222' ); ?>
</div>
<?php print $embedded ? '' : '</div>'; ?>
