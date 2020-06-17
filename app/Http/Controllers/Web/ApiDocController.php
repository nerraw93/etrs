<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ApiDocController extends Controller
{
    private $apiDocPath;

    public function __construct()
    {

        $this->apiDocPath = base_path('Api Documentation/');
    }

    /**
     * Display API doc - NEW!
     * @return view
     */
    public function v2()
    {
        $version = request()->route()->getName();
        $directories = $this->constructFiles($version);
        return view('api_doc', compact('directories', 'version'));
    }

    /**
     * Display API doc for V1 / Legacy
     * @return view
     */
    public function v1()
    {
        $version = request()->route()->getName();
        $directories = $this->constructFiles($version);
        return view('api_doc', compact('directories', 'version'));
    }

    /**
     * Get api doc content
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function get(Request $request)
    {
        $version = $request->version;

        if ($request->has('file')) {
            $file = $request->file;
            $path = $this->buildPath($file);
            $content = $this->getMarkDownContent($file);
            $details = $this->getDocDetails($content);
            return success_data(compact('content', 'path', 'details'));
        }

        if ($request->has('folders')) {
            $files = $this->getAllFolders($this->apiDocPath . $request->folders);
            return success_data(compact('files'));
        }

        return errorify('File not found.');
    }

    /**
     * Construcy files
     * @return array
     */
    public function constructFiles($version)
    {
        $this->apiDocPath .=  $version . '/';

        $directories = [];
        $files = File::allFiles($this->apiDocPath);

        foreach ($files as $file) {
            $relativePath = $file->getrelativePath();
            $fileName = $file->getFilename();
            $relativePath = str_replace('_', ' ', $relativePath);
            $fileName = str_replace('.md', '', $fileName);
            if (!array_key_exists($relativePath, $directories)) {
                // Not exist - add
                $directories[$relativePath] = [$fileName];
            } else {
                // Exist - get prev data and merge
                $directories[$relativePath] = array_merge($directories[$relativePath], [$fileName]);
            }
        }
        return $directories;
    }

    private function getAllFolders($dirPath)
    {
        $folders = [];
        $folderPaths = glob($dirPath . '/*', GLOB_ONLYDIR);

        foreach ($folderPaths as $path) {
            $folderName = explode($dirPath . '/', $path)[1];
            array_push($folders, $folderName);
        }
        $files = [];
        $filePaths = glob($dirPath . '/*');

        foreach ($filePaths as $path) {
            $name = explode($dirPath . '/', $path)[1];
            if (Str::contains($name, '.'))
                array_push($files, $name);
        }
        $folders = array_merge($folders, $files);
        return $folders;
    }

    /**
     * Build doc path
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    private function buildPath($file)
    {
        $exploded = explode('/', $file);
        // Build path
        $path = '';
        if (count($exploded) > 0) {
            for ($i=0; $i < count($exploded) - 1; $i++) {
                $path .= $exploded[$i] . '/';
            }
        }
        return $path;
    }

    /**
     * Get doc content
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function getMarkDownContent($file)
    {
        $version = request()->get('version');

        $content = '';
        $apiDocPath = base_path("Api Documentation/$version/" . $file);
        $markdown = file_get_contents($apiDocPath);
        $content = Markdown::convertToHtml($markdown);
        return $this->parser($content);
    }

    /**
     * Parse doc content
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    private function parser($content)
    {
        $parseContent = '';
        // Add class on all `anchor` elements
        $parseContent = str_replace('<a', '<a class="md-link" ', $content);

        return $parseContent;
    }

    private function getDocDetails($content)
    {
        $request = '';
        $route = '';
        $route = $this->getBetween($content, '<strong>URL</strong> : <code>', '</code>');
        $request = $this->getBetween($content, '<p><strong>Method</strong> : <code>', '</code></p>');
        return compact('request', 'route');
    }

    private function getBetween($content, $start, $end)
    {
        $between = explode($start, $content);
        if (isset($between[1])){
            $between = explode($end, $between[1]);
            return $between[0];
        }
        return '';
    }
}
