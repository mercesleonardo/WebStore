<?php require view('includes/head.php') ?>
<?php require view('includes/top-nav.php') ?>
<?php require view('includes/header.php') ?>

<main class="mx-auto max-w-7xl py-6 px-8">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Source</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Message</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <?php foreach ($messages as $message) : ?>
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <?= $message->name ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <?= $message->email ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <?= $message->source ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <?= htmlspecialchars($message->message) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require view('includes/footer.php') ?>