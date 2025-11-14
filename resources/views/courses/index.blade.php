@extends('layouts.noauth')
@section('title', 'Courses')

@section('form')
<div class="container py-5">
    <!-- Toggle Button -->
    <div class="d-flex justify-content-end mb-4">
        <button id="toggleViewBtn" class="btn btn-outline-primary">
            📋 Show All Courses
        </button>
    </div>

    <!-- Add Course Form -->
    <div id="addCourseForm" class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 fw-bold">➕ Add New Course</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter course title" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="course-slug" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Brief course description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary px-4">
                    💾 Save Course
                </button>
            </form>
        </div>
    </div>

    <!-- Courses Table -->
    <div id="coursesTable" class="card shadow-sm border-0" style="display:none;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0 fw-bold">📚 All Courses</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase text-muted fw-bold">
                            <th class="ps-4">ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $course->id }}</td>
                            <td class="fw-semibold text-primary">{{ $course->title }}</td>
                            <td><code class="text-muted">{{ $course->slug }}</code></td>
                            <td class="text-muted">{{ Str::limit($course->description, 50) }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-outline-warning me-1">✏️ Edit</a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No courses found. Add your first course!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleViewBtn');
    const formDiv = document.getElementById('addCourseForm');
    const tableDiv = document.getElementById('coursesTable');

    // Initialize - make sure table is hidden on load
    tableDiv.style.display = 'none';
    formDiv.style.display = 'block';

    // Check if there's a hash in URL to show table
    if(window.location.hash === '#courses') {
        showTableView();
    }

    toggleBtn.addEventListener('click', function () {
        if(formDiv.style.display !== 'none') {
            showTableView();
        } else {
            showFormView();
        }
    });

    function showTableView() {
        formDiv.style.display = 'none';
        tableDiv.style.display = 'block';
        toggleBtn.innerHTML = '➕ Add New Course';
        toggleBtn.classList.remove('btn-outline-primary');
        toggleBtn.classList.add('btn-outline-success');
        window.history.replaceState(null, null, '#courses');
    }

    function showFormView() {
        formDiv.style.display = 'block';
        tableDiv.style.display = 'none';
        toggleBtn.innerHTML = '📋 Show All Courses';
        toggleBtn.classList.remove('btn-outline-success');
        toggleBtn.classList.add('btn-outline-primary');
        window.history.replaceState(null, null, ' ');
    }
});
</script>

<style>
.card {
    border-radius: 12px;
}
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
}
.table tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.02);
}
.btn {
    border-radius: 8px;
    font-weight: 500;
}
</style>
@endsection