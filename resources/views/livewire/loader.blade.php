<div x-data="{ showLoader: true }"
     x-init="
        // Show loader immediately when the page starts loading
        showLoader = true;

        // Hide loader once the page fully loads
        window.addEventListener('load', () => showLoader = false);

        // Handle Livewire requests
        Livewire.hook('message.sent', () => showLoader = false);
        Livewire.hook('message.received', () => showLoader = false);
        Livewire.hook('message.failed', () => showLoader = false);
     ">

    <!-- Loader -->
    <template x-if="showLoader">
        <div class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
        </div>
    </template>
</div>
