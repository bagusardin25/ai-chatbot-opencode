import { marked } from 'marked';
import DOMPurify from 'dompurify';
import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';
import python from 'highlight.js/lib/languages/python';
import css from 'highlight.js/lib/languages/css';
import xml from 'highlight.js/lib/languages/xml';

hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('python', python);
hljs.registerLanguage('css', css);
hljs.registerLanguage('html', xml);
hljs.registerLanguage('xml', xml);

marked.setOptions({
    highlight: function(code, lang) {
        if (lang && hljs.getLanguage(lang)) {
            return hljs.highlight(code, { language: lang }).value;
        }
        return hljs.highlightAuto(code).value;
    },
    breaks: true,
    gfm: true
});

window.chatApp = function() {
    return {
        inputMessage: '',
        isStreaming: false,
        currentConversationId: null,
        messages: [],
        conversations: [],
        
        init() {
            this.loadFromLocalStorage();
            if (this.conversations.length === 0) {
                this.startNewChat();
            } else {
                this.loadConversation(this.conversations[0].id);
            }
        },
        
        startNewChat() {
            const newId = Date.now().toString();
            const newConversation = {
                id: newId,
                title: 'New chat',
                messages: [],
                createdAt: new Date().toISOString()
            };
            this.conversations.unshift(newConversation);
            this.currentConversationId = newId;
            this.messages = [];
            this.saveToLocalStorage();
        },
        
        loadConversation(id) {
            this.currentConversationId = id;
            const conversation = this.conversations.find(c => c.id === id);
            if (conversation) {
                this.messages = conversation.messages;
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },
        
        sendMessage() {
            if (!this.inputMessage.trim() || this.isStreaming) return;
            
            const userMessage = {
                id: Date.now().toString(),
                role: 'user',
                content: this.inputMessage,
                created_at: new Date().toISOString()
            };
            
            this.messages.push(userMessage);
            this.saveToLocalStorage();
            
            const userMessageContent = this.inputMessage;
            this.inputMessage = '';
            
            if (this.messages.filter(m => m.role === 'user').length === 1) {
                this.autoRenameConversation(userMessageContent);
            }
            
            this.simulateAIResponse(userMessageContent);
        },
        
        async simulateAIResponse(userMessage) {
            this.isStreaming = true;
            
            const aiMessage = {
                id: Date.now().toString(),
                role: 'assistant',
                content: '',
                created_at: new Date().toISOString()
            };
            this.messages.push(aiMessage);
            
            const responses = [
                "Hello! I'm your AI assistant. How can I help you today?",
                "That's an interesting question! Let me think about that...",
                "I'd be happy to help with that. Here's what I know:",
                "Great question! Let me break this down for you..."
            ];
            
            const responseText = responses[Math.floor(Math.random() * responses.length)];
            let currentContent = '';
            
            for (let i = 0; i < responseText.length; i++) {
                currentContent += responseText[i];
                aiMessage.content = currentContent;
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
                await new Promise(resolve => setTimeout(resolve, 30));
            }
            
            this.isStreaming = false;
            this.saveToLocalStorage();
        },
        
        autoRenameConversation(firstMessage) {
            const maxLength = 30;
            const title = firstMessage.length > maxLength 
                ? firstMessage.substring(0, maxLength) + '...' 
                : firstMessage;
            
            const conversation = this.conversations.find(c => c.id === this.currentConversationId);
            if (conversation) {
                conversation.title = title;
                this.saveToLocalStorage();
            }
        },
        
        renameConversation(id) {
            const conversation = this.conversations.find(c => c.id === id);
            if (conversation) {
                const newTitle = prompt('Enter new title:', conversation.title);
                if (newTitle && newTitle.trim()) {
                    conversation.title = newTitle.trim();
                    this.saveToLocalStorage();
                }
            }
        },
        
        deleteConversation(id) {
            if (confirm('Are you sure you want to delete this conversation?')) {
                this.conversations = this.conversations.filter(c => c.id !== id);
                if (this.currentConversationId === id) {
                    if (this.conversations.length > 0) {
                        this.loadConversation(this.conversations[0].id);
                    } else {
                        this.startNewChat();
                    }
                }
                this.saveToLocalStorage();
            }
        },
        
        formatMessage(content) {
            try {
                const html = marked.parse(content);
                return DOMPurify.sanitize(html);
            } catch (e) {
                return content;
            }
        },
        
        formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        
        handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                this.sendMessage();
            }
        },
        
        autoResize(event) {
            const textarea = event.target;
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 128) + 'px';
        },
        
        scrollToBottom() {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },
        
        saveToLocalStorage() {
            const conversation = this.conversations.find(c => c.id === this.currentConversationId);
            if (conversation) {
                conversation.messages = this.messages;
            }
            localStorage.setItem('ai-chat-conversations', JSON.stringify(this.conversations));
        },
        
        loadFromLocalStorage() {
            try {
                const saved = localStorage.getItem('ai-chat-conversations');
                if (saved) {
                    this.conversations = JSON.parse(saved);
                }
            } catch (e) {
                console.error('Failed to load from localStorage:', e);
            }
        }
    };
};