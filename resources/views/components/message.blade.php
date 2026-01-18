<div :class="message.role === 'user' ? 'flex justify-end mb-4' : 'flex justify-start mb-4'">
    <div class="flex items-start space-x-3 max-w-3xl" :class="message.role === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
        <div class="w-8 h-8 rounded-sm flex-shrink-0 flex items-center justify-center"
             :class="message.role === 'user' ? 'bg-purple-600' : 'bg-[#19c37d]'">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="inline-block px-4 py-2 rounded-lg"
                 :class="message.role === 'user' 
                    ? 'bg-purple-600 text-white' 
                    : 'bg-gray-700 text-gray-100'"
                 x-html="formatMessage(message.content)">
            </div>
            <div class="text-xs text-gray-500 mt-1" x-text="formatTime(message.created_at)"></div>
        </div>
    </div>
</div>