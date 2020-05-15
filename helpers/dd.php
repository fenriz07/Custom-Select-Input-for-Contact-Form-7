<?php


if (!function_exists('dd')) {
    function dd($data)
    {
        ini_set("highlight.comment", "#969896; font-style: italic");
        ini_set("highlight.default", "#FFFFFF");
        ini_set("highlight.html", "#D16568");
        ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
        ini_set("highlight.string", "#F2C47E");
        $output = highlight_string("<?php\n\n" . var_export($data, true), true);
        echo "<div style=\"background-color: #1C1E21; padding: 1rem\">{$output}</div>";
        die();
    }
}

function strip_defined_tags_spn($str, $tags, $stripContent = false) 
{
    $content = '';
    if (!is_array($tags)) {
      $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
      if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) {
      if ($stripContent) {
        $content = '(.+</'.$tag.'(>|\s[^>]*>)|)';
        $str = preg_replace('#</?'.$tag.'(>|\s[^>]*>)'.$content.'#is', '', $str);
    }
    return $str;
  }
}