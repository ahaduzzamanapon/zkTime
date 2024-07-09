<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User List</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      margin-top: 50px;
      max-width: 800px;
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

    h1 {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>User List</h1>
    <button id="add-user-button" class="btn btn-primary" style="float: inline-end;">Add User</button>
    <button id="get-user-list-button" class="btn btn-primary">Get User List</button>
    <a href="index.php"  class="btn btn-primary">Attendance</a>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
      <thead>
        <tr>
          <th>UID</th>
          <th>Name</th>
          <th>Role</th>
          <th>Password</th>
        </tr>
      </thead>
      <tbody id="user-list">
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addUserForm">
            <!-- <div class="form-group">
              <label for="uid">UID</label>
              <input type="text" class="form-control" id="uid" name="uid" placeholder="Enter UID">
            </div> -->
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="add-user-button" class="btn btn-primary">Add User</button>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    // Add User Modal
    $("#add-user-button").click(function() {
      $("#addUserModal").modal("show");
    });

    // Add User API
    $("#addUserModal .btn-primary").click(function() {
      $.ajax({
        url: 'add_user.php',
        type: 'POST',
        data: $("#addUserForm").serialize(),
        success: function(response) {
          if (response.success) {
            $("#addUserModal").modal("hide");
            getUserList();
          } else {
            console.error("Error:", response.error);
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error("Error:", errorThrown);
        }
      });
    });

    // Get User List API
    function getUserList() {
      $.ajax({
        url: 'get_user.php',
        type: 'POST',
        success: function(response) {
          $("#user-list").empty();
          response.forEach(function(user) {
            $("#user-list").append(`
              <tr>
                <td>${user[0]}</td>
                <td>${user[1]}</td>
                <td>${user[2]}</td>
                <td>${user[3]}</td>
              </tr>
            `);
          });
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error("Error:", errorThrown);
        }
      });
    }

    $("#get-user-list-button").click(function() {
      getUserList();
    });
  </script>

  <script>
    $(document).ready(function() {
      getUserList();
    });
  </script>
</body>
</html>

