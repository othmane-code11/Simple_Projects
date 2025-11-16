<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Weather App</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #ffffffdd;
            padding: 30px;
            border-radius: 20px;
            width: 330px;
            text-align: center;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
        }

        h2 {
            margin-bottom: 15px;
        }

        form, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }
        input {
            width:93%;
            border-radius: 10px;
            border: 1px solid #aaa;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: #4facfe;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #00c6ff;
        }

        .weather-box {
            margin-top: 20px;
        }

        .temp {
            font-size: 20px;
            font-weight: bold;
        }

        .desc {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Weather App By </h2>
        <form action="" method="post">
            <input type="text" name="city" placeholder="Enter city...">
            <button name="getweather" type="submit">Get Weather</button>
        </form>
        
        <div class="weather-box">
            <?php 
                if (isset($_POST["getweather"])) {
                    $city = $_POST["city"];
                    $apikey = "Your api Key";
                    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apikey";

                    $request = curl_init();
                    curl_setopt($request, CURLOPT_URL, $url);
                    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($request);
                    curl_close($request);

                    if ($response) {
                        $data = json_decode($response, true);

                        if (isset($data["main"]["temp"])) {
                            $temp = $data["main"]["temp"] - 273;
                            $desc = $data["weather"][0]["description"];?>
                            <div>
                                <p class="temp"><?php echo $temp?>°C</p>
                                <p class="desc"><?php echo $desc?></p>
                            </div>
                        <?php
                        } 
                    }
                }
                else {
                    echo "error";
                }
            ?>
            
        </div>
    </div>
</body>
</html>
