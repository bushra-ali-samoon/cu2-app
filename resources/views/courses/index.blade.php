@extends('layouts.app')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <main class="app-content flex-column-fluid" id="kt_app_content">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!-- Card -->
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <h3 class="card-title">Course Management</h3>
                        <div class="card-toolbar">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                                Add New Course
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="coursesTable">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr data-id="{{ $course->id }}">
                                        <td>{{ $course->id }}</td>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ $course->slug }}</td>
                                        <td>{{ $course->description }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editCourse" 
                                                data-id="{{ $course->id }}"
                                                data-title="{{ $course->title }}"
                                                data-slug="{{ $course->slug }}"
                                                data-description="{{ $course->description }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteCourse" data-id="{{ $course->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Card -->

            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="courseForm" class="modal-content">
            @csrf
            <input type="hidden" name="course_id" id="course_id">
            <div class="modal-header">
                <h5 class="modal-title">Add / Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Course</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseForm = document.querySelector('#courseForm');

    // Open Add Modal
    document.querySelector('button[data-bs-target="#addCourseModal"]').addEventListener('click', function(){
        courseForm.reset();
        document.querySelector('#course_id').value = '';
        document.querySelector('.modal-title').textContent = 'Add Course';
    });

    // Open Edit Modal
    document.querySelectorAll('.editCourse').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            document.querySelector('#course_id').value = id;
            document.querySelector('#title').value = this.dataset.title;
            document.querySelector('#slug').value = this.dataset.slug;
            document.querySelector('#description').value = this.dataset.description;
            document.querySelector('.modal-title').textContent = 'Edit Course';

            const modalEl = document.getElementById('addCourseModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });
    });

    // Add / Edit AJAX
    courseForm.addEventListener('submit', function(e){
        e.preventDefault();
        const id = document.querySelector('#course_id').value;
        const url = id ? `/courses/${id}` : '{{ route("courses.store") }}';
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(courseForm);

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.message){
                const modalEl = document.getElementById('addCourseModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                location.reload();
            } else {
                alert('Error saving course');
            }
        })
        .catch(err => console.log(err));
    });

    // Delete Course
    document.querySelectorAll('.deleteCourse').forEach(btn => {
        btn.addEventListener('click', function(){
            if(!confirm('Are you sure you want to delete this course?')) return;
            const id = this.dataset.id;
            fetch(`/courses/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.message){
                    this.closest('tr').remove();
                } else {
                    alert('Error deleting course');
                }
            });
        });
    });
});
</script>
@endsection
