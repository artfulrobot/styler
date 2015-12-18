<!DOCTYPE html>
<html>
  <head>
    <title><?php print $title?></title>
    <link rel="stylesheet" href="css/styler.css">
    <!-- point to site stylesheet here. 
    <link rel="stylesheet" href="/path/to/site/styles.css">
    -->

    <meta name="viewport" content="width=device-width">
    <!-- update with fonts required etc. -->
    <link href='https://fonts.googleapis.com/css?family=Contrail+One|Economica:700italic,700|Share:700,700italic' rel='stylesheet' type='text/css'>

    <!-- update with scripts required etc. -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js" ></script>
  </head>
  <body class="<?php print $body_classes; ?>">
    <div id="styler-header" >
      <div class="styler-menu"><a href="/styler/" >Menu</a><?php print $menu ;?></div>
      <div class="title" ><?php print $title; ?></div>
    </div>
    <div id="page-container" >
      <?php print $body; ?>
    </div>
  </body>
</html>
