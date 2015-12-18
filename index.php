<?php
require './artfulrobot/ArtfulRobot/autoload.php';

class Container
{
  public $config = [
    'lorem' => [
      'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse eu faucibus magna. In quam sapien, elementum et malesuada ornare, placerat vel libero. Nam eget ex purus. Nam et metus ipsum. Donec vitae porta purus. Nulla rutrum elementum commodo. Sed malesuada congue massa, sit amet posuere dolor consectetur sed.',
      'Cras consequat consequat lectus, sed vulputate lorem ultricies eu. Morbi nibh mi, aliquam nec elementum a, congue eget urna. Sed ornare malesuada magna, vel rhoncus ex semper sit amet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Eorbi ac sem at nunc facilisis accumsan et dapibus ligula. Fusce sagittis finibus arcu, ac dignissim nibh venenatis vel. Quisque at purus sit amet enim ornare finibus. Maecenas ornare lobortis elementum.',
      'Vivamus id felis nec ex malesuada consequat ut nec nunc. Integer rhoncus, nisl non pellentesque elementum, libero nisl sodales nulla, vitae dictum lorem nisi at lectus. Quisque ultricies est vel dui elementum ornare. Pellentesque consequat erat ut odio vehicula tristique. Integer ac neque ultricies, iaculis lorem id, tempor elit. Fusce nulla orci, aliquet a efficitur eget, mattis at purus. Donec vitae felis nisl. Sed nec purus dui. Aliquam ullamcorper, enim lobortis lobortis iaculis, mauris sapien tristique nisl, porta molestie dui nunc et sem. In rhoncus nunc nibh, eu tincidunt ipsum sodales sed. Aenean vitae dictum massa.',
      'Praesent venenatis erat vel augue interdum efficitur. Aenean ultricies velit at purus vestibulum dignissim. Nulla tincidunt eu neque sit amet ultrices. Donec sagittis tellus sit amet ipsum finibus, a lobortis nunc porta. Pellentesque porta diam id nisi vulputate sollicitudin. Sed eget ultrices justo. Praesent at orci pellentesque, porta lacus eu, convallis enim. Nam aliquam ligula quis diam viverra, nec egestas nisl ultricies. Morbi magna nulla, congue eget aliquet sed, suscipit vel lorem. Nulla ut nulla eu leo pulvinar pellentesque a eu dolor. Pellentesque aliquam ornare sem id efficitur. Proin congue elit libero.',
      'Phasellus laoreet sed odio gravida placerat. Sed eu mi ex. Donec sed quam vitae turpis rhoncus feugiat. Pellentesque posuere eleifend blandit. Aliquam erat volutpat. Morbi dapibus et enim sit amet malesuada. Nullam ut eros viverra sem tempor pretium. ',
    ],
    'headings' => [
      'Event X is coming up soon.',
      '5 out of 10 people don\'t think.',
      'Most headlines are completely made up.',
      'How we won our campaign',
      'It\'s official: something amazing has happened.',
    ],
  ];
  public $controller;
  public static $app;

  public function __construct() {
    $this->controller = new PageController($this);
  }

  public function configure($config) {
    // Merge in config, take new config over old.
    $this->config = $config + $this->config;

    return $this;
  }
  public function getConfig($key) {
    if (isset($this->config[$key])) {
      return $this->config[$key];
    }
  }

  public function item($tpl) {
    $item = new Item($this, $tpl);
    return $item;
  }

  public function templater() {
    $t = new \ArtfulRobot\Template($this->config['templates_base']);
    return $t;
  }
  /**
   * Returns singleton app.
   */
  public function app() {
    if (!isset(static::$app)) {
      static::$app = new static();
    }
    return static::$app;
  }
}


class PageController
{
  public $html_body;
  public $html_title;
  public $response=200;
  public $tpl_path;
  public $templates_base;
  public $container;

  public function __construct($container) {
    $this->container = $container;
  }
  public function run($tpl) {
    try {
      if ($tpl) {
        $item = $this->container->item($tpl);
        $vars = ['embedded' => FALSE, 'tpl' => $tpl];
        $this->html_body = $item->fetch($vars);
        $this->html_title = $tpl;
      }
      else {
        $this->html_title = 'Menu';
        $this->html_body = $this->menu();
      }
    }
    catch (Exception $e) {
      $this->html_title = "Error";
      $this->html_body = "<div style='border-left:solid 2px red;padding:1rem;background-color:#eee;'>"
        . htmlspecialchars($e->getMessage())
        . "</div>";
    }
    $this->output();

  }
  public function menu() {
    static $menu = null;
    if ($menu !== null) {
      return $menu;
    }

    // List templates, provide links.
    $base = $this->container->config['templates_base'];
    $templates = preg_ls($base, true, '/\.tpl\.php$/');
    $this->html_body = '';
    $request = $_SERVER['REQUEST_URI'];
    asort($templates);
    foreach ($templates as $_) {
      $_ = substr($_, strlen($base));
      if (substr($_, 0, 1) == '_') {
        continue;
      }
      $_ = str_replace('.tpl.php', '', $_);
      $menu .= "<li><a href=\"$_SERVER[SCRIPT_NAME]?tpl=" . urlencode($_) . "\" >" . htmlspecialchars($_) . "</a></li>";
    }
    $menu = "<ul class=\"styler-menu\">$menu</ul>";
    return $menu;
  }
  public function output() {
    // @todo http response code.
    $tpl = $this->container->templater();
    $tpl->set_vars([
        'body' => $this->html_body,
        'menu' => $this->menu(),
        'body_classes' => 'tpl-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($this->title)),
        'title' => $this->container->site_name .  ucfirst(htmlspecialchars($this->html_title)),
      ], true);
    $output = $tpl->fetch('_page.tpl.php');
    print $output;
  }
}

/**
 * Represents a single chunk/template.
 */
class Item
{
  public $container;
  protected $relative_path;

  public function __construct($container, $tpl) {
    $this->container = $container;
    $this->relative_path = $this->validateRequest($tpl);
  }
  public function validateRequest($tpl) {

    if (preg_match('@(^|/)\.\.?@', $tpl)) {
      // Template includes a hidden file/folder, or a double dot - trying to
      // access file outside of dir.
      throw new InvalidArgumentException('Invalid request.');
    }

    // Check tpl exists.
    $b = $this->container->config['templates_base'];
    $_ = $b . $tpl . '.tpl.php';
    if (!is_file($_) || !is_readable($_)) {
      $this->response = 404;
      throw new InvalidArgumentException('Template does not exist.');
    }
    $_ = realpath($_);
    $base_len = strlen($b);
    if (substr($_, 0, $base_len) !== $b) {
      // Somehow this is accessing somewhere outside of the allowed area.
      throw new InvalidArgumentException('Invalid request.');
    }

    // Ok, looks valid.
    return substr($_, $base_len);
  }
  public function fetch($vars = []) {
    $tpl = $this->container->templater($this->relative_path);
    // add in any vars sent.
    $tpl->set_vars($vars);
    return $tpl->fetch($this->relative_path);
  }
}

// Helper functions for templates
function lorem($options=[]) {
  $options = $options + ['links'=>TRUE, 'strong'=>TRUE, 'words' => FALSE ];
  $lorem = Container::app()->config['lorem'];
  static $i = null;
  if ($i === null) {
    $i = rand(0,count($lorem)-1);
  }
  $output = explode(' ',$lorem[$i]);
  if ($options['words'] !== FALSE && count($output)>$options['words']) {
    $output = array_slice($output, 0, $options['words']-1);
  }
  if ($options['links']) {
    $i = (int) rand(0, count($output)/2);
    $j = (int) rand(1, 10);
    $random_part = array_slice($output, $i, $j);
    $random_part = '<a href="#' . rand(1,10000) . '" >' . implode(' ', $random_part) . '</a>';
    array_splice($output, $i, $j, $random_part);
  }
  if ($options['strong']) {
    $i = (int) rand(0, count($output)/2);
    $j = (int) rand(2, 10);
    $random_part = array_slice($output, $i, $j);
    $random_part = '<strong>' . implode(' ', $random_part) . '</strong>';
    array_splice($output, $i, $j, $random_part);
  }
  $output = implode(' ', $output);
  $i = ($i + 1) % (count($lorem) - 1);
  print $output;
}

function heading($words) {
  global $app;
  static $i = null;
  $headings = Container::app()->config['headings'];
  if ($i === null) {
    $i = rand(0,count($headings)-1);
  }
  $output = $headings[$i];
  $i = ($i + 1) % (count($headings) - 1);
  $output = explode(' ', $output);
  if (count($output)>$words) {
    $output = array_slice($output, 0, $words-1);
  }
  print implode(' ', $output);
}

function chunk($tpl, $vars=[]) {
  global $app;
  $item = $app->item($tpl);
  $vars += ['embedded' => TRUE];
  print $item->fetch($vars);
}

function swatch($name, $bg, $fg='white') {
  print "<div class=\"sample\" style=\"background-color:$bg;color:$fg;\">"
    . htmlspecialchars($name) . "<br />"
    . (stripos($name, 'text')===FALSE ? $bg : $fg)
    . "</div>\n";
}
function preg_ls ($path=".", $rec=false, $pat="/.*/") {
    // it's going to be used repeatedly, ensure we compile it for speed.
    $pat=preg_replace("|(/.*/[^S]*)|s", "\\1S", $pat);
    //Remove trailing slashes from path
    while (substr($path,-1,1)=="/") $path=substr($path,0,-1);
    //also, make sure that $path is a directory and repair any screwups
    if (!is_dir($path)) $path=dirname($path);
    //assert either truth or falsehoold of $rec, allow no scalars to mean truth
    if ($rec!==true) $rec=false;
    //get a directory handle
    $d=dir($path);
    //initialise the output array
    $ret=Array();
    //loop, reading until there's no more to read
    while (false!==($e=$d->read())) {
        //Ignore parent- and self-links
        if (($e==".")||($e=="..")) continue;
        //If we're working recursively and it's a directory, grab and merge
        if ($rec && is_dir($path."/".$e)) {
            $ret=array_merge($ret,preg_ls($path."/".$e,$rec,$pat));
            continue;
        }
        //If it don't match, exclude it
        if (!preg_match($pat,$e)) continue;
        //In all other cases, add it to the output array
        $ret[]=$path."/".$e;
    }
    //finally, return the array
    return $ret;
}


$app = Container::app()
  ->configure(['templates_base' => dirname(__FILE__) . "/templates/"]);

include_once 'config.php';

$tpl_path = isset($_GET['tpl']) ? $_GET['tpl'] : '';
$app->controller->run($tpl_path);
