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
    gfm: true,
    renderer: {
        code: function(code, language) {
            const validLang = language && hljs.getLanguage(language) ? language : 'plaintext';
            const highlighted = hljs.highlight(code, { language: validLang }).value;
            return `<pre><code class="hljs language-${validLang}">${highlighted}</code></pre>`;
        }
    }
});

window.chatApp = function() {
    return {
        inputMessage: '',
        isStreaming: false,
        currentConversationId: null,
        messages: [],
        conversations: [],
        
        init() {
            this.loadConversations();
            if (this.conversations.length === 0) {
                this.startNewChat();
            } else {
                this.loadConversation(this.conversations[0].id);
            }
        },
        
        async loadConversations() {
            try {
                const response = await axios.get('/api/conversations');
                this.conversations = response.data;
            } catch (error) {
                console.error('Failed to load conversations:', error);
            }
        },
        
        startNewChat() {
            this.createConversation('New chat');
        },
        
        async createConversation(title) {
            try {
                const response = await axios.post('/api/conversations', { title });
                this.conversations.unshift(response.data);
                this.currentConversationId = response.data.id;
                this.messages = [];
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            } catch (error) {
                console.error('Failed to create conversation:', error);
            }
        },
        
        async loadConversation(id) {
            try {
                const response = await axios.get(`/api/conversations/${id}`);
                this.currentConversationId = response.data.id;
                this.messages = response.data.messages || [];
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            } catch (error) {
                console.error('Failed to load conversation:', error);
            }
        },
        
        sendMessage() {
            if (!this.inputMessage.trim() || this.isStreaming) return;
            
            const userMessageContent = this.inputMessage;
            this.inputMessage = '';
            
            const userMessage = {
                id: Date.now().toString(),
                role: 'user',
                content: userMessageContent,
                created_at: new Date().toISOString()
            };
            
            this.messages.push(userMessage);
            this.$nextTick(() => {
                this.scrollToBottom();
            });
            
            if (this.messages.filter(m => m.role === 'user').length === 1) {
                this.autoRenameConversation(userMessageContent);
            }
            
            this.streamAIResponse(userMessageContent);
        },
        
        async streamAIResponse(userMessage) {
            this.isStreaming = true;
            
            const aiMessage = {
                id: Date.now().toString(),
                role: 'assistant',
                content: '',
                created_at: new Date().toISOString()
            };
            this.messages.push(aiMessage);
            
            try {
                const url = this.currentConversationId 
                    ? `/api/chat/stream/${this.currentConversationId}`
                    : '/api/chat/stream';
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/event-stream',
                    },
                    body: JSON.stringify({ message: userMessage }),
                });
                
                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';
                
                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;
                    
                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop() || '';
                    
                    for (const line of lines) {
                        if (line.startsWith('data: ')) {
                            const data = JSON.parse(line.slice(6));
                            
                            if (data.done) {
                                this.currentConversationId = data.conversation.id;
                                await this.loadConversations();
                            } else {
                                aiMessage.content += data.content;
                                this.$nextTick(() => {
                                    this.scrollToBottom();
                                });
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Streaming error:', error);
                aiMessage.content = 'Sorry, something went wrong. Please try again.';
            }
            
            this.isStreaming = false;
        },
        
        async autoRenameConversation(firstMessage) {
            const maxLength = 30;
            const title = firstMessage.length > maxLength 
                ? firstMessage.substring(0, maxLength) + '...' 
                : firstMessage;
            
            try {
                await axios.post(`/api/conversations/${this.currentConversationId}/rename`, { title });
                await this.loadConversations();
            } catch (error) {
                console.error('Failed to rename conversation:', error);
            }
        },
        
        async renameConversation(id) {
            const conversation = this.conversations.find(c => c.id === id);
            if (conversation) {
                const newTitle = prompt('Enter new title:', conversation.title);
                if (newTitle && newTitle.trim()) {
                    try {
                        await axios.post(`/api/conversations/${id}/rename`, { title: newTitle.trim() });
                        await this.loadConversations();
                    } catch (error) {
                        console.error('Failed to rename conversation:', error);
                    }
                }
            }
        },
        
        async deleteConversation(id) {
            if (confirm('Are you sure you want to delete this conversation?')) {
                try {
                    await axios.delete(`/api/conversations/${id}`);
                    this.conversations = this.conversations.filter(c => c.id !== id);
                    if (this.currentConversationId === id) {
                        if (this.conversations.length > 0) {
                            this.loadConversation(this.conversations[0].id);
                        } else {
                            this.startNewChat();
                        }
                    }
                } catch (error) {
                    console.error('Failed to delete conversation:', error);
                }
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
            const newHeight = Math.min(textarea.scrollHeight, 160);
            textarea.style.height = newHeight + 'px';
            
            if (newHeight > 52) {
                textarea.classList.add('pt-4');
            } else {
                textarea.classList.remove('pt-4');
            }
        },
        
        scrollToBottom() {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: 'smooth'
                });
            }
        }
    };
};