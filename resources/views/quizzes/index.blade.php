@extends('layouts.noauth')

@section('content')
<div class="app-main flex-column flex-row-fluid">

    <div class="card card-flush">
        <div class="card-header py-5 d-flex justify-content-between">
            <h3 class="card-title">{{ $topic->title }} – Quizzes</h3>

            <!-- Add button (type="button") -->
            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#quizDrawer">
                Add New Quiz
            </button>
        </div>

        <div class="card-body pt-0">
            <table class="table table-row-dashed align-middle fs-6 gy-5">
                <thead>
                    <tr class="text-gray-600 fw-bold text-uppercase">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Total Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topic->quizzes as $quiz)
                    <tr data-id="{{ $quiz->id }}">
                        <td>{{ $quiz->id }}</td>
                        <td>{{ $quiz->name }}</td>
                        <td>{{ $quiz->duration_minutes }} min</td>
                        <td>{{ $quiz->total_marks }}</td>
                        <td>
                            <!-- Edit button -->
                            <button type="button" class="btn btn-warning btn-sm editQuiz"
                                data-id="{{ $quiz->id }}"
                                data-name="{{ $quiz->name }}"
                                data-duration="{{ $quiz->duration_minutes }}"
                                data-marks="{{ $quiz->total_marks }}"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#quizDrawer">
                                Edit
                            </button>

                            <!-- Delete button -->
                            <button type="button" class="btn btn-danger btn-sm deleteQuiz" data-id="{{ $quiz->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Button to open drawer -->
<button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#quizDrawer">
    Add New Quiz
</button>

<!-- Offcanvas drawer -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="quizDrawer">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add / Edit Quiz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="quizForm">
            @csrf
            <input type="hidden" name="quiz_id" id="quiz_id">

            <div class="mb-3">
                <label class="fw-bold">Quiz Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Duration (Minutes)</label>
                <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Total Marks</label>
                <input type="number" name="total_marks" id="total_marks" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Save Quiz</button>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#quizForm');

    // ------------------ Add Mode ------------------
    document.querySelector('.card-header button[data-bs-target="#quizDrawer"]').addEventListener('click', () => {
        form.reset();
        document.querySelector('#quiz_id').value = "";
        document.querySelector('.offcanvas-title').textContent = "Add Quiz";
    });

    // ------------------ Edit Mode ------------------
    document.querySelectorAll('.editQuiz').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#quiz_id').value = this.dataset.id;
            document.querySelector('#name').value = this.dataset.name;
            document.querySelector('#duration_minutes').value = this.dataset.duration;
            document.querySelector('#total_marks').value = this.dataset.marks;

            document.querySelector('.offcanvas-title').textContent = "Edit Quiz";
        });
    });

    // ------------------ Submit Form ------------------
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const quizId = document.querySelector('#quiz_id').value;
        const topicId = "{{ $topic->id }}";

        const url = quizId ? `/quizzes/${quizId}` : `/topics/${topicId}/quizzes`;
        const method = quizId ? 'POST' : 'POST'; // PUT method handled via _method
        const formData = new FormData(form);

        if(quizId) formData.append('_method', 'PUT');

        fetch(url, {
            method: method,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data); // debug
            location.reload();
        })
        .catch(err => console.error(err));
    });

    // ------------------ Delete Quiz ------------------
    document.querySelectorAll('.deleteQuiz').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm("Delete this quiz?")) return;

            fetch(`/quizzes/${this.dataset.id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(() => location.reload());
        });
    });
});
</script>

@endsection
