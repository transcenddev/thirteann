<?php
    // Checks if the user is an admin
    require "../config/admin-authentication.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/admin-sidebar.css">
    <link rel="stylesheet" href="../styles/hrm.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
    <!-- Add Staff Modal -->
    <div class="modal fade" id="staffAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="saveStaff" action="">
                    <div class="modal-body">

                        <div id="errorMessageSave" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Contact Number</label>
                            <input type="number" name="contact_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="role">Role</label>
                            <select name="role" class="form-control">
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Save Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="staffEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="updateStaff" action="">
                    <div class="modal-body">

                        <div id="errorMessageSave" class="alert alert-warning d-none"></div>

                        <input type="hidden" name="user_id" id="user_id">

                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Contact Number</label>
                            <input type="tel" name="contact_number" id="contact_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigator -->
    <?php require "../config/admin-sidebar.php"; ?>

    <div class="main-content">
        <div class="main-header d-flex justify-content-between align-items-center m-4">
            <h1>Staff Management</h1>

            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#staffAddModal">Add Staff</button>
        </div>
        
        <div class="table-section">
            <table class="table" id="staff_table">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Contact Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Get All Staff Data and Populate to Table with Actions -->
                    <?php
                        require '../config/config.php';

                        $stmt = $mysqli->prepare("SELECT user_id, name, email, role, contact_number FROM staff_table");
                        $stmt->execute();
                        $stmt->bind_result($user_id, $name, $email, $role, $contact_number);

                        while ($stmt->fetch()) {
                            echo "<tr>";
                            echo "<td data-cell='User ID'>$user_id</td>";
                            echo "<td data-cell='Name'>$name</td>";
                            echo "<td data-cell='Email'>$email</td>";
                            echo "<td data-cell='Role'>$role</td>";
                            echo "<td data-cell='contact Number'>$contact_number</td>";
                            echo "<td data-cell='Action' class='d-flex justify-content-between g-3 w-50'>
                                    <button class='btn edit-btn' data-bs-toggle='modal' data-bs-target='#staffEditModal' data-user-id='$user_id'> <i class='bx bx-edit-alt'></i> </button>

                                    <button class='btn delete-btn' data-user-id='$user_id'> <i class='bx bx-trash' > </i></button>
                                </td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Change table to DataTable of jQuery
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#staff_table')) {
                $('#staff_table').DataTable().destroy();
            }

            $('#staff_table').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
            });
        }

        $(document).ready(function () {
            initializeDataTable();
        });

        // add Staff
        $(document).on('submit', '#saveStaff', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_staff", true);
            
            $.ajax({
                type: "POST",
                url: "../config/hrm-function.php",
                data: formData,        
                processData: false,
                contentType: false,
                success: function (response) {

                    var res = JSON.parse(response);
                    if (res.status == 422) {
                        $("#errorMessageSave").removeClass('d-none');
                        $("#errorMessageSave").text(res.message);
                    } else if (res.status == 200) {
                        $("#errorMessageSave").addClass('d-none');
                        $('#staffAddModal').modal('hide');
                        $('#saveStaff')[0].reset();

                        alertify.set('notifier','position', 'bottom-right');
                        alertify.success(res.message);

                        // Destroy the DataTable instance
                        $('#staff_table').DataTable().destroy();

                        // Reload the page
                        location.reload(true);
                    }
                }
            });
        });

        // fetch data for editing
        $(document).on('click', '.edit-btn', function () {
            var userId = $(this).data('user-id');

            $.ajax({
                type: "GET",
                url: "../config/hrm-function.php",
                data: { user_id: userId },
                success: function (response) {
                    var res = JSON.parse(response);

                    if (res.status == 422) {
                        alert(res.message);
                    } else if (res.status == 200) {   
                        // Populate the form fields in the Edit Staff modal
                        $('#user_id').val(res.data.user_id);
                        $('#name').val(res.data.name);
                        $('#email').val(res.data.email);
                        $('#password').val(res.data.password);
                        $('#contact_number').val(res.data.contact_number);

                        // Create and select the correct role option dynamically
                        var roleValue = res.data.role;
                        $('#role').val(roleValue);

                        // Show the Edit Staff modal
                        $('#staffEditModal').modal('show');
                    } else {
                        alertify.error(res.message);
                    }
                }
            });
        });

        // update Staff
        $(document).on('submit', '#updateStaff', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_staff", true);

            $.ajax({
                type: "POST",
                url: "../config/hrm-function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                 
                    var res = JSON.parse(response);

                    if (res.status == 422) {
                        $("#errorMessageUpdate").removeClass('d-none');
                        $("#errorMessageUpdate").text(res.message);
                    } else if (res.status == 200) {
                        $("#errorMessageUpdate").addClass('d-none');
                        $('#staffEditModal').modal('hide');
                        $('#updateStaff')[0].reset();

                        alertify.set('notifier','position', 'bottom-right');
                        alertify.success(res.message);

                        // Destroy the DataTable instance
                        $('#staff_table').DataTable().destroy();

                        // Reload the page
                        location.reload(true);
                    }
                }
            });
        });

        // delete Staff
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var userId = $(this).data('user-id');

                $.ajax({
                    type: "POST",
                    url: "../config/hrm-function.php",
                    data: {
                        'delete_staff': true,
                        'user_id': userId,
                    },
                    success: function (response) {

                        var res = JSON.parse(response);

                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier','position', 'bottom-right');
                            alertify.success(res.message);

                            // Destroy the DataTable instance
                            $('#staff_table').DataTable().destroy();

                            // Reload the page
                            location.reload(true);
                        }
                    }
                });
            }
        });


    </script>
</body>
</html>
