<div :class="message.role === 'user' ? 'flex justify-end mb-6' : 'flex justify-start mb-6'">
    <div class="flex items-start space-x-4 max-w-4xl" :class="message.role === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
        <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center shadow-lg"
             :class="message.role === 'user' 
                ? 'bg-gradient-to-br from-violet-500 to-purple-600 shadow-purple-500/30' 
                : 'bg-gradient-to-br from-emerald-400 to-cyan-400 shadow-emerald-500/30'">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="px-5 py-3 rounded-2xl shadow-lg backdrop-blur-sm border transition-all duration-200"
                 :class="message.role === 'user' 
                    ? 'bg-gradient-to-br from-violet-600/90 to-purple-600/90 text-white border-purple-500/30' 
                    : 'bg-white/5 border-white/10 text-gray-100 hover:bg-white/10'"
                 x-html="formatMessage(message.content)">
            </div>
            <div class="text-xs text-gray-500 mt-2 flex items-center space-x-2" :class="message.role === 'user' ? 'justify-end' : 'justify-start'">
                <span x-text="formatTime(message.created_at)"></span>
            </div>
        </div>
    </div>
</div>