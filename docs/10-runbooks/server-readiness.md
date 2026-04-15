# Server Readiness

This document defines the canonical scope and intent for Server Readiness.

## Production Host

SSH alias:

```sshconfig
Host platform-prod
    HostName 159.89.185.57
    User deploy
    IdentityFile C:\Users\kswin\.ssh\id_ed25519
    Port 22
    StrictHostKeyChecking accept-new
```

## Known Installed Services

Based on planning notes:

* Apache2
* PHP 8.3 and required modules
* PostgreSQL
* Redis server

## Verification Checklist

Before deployment scaffold work:

* Confirm PHP 8.3 CLI is installed.
* Confirm PHP-FPM is installed and enabled if Apache + PHP-FPM remains the production path.
* Confirm Apache modules for proxy/FPM, rewrite, headers, SSL, and vhosts.
* Confirm PHP extensions for PostgreSQL, Redis, mbstring, XML, cURL, zip, bcmath, intl, image handling, and fileinfo.
* Confirm Composer is installed.
* Confirm PostgreSQL is running and reachable locally.
* Confirm Redis is running and not publicly exposed.
* Confirm Node.js/npm availability for Vite and future Astro builds.
* Confirm firewall rules only expose expected ports.
* Confirm Certbot/Let's Encrypt plan for platform and tenant domains.
* Confirm backup plan before tenant data is created.

## Related

* [Runbook Index](index.md)
* [00-start-here](../00-start-here.md)
* [Stack - Apache And PHP-FPM](../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* [Stack - Docker Compose](../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
