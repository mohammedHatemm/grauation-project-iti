<div x-data="{ isLoading: false, opacity: 0, visibility: 'hidden' }"
     x-init="
        // Watch for isLoading changes and handle opacity transitions
        $watch('isLoading', value => {
            if (value) {
                visibility = 'visible';
                setTimeout(() => {
                    opacity = 100; // Fade in
                }, 50);
            } else {
                // Extended fade out with a slight delay
                setTimeout(() => {
                    opacity = 0;
                    // Hide element completely after transition ends
                    setTimeout(() => {
                        if (!isLoading) {
                            visibility = 'hidden';
                        }
                    }, 1000); // Wait for transition to complete
                }, 200); // Small delay before starting fade out
            }
        });

        window.addEventListener('beforeunload', () => isLoading = true);

        if (typeof Livewire !== 'undefined') {
            Livewire.hook('commit', ({ commit, succeed, fail }) => {
                commit(() => { isLoading = true; });
                succeed(() => { isLoading = false; });
                fail(() => { isLoading = false; });
            });
        }

        document.addEventListener('alpine:init', () => {
            window.addEventListener('htmx:beforeRequest', () => isLoading = true);
            window.addEventListener('htmx:afterRequest', () => isLoading = false);

            const originalFetch = window.fetch;
            window.fetch = async (...args) => {
                try {
                    isLoading = true;
                    const response = await originalFetch(...args);
                    return response;
                } finally {
                    isLoading = false;
                }
            };

            if (typeof axios !== 'undefined') {
                axios.interceptors.request.use(config => {
                    isLoading = true;
                    return config;
                });

                axios.interceptors.response.use(
                    response => {
                        isLoading = false;
                        return response;
                    },
                    error => {
                        isLoading = false;
                        return Promise.reject(error);
                    }
                );
            }
        });

        // Initialize Lottie animation when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            let loaderContainer = document.getElementById('snail-loader');
            lottie.loadAnimation({
                container: loaderContainer,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/snail-loader.json'
            });
        });
     ">

    <!-- Loader with enhanced manual transition -->
    <div x-bind:style="'opacity: ' + opacity + '%; transition: opacity 300ms ease-in-out; visibility: ' + visibility + ';'"
         class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">

        <!-- Snail Lottie Animation -->
        <div id="snail-loader" class="w-96 h-96"></div>
    </div>
</div>
