<h2 class="text-xl leading-6 font-bold text-gray-900">Products</h2>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-10">
    <?php foreach ($products as $product) : ?>
        <div class="p-4 bg-white rounded-lg shadow-md mb-8">
            <div class="relative">
                <div class="relative max-h-[161px] w-full overflow-hidden rounded-lg">
                    <img src="<?= $product->image ?>" class="max-h-[161px] w-full" alt="Product Image" />
                </div>

                <div class="relative mt-4">
                    <h3 class="text-sm font-medium text-gray-800">
                        <?= $product->name ?>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 h-[200px] overflow-ellipsis">
                        <?= $product->description ?>
                    </p>

                    <div class="pt-3 text-sm font-medium text-gray-400">
                        <?= format_money($product->price) ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a class="flex items-center justify-center rounded-md border border-transparent px-8 py-2 text-sm font-medium
                        bg-gray-200 hover:bg-gray-300 transition duration-150 ease-in-out"
                       href="/product?id=<?= $product->id ?>"
                    >
                        View Product
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-4">
    <?= $products->links() ?>
</div>
