const DEFAULT_TIMEOUT_MS = 60_000;
const POLL_INTERVAL_MS = 1_000;

export async function waitForApp(request, timeoutMs = DEFAULT_TIMEOUT_MS) {
    const deadline = Date.now() + timeoutMs;
    let lastError = null;

    while (Date.now() < deadline) {
        try {
            const response = await request.get('/up', { timeout: 2_000 });

            if (response.ok()) {
                return;
            }

            lastError = new Error(`/up returned HTTP ${response.status()}`);
        } catch (error) {
            lastError = error;
        }

        await new Promise((resolve) => setTimeout(resolve, POLL_INTERVAL_MS));
    }

    throw new Error(
        `Laravel app did not become ready before browser test navigation. Last readiness result: ${lastError?.message ?? 'unknown error'}`
    );
}
