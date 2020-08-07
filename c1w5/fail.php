<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo("<p>What we want to see below is a 'Fatal Error'.</p>\n");

// Do not fix the mistake in the code below - the goal is to
// trigger an error to verify that we see errors in the browser.

failure_is_expected();
