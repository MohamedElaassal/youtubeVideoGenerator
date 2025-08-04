<template>
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-2xl font-bold text-gray-900">My Videos</h2>
              <p class="mt-1 text-sm text-gray-600">
                Manage all your generated videos
              </p>
            </div>
            <Link :href="route('videos.create')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
              <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Generate Video
            </Link>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
          <div class="p-6 border-b border-gray-200">
            <div class="flex flex-wrap gap-4">
              <select v-model="filters.status" @change="filterVideos" class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="uploaded">Uploaded</option>
                <option value="failed">Failed</option>
              </select>

              <select v-model="filters.duration" @change="filterVideos" class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Durations</option>
                <option value="short">Short (&lt; 1 min)</option>
                <option value="medium">Medium (1-5 min)</option>
                <option value="long">Long (&gt; 5 min)</option>
              </select>

              <input
                v-model="filters.search"
                @input="debounceSearch"
                type="text"
                placeholder="Search videos..."
                class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
              />
            </div>
          </div>
        </div>

        <!-- Videos Grid -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
          <div class="p-6">
            <div v-if="filteredVideos.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div v-for="video in filteredVideos" :key="video.id" class="bg-gray-50 rounded-lg overflow-hidden">
                <!-- Video Thumbnail -->
                <div class="aspect-video bg-gray-200 flex items-center justify-center">
                  <img
                    v-if="video.thumbnail_url"
                    :src="video.thumbnail_url"
                    :alt="video.title"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="text-gray-400">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>

                <!-- Video Info -->
                <div class="p-4">
                  <div class="flex items-start justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2">
                      {{ video.title || 'Untitled Video' }}
                    </h3>
                    <span
                      :class="getStatusColor(video.status)"
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    >
                      {{ formatStatus(video.status) }}
                    </span>
                  </div>

                  <p v-if="video.description" class="text-sm text-gray-600 mb-3 line-clamp-2">
                    {{ video.description }}
                  </p>

                  <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                    <span v-if="video.duration">{{ formatDuration(video.duration) }}</span>
                    <span>{{ formatDate(video.created_at) }}</span>
                  </div>

                  <!-- Action Buttons -->
                  <div class="flex items-center justify-between">
                    <div class="flex space-x-2">
                      <Link
                        :href="route('videos.show', video.id)"
                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        View
                      </Link>

                      <Link
                        v-if="video.status === 'draft'"
                        :href="route('videos.edit', video.id)"
                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        Edit
                      </Link>
                    </div>

                    <div class="flex space-x-1">
                      <button
                        v-if="video.youtube_url"
                        @click="openYouTube(video.youtube_url)"
                        class="text-red-600 hover:text-red-900"
                        title="View on YouTube"
                      >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                      </button>

                      <button
                        @click="deleteVideo(video.id)"
                        class="text-red-600 hover:text-red-900"
                        title="Delete video"
                      >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No videos found</h3>
              <p class="mt-1 text-sm text-gray-500">Get started by creating your first video.</p>
              <div class="mt-6">
                <Link :href="route('videos.create')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                  Generate Video
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  videos: Array
})

const filters = ref({
  status: '',
  duration: '',
  search: ''
})

let searchTimeout = null

const filteredVideos = computed(() => {
  let filtered = props.videos

  // Filter by status
  if (filters.value.status) {
    filtered = filtered.filter(video => video.status === filters.value.status)
  }

  // Filter by duration
  if (filters.value.duration) {
    filtered = filtered.filter(video => {
      const duration = video.duration || 0
      switch (filters.value.duration) {
        case 'short':
          return duration < 60
        case 'medium':
          return duration >= 60 && duration <= 300
        case 'long':
          return duration > 300
        default:
          return true
      }
    })
  }

  // Filter by search
  if (filters.value.search) {
    const search = filters.value.search.toLowerCase()
    filtered = filtered.filter(video =>
      video.title?.toLowerCase().includes(search) ||
      video.description?.toLowerCase().includes(search) ||
      video.topic?.toLowerCase().includes(search)
    )
  }

  return filtered
})

const debounceSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    filterVideos()
  }, 300)
}

const filterVideos = () => {
  // In a real app, you might want to update the URL params
  // router.get(route('videos.index'), filters.value, {
  //   preserveState: true,
  //   replace: true
  // })
}

const getStatusColor = (status) => {
  const colors = {
    draft: 'bg-gray-100 text-gray-800',
    processing: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
    uploaded: 'bg-blue-100 text-blue-800',
    failed: 'bg-red-100 text-red-800'
  }
  return colors[status] || 'bg-gray-100 text-gray-800'
}

const formatStatus = (status) => {
  const labels = {
    draft: 'Draft',
    processing: 'Processing',
    completed: 'Completed',
    uploaded: 'Uploaded',
    failed: 'Failed'
  }
  return labels[status] || status
}

const formatDuration = (seconds) => {
  if (!seconds) return 'Unknown'

  const minutes = Math.floor(seconds / 60)
  const remainingSeconds = seconds % 60

  if (minutes === 0) {
    return `${remainingSeconds}s`
  } else if (remainingSeconds === 0) {
    return `${minutes}m`
  } else {
    return `${minutes}m ${remainingSeconds}s`
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const openYouTube = (url) => {
  window.open(url, '_blank')
}

const deleteVideo = (videoId) => {
  if (confirm('Are you sure you want to delete this video? This action cannot be undone.')) {
    router.delete(route('videos.destroy', videoId))
  }
}
</script>
