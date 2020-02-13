<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $clientIP = '27.109.17.18';
        $host = "58f755eb75f7b.streamlock.net";
        $url= "https://".$host."/";
        $stream = "testapp/st/mp4:amazons3/ts-esense/MSB/Video/64174.mp4";
        $start = time();
        $end = strtotime("+5000 minutes");
        $secret = "cdc907f88d1315d2";
        $tokenName = "wowzatoken";
        $hash = "";
        
        if(is_null($clientIP))
        {
            $hash = hash('sha256', $stream."?".$secret."&{$tokenName}endtime=".$end."&{$tokenName}starttime=".$start, true); // generate the hash string
        
        }
        else
        {
            $hash = hash('sha256', $stream."?".$clientIP."&".$secret."&{$tokenName}endtime=".$end."&{$tokenName}starttime=".$start, true); // generate the hash string
        }
        
        $base64Hash = strtr(base64_encode($hash), '+/', '-_');
        
        $params = array("{$tokenName}starttime=".$start, "{$tokenName}endtime=".$end, "{$tokenName}hash=".$base64Hash);
        
        sort($params);
        $playbackURL = $url.$stream."/manifest.m3u8?";
        
        if(preg_match("/(rtmp)/",$url))
        {
            $playbackURL = $url.$stream."/manifest.m3u8?";
        }
        
        foreach($params as $entry)
        {
            $playbackURL.= $entry."&";
        }
        
        $playbackURL = preg_replace("/(\&)$/","", $playbackURL);
        return $playbackURL;
    }
}
