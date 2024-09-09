<?php require view('includes/head.php') ?>
<?php require view('includes/top-nav.php') ?>
<?php require view('includes/header.php') ?>

    <main>
        <div class="mx-auto max-w-7xl py-6 px-8">

            <?php if ($messageWasSent) : ?>
                <div class="mb-4 px-4 py-4 w-full rounded-lg bg-green-400 text-green-900 font-bold">
                    Sua mensagem foi enviada com sucesso!
                </div>
            <?php endif ?>

            <?php if ($failure) : ?>
                <div class="mb-4 px-4 py-4 w-full rounded-lg bg-red-400 text-red-900 font-bold">
                    Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.
                </div>
            <?php endif ?>

            <form method="post">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input
                            type="text"
                            id="name"
                            name="name"
                            class="mt-1 block w-full form-input py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required
                            maxlength="100"
                            value="<?= old('name') ?>"
                    >

                    <?php if($error = validation_error('name')) : ?>
                        <span class="text-sm text-red-400">
                        <?= $error ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                            type="email"
                            id="email"
                            name="email"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required
                            maxlength="100"
                            value="<?= old('email') ?>"
                    >

                    <?php if($error = validation_error('email')) : ?>
                        <span class="text-sm text-red-400">
                        <?= $error ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="source" class="block text-sm font-medium text-gray-700">Where did you know us?</label>
                    <select name="source"
                            id="source"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required
                    >
                        <?php foreach ($sources as $source) : ?>
                            <option value="<?= $source ?>" <?= old('source') === $source ? 'selected' : '' ?>>
                                <?= ucfirst($source) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if($error = validation_error('source')) : ?>
                        <span class="text-sm text-red-400">
                        <?= $error ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea
                            id="message"
                            name="message"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required
                            maxlength="255"
                    ><?= old('message') ?></textarea>

                    <?php if($error = validation_error('message')) : ?>
                        <span class="text-sm text-red-400">
                        <?= $error ?>
                    </span>
                    <?php endif; ?>
                </div>

                <button type="reset" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Reset
                </button>

                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit
                </button>
            </form>
        </div>
    </main>

<?php require view('includes/footer.php') ?>