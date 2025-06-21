<?php

// Lazy Load

function dziri_add_lazy_loading($content) {
    $content = preg_replace('/<img([^>]+?)>/i', '<img$1 loading="lazy">', $content);
    return $content;
}
add_filter('the_content', 'dziri_add_lazy_loading');