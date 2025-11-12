@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ $course->title }} - Topics</h2>

    <!-- Add Topic Form -->
<div class="container mt-4">
    <h3 class="mb-4">chemistry - Topics</h3>

    <form id="addTopicForm" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">

            <!-- Topic Title -->
            <div class="col-md-6">
                <label class="form-label">Topic Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter topic title" required>
            </div>

            <!-- Description -->
            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" placeholder="Enter description">
            </div>

            <!-- Students Visible For -->
            <div class="col-md-6">
                <label class="form-label">Visible For</label>
                <select name="visible_for" class="form-select">
                    <option value="all">All Students</option>
                    <option value="specific">Specific Students</option>
                </select>
            </div>

            <!-- Audio Upload -->
            <div class="col-md-6">
                <label class="form-label">Audio File</label>
                <input type="file" name="audio_path" class="form-control">
            </div>

            <!-- PDF Uploads -->
            <div class="col-md-4">
                <label class="form-label">Transcript PDF</label>
                <input type="file" name="transcript_pdf" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Worksheet PDF</label>
                <input type="file" name="worksheet_pdf" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Test PDF</label>
                <input type="file" name="test_pdf" class="form-control">
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Add Topic</button>
        </div>
    </form>
</div>


    <!-- Topics Grid -->
    <div class="row g-3" id="topicsList">
        @foreach($course->topics as $topic)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <h5>{{ $topic->title }}</h5>
                <p class="text-muted">{{ $topic->description }}</p>

                @if($topic->audio_path)
                    <audio controls class="w-100">
                        <source src="{{ asset('storage/'.$topic->audio_path) }}" type="audio/mpeg">
                    </audio>
                @endif

                <div class="mt-2">
                    @if($topic->transcript_pdf)
                        <a href="{{ asset('storage/'.$topic->transcript_pdf) }}" target="_blank">Transcript</a> |
                    @endif
                    @if($topic->worksheet_pdf)
                        <a href="{{ asset('storage/'.$topic->worksheet_pdf) }}" target="_blank">Worksheet</a> |
                    @endif
                    @if($topic->test_pdf)
                        <a href="{{ asset('storage/'.$topic->test_pdf) }}" target="_blank">Test</a>
                    @endif
                </div>

                <p class="mt-2 small text-secondary">Visible for: {{ ucfirst($topic->visible_for) }}</p>

                <button class="btn btn-sm btn-danger deleteTopic" data-id="{{ $topic->id }}">Delete</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#topicForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const courseId = '{{ $course->id }}';
        const formData = new FormData(form);

        fetch(`/courses/${courseId}/topics`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: formData
        })
        .then(res => res.json())
        .then(data => location.reload());
    });

    document.querySelectorAll('.deleteTopic').forEach(btn => {
        btn.addEventListener('click', function() {
            if(!confirm('Delete this topic?')) return;
            fetch(`/topics/${this.dataset.id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            })
            .then(res => res.json())
            .then(data => location.reload());
        });
    });
});
</script>
@endsection
