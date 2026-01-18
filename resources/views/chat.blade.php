<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Chat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/chat.css', 'resources/js/app.js'])
</head>
<body class="bg-[#343541] text-white antialiased" x-data="chatApp()">
    <div class="flex h-screen overflow-hidden">
        @include('components.sidebar')
        
        <div class="flex-1 flex flex-col relative">
            <div class="flex-1 overflow-y-auto" id="chat-container">
                <div class="max-w-3xl mx-auto px-4 py-6" id="messages">
                    <template x-for="message in messages" :key="message.id">
                        @include('components.message')
                    </template>
                    <div x-show="isStreaming" class="flex justify-start mb-4">
                        <div class="flex items-start space-x-3 max-w-3xl">
                            <div class="w-8 h-8 rounded-sm bg-[#19c37d] flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/>
                                </svg>
                            </div>
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
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