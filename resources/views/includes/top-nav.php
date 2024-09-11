<?php

use Core\Auth\Auth;

?>
<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center justify-start gap-4 h-16">
                <a href="/"
                   class="<?= route_is('/') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> py-2 px-3 leading-lg rounded-md hover:bg-gray-900 transition transition-all duration-[0.5s]">
                    Home
                </a>

                <a href="/contact"
                   class="<?= route_is('/contact') ? 'bg-gray-900 text-white': 'text-gray-300' ?> py-2 px-3 leading-lg rounded-md hover:bg-gray-900 transition transition-all duration-[0.5s]">
                    Contact
                </a>
            </div>

            <div class="flex items-center">
                <?php if (container(Auth::class)->check()) : ?>
                    <div
                        x-data="{ isOpen: false }"
                        @keydown.escape.stop="isOpen = false"
                        @click.away="isOpen = false"
                        class="relative"
                    >
                        <div>
                            <button
                                type="button"
                                class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                @click="isOpen = !isOpen"
                            >
                                <span class="absolute -inset-1.5"></span>
                                <img src="/img/avatar/avatar.png" alt="avatar" class="size-8 rounded-full">
                            </button>
                        </div>

                        <div
                            x-show="isOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md  bg-white py-1 ring-1 ring-black ring-opacity-5 focus:outline-none"
                            @click.away="isOpen = false"
                        >
                            <a
                                href="/auth/logout"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                @click="isOpen = false"
                            >
                                Logout
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>