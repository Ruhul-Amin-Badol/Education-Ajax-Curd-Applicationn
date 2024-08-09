<!DOCTYPE html>
<html>
<head>
    <title>Education Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div id="responseMessage" class="mt-3"></div>
        
        <div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="card-body">
                <h2 class="card-title">Education Form</h2>
                <form id="educationForm">
                    <input type="hidden" id="education_id" name="education_id">
                    <div class="form-group">
                        <label for="institution_name">Institution Name:</label>
                        <input type="text" class="form-control" id="institution_name" name="institution_name" required>
                    </div>
                    <div class="form-group">
                        <label for="degree">Degree:</label>
                        <input type="text" class="form-control" id="degree" name="degree" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <!--show data in table-->
        <h2 class="mt-5">Education List</h2>
        <table class="table table-bordered shadow" id="educationList">
            <thead>
                <tr>
                    <th>Institution Name</th>
                    <th>Degree</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be appended here -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            loadEducationData();

            $('#educationForm').on('submit', function(event) {
                event.preventDefault();
                let educationId = $('#education_id').val();
                let formData = {
                    institution_name: $('#institution_name').val(),
                    degree: $('#degree').val(),
                };

                if (educationId) {
                    // Update the record
                    $.ajax({
                        url: '{{ url('/education') }}/' + educationId,
                        method: 'PUT',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                            $('#educationForm')[0].reset();
                            loadEducationData(); // Load the updated education data
                        }
                    });
                } else {
                    // Create a new record
                    $.ajax({
                        url: '{{ route('education.store') }}',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                            $('#educationForm')[0].reset();
                            loadEducationData(); // Load the updated education data
                        }
                    });
                }
            });

            function loadEducationData() {
                $.ajax({
                    url: '{{ route('education.index') }}',
                    method: 'GET',
                    success: function(response) {
                        let educationList = '';
                        response.education.forEach(function(education) {
                            educationList += '<tr>' +
                                '<td>' + education.institution_name + '</td>' +
                                '<td>' + education.degree + '</td>' +
                                '<td>' +
                                    '<button class="btn btn-warning btn-sm edit" data-id="' + education.id + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete" data-id="' + education.id + '">Delete</button>' +
                                '</td>' +
                                '</tr>';
                        });
                        $('#educationList tbody').html(educationList);
                    }
                });
            }

            $(document).on('click', '.edit', function() {
                let educationId = $(this).data('id');
                $.ajax({
                    url: '{{ url('/education') }}/' + educationId,
                    method: 'GET',
                    success: function(response) {
                        $('#education_id').val(response.education.id);
                        $('#institution_name').val(response.education.institution_name);
                        $('#degree').val(response.education.degree);
                    }
                });
            });

            $(document).on('click', '.delete', function() {
                let educationId = $(this).data('id');
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: '{{ url('/education') }}/' + educationId,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                            loadEducationData(); // Load the updated education data
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
