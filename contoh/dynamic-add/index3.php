<!DOCTYPE html>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var i = 1;
      var n = 0;
      $("#tambah").click(function() {
        i++;
        n++;
        // console.log(n);
        // console.log($(i).length);
        // $("#1").append("<th>Aksi" + i + "</th>");
        // $("#1").after("<th>Aksi" + i + "</th>");
        // $("#2").after("<th>Aksi" + i + "</th>");
        // $("#3").after("<th>Aksi" + i + "</th>");
        // $("<td>Kurang" + i + "</td>").append("#2");
        // $("<td>Kurang" + i + "</td>").appendTo("#3");
        $('<th class="appnd_horizon' + i + '" style="text-align:center;font-weight:bolder;" id="th-las' + i + '">Aksi' + i + '</th>')
          .insertAfter($('[id="th-las' + n + '"]').last());
        $('<td class="appnd_horizon' + i + '" id="td-last' + i + '">Aksi' + i + '</td>')
          .insertAfter($('[id="td-last' + n + '"]').last());
        $('<td class="appnd_horizon' + i + '" id="td-lasts' + i + '">Aksi' + i + '</td>')
          .insertAfter($('[id="td-lasts' + n + '"]').last());

        console.log($('#th-las' + n + '').length);
      });
      $(document).on('click', '#hapus', function() {
        // var button_id = $(this).attr("class");
        $('.appnd_horizon' + i + '').remove();
        n--;
        i--;
        // console.log(button_id);
        // $('#row2' + button_id + '').remove();
      });
    });
  </script>
</head>

<body>

  <button id="tambah">Click</button>
  <button id="hapus">Hapus</button>
  <br>
  <table width="300px" border="1">
    <tr>
      <th style="text-align:center;font-weight:bolder;">Data</th>
      <th id="th-las1" style="text-align:center;font-weight:bolder;">Aksi1</th>
    </tr>
    <tr>
      <td>Kosmo</td>
      <td id="td-last1">tambah</td>
    </tr>
    <tr>
      <td>udin</td>
      <td id="td-lasts1">tambah</td>
    </tr>
  </table>

</body>

</html>