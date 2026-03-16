<div class="border-t border-white/10 bg-gradient-to-t from-slate-900/95 via-slate-900/80 to-transparent backdrop-blur-xl">
    <div class="max-w-4xl mx-auto px-6 py-6">
        <div class="relative flex items-end space-x-3 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 focus-within:border-purple-500/50 focus-within:shadow-lg focus-within:shadow-purple-500/20 transition-all duration-300 group">
            <textarea 
                x-model="inputMessage" 
                @keydown.enter.prevent="handleKeyDown($event)"
                @input="autoResize($event)"
                placeholder="Send a message..."
                class="flex-1 bg-transparent border-0 focus:ring-0 text-white placeholder-gray-400 resize-none py-4 px-5 max-h-40 min-h-[60px] leading-relaxed"
                rows="1"
                id="message-input"
            ></textarea>
            
            <button 
                @click="sendMessage()"
                :disabled="!inputMessage.trim() || isStreaming"
                :class="!inputMessage.trim() || isStreaming 
                    ? 'opacity-40 cursor-not-allowed bg-white/5' 
                    : 'bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 hover:scale-105'"
                class="p-3 mb-2 mr-2 rounded-xl transition-all duration-300"
            >
                <svg class="w-5 h-5" :class="isStreaming ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <template x-if="isStreaming">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </template>
                    <template x-if="!isStreaming">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </template>
                </svg>
            </button>
        </div>
        
        <div class="text-xs text-gray-500 text-center mt-3 flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>AI can make mistakes. Consider checking important information.</span>
        </div>
    </div>
</div>