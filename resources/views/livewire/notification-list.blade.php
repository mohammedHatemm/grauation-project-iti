<div x-data="{ isOpen: $wire.entangle('showNotifications') }">
  <div class="flex items-center space-x-2">
    <button @click="isOpen = true" class="relative">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      @if($unreadCount > 0)
      <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-2 py-1">{{ $unreadCount }}</span>
      @endif
    </button>
  </div>

  <div x-show="isOpen"
    @click.away="isOpen = false"
    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
    <div class="p-4 border-b">
      <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold">Notifications</h3>
        @if($unreadCount > 0)
        <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800">
          Mark all as read
        </button>
        @endif
      </div>
    </div>

    <div class="max-h-96 overflow-y-auto">
      @forelse($notifications as $notification)
      <div class="p-4 border-b hover:bg-gray-50 {{ !$notification['read_at'] ? 'bg-blue-50' : '' }}">
        <div class="flex justify-between items-start">
          <div class="flex-1">
            <p class="font-medium text-gray-900">{{ $notification['data']['title'] ?? 'Notification' }}</p>
            <p class="text-sm text-gray-600">{{ $notification['data']['message'] ?? '' }}</p>
            <p class="text-xs text-gray-500 mt-1">
              {{ Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
            </p>
          </div>
          @if(!$notification['read_at'])
          <button wire:click="markAsRead({{ $notification['id'] }})" class="text-sm text-blue-600 hover:text-blue-800">
            Mark as read
          </button>
          @endif
        </div>
      </div>
      @empty
      <div class="p-4 text-gray-500">
        No new notifications
      </div>
      @endforelse
    </div>
  </div>
</div>
