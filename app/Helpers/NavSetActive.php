 <?php 
use Illuminate\Support\Str;
 /*
  Sets active class on navigation.
*/
function setActive($path, $active = 'active') {
  return  Str::contains(Request::path(), $path) ? $active : '';
}