import { defineConfig} from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel([
            'resource/css/app.css',
            'resource/js/app.js',
        ])
    ]
});