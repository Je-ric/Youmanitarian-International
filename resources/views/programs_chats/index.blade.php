@extends('layouts.sidebar_final')

@section('content')
    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        Program Group Chats
                    </h1>
                    <p class="text-gray-600">Communicate with program volunteers and coordinators</p>
                </div>
            </div>
        </div>

        <!-- Program Chats List -->
        @if($coordinatorPrograms->isNotEmpty())
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-[#1a2235] mb-4">Programs You Coordinate</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($coordinatorPrograms as $program)
                    <a href="{{ route('program.chats.show', $program) }}" 
                       class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-[#1a2235]">{{ $program->title }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    Coordinator
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class='bx bx-group mr-1'></i>
                                <span>{{ $program->volunteers->count() }} Volunteers</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-message-square-dots mr-1'></i>
                                <span>{{ $program->chats->count() }} Messages</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($volunteerPrograms->isNotEmpty())
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-[#1a2235] mb-4">Programs You Volunteer For</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($volunteerPrograms as $program)
                    <a href="{{ route('program.chats.show', $program) }}" 
                       class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-[#1a2235]">{{ $program->title }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Volunteer
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class='bx bx-group mr-1'></i>
                                <span>{{ $program->volunteers->count() }} Volunteers</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-message-square-dots mr-1'></i>
                                <span>{{ $program->chats->count() }} Messages</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($program))
        <!-- Chat Interface -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                        <i class='bx bx-message-square-dots mr-2 text-[#ffb51b]'></i>
                        Group Chat - "{{ $program->title }}"
                    </h3>
                    <a href="{{ route('programs.volunteers', $program) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class='bx bx-arrow-back mr-2'></i> Back to Program
                    </a>
                </div>
            </div>
            
            <div class="flex flex-col h-[600px]">
                <!-- Chat Messages Area -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chatMessages">
                    <!-- Loading indicator -->
                    <div id="loadingMessages" class="text-center py-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-[#ffb51b] border-t-transparent"></div>
                        <p class="mt-2 text-gray-600">Loading messages...</p>
                    </div>
                    
                    <!-- Error message -->
                    <div id="errorMessage" class="hidden text-center py-4">
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg">
                            <i class='bx bx-error-circle text-2xl mb-2'></i>
                            <p>Failed to load messages. Please try again.</p>
                        </div>
                    </div>
                </div>

                <!-- Message Input Area -->
                <div class="border-t border-gray-200 p-4">
                    <form id="chatForm" class="flex gap-2">
                        <div class="flex-1">
                            <input type="text" 
                                   id="messageInput" 
                                   class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                   placeholder="Type your message..."
                                   required>
                        </div>
                        <button type="submit" 
                                id="sendButton"
                                class="px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors">
                            <i class='bx bx-send'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
    // Get the program ID
    const programId = '{{ $program->id ?? "" }}';

    // Get all the elements we need
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const loadingMessages = document.getElementById('loadingMessages');
    const errorMessage = document.getElementById('errorMessage');
    const sendButton = document.getElementById('sendButton');

    // Function to show loading state
    function showLoading() {
        loadingMessages.classList.remove('hidden');
        errorMessage.classList.add('hidden');
    }

    // Function to show error state
    function showError() {
        loadingMessages.classList.add('hidden');
        errorMessage.classList.remove('hidden');
    }

    // Function to create a message element
    function createMessageElement(message) {
        // Create the message container
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex gap-3';
        
        // Create the avatar
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'flex-shrink-0';
        const avatarImg = document.createElement('img');
        avatarImg.src = message.sender.profile_pic || '/images/default-avatar.png';
        avatarImg.alt = message.sender.name;
        avatarImg.className = 'w-10 h-10 rounded-full';
        avatarDiv.appendChild(avatarImg);
        
        // Create the message content
        const contentDiv = document.createElement('div');
        contentDiv.className = 'flex-1';
        
        // Create the header (name and time)
        const headerDiv = document.createElement('div');
        headerDiv.className = 'flex items-center gap-2';
        
        const nameSpan = document.createElement('span');
        nameSpan.className = 'font-medium text-[#1a2235]';
        nameSpan.textContent = message.sender.name;
        
        const timeSpan = document.createElement('span');
        timeSpan.className = 'text-sm text-gray-500';
        timeSpan.textContent = new Date(message.created_at).toLocaleTimeString();
        
        headerDiv.appendChild(nameSpan);
        headerDiv.appendChild(timeSpan);
        
        // Create the message text
        const messageP = document.createElement('p');
        messageP.className = 'mt-1 text-gray-700';
        messageP.textContent = message.message;
        
        // Put it all together
        contentDiv.appendChild(headerDiv);
        contentDiv.appendChild(messageP);
        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(contentDiv);
        
        return messageDiv;
    }

    // Function to load messages
    async function loadMessages() {
        if (!programId) return;
        
        try {
            showLoading();
            
            const response = await fetch(`{{ route('program.chats.messages', ['program' => ':programId']) }}`.replace(':programId', programId));
            if (!response.ok) {
                throw new Error('Failed to load messages');
            }
            
            const data = await response.json();
            
            // Clear the messages area
            chatMessages.innerHTML = '';
            loadingMessages.classList.add('hidden');
            
            // Add each message
            data.data.forEach(message => {
                const messageElement = createMessageElement(message);
                chatMessages.appendChild(messageElement);
            });
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
        } catch (error) {
            console.error('Error loading messages:', error);
            showError();
        }
    }

    // Function to send a message
    async function sendMessage(message) {
        if (!programId) return;
        
        try {
            // Disable the send button
            sendButton.disabled = true;
            sendButton.classList.add('opacity-50');
            
            const response = await fetch(`{{ route('program.chats.store', ['program' => ':programId']) }}`.replace(':programId', programId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    message: message,
                    message_type: 'regular'
                })
            });
            
            if (!response.ok) {
                throw new Error('Failed to send message');
            }
            
            // Clear the input
            messageInput.value = '';
            
            // Reload messages
            await loadMessages();
            
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        } finally {
            // Re-enable the send button
            sendButton.disabled = false;
            sendButton.classList.remove('opacity-50');
        }
    }

    // Handle form submission
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            sendMessage(message);
        });

        // Load messages when the page loads
        loadMessages();

        // Check for new messages every 30 seconds
        setInterval(loadMessages, 30000);
    }
    </script>
@endsection 