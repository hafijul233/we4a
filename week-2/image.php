<?php
if (!empty($_GET['ref'])) {
    $url = urldecode($_GET['ref']);
/*    $handle = curl_init();
    $url = "https://www.ladygaga.com";
    curl_setopt_array($handle, array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true
    ));
    $data = curl_exec($handle);
    var_dump(curl_error($handle));
    var_dump(curl_getinfo($handle));

    if (empty($data)) {
        var_dump(curl_error($handle));
    } else {
        var_dump($data);
    }

    curl_close($handle);

} else {
    die("Invalid Reference URL");
}*/

header("Location: " . $url);
}