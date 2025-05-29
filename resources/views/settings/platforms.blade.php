@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="h2 mb-4">Platform Management</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Platform List -->
        <div class="card shadow mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($platforms as $platform)
                            <tr>
                                <td>{{ ucfirst($platform['name']) }}</td>
                                <td>{{ ucfirst($platform['type']) }}</td>
                                <td>
                                        <span class="badge rounded-pill
                                            @if($platform['is_active']) bg-success
                                            @else bg-secondary @endif">
                                            {{ $platform['is_active'] ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td>
                                    <form action="{{ route('platforms.toggle', $platform['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" value="{{$platform['is_active'] ? 0 : 1}}" name="is_active">
                                        <button type="submit" class="btn btn-sm
                                                @if($platform['is_active']) btn-outline-warning
                                                @else btn-outline-success @endif">
                                            {{ $platform['is_active'] ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add New Platform Form -->
{{--        <div class="card shadow">--}}
{{--            <div class="card-body">--}}
{{--                <h2 class="h4 mb-4">Add New Platform</h2>--}}
{{--                <form action="{{ route('platforms.store') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <div class="row g-3">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label for="name" class="form-label">Platform Name</label>--}}
{{--                            <input type="text" id="name" name="name" class="form-control" required>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label for="type" class="form-label">Platform Type</label>--}}
{{--                            <select id="type" name="type" class="form-select" required>--}}
{{--                                <option value="">Select Type</option>--}}
{{--                                <option value="twitter">Twitter</option>--}}
{{--                                <option value="instagram">Instagram</option>--}}
{{--                                <option value="linkedin">LinkedIn</option>--}}
{{--                                <option value="facebook">Facebook</option>--}}
{{--                                <option value="tiktok">TikTok</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label for="character_limit" class="form-label">Character Limit (Optional)</label>--}}
{{--                            <input type="number" id="character_limit" name="character_limit" class="form-control">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 d-flex align-items-center">--}}
{{--                            <div class="form-check form-switch mt-3">--}}
{{--                                <input class="form-check-input" type="checkbox" id="image_required" name="image_required">--}}
{{--                                <label class="form-check-label" for="image_required">Image Required</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="mt-4 d-flex justify-content-end">--}}
{{--                        <button type="submit" class="btn btn-primary">--}}
{{--                            <i class="bi bi-plus-circle me-2"></i>Add Platform--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
