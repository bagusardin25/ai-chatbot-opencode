<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Chat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/chat.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900/20 to-slate-900 text-white antialiased" x-data="chatApp()">
    <div class="flex h-screen overflow-hidden relative">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDMpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-50 pointer-events-none"></div>
        
        @include('components.sidebar')
        
        <div class="flex-1 flex flex-col relative z-10">
            <div class="flex-1 overflow-y-auto" id="chat-container">
                <div class="max-w-4xl mx-auto px-6 py-8" id="messages">
                    <template x-for="message in messages" :key="message.id">
                        @include('components.message')
                    </template>
                    <div x-show="isStreaming" class="flex justify-start mb-6">
                        <div class="flex items-start space-x-4 max-w-4xl">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/>
                                </svg>
                            </div>
                            <div class="flex space-x-2 pt-3">
                                <div class="w-2 h-2 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full animate-bounce shadow-lg shadow-emerald-500/30"></div>
                                <div class="w-2 h-2 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full animate-bounce shadow-lg shadow-emerald-500/30" style="animation-delay: 0.15s"></div>
                                <div class="w-2 h-2 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full animate-bounce shadow-lg shadow-emerald-500/30" style="animation-delay: 0.3s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @include('components.input-area')
        </div>
    </div>
    
    @vite(['resources/js/chat.js'])
</body>
</html>