<?php

declare(strict_types = 1);
/** @var Core\Database\Pagination $paginator */
/** @var array $elements */
?>
<?php if ($paginator->hasPages()): ?>
    <nav class="flex items-center justify-between">

        <div class="flex justify-between flex-1 sm:hidden">
            <?php if ($paginator->onFirstPage()) :?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    &laquo; Anterior
                </span>
            <?php else: ?>
                <a href="<?= $paginator->previousPageUrl() ?>"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                >
                    &laquo; Anterior
                </a>
            <?php endif;?>

            <?php if ($paginator->onFirstPage()) :?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    Próximo &raquo;
                </span>
            <?php else: ?>
                <a href="<?= $paginator->previousPageUrl() ?>"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                >
                    Próximo &raquo;
                </a>
            <?php endif;?>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Exibindo
                    <?php if ($paginator->firstItem()) :?>
                        <span class="font-medium"><?= $paginator->firstItem() ?></span>
                        até
                        <span class="font-medium"><?= $paginator->lastItem() ?></span>
                    <?php else: ?>
                        <?= $paginator->count() ?>
                    <?php endif;?>
                    de
                    <span class="font-medium"><?= $paginator->total() ?></span>
                    resultados
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    <?php if ($paginator->onFirstPage()) : ?>
                        <span>
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-l-md">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?= $paginator->previousPageUrl() ?>"
                           class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif;?>

                    <!-- Aqui colocamos os pontos e outros items da paginação -->
                    <?php foreach ($elements as $element) :?>
                        <?php if (is_string($element)) :?>
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">
                                    <?= $element ?>
                                </span>
                            </span>
                        <?php endif;?>

                        <?php if (is_array($element)) :?>
                            <?php foreach ($element as $page => $url) :?>
                                <?php if($page === $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            <?= $page ?>
                                        </span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?= $url ?>"
                                       class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    >
                                        <?= $page ?>
                                    </a>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>

                    <?php endforeach; ?>

                    <?php if ($paginator->hasMorePages()) :?>
                        <a href="<?= $paginator->nextPageUrl() ?>"
                           class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else:?>
                        <span>
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif;?>
                </span>
            </div>
        </div>

    </nav>
<?php endif; ?>
