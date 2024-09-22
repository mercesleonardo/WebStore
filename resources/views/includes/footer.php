        </div>

        <div class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
            <div class="flex w-full flex-col items-center space-y-4 sm:items-end" id="notifications"></div>
        </div>

        <script>
            window.onload = () => {
                <?php /** @var App\Helpers\Toast|null $toast */ ?>
                <?php if ($toast = Core\Facades\Session::getFlash('toast')): ?>
                window.toast('<?= $toast->type ?>', '<?= $toast->message ?>');
                <?php endif; ?>
            }
        </script>

    </body>
</html>