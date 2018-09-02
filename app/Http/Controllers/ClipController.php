<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ClipController extends Controller
{
    //
    public function index()
    {
        $clips=\App\Clip::all();
        return view('index',compact('clips'));
    }

    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        $clip = \App\Clip::find($id);
        return view('edit',compact('clip','id'));
    }

    public function store(Request $request)
    {
        if($request->hasfile('filename'))
        {
            $file = $request->file('filename');
            // print($file);return;
            $name=time().".jpg";
            $file->move(public_path().'/images/', $name);
        }
        $clip= new \App\Clip;
        $clip->title=$request->get('title');
        $clip->duration=$request->get('duration');
        $clip->type=$request->get('type');
        
        $clip->filename=$name;
        // print_r($request);
        $clip->save();
       
        return redirect('clips')->with('success', 'Information has been added');
    }
    public function update(Request $request, $id)
    {
        $clip= \App\Clip::find($id);
        if($request->hasfile('filename'))
        {
            $file = $request->file('filename');
            $name=time();
            $file->move(public_path().'/images/', $name);
            $clip->filename=$name;
        }
        $clip->title=$request->get('title');
        $clip->type=$request->get('type');
        $clip->duration=$request->get('duration');
        $clip->save();
        return redirect('clips');
    }

    public function destroy($id)
    {
        $clip = \App\Clip::find($id);
        $clip->delete();
        return redirect('clips')->with('success','Information has been  deleted');
    }
}
