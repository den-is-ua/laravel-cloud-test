@extends('layouts.bootstrap')

@section('title', 'Notes')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    New note
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input
                                id="title"
                                name="title"
                                type="text"
                                value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror"
                                required
                                maxlength="255"
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea
                                id="body"
                                name="body"
                                rows="5"
                                class="form-control @error('body') is-invalid @enderror"
                                maxlength="10000"
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Create
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Notes</span>
                    <small class="text-muted">{{ $notes->total() }} total</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 1%;">#</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th style="width: 1%;">Created</th>
                                <th style="width: 1%;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notes as $note)
                                <tr>
                                    <td class="text-muted">{{ $note->id }}</td>
                                    <td class="fw-semibold">{{ $note->title }}</td>
                                    <td class="text-muted">{{ str($note->body)->limit(120) }}</td>
                                    <td class="text-muted text-nowrap">{{ $note->created_at->diffForHumans() }}</td>
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('notes.destroy', $note) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this note?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No notes yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($notes->hasPages())
                    <div class="card-footer">
                        {{ $notes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
