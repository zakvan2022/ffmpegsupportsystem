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
        <video width="70%" height="70%" controls>
            <source src="{{$video}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
  </body>
</html>