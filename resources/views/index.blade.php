<!-- index.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
  </head>
  <body>
    <div class="container">
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
    <a href="{{action('ClipController@create')}}" class="btn btn-success">Create</a>
    <a href="{{action('FFmpegController@preview')}}" class="btn btn-warning">Preview</a>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Filename</th>
        <th>Title</th>
        <th>Duration</th>
        <th>Type</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($clips as $clip)
      <tr>
        <td>{{$clip['id']}}</td>
        <td>{{$clip['filename']}}</td>
        <td>{{$clip['title']}}</td>
        <td>{{$clip['duration']}}</td>
        <td>{{$clip['cliptype']}}</td>
        
        <td><a href="{{action('ClipController@edit', $clip['id'])}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{action('ClipController@destroy', $clip['id'])}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  </body>
</html>