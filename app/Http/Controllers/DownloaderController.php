<?php

namespace App\Http\Controllers;

use App\Models\Downloader;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class DownloaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $products = Downloader::latest()->paginate(5);
        return view('downloader.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function download(Request $request)
    {
        $url = $request->query('url');

        if (empty($url)) {
            return redirect()->back()->with('error', 'No URL provided');
        }

        // Extract the video ID (optional - to validate)
        $videoId = $this->extractVideoId($url);

        if (!$videoId) {
            return redirect()->back()->with('error', 'Invalid YouTube URL');
        }

        // Prepare the command to download the video using yt-dlp (or youtube-dl)
        $command = [
            'yt-dlp', // Use yt-dlp command (make sure it's installed on your server)
            '-f', 'mp4', // You can customize the format here
            '-o', public_path('downloads/%(title)s.%(ext)s'), // Set the download path
            $url
        ];

        try {
            // Execute the process
            $process = new Process($command);
            $process->mustRun(); // This will throw an exception if it fails

            // Success - return the download link or redirect as needed
            return response()->download(public_path('downloads/' . $process->getOutput()));
        } catch (ProcessFailedException $exception) {
            return redirect()->back()->with('error', 'Video download failed. Please try again.');
        }
    }

    private function extractVideoId($url)
    {
        $videoId = null;
        $patterns = [
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/|.*[?&]v=))([a-zA-Z0-9_-]{11})/',
            '/(?:https?:\/\/)?(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]{11})/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                break;
            }
        }

        return $videoId;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()

    {
        return view('products.create.blade.php');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)

    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        Downloader::create($request->all());
        return redirect()->route('downloader.index')
            ->with('success', 'Downloader created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */

    public function show(Downloader $product)
    {
        return view('downloader.show', compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */

    public function edit(Downloader $product)

    {
        return view('downloader.edit', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Downloader $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        $product->update($request->all());
        return redirect()->route('downloader.index')
            ->with('success', 'Downloader updated successfully');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */

    public function destroy(Downloader $product)

    {
        $product->delete();
        return redirect()->route('downloader.index')
            ->with('success', 'Downloader deleted successfully');
    }
}
