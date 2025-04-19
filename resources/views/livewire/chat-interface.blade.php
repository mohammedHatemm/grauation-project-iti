<div class="fixed bottom-4 right-4 w-96 flex flex-col h-[600px] bg-white rounded-lg shadow-lg z-50 {{ $isOpen ? '' : 'hidden' }}">
  <!-- Chat Toggle Button -->
  <button
    wire:click="toggle"
    class="fixed bottom-4 right-4 w-14 h-14 bg-emerald-500 text-white rounded-full shadow-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 flex items-center justify-center transition-transform transform hover:scale-110 {{ $isOpen ? 'hidden' : '' }}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
    </svg>
  </button>

  <!-- Chat Window -->
  <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-[500px] {{ $isOpen ? '' : 'hidden' }}">
    <!-- Close Button -->
    <button
      wire:click="toggle"
      class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
    <!-- Chat Header -->
    <div class="p-4 border-b">
      <h3 class="text-lg font-semibold text-black">Shipping Assistant</h3>
      <p class="text-sm text-gray-700">Ask me about your orders and shipping rates</p>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
      @if($error)
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ $error }}</p>
      </div>
      @endif
      @foreach($messages as $msg)
      <div class="flex {{ $msg['role'] === 'assistant' ? 'justify-start' : 'justify-end' }} items-start space-x-2">
        @if($msg['role'] === 'assistant')
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
          </svg>
        </div>
        @endif
        <div class="flex flex-col space-y-2 {{ $msg['role'] === 'assistant' ? 'items-start' : 'items-end' }}">
          <div class="px-4 py-2 rounded-lg {{ $msg['role'] === 'assistant' ? 'bg-gray-100 text-black' : 'bg-emerald-500 text-white' }}">
            <p class="text-sm">{{ $msg['content'] }}</p>
          </div>
          <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($msg['created_at'])->diffForHumans() }}</span>
        </div>
        @if($msg['role'] === 'user')
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        @endif
      </div>
      @endforeach

      @if($loading)
      <div class="flex justify-start items-center space-x-2">
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center animate-pulse">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
          </svg>
        </div>
        <div class="px-4 py-2 rounded-lg bg-gray-100">
          <div class="flex space-x-1">
            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
          </div>
        </div>
      </div>
      @endif
    </div>

    <!-- Chat Input -->
    <div class="p-4 border-t">
      <form wire:submit.prevent="sendMessage" class="flex space-x-2">
        <input
          type="text"
          wire:model="message"
          placeholder="Type your message..."
          class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
          :disabled="loading">
        <button
          type="submit"
          class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
          :disabled="loading || !message.trim()">
          @if($loading)
          <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          @else
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
          </svg>
          @endif
        </button>
      </form>
    </div>

    @push('scripts')
    <script>
      // Scroll to bottom when new messages arrive
      document.addEventListener('livewire:initialized', () => {
        const messagesContainer = document.getElementById('chat-messages');
        const scrollToBottom = () => {
          if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
          }
        };

        // Initial scroll
        scrollToBottom();

        // Scroll on new messages
        Livewire.on('chatMessageSent', scrollToBottom);
        Livewire.on('messageReceived', scrollToBottom);

        // Auto-scroll when messages are loaded
        const observer = new MutationObserver(scrollToBottom);
        if (messagesContainer) {
          observer.observe(messagesContainer, {
            childList: true,
            subtree: true
          });
        }

        // Clean up
        return () => observer.disconnect();
      });
    </script>
    @endpush
  </div>
