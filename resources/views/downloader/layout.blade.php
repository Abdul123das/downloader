<!DOCTYPE html>

<html>

<head>

    <title>Laravel 8 CRUD Application - ItSolutionStuff.com</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">

</head>

<body>



<div class="container">

    @yield('content')

</div>



</body>

</html>
<script>
    function processYouTubeLink() {
        var url = document.getElementById('youtubeLink').value;
        var videoId = extractVideoId(url);

        if (videoId) {
            // Display the video using iframe
            var iframeHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
            document.getElementById('videoContainer').innerHTML = iframeHTML;

            // Show the download link
            var downloadLinkHTML = `<a href="/download?url=${encodeURIComponent(url)}" id="downloadBtn">Download MP4</a>`;
            document.getElementById('downloadLink').innerHTML = downloadLinkHTML;
            document.getElementById('downloadLink').style.display = 'block';
        } else {
            alert('Please enter a valid YouTube link.');
        }
    }

    function extractVideoId(url) {
        var videoId = null;
        var youtubePatterns = [
            /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/|.*[?&]v=))([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]{11})/
        ];

        youtubePatterns.some(function(pattern) {
            var match = url.match(pattern);
            if (match && match[1]) {
                videoId = match[1];
                return true;
            }
        });

        return videoId;
    }
</script>
