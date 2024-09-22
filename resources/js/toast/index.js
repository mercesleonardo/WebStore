const ToastTitles = {
    success: 'Success',
    error: 'Error',
    warning: 'Warning',
    info: 'Information',
};

const MainColors = {
    success: 'text-green-400',
    error: 'text-red-400',
    warning: 'text-yellow-400',
    info: 'text-blue-400',
};

const toastContainer = document.getElementById('notifications')

const toast = function (type, message) {
    const toastId = Math.floor(Math.random() * 1000);
    const toast = document.createElement('div');

    toast.innerHTML = `
        <div class="p-4" id="${toastId}">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ${MainColors[type]} animation-swing">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium ${MainColors[type]}">${ToastTitles[type]}</p>
                    <p class="mt-1 text-sm text-gray-500">${message}</p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button
                        type="button"
                        class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        onclick=""
                    >
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>                    
                    </button>
                </div>
            </div>
        </div>
    `;

    toast.classList.add('notification', 'hidden')
    toastContainer.appendChild(toast)

    toast.classList.remove('hidden')
}

export default toast