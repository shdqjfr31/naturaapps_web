<!DOCTYPE html>
<html>

<head>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script type="text/javascript" language="javascript" src="js/jQuery-3.5.1/jquery-3.5.1.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".f").submit(function() {
        alert("cuy");
      });
    });
  </script>
</head>

<body>

  <form action="" class="f">
    First name: <input type="text" name="FirstName" value="Mickey"><br>
    Last name: <input type="text" name="LastName" value="Mouse"><br>
    <button type="submit" value="Submit">yeyeye</button>
  </form>

</body>

</html>