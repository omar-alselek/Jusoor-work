<x-layouts.company>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h1>
            <p class="text-gray-600 dark:text-gray-400">Chat with students and other users</p>
        </div>
        <div class="flex h-[600px] bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Users List -->
            <div class="w-1/3 border-r border-gray-200 dark:border-gray-700">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Chat</h2>
                </div>
                <div class="overflow-y-auto h-full">
                    @foreach($users as $user)
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer user-item" data-user-id="{{ $user->id }}">
                            <div class="flex items-center">
                                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7B2FF5&background=F357A8' }}" 
                                     class="h-10 w-10 rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-800" alt="{{ $user->name }}">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Chat Area -->
            <div class="w-2/3 flex flex-col">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white" id="chat-with">Select a user to chat</h2>
                </div>
                <div class="flex-1 overflow-y-auto p-4" id="messages-container">
                    <!-- Messages will be loaded here -->
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <form id="message-form" class="flex items-center">
                        <input type="hidden" id="receiver-id">
                        <input type="text" id="message-input" 
                               class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                               placeholder="Type your message...">
                        <button type="submit" 
                                class="ml-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        function subscribeToChatChannel() {
            if (window.pusher) {
                var channel = window.pusher.subscribe('chat-channel');
                channel.bind('new-message', function(data) {
                    if (data.message.receiver_id == {{ auth()->id() }} || data.message.sender_id == {{ auth()->id() }}) {
                        appendMessage(data.message);
                    }
                });
            } else {
                setTimeout(subscribeToChatChannel, 200);
            }
        }
        subscribeToChatChannel();

        $(document).ready(function() {
            // دعم فتح الشات مباشرة مع user_id من الرابط
            const urlParams = new URLSearchParams(window.location.search);
            const userIdParam = urlParams.get('user_id');
            if (userIdParam) {
                const userDiv = $(`.user-item[data-user-id='${userIdParam}']`);
                if (userDiv.length) {
                    userDiv.click();
                }
            }
            // استخدم delegated event
            $(document).on('click', '.user-item', function() {
                const userId = $(this).data('user-id');
                const userName = $(this).find('h3').text();
                $('#receiver-id').val(userId);
                $('#chat-with').text('Chat with ' + userName);
                loadMessages(userId);
            });

            $('#message-form').submit(function(e) {
                e.preventDefault();
                const message = $('#message-input').val();
                const receiverId = $('#receiver-id').val();
                if (!receiverId) {
                    alert('Please select a user to chat with');
                    return;
                }
                $.ajax({
                    url: '/chat/send',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        receiver_id: receiverId,
                        message: message
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        appendMessage(response);
                    }
                });
            });
        });

        function loadMessages(userId) {
            $.get('/chat/messages/' + userId, function(messages) {
                $('#messages-container').empty();
                messages.forEach(function(message) {
                    appendMessage(message);
                });
            });
        }

        function appendMessage(message) {
            const isSender = message.sender_id == {{ auth()->id() }};
            const messageHtml = `
                <div class="flex ${isSender ? 'justify-end' : 'justify-start'} mb-4">
                    <div class="max-w-xs ${isSender ? 'bg-indigo-100 dark:bg-indigo-900/30' : 'bg-gray-100 dark:bg-gray-700'} rounded-lg px-4 py-2 shadow-sm">
                        <p class="text-sm ${isSender ? 'text-indigo-800 dark:text-indigo-200' : 'text-gray-800 dark:text-gray-200'}">${message.message}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${new Date(message.created_at).toLocaleTimeString()}</p>
                    </div>
                </div>
            `;
            $('#messages-container').append(messageHtml);
            $('#messages-container').scrollTop($('#messages-container')[0].scrollHeight);
        }
    </script>
    @endpush
</x-layouts.company>