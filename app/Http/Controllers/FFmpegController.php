<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

class FFmpegController extends Controller
{
    //
    public function joinmp4()
    {
        $video = "images/out.mp4";
        return $video;
    }
    public function preview()
    {
        $clippath = public_path('images/%1d.jpg');
        $outpath = public_path('images/out.mp4');
        
        // if (File::exists($outpath)){
        //     File::delete($outpath);
        //     // unlink($outpath);
        // }
        
        
        // $drive = public_path('drive\ffmpeg\bin');
        // $clippath = url('/')."/clips";
        $ffmpegpath = base_path("ffmpeg/ffmpeg.exe");
        
        
        // $str = "$ffmpegpath -r 0.5 -i $clippath $outpath";
        // $result = exec($str);
        // exec($str);
        // echo $str;
        $video = self::joinmp4();
        return view('preview',compact('video'));
    }
}
