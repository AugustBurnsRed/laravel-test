<html>
<body>



@foreach($posts as $post)
 <div>
  <h2>{{ $post->title }}</h2>
  <div>{{ $post->description }}</div>
  <!--<div><small>{{ $post->tags }}</small></div>-->
 </div>
@endforeach
</body>
</html>

