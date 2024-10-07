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
                   class="<?= route_is('/contact') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> py-2 px-3 leading-lg rounded-md hover:bg-gray-900 transition transition-all duration-[0.5s]">
                    Contact
                </a>
            </div>

            <div class="flex items-center">

                <div class="relative"
                     x-data
                     @click.away="$store.cart.closeCartMenu()"
                     @keydown.escape.stop="$store.cart.closeCartMenu()"
                >
                    <div>
                        <button
                                class="size-10 text-white rounded-full hover:bg-gray-600 flex items-center justify-center relative"
                                @click="$store.cart.toggleCartMenu()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>

                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full size-5 flex items-center justify-center"
                                x-text="$store.cart.itemsCount() || 0"
                            >

                            </span>
                        </button>
                    </div>

                    <div
                            x-cloak
                            class="absolute top-10 right-0 bg-white w-[180px] p-4 shadow-md border rounded-md max-h-[150px] overflow-auto"
                            style="scrollbar-width: thin"
                            x-show="$store.cart.isMenuOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                    >
                        <div class="flex flex-col gap-8">
                            <template x-if="$store.cart.items.length <= 0">
                                <div class="flex flex-col w-full justify-center items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                                    </svg>

                                    <div class="text-md text-gray-500 font-normal text-center">
                                        Não há itens no carrinho
                                    </div>
                                </div>
                            </template>

                            <template x-if="$store.cart.items.length > 0">
                                <template x-for="product in $store.cart.items">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4 justify-between">
                                            <img :src="product.image"
                                                 :alt="product.name"
                                                 class="size-8 rounded-full border"
                                            />

                                            <div class="flex flex-col gap-1">
                                                <div class="text-sm font-bold" x-text="product.name"></div>
                                                <div class="text-xs font-semibold" x-text="money(product.price)"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>

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