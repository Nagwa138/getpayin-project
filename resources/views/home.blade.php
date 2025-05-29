@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8" id="app">
        <div class="d-flex justify-content-between align-items-center mb-8">
            <h1 class="text-2xl font-bold">Content Dashboard</h1>
            <a href="{{ route('posts.create') }}" class="bg-warning text-white px-4 rounded-lg hover:bg-blue-700 transition btn">
                + New Post
            </a>
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
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form method="GET" action="{{route('home')}}" class="d-flex flex-wrap justify-content-around align-items-end gap-4">
                @csrf
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full px-3 mx-2 py-2 border rounded-lg">
                        <option value="all" {{old('status') == 'all'? 'selected' : ''}}>All</option>
                        <option value="draft" {{old('status') == 'draft'? 'selected' : ''}}>Draft</option>
                        <option value="scheduled" {{old('status') == 'scheduled'? 'selected' : ''}}>Scheduled</option>
                        <option value="published" {{old('status') == 'published'? 'selected' : ''}}>Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Platform</label>
                    <select name="platform_id" class=" mx-2 w-full px-3 py-2 border rounded-lg">
                        <option value="">All</option>
                        @foreach($platforms as $platform)
                            <option value="{{ $platform->id }}" {{old('platform_id') == '$platform->id'? 'selected' : ''}}>{{ $platform->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class=" block text-gray-700 text-sm font-medium mb-1">From Date</label>
                    <input type="date" name="from_date" value="{{old('from_date')}}" class="mx-2 w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-info text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="d-flex flex-wrap justify-content-between p-0" id="dashboardTabs">
                <li class="d-inline">
                    <button @click="activeTab = 'list'"
                            :class="{'text-blue-600 border-blue-600': activeTab === 'list', 'text-gray-500 hover:text-gray-600 hover:border-gray-300': activeTab !== 'list'}"
                            class="inline-block px-4 rounded-t-lg btn btn-success">
                        List View
                    </button>
                </li>
                <li class="mr-2 d-inline" >
                    <button @click="activeTab = 'calendar'"
                            :class="{'text-blue-600 border-blue-600': activeTab === 'calendar', 'text-gray-500 hover:text-gray-600 hover:border-gray-300': activeTab !== 'calendar'}"
                            class="inline-block px-4 border-b-2 rounded-t-lg btn btn-success">
                        Calendar View
                    </button>
                </li>
            </ul>
        </div>

        <!-- List View -->
        <div v-show="activeTab === 'list'" class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Image</th>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Platforms</th>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Scheduled</th>
                    <th class="px-4 py-2 text-left text-xs font-weight-bold text-muted text-uppercase">Added</th>
                </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td class="px-4 py-3 text-nowrap">
                            <div class="text-sm font-weight-bold text-dark">{{ Str::limit($post->title, 30) }}</div>
                        </td>
                        <td class="px-4 py-3 ">
                            <img src="{{ $post->image_url ? asset('/storage/' . $post->image_url) : asset('images/not_found.jpg')  }}" class="img-fluid"/>
                        </td>
                        <td class="px-4 py-3 text-nowrap">
                            <div class="d-flex gap-1">
                                @foreach($post->platforms as $platform)
                                    <span class="px-2 py-1 text-xs rounded-pill d-inline-block"
                                          style="background-color: {{ $platform->color }};">
                            {{ $platform->name }}
                        </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-nowrap">
                <span class="px-2 py-1 text-xs rounded-pill d-inline-block
                          @if($post->status === 'published') bg-success-light text-success
                          @elseif($post->status === 'scheduled') bg-primary-light text-primary
                          @else bg-light text-secondary @endif">
                    {{ ucfirst($post->status) }}
                </span>
                        </td>
                        <td class="px-4 py-3 text-nowrap text-sm text-muted">
                            {{ $post->scheduled_time->format('M d, Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-nowrap text-sm text-muted">
                            {{ $post->created_at->format('M d, Y H:i') }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center px-4 py-3 text-nowrap text-sm text-muted">
                           No Posts Available yet !
                        </td>

                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('vendor.pagination.bootstrap-5') }}
            </div>

        </div>

        <!-- Calendar View -->
        <div v-show="activeTab === 'calendar'" class="bg-white rounded-lg shadow-md p-4">
            <div id="calendar"></div>
        </div>
    </div>

    <script type="module">
        import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
        import axios from 'https://esm.sh/axios';  // Works as ES Module
        //import axios from 'axios';

            createApp({
                data() {
                    return {
                        title: 'My Vue App',
                        userId: "{{auth()->id()}}",
                        activeTab: 'list',
                        loading: false,
                        error: null,
                        posts: []
                    }
                },
                methods: {
                    async getScheduledPosts() {
                        try {
                            const response = await axios.get(`{{env('API_URL')}}/posts/show`);
                            return response.data;
                        } catch (error) {
                            console.error('Error fetching posts:', error);
                            throw error;
                        }
                    },
                    async fetchUserPosts() {
                        this.loading = true;
                        try {
                            this.posts = await this.getScheduledPosts();

                            const calendarEl = document.getElementById('calendar');
                            const calendar = new FullCalendar.Calendar(calendarEl, {
                                themeSystem: 'bootstrap5',
                                initialView: 'dayGridMonth',
                                headerToolbar: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                },
                                events: this.posts, // or your events array
                                eventClick: function(info) {
                                    const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                                    document.getElementById('modalTitle').innerText = info.event.title;
                                    document.getElementById('modalBody').innerHTML = `
            <p>Start: ${info.event.startStr}</p>
            ${info.event.extendedProps.description || ''}
          `;
                                    modal.show();
                                }
                            });

                            calendar.render();
                        } catch (err) {
                            this.error = 'Failed to fetch posts';
                        } finally {
                            this.loading = false;
                        }
                    }
                },
                created() {
                    this.fetchUserPosts();
                }
            }).mount('#app');


        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
@endsection
