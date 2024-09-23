<?php /** @var App\Models\Product $product */ ?>
<div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
    <div class="flex w-full">
        <img
                src="<?= $product->image ?>"
                title="<?= $product->name ?>"
                alt="<?= $product->name ?>"
                class="w-full h-full object-cover object-center rounded-lg shadow-lg">
    </div>
    <div class="mt-10 px-4">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900">
            <?= $product->name ?>
        </h2>

        <div class="mt-3">
            <p class="text-3xl tracking-tight text-gray-900">
                <?= format_money($product->price) ?>
            </p>
        </div>

        <div class="mt-6">
            <div class="space-y-6 text-base text-gray-700">
                <p><?= $product->description ?></p>
            </div>
        </div>

        <div class="mt-6 flex">
            <button class="
                max-w-xs px-4 py-2 rounded-md
                bg-gray-800 hover:bg-gray-700
                text-base text-white font-medium
                focus:ring-gray-800 focus:ring-2 focus:ring-offset-2
            "   x-data
                @click="$store.cart.addProduct(<?= $product->id ?>)"
            >
                Add to Cart
            </button>
        </div>
    </div>
</div>