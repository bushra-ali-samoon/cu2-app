@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">{{ $course->title }} - Topics</h2>
    </div>

    <!-- Add Topic Card -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Topic</h5>
        </div>
        <div class="card-body">
           <form id="addTopicForm" method="POST" action="{{ route('topics.store', $course->id) }}">
    @csrf
    <input type="text" name="title" placeholder="Enter topic title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit" class="btn btn-primary">Add Topic</button>
</form>

        </div>
    </div>

<script>
document.getElementById('addTopicForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const courseId = {{ $course->id }};
    const formData = new FormData(this);

    fetch(`/courses/${courseId}/topics`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Topic added successfully!');
            location.reload(); // reload to see new topic
        }
    })
    .catch(err => console.error(err));
});
</script>
@endsection
