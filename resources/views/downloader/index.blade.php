@extends('downloader.layout')



@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #cc0000;
        }
        #videoContainer {
            margin-top: 20px;
            text-align: center;
        }
        #downloadLink {
            display: none;
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <div class="container">
        <h1>YouTube Video Viewer & MP4 Download</h1>
        <p>Paste a YouTube link below to view the video and get an MP4 download link:</p>
        <input type="text" id="youtubeLink" placeholder="Paste YouTube link here">
        <button onclick="processYouTubeLink()">Get Video</button>

        <div id="videoContainer"></div>
        <div id="downloadLink"></div>
    </div>

@endsection
