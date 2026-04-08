# Apache And PHP-FPM

## Role In App 2.0

Apache and PHP-FPM are the planned production runtime on the VPS.

## Why This Stack

* conventional Linux hosting model
* works cleanly with Laravel
* fits the current VPS preparation work
* keeps production infrastructure straightforward while the application architecture evolves

## Best Practices For This Repo

* keep Apache focused on HTTP serving, TLS, vhosts, and proxying PHP execution
* let PHP-FPM own PHP worker management
* keep the Laravel public directory as the served web root
* keep vhost and proxy configuration explicit and minimal
* avoid open proxy behavior or overly broad proxy rules

## Official References

* Apache `mod_proxy_fcgi`: https://httpd.apache.org/docs/2.4/mod/mod_proxy_fcgi.html
* Apache docs index: https://httpd.apache.org/docs/2.4/

## Practical Notes

`mod_proxy_fcgi` requires `mod_proxy` and `mod_proxy_fcgi`. Apache proxies requests to PHP-FPM, but does not manage PHP-FPM itself, so service supervision still matters at the OS layer.

## Related

* [[V2 App/Reference/Reference Index]] | [Reference Index](Reference%20Index.md)
* [[V2 App/Runbooks/Server Readiness]] | [Server Readiness](../Runbooks/Server%20Readiness.md)
