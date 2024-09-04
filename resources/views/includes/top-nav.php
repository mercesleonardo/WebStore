<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4">
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
    </div>
</nav>