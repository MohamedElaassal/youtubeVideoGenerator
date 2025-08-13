<template>
  <div class="min-h-screen bg-black overflow-hidden relative flex flex-col justify-center">
    <!-- Animated Background -->
    <div class="absolute inset-0">
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-blue-900/30 to-cyan-900/30"></div>

      <!-- Animated Particles -->
      <div class="particles-container">
        <div v-for="n in 30" :key="n"
             class="particle"
             :style="{
               '--delay': Math.random() * 15 + 's',
               '--duration': (Math.random() * 8 + 12) + 's',
               '--x': Math.random() * 100 + '%',
               '--y': Math.random() * 100 + '%'
             }">
        </div>
      </div>

      <!-- Grid Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="grid-pattern"></div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="absolute top-0 left-0 right-0 z-50 backdrop-blur-xl bg-white/5 border-b border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <Link :href="route('welcome')" class="flex items-center group">
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
          </Link>

          <Link :href="route('welcome')"
                class="text-gray-300 hover:text-white transition-colors duration-300 font-medium">
            ← Back to Home
          </Link>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8 animate-fade-in-up">
          <div class="inline-flex items-center space-x-2 bg-white/5 backdrop-blur-xl rounded-full px-6 py-2 mb-6 border border-white/10">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-sm text-gray-300">Secure Login</span>
          </div>

          <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
            Welcome
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400 animate-gradient">
              Creator
            </span>
          </h2>
          <p class="text-lg text-gray-300">
            Sign in to start creating viral YouTube content with AI
          </p>
        </div>

        <!-- Login Card -->
        <div class="relative animate-fade-in-up animation-delay-400">
          <div class="absolute -inset-4 bg-gradient-to-r from-pink-600 via-purple-600 to-cyan-500 rounded-3xl blur-xl opacity-20"></div>
          <div class="relative bg-gray-900/50 backdrop-blur-xl rounded-3xl p-8 border border-white/10">

            <!-- Google Sign-in Button -->
            <div class="mb-6">
              <Link :href="route('google.redirect')"
                    class="group relative w-full flex justify-center items-center px-6 py-4 text-lg font-semibold text-white transition-all duration-500 hover:scale-105 transform btn-ripple">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-purple-600 rounded-xl blur opacity-70 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                <div class="relative bg-gradient-to-r from-pink-600 to-purple-600 px-6 py-4 rounded-xl flex items-center justify-center space-x-3 w-full">
                  <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                  </svg>
                  <span>Continue with Google</span>
                  <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
                </div>
              </Link>
            </div>

            <!-- Divider -->
            <div class="relative mb-6">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/20"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-gray-900/50 text-gray-300 font-medium">Or try without OAuth</span>
              </div>
            </div>

            <!-- Demo Login Button -->
            <div class="mb-8">
              <Link :href="route('demo.login')"
                    class="group relative w-full flex justify-center items-center px-6 py-4 text-lg font-semibold text-white transition-all duration-500 hover:scale-105 transform">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
                <div class="relative bg-black/50 backdrop-blur-xl px-6 py-4 rounded-xl border-2 border-dashed border-cyan-400/50 group-hover:border-cyan-400 flex items-center justify-center space-x-3 w-full">
                  <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                  <span>Try Demo Mode</span>
                </div>
              </Link>
            </div>

            <!-- Benefits -->
            <div class="space-y-4">
              <h3 class="text-white font-semibold text-center mb-4">Why Sign In with Google?</h3>

              <div class="space-y-3">
                <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </div>
                  <p class="text-gray-300 text-sm leading-relaxed">
                    <span class="text-white font-medium">Direct YouTube Access</span> - Upload videos directly to your channel
                  </p>
                </div>

                <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mt-0.5">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                  </div>
                  <p class="text-gray-300 text-sm leading-relaxed">
                    <span class="text-white font-medium">Bank-Level Security</span> - Your data is protected by Google's security
                  </p>
                </div>

                <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mt-0.5">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                  <p class="text-gray-300 text-sm leading-relaxed">
                    <span class="text-white font-medium">Instant Setup</span> - No forms to fill, get started in seconds
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer Text -->
        <div class="mt-8 text-center animate-fade-in-up animation-delay-800">
          <p class="text-xs text-gray-400 leading-relaxed">
            By signing in, you agree to our
            <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors duration-300 underline">Terms of Service</a>
            and
            <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors duration-300 underline">Privacy Policy</a>
          </p>
        </div>
      </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-gradient-to-br from-pink-500/20 to-purple-600/20 rounded-full blur-xl animate-float animation-delay-1000"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-full blur-xl animate-float animation-delay-600"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-gradient-to-br from-purple-500/20 to-pink-600/20 rounded-full blur-xl animate-float animation-delay-1200"></div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
