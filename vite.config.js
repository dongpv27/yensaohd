import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/header.css',
                'resources/css/style-layout.css',
                'resources/css/product.css',
                'resources/css/footer.css',
                'resources/css/product-detail.css',
                'resources/css/checkout.css',
                'resources/css/cart.css',
                'resources/css/responsive.css',
                'resources/css/utilities.css',
                'resources/css/news.css',
                'resources/css/mobile-product-modal.css',
                'resources/css/promotion-carousel.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/header.js',
                'resources/js/footer.js',
                'resources/js/cart-toast.js',
                'resources/js/mobile-product-modal.js'
            ],
            refresh: true,
        }),
    ],
});
