<!DOCTYPE html>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var i = 1;
      $('#add').click(function() {
        i++;
        $('#dynamic_field_1').append('<tr id="row' + i + '"><td><input type="datetime-local" class="form-control form-control-sm" name="" id=""></td><td><input type="text" class="form-control form-control-sm" name="" id=""></td>' +
          '<td><center><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm">x</button></center></td></tr>');
      });

      $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
        // $('#row2' + button_id + '').remove();
      });



    });

    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#row' + button_id + '').remove();
      // $('#row2' + button_id + '').remove();
    });

    $(document).ready(function() {
      var id = 1;
      $('.coba').click(function() {
        // id = 1;
        id++;
        console.log("Hello guys")
        var new_add = 'testermasuk';
        var new_add2 = 'testermasuk2';
        $('<td id="td-last' + id + '">' + new_add + '</td>')
          .insertAfter($('[id^="td-last"]').last());
        // $('<td id="td-lastses' + id + '">' + new_add2 + '</td>')
        //   .insertAfter($('[id^="td-lastses"]').last());
        // $("<td>Hello world!</td>").insertAfter("td");
        // $(this).closest('.main').nextUntil('.main:not(.reply)').addBack().last().after(new_add);
      });

    });




    $(document).ready(function() {
      $("#span").click(function() {
        console.log('Hello');
        $("<span>Hello world!</span>").insertAfter("p");
      });
    });

    // $('.coba').on('click', function() {
    //   console.log("Hello");
    //   var new_add = '<tr><td>testermasuk</td></tr>';
    //   $(this).parents('table.main').next('.main:last').append(new_add);
    // });

    $('#coba').on('click', function() {
      console.log('Hello');
      // var new_add = '<div class="new">xxx</div>';
      // $(this).closest('.main').nextUntil('.main:not(.reply)').addBack().last().after(new_add);

      function log() {
        console.log('Hello');
      };

    });


    // $('#AddNextElement' + id).click(function(e) {
    //   $('<div id="NextElement' + id + '">' + /*Add after the last element*/ +'</div>').insertAfter($("#FirstElement"));
    // });

    // $('<div id="td-last"' + id + '>' + tes + '</div>')
    //   .insertAfter($('[id^="td-last"]').last());
  </script>
</head>

<body>
  <div class="find">
    <div id="FirstElement">
      <!-- /*First element loaded first */  -->
    </div>
  </div>

  <button id="span">Insert span element after each p element</button>
  <button class="coba" id="coba">Tekan</button>
  <button onclick="log()">Click me!</button>

  <p>This is a paragraph.</p>
  <p>This is another paragraph.</p>

  <table class="main" border="1">
    <tr>
      <td>tes1</td>
      <td id="td-last">tes2</td>
    </tr>
    <tr>
      <td>tes21</td>
      <td id="td-lastses">tes22</td>
    </tr>
    <tr>
      <td>tes31</td>
      <td>tes32</td>
    </tr>
  </table>

</body>

</html>