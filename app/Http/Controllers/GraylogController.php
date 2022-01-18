<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GraylogController extends Controller
{
    public function index()
    {
        $apiURL = 'https://jsonplaceholder.typicode.com/posts';

        $response = Http::get($apiURL);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        dd($responseBody);
    }

    /**
     * Using GuzzleHttp
     *
     * @return response()
     */
    public function show(Request $request)
    {
        $ip = $request->input('ip');
        $port = $request->input('port');
        $from = $request->input('from');
        $to = $request->input('to');
        // return ($request);


        // headers: { "X-Requested-By": "ndandrea" },
        // auth: { username: "ndandrea", password: "changeme" },
        // return (('http://192.168.7.120:9000/api/search/universal/absolute?query='.$ip.'%20AND%20'.$port.'&from='.$from.'%2000%3A00%3A00&to='.$to.'%2000%3A00%3A00&fields=message&decorate=true'));
        $response = Http::withHeaders(['X-Requested-By' => 'ndandrea'])
        ->withBasicAuth('ndandrea', 'changeme')
        ->get(('http://192.168.7.120:9000/api/search/universal/absolute?query='.$ip.'%20AND%20'.$port.'&from='.$from.'%2000%3A00%3A00&to='.$to.'%2000%3A00%3A00&fields=message&decorate=true'));

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $response;

        dd($responseBody);
    }
}
