<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staffShip) {
            auth()->user()->staffShip = false;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->staffShip = true;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }

    public static function cacheHits()
    {
        $cache = Cache::getStore()->getMemcached()->getAllKeys();

        return view('site.cache', [
            'cache' => array_reverse($cache),
        ]);
    }

    public static function commitData()
    {
        $client = new Client(['http_errors' => false]);
        $commit = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/repository/commits', [
            'query' => [
                'per_page' => 1,
            ],
        ]);

        if ($commit->getStatusCode() === 200) {
            return view('site.commit', [
                'commit' => json_decode($commit->getBody()->getContents())[0],
            ]);
        } else {
            return 'Something went wrong!';
        }
    }

    public static function ciData()
    {
        $client = new Client(['http_errors' => false]);
        $ci = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/pipelines', [
            'query' => [
                'per_page' => 1,
                'ref' => 'main',
            ],
        ]);

        if ($ci->getStatusCode() === 200) {
            return view('site.ci', [
                'ci' => json_decode($ci->getBody()->getContents())[0],
            ]);
        } else {
            return 'Something went wrong!';
        }
    }

    public static function deploymentData()
    {
        $client = new Client(['http_errors' => false]);
        $deployments = $client->request('GET', 'https://gitlab.com/api/v4/projects/25370928/pipelines', [
            'query' => [
                'per_page' => 5,
                'ref' => 'master',
            ],
        ]);

        if ($deployments->getStatusCode() === 200) {
            return view('site.deployment', [
                'deployments' => json_decode($deployments->getBody()->getContents()),
            ]);
        } else {
            return 'Something went wrong!';
        }
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'K', 'M', 'G', 'T'];

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }

    public static function system()
    {
        $contents = file_get_contents('/proc/meminfo');
        preg_match_all('/(\w+):\s+(\d+)\s/', $contents, $matches);
        $meminfo = array_combine($matches[1], $matches[2]);

        return view('admin.system', [
            'meminfo' => $meminfo,
        ]);
    }
}
