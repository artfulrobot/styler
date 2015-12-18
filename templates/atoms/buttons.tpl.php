<?php print $embedded ? '' : '<div class="layout-container">'; ?>
<h1>Buttons</h1>

<h2>As button elements</h2>
<button class="caution">Delete</button>
<button class="secondary">Secondary</button>
<button class="primary">Primary</button>

<h2>As input elements</h2>
<input type="submit" value="Delete" class="caution" />
<input type="submit" value="Secondary" class="secondary" />
<input type="submit" value="Primary" class="primary" />

<h2>Link buttons</h2>
<a href="#" class="button caution">Delete</a>
<a href="#" class="button">Secondary</a>
<a href="#" class="button primary">Primary</a>

<?php print $embedded ? '' : '</div>'; ?>
