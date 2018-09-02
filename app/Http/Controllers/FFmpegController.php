<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

class FFmpegController extends Controller
{
    //

    public function joinvideo($video1, $video2, $output)
    {
        $temp1 = public_path('temp/intermediate1.ts');
        $temp2 = public_path('temp/intermediate2.ts');

        $video1 = public_path($video1);
        $video2 = public_path($video2);
        $video3 = public_path($output);
        if (File::exists($video3)){
            File::delete($video3);
        } 
        $ffmpegpath = base_path("ffmpeg/ffmpeg.exe");
        $cmd1 = "$ffmpegpath -i $video1 -c copy -bsf:v h264_mp4toannexb -f mpegts temp/intermediate1.ts";
        exec($cmd1);
        $cmd2 = "$ffmpegpath -i $video2 -c copy -bsf:v h264_mp4toannexb -f mpegts temp/intermediate2.ts";
        exec($cmd2);
        $cmd = "$ffmpegpath -i ".'"'."concat:$temp1|$temp2".'"'." -c copy -bsf:a aac_adtstoasc $video3";
        // print_r($cmd);
        exec($cmd);
        $video = $output;

        if (File::exists($temp1)){
            File::delete($temp1);
        } 
        if (File::exists($temp2)){
            File::delete($temp2);
        }  

        return $video;
    }

    public function convertImagetoVideo($clip, $outputpath)
    {
        $clippath = public_path('images/'.$clip['filename']);
        $outpath = public_path($outputpath);
        $temppath = public_path('temp/tempout.mp4');
        if (File::exists($outpath)){
            File::delete($outpath);
        } 

        $ffmpegpath = base_path("ffmpeg/ffmpeg.exe");
        $duration = $clip['duration']?$clip['duration']:1;
        // $str = "$ffmpegpath -t $duration -i $clippath $outpath";
        $str = "$ffmpegpath -loop 1 -i $clippath -c:v libx264 -t $duration -pix_fmt yuv420p $temppath";
        // print_r($str);
        exec($str);
        $title = $clip['title'];
        $str = "$ffmpegpath -i $temppath -filter_complex ".'"'."[0:v]drawtext=fontfile=Lato-Light.ttf:text='$title':fontsize=100:fontcolor=d40a0a:alpha='if(lt(t,2),0,if(lt(t,3),(t-2)/1,if(lt(t,8),1,if(lt(t,9),(1-(t-8))/1,0))))':x=(w-text_w)/2:y=(h-text_h)/2".'"' ." $outpath";
        // print_r($str);
        exec($str);

        if (File::exists($temppath)){
            File::delete($temppath);
        }
        return $outputpath;
    }
    public function preview()
    {
        $clippath = public_path('images/%1d.jpg');
        $outpath = 'temp/out.mp4';
        
        $clips=\App\Clip::all();
        $testclip1 = $clips[0];
        $testclip2 = $clips[1];

        $outputpath1 = "temp/out1.mp4";
        $video1 = self::convertImagetoVideo($testclip1, $outputpath1);
        $outputpath2 = "temp/out2.mp4";
        $video2 = self::convertImagetoVideo($testclip2, $outputpath2);
        

        $video = self::joinvideo($video1, $video2, $outpath);
        $video = url($video);
        return view('preview',compact('video'));
    }
}
