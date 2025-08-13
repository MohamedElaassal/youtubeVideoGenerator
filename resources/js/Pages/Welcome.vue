<template>
  <div class="min-h-screen bg-black overflow-hidden relative">
    <!-- Animated Background -->
    <div class="absolute inset-0">
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 via-blue-900/20 to-cyan-900/20"></div>

      <!-- Animated Particles -->
      <div class="particles-container">
        <div v-for="n in 50" :key="n"
             class="particle"
             :style="{
               '--delay': Math.random() * 20 + 's',
               '--duration': (Math.random() * 10 + 15) + 's',
               '--x': Math.random() * 100 + '%',
               '--y': Math.random() * 100 + '%'
             }">
        </div>
      </div>

      <!-- Grid Pattern -->
      <div class="absolute inset-0 opacity-20">
        <div class="grid-pattern"></div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 backdrop-blur-xl bg-white/5 border-b border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center group">
            <div class="relative">
              <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
              <div class="relative flex items-center space-x-2 bg-black px-4 py-2 rounded-lg">
                <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    <path d="M9 10l3 3 3-3"/>
                  </svg>
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                  VideoGenius AI
                </h1>
              </div>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <Link :href="route('demo.login')"
                  class="group relative px-6 py-2 font-medium text-white transition-all duration-300 hover:scale-105">
              <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
              <div class="relative bg-gray-900 px-6 py-2 rounded-lg border border-gray-800 group-hover:border-cyan-400/50">
                Try Demo
              </div>
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
      <div class="text-center">
        <!-- Floating Badge -->
        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-xl rounded-full px-6 py-2 mb-8 border border-white/20 animate-fade-in-up">
          <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
          <span class="text-sm text-gray-300">AI-Powered • Automated • Revolutionary</span>
        </div>

        <!-- Main Heading with Stagger Animation -->
        <div class="space-y-4 mb-8">
          <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight animate-fade-in-up animation-delay-200">
            Create YouTube Videos
          </h1>
          <div class="relative animate-fade-in-up animation-delay-400">
            <span class="text-5xl md:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-500 to-cyan-400 animate-gradient">
              with AI Magic
            </span>
            <div class="absolute -inset-1 bg-gradient-to-r from-pink-400 via-purple-500 to-cyan-400 opacity-20 blur-xl animate-pulse"></div>
          </div>
        </div>

        <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed animate-fade-in-up animation-delay-600">
          Transform your ideas into viral YouTube content in minutes. Our AI handles script writing,
          visual selection, voiceover, and everything in between.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-in-up animation-delay-800">
          <Link :href="route('google.redirect')"
                class="group relative inline-flex items-center px-8 py-4 text-lg font-semibold text-white transition-all duration-500 hover:scale-105 transform">
            <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-purple-600 rounded-xl blur opacity-70 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
            <div class="relative bg-gradient-to-r from-pink-600 to-purple-600 px-8 py-4 rounded-xl flex items-center space-x-3">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
              </svg>
              <span>Start Creating Magic</span>
              <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
            </div>
          </Link>

          <Link :href="route('demo.login')"
                class="group relative inline-flex items-center px-8 py-4 text-lg font-semibold text-white transition-all duration-500 hover:scale-105 transform">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-black/50 backdrop-blur-xl px-8 py-4 rounded-xl border border-white/20 group-hover:border-cyan-400/50 flex items-center space-x-3">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              <span>Watch Demo</span>
            </div>
          </Link>
        </div>

        <!-- Stats Row -->
        <div class="flex flex-wrap justify-center gap-8 mt-16 animate-fade-in-up animation-delay-1000">
          <div class="text-center">
            <div class="text-3xl font-bold text-white mb-1 counter" data-target="10000">0</div>
            <div class="text-sm text-gray-400">Videos Created</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-white mb-1 counter" data-target="500">0</div>
            <div class="text-sm text-gray-400">Happy Creators</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-white mb-1 counter" data-target="99">0</div>
            <div class="text-sm text-gray-400">% Success Rate</div>
          </div>
        </div>
      </div>

      <!-- Demo Video Section -->
      <div class="mt-20 max-w-5xl mx-auto animate-fade-in-up animation-delay-1200">
        <div class="relative group">
          <div class="absolute -inset-4 bg-gradient-to-r from-pink-600 via-purple-600 to-cyan-500 rounded-2xl blur-xl opacity-25 group-hover:opacity-40 transition duration-1000"></div>
          <div class="relative bg-gray-900/80 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
            <div class="aspect-video bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl flex items-center justify-center relative overflow-hidden">
              <!-- Play Button -->
              <button class="group/play relative z-10 flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-xl rounded-full border border-white/20 hover:scale-110 transition-all duration-300">
                <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z"/>
                </svg>
                <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full opacity-0 group-hover/play:opacity-20 transition-opacity duration-300"></div>
              </button>

              <!-- Background Pattern -->
              <div class="absolute inset-0 opacity-20">
                <div class="w-full h-full bg-gradient-to-br from-pink-500/20 via-purple-500/20 to-cyan-500/20"></div>
              </div>
            </div>
            <div class="text-center mt-6">
              <h3 class="text-xl font-semibold text-white mb-2">See VideoGenius AI in Action</h3>
              <p class="text-gray-400">Watch how we transform a simple topic into a complete YouTube video</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="relative z-10 py-24 overflow-hidden">
      <!-- Section Background -->
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-purple-900/5 to-transparent"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-20 animate-fade-in-up">
          <div class="inline-flex items-center space-x-2 bg-white/5 backdrop-blur-xl rounded-full px-6 py-2 mb-6 border border-white/10">
            <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></div>
            <span class="text-sm text-gray-300">Powerful Features</span>
          </div>

          <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
            Everything You Need to
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 animate-gradient">
              Dominate YouTube
            </span>
          </h2>
          <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
            Our AI-powered platform handles the entire video creation process, from ideation to publication.
          </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="group relative animate-fade-in-up animation-delay-200">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-purple-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <!-- Icon -->
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-purple-300 transition-colors duration-300">
                AI Script Generation
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                Transform any topic into engaging, viral-ready scripts with perfect pacing, hooks, and storytelling structure.
              </p>

              <!-- Feature Tags -->
              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-medium border border-purple-500/30">
                  GPT-4 Powered
                </span>
                <span class="px-3 py-1 bg-pink-500/20 text-pink-300 rounded-full text-xs font-medium border border-pink-500/30">
                  Viral Hooks
                </span>
              </div>
            </div>
          </div>

          <!-- Feature 2 -->
          <div class="group relative animate-fade-in-up animation-delay-400">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-cyan-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-cyan-300 transition-colors duration-300">
                Smart Visual Selection
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                AI analyzes your script and automatically selects the perfect stock footage, images, and graphics from Pexels.
              </p>

              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-full text-xs font-medium border border-cyan-500/30">
                  Auto-Sync
                </span>
                <span class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-medium border border-blue-500/30">
                  HD Quality
                </span>
              </div>
            </div>
          </div>

          <!-- Feature 3 -->
          <div class="group relative animate-fade-in-up animation-delay-600">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-green-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-emerald-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-emerald-300 transition-colors duration-300">
                Professional Voiceover
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                Natural-sounding AI voices that bring your scripts to life with perfect pronunciation and emotion.
              </p>

              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-medium border border-emerald-500/30">
                  40+ Voices
                </span>
                <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium border border-green-500/30">
                  Multilingual
                </span>
              </div>
            </div>
          </div>

          <!-- Feature 4 -->
          <div class="group relative animate-fade-in-up animation-delay-800">
            <div class="absolute -inset-1 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-amber-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-amber-300 transition-colors duration-300">
                Direct YouTube Upload
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                Seamlessly publish to your YouTube channel with optimized titles, descriptions, and tags for maximum reach.
              </p>

              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-xs font-medium border border-amber-500/30">
                  Auto-SEO
                </span>
                <span class="px-3 py-1 bg-orange-500/20 text-orange-300 rounded-full text-xs font-medium border border-orange-500/30">
                  Bulk Upload
                </span>
              </div>
            </div>
          </div>

          <!-- Feature 5 -->
          <div class="group relative animate-fade-in-up animation-delay-1000">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-indigo-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-indigo-300 transition-colors duration-300">
                Autopilot Mode
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                Set your niche and schedule. Our AI creates and publishes videos automatically while you sleep.
              </p>

              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs font-medium border border-indigo-500/30">
                  24/7 Active
                </span>
                <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-medium border border-purple-500/30">
                  Smart Scheduling
                </span>
              </div>
            </div>
          </div>

          <!-- Feature 6 -->
          <div class="group relative animate-fade-in-up animation-delay-1200">
            <div class="absolute -inset-1 bg-gradient-to-r from-rose-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-2xl p-8 border border-white/10 group-hover:border-rose-500/50 transition-all duration-500 transform group-hover:-translate-y-2">
              <div class="relative mb-6">
                <div class="absolute -inset-2 bg-gradient-to-r from-rose-500 to-pink-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                  <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
              </div>

              <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-rose-300 transition-colors duration-300">
                Advanced Analytics
              </h3>
              <p class="text-gray-300 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                Deep insights into your video performance with AI-powered recommendations to maximize growth.
              </p>

              <div class="flex flex-wrap gap-2 mt-6">
                <span class="px-3 py-1 bg-rose-500/20 text-rose-300 rounded-full text-xs font-medium border border-rose-500/30">
                  Real-time
                </span>
                <span class="px-3 py-1 bg-pink-500/20 text-pink-300 rounded-full text-xs font-medium border border-pink-500/30">
                  Predictive AI
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="relative z-10 py-24 overflow-hidden">
      <!-- Background Effects -->
      <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/20 via-blue-900/20 to-cyan-900/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Final CTA -->
        <div class="max-w-4xl mx-auto animate-fade-in-up">
          <div class="inline-flex items-center space-x-2 bg-white/5 backdrop-blur-xl rounded-full px-6 py-2 mb-8 border border-white/10">
            <div class="w-2 h-2 bg-cyan-500 rounded-full animate-pulse"></div>
            <span class="text-sm text-gray-300">Join 10,000+ Creators Already Growing</span>
          </div>

          <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
            Ready to
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-400 animate-gradient">
              10x Your Channel?
            </span>
          </h2>

          <p class="text-xl md:text-2xl text-gray-300 mb-12 leading-relaxed">
            Stop spending hours on video creation. Let AI do the heavy lifting while you focus on what matters most - growing your audience.
          </p>

          <!-- CTA Buttons -->
          <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
            <Link :href="route('google.redirect')"
                  class="group relative inline-flex items-center px-10 py-5 text-xl font-bold text-white transition-all duration-500 hover:scale-105 transform">
              <div class="absolute -inset-2 bg-gradient-to-r from-pink-600 via-purple-600 to-cyan-500 rounded-2xl blur-xl opacity-70 group-hover:opacity-100 transition duration-1000 animate-pulse"></div>
              <div class="relative bg-gradient-to-r from-pink-600 via-purple-600 to-cyan-500 px-10 py-5 rounded-2xl flex items-center space-x-4">
                <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                </svg>
                <span>Start Your AI Journey</span>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
              </div>
            </Link>

            <Link :href="route('demo.login')"
                  class="group relative inline-flex items-center px-10 py-5 text-xl font-bold text-white transition-all duration-500 hover:scale-105 transform">
              <div class="absolute -inset-2 bg-gradient-to-r from-gray-600 to-gray-800 rounded-2xl blur opacity-50 group-hover:opacity-75 transition duration-1000"></div>
              <div class="relative bg-black/50 backdrop-blur-xl px-10 py-5 rounded-2xl border-2 border-white/20 group-hover:border-cyan-400/50 flex items-center space-x-4">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Experience the Magic</span>
              </div>
            </Link>
          </div>

          <!-- Social Proof -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2 counter" data-target="1000000">0</div>
              <div class="text-sm text-gray-400">Videos Generated</div>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2 counter" data-target="50000">0</div>
              <div class="text-sm text-gray-400">Happy Creators</div>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2">4.9★</div>
              <div class="text-sm text-gray-400">User Rating</div>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2">24/7</div>
              <div class="text-sm text-gray-400">AI Working</div>
            </div>
          </div>

          <!-- Testimonial Preview -->
          <div class="relative max-w-2xl mx-auto">
            <div class="absolute -inset-4 bg-gradient-to-r from-purple-600/20 to-cyan-600/20 rounded-3xl blur-xl"></div>
            <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-3xl p-8 border border-white/10">
              <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-cyan-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-bold">JD</span>
                </div>
                <div>
                  <div class="text-white font-semibold">John Davis</div>
                  <div class="text-gray-400 text-sm">YouTuber • 2.5M Subscribers</div>
                </div>
              </div>
              <p class="text-gray-300 italic leading-relaxed">
                "VideoGenius AI transformed my channel completely. I went from uploading once a week to daily uploads, and my subscriber count exploded from 10K to 2.5M in just 8 months!"
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-white/10 bg-black/50 backdrop-blur-xl">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <div class="flex items-center justify-center space-x-2 mb-4">
            <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                <path d="M9 10l3 3 3-3"/>
              </svg>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
              VideoGenius AI
            </span>
          </div>
          <p class="text-gray-400 mb-6">
            Revolutionizing YouTube content creation with artificial intelligence.
          </p>
          <div class="flex justify-center space-x-6 text-sm text-gray-500">
            <a href="#" class="hover:text-white transition-colors duration-300">Privacy Policy</a>
            <a href="#" class="hover:text-white transition-colors duration-300">Terms of Service</a>
            <a href="#" class="hover:text-white transition-colors duration-300">Support</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'

onMounted(() => {
  // Initialize counter animations
  const counters = document.querySelectorAll('.counter')

  const animateCounter = (element) => {
    const target = parseInt(element.getAttribute('data-target'))
    const duration = 2000 // 2 seconds
    const increment = target / (duration / 50)
    let current = 0

    const timer = setInterval(() => {
      current += increment
      if (current >= target) {
        current = target
        clearInterval(timer)
      }

      // Format large numbers
      if (target >= 1000000) {
        element.textContent = (current / 1000000).toFixed(1) + 'M+'
      } else if (target >= 1000) {
        element.textContent = (current / 1000).toFixed(0) + 'K+'
      } else {
        element.textContent = Math.floor(current)
      }
    }, 50)
  }

  // Start counters when they come into view
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target)
        observer.unobserve(entry.target)
      }
    })
  })

  counters.forEach(counter => {
    observer.observe(counter)
  })
})
</script>
