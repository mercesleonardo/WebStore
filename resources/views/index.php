<?php require 'includes/head.php'; ?>
<?php require 'includes/top-nav.php'; ?>
<?php require 'includes/header.php'; ?>

<main class="mx-auto max-w-7xl py-6 px-8">
    <h2 class="text-xl loading-6 font-bold text-gray-900">Products</h2>

    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <a href="/product?1d=<?= $product->id ?>">
                    <?= $product->name ?> - <?= format_money($product->price) ?>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
</main>

<?php require 'includes/footer.php'; ?>