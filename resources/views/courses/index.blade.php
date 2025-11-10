<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { background-color: #f8f9fa; }
        .alert-position { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .table-hover tbody tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 fw-bold text-primary">Course Management</h2>

    <!-- Alert -->
    <div id="alertBox" class="alert alert-success alert-position d-none"></div>

    <!-- Form -->
    <form id="courseForm" class="mb-4 shadow p-4 bg-white rounded">
        @csrf
        <input type="hidden" id="course_id">

        <div class="row">
            <div class="col-md-4 mb-3">
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter Course Title" required>
            </div>

            <div class="col-md-4 mb-3">
                <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter Slug" required>
            </div>

            <div class="col-md-4 mb-3">
                <input type="text" id="description" name="description" class="form-control" placeholder="Enter Description" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="saveBtn">Add Course</button>
    </form>

    <!-- Table -->
    <table class="table table-bordered table-striped table-hover align-middle bg-white shadow-sm rounded" id="courseTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course as $c)
            <tr data-id="{{ $c->id }}">
                <td>{{ $c->id }}</td>
                <td>{{ $c->title }}</td>
                <td>{{ $c->slug }}</td>
                <td>{{ $c->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {

    // ✅ Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ✅ Show alert
    function showAlert(message) {
        $('#alertBox').text(message).removeClass('d-none').fadeIn();
        setTimeout(() => $('#alertBox').fadeOut(), 2000);
    }

    // ✅ Add / Update Course
    $('#courseForm').on('submit', function(e) {
        e.preventDefault();

        let id = $('#course_id').val();
        let url = id ? `/courses/${id}` : `{{ route('courses.store') }}`;
        let data = {
            title: $('#title').val(),
            slug: $('#slug').val(),
            description: $('#description').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        if (id) data._method = 'PUT';

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(res) {
                $('#courseForm')[0].reset();
                $('#course_id').val('');
                $('#saveBtn').text('Add Course');
                loadCourses();
                showAlert(res.message);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Something went wrong. Check console.');
            }
        });
    });

    // ✅ Load Courses (refresh table)
    function loadCourses() {
        $.get("{{ route('courses.index') }}", function(data) {
            let tbody = '';
            $(data.courses || data).each(function(_, c) {
                tbody += `
                    <tr data-id="${c.id}">
                        <td>${c.id}</td>
                        <td>${c.title}</td>
                        <td>${c.slug}</td>
                        <td>${c.description}</td>
                        <td>
                            <button class="btn btn-sm btn-warning editBtn">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                        </td>
                    </tr>`;
            });
            $('#courseTable tbody').html(tbody);
        });
    }

    // ✅ Edit
    $(document).on('click', '.editBtn', function() {
        let tr = $(this).closest('tr');
        $('#course_id').val(tr.data('id'));
        $('#title').val(tr.find('td:eq(1)').text());
        $('#slug').val(tr.find('td:eq(2)').text());
        $('#description').val(tr.find('td:eq(3)').text());
        $('#saveBtn').text('Update Course');
    });

    // ✅ Delete
    $(document).on('click', '.deleteBtn', function() {
        if(!confirm('Are you sure?')) return;

        let id = $(this).closest('tr').data('id');

        $.ajax({
            url: `/courses/${id}`,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                loadCourses();
                showAlert(res.message);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Something went wrong. Check console.');
            }
        });
    });

});
</script>

</body>
</html>
