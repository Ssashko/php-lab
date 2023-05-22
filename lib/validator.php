<?php

function validate_text($text) {
    return htmlspecialchars(stripslashes(trim($text)));
}

function validate_url($url)
{
    return htmlspecialchars($url);
}