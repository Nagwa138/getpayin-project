@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <!-- Form Header -->
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0">Create New Post</h1>
                <p class="mb-0 opacity-75">Schedule your content across multiple platforms</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="postForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="card-body">
                @csrf

                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title"
                           class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title"
                           value="{{old('title')}}"
                           class="form-control form-control-lg"
                           placeholder="Enter post title" required>
                </div>

                @error('title')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                <!-- Content Field -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <small class="text-muted" :class="{'text-muted': charCount <= warningThreshold, 'text-warning': charCount > warningThreshold && charCount <= maxCharacterLimit, 'text-danger': charCount > maxCharacterLimit}">
                            <span id="charCount" ></span>@{{ charCount }}/{{ $maxCharacterLimit }} characters
                        </small>
                    </div>
                    <textarea id="content" name="content" rows="8"
                              value="{{old('content')}}"
                              class="form-control"
                              placeholder="Write your post content here..."
                              v-model="content"
                              @input="updateCharacterCount"
                              maxlength="{{ $maxCharacterLimit }}"
                              required></textarea>
                    <div class="form-text">Supports basic Markdown formatting</div>
                </div>

                @error('content')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="image" class="form-label">Featured Image</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative flex-grow-1">
                            <input type="file" id="image" name="image" accept="image/*"
                                   class="position-absolute w-100 h-100 opacity-0 cursor-pointer"
                                   @change="previewImage">
                            <div class="border border-2 border-dashed rounded p-4 text-center hover-border-primary">
                                <i class="bi bi-image fs-1 text-muted"></i>
                                <p class="mt-1 mb-0 small" x-text="imageFile ? imageFile.name : 'Click to upload an image'"></p>
                                <p class="mt-1 mb-0 small text-muted">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                        <div class="w-25 ratio ratio-1x1 rounded overflow-hidden bg-light" x-show="imagePreview">
                            <img :src="imagePreview" alt="Preview" class="object-fit-cover">
                        </div>
                    </div>
                </div>

                @error('image')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                <!-- Platform Selector -->
                <div class="mb-4">
                    <label class="form-label">Select Platforms <span class="text-danger">*</span></label>
                    <p class="text-muted small mb-3">Choose where to publish this post</p>

                    @error('platforms')
                    <div class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror

                    <div class="row g-3">
                        @foreach($platforms as $platform)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="position-relative">
                                    <input type="checkbox" name="platforms[]" value="{{ $platform->id }}"
                                           id="platform-{{ $platform->id }}"
                                           class="position-absolute opacity-0"
                                           @change="checkPlatformRestrictions($event, {{ json_encode($platform) }})">
                                    <label for="platform-{{ $platform->id }}"
                                           class="d-block p-3 border rounded cursor-pointer hover-border-primary">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle border d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-check-lg text-primary opacity-0"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $platform->name }}</h6>
                                                <small class="text-muted">{{ $platform->type }}</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Schedule Options -->
                <div class="mb-4">
                    <label for="scheduled_time" class="form-label">Schedule</label>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <input type="datetime-local" id="scheduled_time" name="scheduled_time"
                                   class="form-control"
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   :value="defaultScheduleTime">
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <button type="submit"
                                    class="btn btn-outline-primary w-100">
                                Schedule Post
                            </button>
                        </div>
                    </div>
                </div>

                @error('scheduled_time')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

            </form>
        </div>
    </div>

    <script type="module">
        import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

        createApp({
            data() {
                return {
                    content: '',
                    charCount: 0,
                    maxCharacterLimit: {{ $maxCharacterLimit }},
                    warningThreshold: {{ $maxCharacterLimit * 0.9 }},
                    imageFile: null,
                    imagePreview: null,
                    platformRestrictions: @json($platformRestrictions),
                    defaultScheduleTime: new Date(Date.now() + 3600000).toISOString().slice(0, 16) // Default to 1 hour from now
                }
            },
            methods: {
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imageFile = file;
                        this.imagePreview = URL.createObjectURL(file);

                        // Add checked style to the parent label
                        event.target.nextElementSibling.classList.add('border-primary');
                    }
                },
                updateCharacterCount() {
                    this.charCount = this.content.length;
                },
                checkPlatformRestrictions(event, platform) {
                    const label = event.target.nextElementSibling;

                    if (event.target.checked) {
                        label.classList.add('border-primary', 'bg-primary-light');
                        label.querySelector('i').classList.remove('opacity-0');

                        let messages = [];

                        if (this.content.length > restrictions.character_limit) {
                            messages.push(`${platform.name} has a 2200 character limit (currently ${this.content.length})`);
                        }

                        if (messages.length > 0) {
                            Swal.fire({
                                title: 'Platform Restrictions',
                                html: messages.map(msg => `<div class="text-start py-2 border-bottom">• ${msg}</div>`).join(''),
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'text-start'
                                }
                            });
                            event.target.checked = false;
                            label.classList.remove('border-primary', 'bg-primary-light');
                            label.querySelector('i').classList.add('opacity-0');
                        }
                    } else {
                        label.classList.remove('border-primary', 'bg-primary-light');
                        label.querySelector('i').classList.add('opacity-0');
                    }
                },
            }
        }).mount('#postForm');
    </script>

    <style>
        .hover-border-primary:hover {
            border-color: #0d6efd !important;
        }
        .bg-primary-light {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .cursor-pointer {
            cursor: pointer;
        }
        input[type="checkbox"]:checked + label {
            border-color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
        }
        input[type="checkbox"]:checked + label i {
            opacity: 1 !important;
        }
    </style>
@endsection
