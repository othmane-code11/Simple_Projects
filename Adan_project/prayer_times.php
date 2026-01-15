<?php
    $city = 'Rabat';
    $country = 'Morocco';
    $date = "today";
    $ApiUrl = "https://api.aladhan.com/v1/timingsByCity/$date?city=$city&country=$country";

    $response = file_get_contents($ApiUrl);
    $data = json_decode($response, false);
    
    $Fajr = $data->data->timings->Fajr;
    $Sunrise = $data->data->timings->Sunrise;
    $Dhuhr = $data->data->timings->Dhuhr;
    $Asr = $data->data->timings->Asr;
    // $Asr = date("H:i", strtotime(datetime:"+1 minutes")); // This is just for testing
    $Maghrib = $data->data->timings->Maghrib;
    $Isha = $data->data->timings->Isha;

    echo json_encode([
        'city' => $city,
        'country' => $country,
        'Fajr' => $Fajr,
        'Sunrise' => $Sunrise,
        'Dhuhr' => $Dhuhr,
        'Asr' => $Asr,
        'Maghrib' => $Maghrib,
        'Isha' => $Isha
    ]);
?>