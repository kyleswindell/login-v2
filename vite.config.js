import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");
    const devServerUrl = env.VITE_DEV_SERVER_URL || "http://localhost:5173";
    const appUrl = env.APP_URL || "http://localhost:8000";
    const browserTestUrl =
        env.PLAYWRIGHT_BASE_URL || "http://laravel.test:8000";
    const reverbProxyTarget =
        env.REVERB_DEV_PROXY_TARGET ||
        `http://127.0.0.1:${env.REVERB_SERVER_PORT || 8080}`;
    const devServer = new URL(devServerUrl);
    const app = new URL(appUrl);
    const browserTest = new URL(browserTestUrl);
    const usePolling = env.VITE_USE_POLLING === "true";
    const pollingInterval = Number(env.VITE_POLLING_INTERVAL || 1000);

    return {
        plugins: [
            {
                name: "app-css-full-reload",
                handleHotUpdate({ file, server }) {
                    if (
                        file
                            .replaceAll("\\", "/")
                            .endsWith("/resources/css/app.css")
                    ) {
                        server.config.logger.info(
                            "app.css changed; sending full browser reload",
                        );
                        server.ws.send({ type: "full-reload", path: "*" });

                        return [];
                    }
                },
            },
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            host: "0.0.0.0",
            port: Number(devServer.port || 5173),
            strictPort: true,
            origin: devServerUrl,
            cors: {
                origin: [
                    app.origin,
                    browserTest.origin,
                    "http://localhost:8000",
                    "http://127.0.0.1:8000",
                ],
            },
            allowedHosts: [
                "localhost",
                "127.0.0.1",
                "host.docker.internal",
                "node",
                app.hostname,
                browserTest.hostname,
                devServer.hostname,
            ],
            hmr: {
                host: devServer.hostname,
                port: Number(devServer.port || 5173),
                protocol: devServer.protocol === "https:" ? "wss" : "ws",
            },
            proxy: {
                "/app": {
                    target: reverbProxyTarget,
                    changeOrigin: true,
                    ws: true,
                },
            },
            watch: {
                ignored: ["**/storage/framework/views/**"],
                usePolling,
                interval: pollingInterval,
            },
        },
    };
});
