<?php require 'includes/head.php'; ?>
<?php require 'includes/top-nav.php'; ?>
<?php require 'includes/header.php'; ?>

<main class="mx-auto max-w-7xl py-6 px-8">
    <?php if ($product): ?>
        <h2 class="text-xl loading-6 font-bold text-gray-900"><?= $product->name?> - <?= format_money($product->price) ?></h2>

        <p class="mt-4 text-gray-600">
            Description:
            <br>
            <small class="text-gray-700">
                <?= $product->description ?>
            </small>
        </p>
    <?php endif;?>
</main>

<?php require 'includes/footer.php'; ?>