<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    apnd
  </title>
  <script src="jquery.min.js" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      var i = 1;
      $('.add_field').click(function() {
        var htmldata = '<div>Name<input type="text" name="cname[]">Mobile Number<input type="text"name="mob[]"> Gender<input type="radio" name="gender[' + i + ']" value="M">Male<input type="radio" name="gender[' + i + ']" value="F">Female Address<textarea name="address[]"></textarea><input type="button" class="remove_field" value="remove"></div>';
        i++;
        $('.wrapper').append(htmldata);
      });
      $('.wrapper').on('click', '.remove_field', function() {
        $(this).parent('div').remove();
        i--;
      });
    });
  </script>
</head>

<body>
  <div class="container">
    <form method="post" action="">
      <div class="wrapper">
        <div>
          Name<input type="text" name="cname[]">
          Mobile Number<input type="text" name="mob[]">
          Gender<input type="radio" name="gender[0]" value="M">Male
          <input type="radio" name="gender[0]" value="F">Female
          Address<textarea name="address[]"></textarea>
          <input type="button" class="add_field" value="Add">
        </div>
      </div>
      <input type="submit" name="sub" value="Save">
    </form>
</body>

</html>