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
        // return $request;
        $ip = $request->ip;
        $port = $request->port;
        $from = $request->from;
        $to = $request->to;
        // return "ip: " . $ip . "port: " . $port . "from: " . $from . "to: " . $to;
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
