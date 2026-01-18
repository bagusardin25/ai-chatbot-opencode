<div class="border-t border-gray-700 bg-[#343541]">
    <div class="max-w-3xl mx-auto px-4 py-4">
        <div class="relative flex items-end space-x-2 bg-gray-700 rounded-lg border border-gray-600 focus-within:border-gray-500 transition-colors">
            <textarea 
                x-model="inputMessage" 
                @keydown.enter.prevent="handleKeyDown($event)"
                @input="autoResize($event)"
                placeholder="Send a message..."
                class="flex-1 bg-transparent border-0 focus:ring-0 text-white placeholder-gray-400 resize-none py-3 px-3 max-h-32 min-h-[52px]"
                rows="1"
                id="message-input"
            ></textarea>
            
            <button 
                @click="sendMessage()"
                :disabled="!inputMessage.trim() || isStreaming"
                :class="!inputMessage.trim() || isStreaming ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-600'"
                class="p-2 mb-1 mr-1 rounded-md transition-colors"
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
        
        <div class="text-xs text-gray-400 text-center mt-2">
            AI can make mistakes. Consider checking important information.
        </div>
    </div>
</div>