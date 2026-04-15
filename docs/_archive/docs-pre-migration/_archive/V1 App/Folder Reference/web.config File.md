# web.config File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/web.config`

## Purpose

This note describes the IIS rewrite config at the V1 app web root.

## Current Behavior

The current file:

- defines a single catch-all rewrite rule
- skips rewrites for existing files and directories
- rewrites other requests to `index.php?url={R:1}`

## Notes

- This is the IIS counterpart to the Apache `.htaccess` front-controller routing behavior.
- It affects request entry, not the deeper tenant database selection logic.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](../Architecture/Request%20And%20Database%20Routing.md)
