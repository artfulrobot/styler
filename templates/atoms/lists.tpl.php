<?php print $embedded ? '' : '<div class="layout-container">'; ?>
<h1>Lists demo</h1>
<ul>
  <li>List items</li>
  <li>List item
    <ul>
      <li>sub List items</li>
      <li>sub List item</li>
    </ul>
  </li>

  <li>List item</li>
</ul>

<ul>
  <li><p><?php lorem(['words'=>40]);?></p></li>
  <li><p><?php lorem(['words'=>40]);?></p>
    <ul>
      <li><p><?php lorem(['words'=>40]);?></p></li>
      <li><p><?php lorem(['words'=>15]);?></p></li>
    </ul>
  </li>
  <li><p><?php lorem(['words'=>40]);?></p></li>
</ul>

<h2>Ordered Lists</h2>
<ol>
  <li>List items</li>
  <li>List item
    <ol>
      <li>sub List items</li>
      <li>sub List item</li>
    </ol>
  </li>

  <li>List item</li>
</ol>

<ol>
  <li><p><?php lorem(['words'=>40]);?></p></li>
  <li><p><?php lorem(['words'=>40]);?></p>
    <ol>
      <li><p><?php lorem(['words'=>40]);?></p></li>
      <li><p><?php lorem(['words'=>15]);?></p></li>
    </ol>
  </li>
  <li><p><?php lorem(['words'=>40]);?></p></li>
</ol>

<?php print $embedded ? '' : '</div>'; ?>
