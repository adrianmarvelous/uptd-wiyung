@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h2 class="mb-4">Upload CSV</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('read.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="file">CSV file</label>
            <input type="file" name="file" id="file" accept=".csv,text/csv" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload & Preview</button>
    </form>
</div>
@endsection
