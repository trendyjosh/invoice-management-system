import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import mjml from "vite-plugin-mjml";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            ssr: "resources/js/ssr.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        mjml({
            input: "resources/mail",
            output: "resources/views/emails",
            extension: ".blade.php",
        }),
    ],
    server: {
        https: false,
        hmr: {
            host: "localhost",
        },
    },
});
