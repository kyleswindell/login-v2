# Profile Mfg static POC

This temporary module provides the authenticated, read-only Profile Mfg presentation workspace. It is intentionally self-contained and is not the permanent architecture for customer, inventory, part, or order capabilities.

The presentation routes cover a daily/weekly shipping schedule, finished-goods inventory comparison, serialized scan activity, an operational report catalog, and customer, part, and order list/detail views. The schedule is the operational home because it is the current employee coordination workflow. Scan-in/ship-out transactions remain disabled; the scan page is read-only activity and exception context. Search, filters, record creation, order closing, inventory transactions, exports, and editing are intentionally disabled.

The POC sidebar links to the existing authenticated Profile and Preferences pages. Employees-and-access and application-settings links use the platform's existing permissions and routes. The POC does not duplicate or bypass those Core capabilities.

## Runtime controls

- `PROFILE_MFG_POC_ENABLED=false` keeps the existing dashboard active and makes the POC routes return `404` for authenticated requests.
- `PROFILE_MFG_POC_DATA_PATH=storage/app/private/profile-mfg-poc.json` points to the normalized private JSON snapshot.
- `PROFILE_MFG_POC_MEDIA_PATH=storage/app/private/profile-mfg-poc-media` points to private part-image files referenced by the snapshot.
- Presentation environments should set `APP_NAME="Profile Mfg"`.

The runtime does not parse CSV files. Convert a curated export to the JSON contract represented by `tests/Fixtures/profile-mfg-poc.json`, then place the real snapshot at the configured private path. The private storage directory is ignored by Git.

Supported statuses are:

- Customers: `active`, `obsolete`
- Parts: `active`, `service`, `obsolete`, `purchase`, `wip`
- Orders: `open`, `shorted`, `closed`, `cancelled`
- Scans: direction `in` or `out`; result `accepted` or `rejected`

`scans[]` is optional and contains a stable ID, related part ID, direction, manufactured date, serial number, scan timestamp, result, and optional message/additional fields. Each accepted scan represents one serialized box. Piece totals are calculated only when the related part supplies pieces per box.

Parts may provide an `image_file` basename. Images are resolved only from the configured private media directory, validated as JPEG, PNG, GIF, or WebP, and served through the authenticated part-image route with private no-store headers. Files, absolute paths, nested paths, and image contents remain outside Git and the JSON response surface.

The source system exposes two inventory perspectives. The POC treats serialized boxes as the physical finished-goods signal and retains the aggregate part balance as a separate reconciliation value. Full-box pieces are calculated only when both a serialized box count and pieces-per-box value were supplied. The POC does not infer loose pieces, allocate stock, or combine the two values into one authoritative quantity.

## Removal

After the presentation, first disable `PROFILE_MFG_POC_ENABLED`. Then remove this module, its entries in `app/Core/Modules/Definitions.php`, the redirect seam in `Modules/Dashboard/Http/Controllers/ShowDashboardController.php`, the POC environment settings, the browser proof, and the private JSON/media snapshot.
