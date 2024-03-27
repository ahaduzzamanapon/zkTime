<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Creative Design</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    .container {
      margin-top: 50px;
    }

    #date {
      width: 200px;
    }

    .btn {
      margin-left: 10px;
    }

    table {
      background-color: #fff;
      border-collapse: collapse;
      width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
      text-align: center;
      padding: 15px;
    }

    th {
      background-color: #6c757d;
      color: #fff;
      text-transform: uppercase;
      font-size: 0.9rem;
    }

    td {
      border-bottom: 1px solid #dee2e6;
    }

    /* Eye-catching Styles */
    .input-group {
      animation: slideInDown 1s ease-out;
    }

    table {
      animation: fadeIn 1s ease-out;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-radius: 50%;
      border-top: 4px solid #ff6b6b;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: none; /* Initially hidden */
    }

    @keyframes slideInDown {
      0% {
        transform: translateY(-100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

    /* Button Animation */
    .btn {
      position: relative;
      overflow: hidden;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 300%;
      height: 300%;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transition: width 0.8s ease, height 0.8s ease, opacity 0.5s ease;
      z-index: 0;
      transform: translate(-50%, -50%);
    }

    .btn:hover::before {
      width: 0;
      height: 0;
      opacity: 0;
    }

    .btn span {
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="input-group">
          <input type="date" class="form-control" id="date">
          <div class="input-group-append">
            <button id="btn" class="btn"><span>Get Data</span></button>
            &nbsp;&nbsp;
            <button id="hit" class="btn"><span>Send Data</span></button>
          </div>
        </div>
        <div class="loader" id="loader"></div>
      </div>
    </div>
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="thead-light">
              <tr>
                <th>User ID</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody id="data"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    var rdata='' ;

    $(document).ready(function(){
      $("#btn").click(function(){
        var date = $("#date").val();
        $("#loader").show(); // Show loader before AJAX request
        $.ajax({
          url: 'api.php',
          type: 'POST',
          data: {
            date: date
          },
          success: function(response){
            var data=response;
            rdata = data;
            $("#data").empty();
            for (var i = 0; i < data.length; i++) {
              $("#data").append("<tr><td>"+data[i].id+"</td><td>"+data[i].time+"</td></tr>");
            }
          },
          complete: function(){
            $("#loader").hide(); // Hide loader when AJAX request is complete
          },
          error: function(xhr, textStatus, errorThrown) { 
            console.log("error: " + errorThrown + ", " + textStatus + ", " + xhr);
          }
        });
      });
      $("#hit").click(function(){
        if (rdata == '') {
          alert("No data to export");
            return false;
        }
        $("#loader").show(); // Show loader before AJAX request

          $.ajax({
            url: 'http://173.212.223.213/smarthr/api/admin/sendRecentPunches',
            type: 'POST',
            data: {
              data: rdata
            },
            success: function(response){
              $("#loader").hide(); // Hide loader when AJAX request is complete
              alert('Data sent successfully');
            }
          })
      })
    });
  </script>
</body>
</html>
