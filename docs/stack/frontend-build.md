# Frontend Build

## Role In App 2.0

Vite and Tailwind power the asset pipeline and styling layer.

## How We Use It

* Vite builds and serves frontend assets
* Laravel integrates with Vite through the framework plugin and Blade helpers
* Tailwind provides utility-first styling with zero runtime CSS generation in production

## Best Practices For This Repo

* keep Laravel as the application server and Vite as the asset pipeline
* keep Tailwind in the styling layer rather than mixing it with application state decisions
* use Blade for current foundation pages
* keep CSS entrypoints and JS entrypoints explicit
* avoid untracked frontend build drift by committing lockfiles

## Official References

* Laravel frontend docs: https://laravel.com/docs/12.x/frontend
* Vite backend integration: https://vite.dev/guide/backend-integration
* Tailwind docs: https://tailwindcss.com/docs

## Practical Commands

```bash
npm install
npm run dev
npm run build
```

## Notes

Tailwind's official Vite guidance currently recommends the dedicated Vite plugin. Our stack should stay close to the current official guidance when we evolve the frontend build setup.
