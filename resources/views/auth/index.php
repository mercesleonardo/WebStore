<div class="sm:mx-auto sm:w-w-full sm:max-w-sm">
    <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Log into your account
    </h2>
</div>

<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="/auth/login" method="POST" class="space-y-6">
        <?php if ($error) : ?>
            <div class="mb-4 px-4 py-4 w-full rounded-lg bg-red-400 text-red-900 font-bold">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                    type="email"
                    id="email"
                    name="email"
                    class="mt-1 block w-full form-input py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required
                    maxlength="100"
                    value="<?= old('email') ?>"
                    autofocus
            >

            <?php if($error = validation_error('email')) : ?>
                <span class="text-sm text-red-400">
                    <?= $error ?>
                </span>
            <?php endif; ?>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
                    type="password"
                    id="password"
                    name="password"
                    class="mt-1 block w-full form-input py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required
                    maxlength="100"
                    value="<?= old('password') ?>"
            >

            <?php if($error = validation_error('password')) : ?>
                <span class="text-sm text-red-400">
                    <?= $error ?>
                </span>
            <?php endif; ?>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Login
            </button>
        </div>
    </form>
</div>