<?php
if (!function_exists('getGamesFromBetconstruct')) {
    function calculateDistance($locationData = [])
    {
        $originLat = $locationData['origin']['lat'];
        $originLng = $locationData['origin']['lng'];
        $destinationLat = $locationData['destination']['lat'];
        $destinationLng = $locationData['destination']['lng'];
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?"
            . "origins=$originLat,$originLng"
            . "&"
            . "destinations=$destinationLat,$destinationLng"
            . "&"
            . "key=" . GOOGLE_MAP_API_KEY;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, TRUE);

        return $response_a;
    }
}
?>
