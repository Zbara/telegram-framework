import { fileURLToPath, URL } from "node:url";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import os from 'os';

const hostname = os.hostname();
const homeDirectory = os.homedir();

let conf = {
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/scss/_core.scss',
                'resources/admin/app.js',
            ],
            refresh: true,
        }),
    ],
    preview: {
        port: 8080
    },
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("resources/admin", import.meta.url)),
        },
    },
    server: {
        cors: true,
    }
}

if(hostname === 'SERVER-PC'){
    conf['server'] = {
        hmr: {
            host: 'avtobot.local.geekproger.pro',
        },
        port: 8210,
    }
}
export default defineConfig(conf);
