<aside class="w-64 bg-[#202123] flex flex-col h-full flex-shrink-0">
    <button @click="startNewChat()" class="flex items-center space-x-2 px-4 py-3 m-2 border border-gray-600 rounded-md hover:bg-gray-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="text-sm">New chat</span>
    </button>
    
    <div class="flex-1 overflow-y-auto px-2 py-2 space-y-2">
        <template x-for="conversation in conversations" :key="conversation.id">
            <div class="group relative">
                <button 
                    @click="loadConversation(conversation.id)"
                    :class="currentConversationId === conversation.id ? 'bg-gray-700' : 'hover:bg-gray-700'"
                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md text-sm text-left transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="flex-1 truncate" x-text="conversation.title"></span>
                </button>
                
                <div class="absolute right-2 top-1/2 -translate-y-1/2 hidden group-hover:flex items-center space-x-1">
                    <button 
                        @click.stop="renameConversation(conversation.id)"
                        class="p-1 hover:bg-gray-600 rounded transition-colors"
                        title="Rename"
                    >
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </button>
                    <button 
                        @click.stop="deleteConversation(conversation.id)"
                        class="p-1 hover:bg-gray-600 rounded transition-colors"
                        title="Delete"
                    >
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
    
    <div class="border-t border-gray-700 px-4 py-3">
        <div class="flex items-center space-x-3 text-sm text-gray-400">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                <span class="text-white text-xs font-medium">U</span>
            </div>
            <span>User</span>
        </div>
    </div>
</aside>