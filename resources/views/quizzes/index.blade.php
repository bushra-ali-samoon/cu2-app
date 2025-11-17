@extends('layouts.noauth')

@section('content')
<div class="app-main flex-column flex-row-fluid">

    <div class="card card-flush py-5 px-5">

        <h3 class="card-title mb-4">{{ $topic->title }} – Quizzes</h3>

        <!-- QUIZ FORM -->
        <form id="quizForm" class="mb-5 needs-validation" novalidate>
            @csrf
            <input type="hidden" name="quiz_id" id="quiz_id">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label fw-bold">Quiz Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter quiz name" required>
                    <div class="invalid-feedback">Please enter a quiz name.</div>
                </div>

                <div class="col-md-4">
                    <label for="duration_minutes" class="form-label fw-bold">Duration (Minutes)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" placeholder="e.g. 30" required min="1">
                    <div class="invalid-feedback">Please enter duration in minutes.</div>
                </div>

                <div class="col-md-4">
                    <label for="total_marks" class="form-label fw-bold">Total Marks</label>
                    <input type="number" name="total_marks" id="total_marks" class="form-control" placeholder="e.g. 100" required min="1">
                    <div class="invalid-feedback">Please enter total marks.</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2">Save Quiz</button>
                <button type="button" id="resetBtn" class="btn btn-secondary">Reset</button>
            </div>
        </form>

        <!-- QUIZ TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle fs-6 gy-5">
                <thead class="table-light text-uppercase fw-bold text-gray-600">
                    <tr>
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
                            <button type="button" class="btn btn-warning btn-sm editQuiz"
                                data-id="{{ $quiz->id }}"
                                data-name="{{ $quiz->name }}"
                                data-duration="{{ $quiz->duration_minutes }}"
                                data-marks="{{ $quiz->total_marks }}">
                                Edit
                            </button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#quizForm');

    // Bootstrap 5 validation
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);

    // RESET form
    document.getElementById('resetBtn').addEventListener('click', function() {
        form.reset();
        form.classList.remove('was-validated');
        document.querySelector('#quiz_id').value = "";
    });

    // EDIT MODE
    document.querySelectorAll('.editQuiz').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#quiz_id').value = this.dataset.id;
            document.querySelector('#name').value = this.dataset.name;
            document.querySelector('#duration_minutes').value = this.dataset.duration;
            document.querySelector('#total_marks').value = this.dataset.marks;
        });
    });

   
   
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#quizForm');

    // RESET form
    document.getElementById('resetBtn').addEventListener('click', function() {
        form.reset();
        form.classList.remove('was-validated');
        document.querySelector('#quiz_id').value = "";
    });

    // EDIT MODE
    document.querySelectorAll('.editQuiz').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#quiz_id').value = this.dataset.id;
            document.querySelector('#name').value = this.dataset.name;
            document.querySelector('#duration_minutes').value = this.dataset.duration;
            document.querySelector('#total_marks').value = this.dataset.marks;
        });
    });

    // SUBMIT FORM (AJAX)
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Bootstrap validation
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return; // stop if invalid
        }

        const quizId = document.querySelector('#quiz_id').value;
        const topicId = "{{ $topic->id }}";

        const url = quizId ? `/quizzes/${quizId}` : `/topics/${topicId}/quizzes`;
        const formData = new FormData(form);

        if (quizId) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('Quiz saved successfully!');
                location.reload(); // reload table
            } else {
                alert(data.message || 'Error saving quiz');
            }
        })
        .catch(err => console.error('Error:', err));
    });

    // DELETE QUIZ
    document.querySelectorAll('.deleteQuiz').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm("Delete this quiz?")) return;

            fetch(`/quizzes/${this.dataset.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(() => location.reload())
            .catch(err => console.error('Delete error:', err));
        });
    });
});


     
</script>
@endsection
