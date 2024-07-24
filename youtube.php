<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }
        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .video-item {
            width: 300px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .video-item img {
            width: 100%;
            border-radius: 4px;
        }
        .video-item h3 {
            font-size: 1.2em;
            margin: 10px 0;
        }
        .video-item p {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>YouTube Video Dashboard</h1>
        <form method="GET" action="">
            <input type="text" name="query" id="search-query" placeholder="Search for videos...">
            <button type="submit" id="search-button">Search</button>
        </form>
        <div id="video-container">
            <?php
            if (isset($_GET['query'])) {
                $query = urlencode($_GET['query']);
                $apiKey = 'AIzaSyAn6PMksTdus8dF2i577GRPmujFYHPOiKs'; // Replace with your actual API key
                $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q={$query}&key={$apiKey}";

                $response = file_get_contents($apiUrl);
                $data = json_decode($response, true);
                $videos = $data['items'];

                if (!empty($videos)) {
                    foreach ($videos as $video) {
                        $thumbnail = $video['snippet']['thumbnails']['high']['url'];
                        $title = $video['snippet']['title'];
                        $description = $video['snippet']['description'];
                        $videoId = $video['id']['videoId'];
                        $videoUrl = "https://www.youtube.com/watch?v={$videoId}";

                        echo "
                        <div class='video-item'>
                            <a href='{$videoUrl}' target='_blank'>
                                <img src='{$thumbnail}' alt='{$title}'>
                            </a>
                            <h3><a href='{$videoUrl}' target='_blank'>{$title}</a></h3>
                            <p>{$description}</p>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No videos found for your search query.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
