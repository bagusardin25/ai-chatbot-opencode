<aside class="w-72 bg-gradient-to-b from-slate-900/95 to-slate-900/80 backdrop-blur-xl flex flex-col h-full flex-shrink-0 border-r border-white/10">
    <div class="p-4">
        <button @click="startNewChat()" class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-gradient-to-r from-violet-600 to-purple-600 rounded-xl hover:from-violet-500 hover:to-purple-500 transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 group">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-sm font-semibold">New Chat</span>
        </button>
    </div>
    
    <div class="flex-1 overflow-y-auto px-3 space-y-2">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-3">Recent</div>
        <template x-for="conversation in conversations" :key="conversation.id">
            <div class="group relative">
                <button 
                    @click="loadConversation(conversation.id)"
                    :class="currentConversationId === conversation.id 
                        ? 'bg-gradient-to-r from-purple-500/20 to-violet-500/20 border-purple-500/50 shadow-lg shadow-purple-500/10' 
                        : 'bg-white/5 border-transparent hover:bg-white/10 hover:border-white/20'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border transition-all duration-200 text-left"
                >
                    <svg class="w-4 h-4 flex-shrink-0 transition-colors" :class="currentConversationId === conversation.id ? 'text-purple-400' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="flex-1 truncate text-sm font-medium" x-text="conversation.title"></span>
                </button>
                
                <div class="absolute right-2 top-1/2 -translate-y-1/2 hidden group-hover:flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-all duration-200">
                    <button 
                        @click.stop="renameConversation(conversation.id)"
                        class="p-1.5 hover:bg-white/10 rounded-lg transition-all hover:scale-110"
                        title="Rename"
                    >
                        <svg class="w-3.5 h-3.5 text-gray-400 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </button>
                    <button 
                        @click.stop="deleteConversation(conversation.id)"
                        class="p-1.5 hover:bg-red-500/20 rounded-lg transition-all hover:scale-110"
                        title="Delete"
                    >
                        <svg class="w-3.5 h-3.5 text-gray-400 hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
    
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center space-x-3 bg-white/5 rounded-xl p-3 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all cursor-pointer group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:shadow-purple-500/50 transition-all">
                <span class="text-white text-sm font-bold">U</span>
            </div>
            <div class="flex-1">
                <div class="text-sm font-semibold text-white">User</div>
                <div class="text-xs text-gray-400">Premium Plan</div>
            </div>
            <svg class="w-5 h-5 text-gray-400 group-hover:text-white group-hover:rotate-90 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </div>
</aside>