<?php 

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude(array(
      'vendor',
      'cache',
      'logs',
    ))
    ->notName('/.*\.(ico|gif|png|jpeg|jpg|bmp|tiff|mp3|wma|wmv|avi|flv|swf|zip|bz2|gz|tar|7z|lzma|doc|docx|csv|xls|xlsx|ppt|pptx|odt|log|phar|jar)/')
    ->in(__DIR__.'/src')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        'indentation',
        'linefeed',
        'trailing_spaces',
        'unused_use',
        'phpdoc_params',
        'visibility',
        'return',
        'short_tag',
        'braces',
        'include',
        'php_closing_tag',
        'extra_empty_lines',
        //'psr0',
        'controls_spaces',
        'elseif',
        'eof_ending',
    ))
    ->finder($finder)
;
