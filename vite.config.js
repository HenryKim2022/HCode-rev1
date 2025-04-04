import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            build: {
                outDir: 'build',
            },
        }),
    ],
    server: {
        cors: true,      // Enable CORS for all origins
    },
});





// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//     ],
//     build: {
//         outDir: 'public/build', // Set the output directory to public/build
//         // outDir: 'build',
//         rollupOptions: {
//             output: {
//                 entryFileNames: '[name].[hash].js', // Customize JS file names
//                 chunkFileNames: '[name].[hash].js', // Customize chunk file names
//                 assetFileNames: '[name].[hash][extname]', // Customize asset file names
//             },
//         },
//     },
// });
