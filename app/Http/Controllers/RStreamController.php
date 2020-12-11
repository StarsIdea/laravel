<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\ArrayToXml\ArrayToXml;
use SimpleXMLElement;

class RStreamController extends Controller
{
    public function __construct(){}

    public function getData(){
        $result = DB::select('SELECT rtmp.streams.*,data.name FROM rtmp.streams JOIN rtmp.data ON rtmp.streams.user = data.username ORDER BY created DESC LIMIT 20');
        $array = [];
        for($i = 0; $i < count($result); $i ++){
            $array[$i] = (array)$result[$i];
        }
        $content = ['stream' => $array];
        $response_data = ArrayToXml::convert(['streams' =>$content]);
        return response($response_data, 200)->header('Content-Type', 'text/xml');
    }
}
