### **1. Dashboard & Development Tools**

- [x]  Navigate to `/platform/dashboard`
- [x]  Scroll down to find "Development Tools" widget (bottom of dashboard)
- [x]  Verify widget displays with a "Generate Test Notification" button
- [x]  Click the button and verify:
    - A success toast/flash appears: "Test notification generated."
    - A notification appears in the notifications inbox
    - No console errors occur
- [x]  Verify widget is only visible to super-admin users
- Dashboard contains a generic JSON style display notification:
  ```
  <div class="ui-alert-success">
                Test notification generated.
            </div>
  ```
  Remove this from Dashboard - Or better yet, For overall page Success / Error notices, Display these app-wide as pop-ups similar to the notification pop-up. 
### **2. Form Redirects (Save vs. Apply)**

**Test Account Settings Form:**

- [x]  Go to account settings (avatar/name icon > Settings)
- [x]  Make a change to email or password
- [ ]  Click **Save** button → redirects to account settings page (same page)
	- Save button redirects to Dashboard with no additional notice or notification displayed. 
	- Seems that password change took affect, but there is no success / error display at all. See above notice regarding sidewide JSON style notice displays and adjust accordingly. This reverting to dashboard is correct, (Previous screen - but a notice needs to be sent for success)
- [x]  Make another change, click **Apply** button → stays on form
- [ ]  Click **Cancel** button → navigates away without saving
	- Redirects to "My Account" which is different functionally than the save button. Save redirects to previous view page successfully while cancel does not. 
	- Cancel also displays browser "Are you sure" pop-up window.

**Test Settings Form (e.g., General Settings):**

- [x]  Go to Settings > General Settings
- [x]  Make a change to site name or tagline
- [ ]  Click **Save** → redirects to Settings page (list view showing all settings)
	- General settings is a redundant location for both Save and Apply. This is only relevant for forms that were directed from a previous view like a create new user from user table view, etc. Settings files that are accessed via the setup > settings menu do not need this dual function save / apply feature. 
- [x]  Click back into General Settings, make another change, click **Apply** → stays on form
- [x]  Click **Cancel** → goes back to Settings list

**Test User Form:**

- [x]  Go to Setup > Staff Management (or Administration > Users)
- [x]  Click "Create User" button
- [x]  Fill form fields
- [ ]  Click **Save** → creates user and returns to User list
	- Save button row is off main view in some sort of footer. This is wrong. 
	- ```
	  <div class="ui-form-actions mt-8 border-t border-slate-800 pt-6">
    <button type="submit" name="submit_action" value="save" class="ui-button-primary">
        Save User
    </button>

            <button type="submit" name="submit_action" value="apply" class="ui-button-secondary">
            Apply Changes
        </button>
    
            <a href="https://staging.parasolutions.com/platform/users" class="ui-button-ghost" data-bypass-unsaved="">
            Cancel
        </a>
    </div>
	  ```
	- Save and Apply in this application both do nothing. Cancel does successfully redirect to users table view. 
- [ ]  Click back into user, edit, click **Apply** → stays on edit form
- [ ]  Click **Cancel** → back to user list

### **3. Audit & Error Log Tables**

**Audit Logs (`/platform/audit-logs`):**

- [ ]  Verify table header layout:
    - Rows-per-page selector on **left** (shows 25, 50, 100) - Yes
    - Search input + **Filters** collapsible panel on **right** - This is not the previous Filters Icon, it now just displays the word 'Filters' as an action button.
- [ ]  Click **Filters** → expands panel with:
    - Event type dropdown - No, not a drop down. Fillable Field. Please fix
    - Actor text input - This is redundant to search being a fillable field. Users can just search for a name. 
    - Result dropdown - Success (However the severity below the result is a bad location. This was previously in its own column and for some reason was moved)
    - Severity badge selector - Works but the location is really poor. Not sure why this decision was made. 
- [ ]  Enter search term (e.g., a user name) and verify table filters - Works but no clear option to clear search. Should be an Enter / X button on the search bar to indicate to users to press to search (enter keyboard key did work) or click the X to clear filters. 
- [ ]  Click a table row (not on View button) → navigates to audit detail page
	- This is not the Microsoft admin panel style pop-out view for row details that existed in /console/ and was explicited requested to be kept. What happened?
- [ ]  Verify detail page displays: - Will not review as this needs to be reverted to previous pop-out view. 
    - Event info (type, actor, result, severity, occurred_at)
    - Request context (route, method, request ID, IP address)
    - Metadata section (if present, JSON pretty-printed)
- [x]  Click back-to-list link → returns to audit logs table
- [x]  Verify pagination buttons at bottom:
    - Shows current page number **highlighted**
    - Shows ±3 pages around current (bounded range)
    - Prev/Next buttons work
    - Clicking page buttons preserves filters + search

**Error Logs (`/platform/error-logs`):**

- [x]  Verify same table/pagination structure as audit logs
- [ ]  Verify filters panel contains: - Same problem as audit log table. Filters action button is not the filter icon
    - Severity badge selector - works
    - Handled checkbox - works
    - Environment selector (production/staging/local) - No drop down or selector. Just a fillable field
    - Exception class input - No drop down or selector. Just a fillable field
    - Date range picker - works
- [ ]  Click a table row → navigates to error detail page - Same view problem as audit log
- [ ]  Verify detail page displays error info + traceback (if available)

### **4. Docs Tree Navigation**

**Verify Docs Tree Expansion:**

- [ ]  Go to Docs index (`/platform/documentation`) - What in the world happened to the docs font color? Half the docs table is plain white now in light mode. Seems fine in dark mode. 
	- Example Element:
	  `<h1>00 - Start Here</h1>`
	  ```
		  .\[\&_h1\]\:text-white h1 {
	
				1. [ ]  color: var(--color-white);
			
			}
	  ```
	  
- [x]  Scroll down to find a docs tree (nested folders like "Features > Installation > Requirements")
	- And now the markdown viewer is somehow broken? Nested file displays a black background and unformatted text. `<pre>` marks the problem section of the article. :
	  ```
	 <article class="max-w-none text-slate-300
                    [&amp;_h1]:mt-8 [&amp;_h1]:text-3xl [&amp;_h1]:font-semibold [&amp;_h1]:text-white
                    [&amp;_h2]:mt-8 [&amp;_h2]:text-2xl [&amp;_h2]:font-semibold [&amp;_h2]:text-white
                    [&amp;_h3]:mt-6 [&amp;_h3]:text-xl [&amp;_h3]:font-semibold [&amp;_h3]:text-white
                    [&amp;_p]:mt-4 [&amp;_p]:leading-7
                    [&amp;_ul]:mt-4 [&amp;_ul]:list-disc [&amp;_ul]:space-y-2 [&amp;_ul]:pl-6
                    [&amp;_ol]:mt-4 [&amp;_ol]:list-decimal [&amp;_ol]:space-y-2 [&amp;_ol]:pl-6
                    [&amp;_li]:leading-7
                    [&amp;_a]:font-medium [&amp;_a]:text-slate-200 hover:[&amp;_a]:text-white
                    [&amp;_table]:mt-6 [&amp;_table]:w-full [&amp;_table]:border-collapse [&amp;_table]:overflow-hidden [&amp;_table]:rounded-md
                    [&amp;_thead]:bg-slate-950/80
                    [&amp;_th]:border [&amp;_th]:border-slate-800 [&amp;_th]:px-4 [&amp;_th]:py-3 [&amp;_th]:text-left [&amp;_th]:text-sm [&amp;_th]:font-semibold [&amp;_th]:text-white
                    [&amp;_td]:border [&amp;_td]:border-slate-800 [&amp;_td]:px-4 [&amp;_td]:py-3 [&amp;_td]:align-top
                    [&amp;_code]:rounded [&amp;_code]:bg-slate-950 [&amp;_code]:px-1.5 [&amp;_code]:py-0.5 [&amp;_code]:text-slate-200
                    [&amp;_pre]:mt-4 [&amp;_pre]:overflow-x-auto [&amp;_pre]:rounded-md [&amp;_pre]:bg-slate-950 [&amp;_pre]:p-4
                    [&amp;_blockquote]:mt-4 [&amp;_blockquote]:border-l-4 [&amp;_blockquote]:border-slate-700 [&amp;_blockquote]:pl-4 [&amp;_blockquote]:text-slate-400
                    [&amp;_hr]:my-6 [&amp;_hr]:border-slate-800
                    [&amp;_strong]:font-semibold [&amp;_strong]:text-white">
                    <h1>Documentation Template</h1>
<p>Copy this shape when creating a new feature, module, or architecture note.</p>
<pre><code class="language-md"># Title

Parent: [[Parent Index Note]] | [Parent Index Note](../Path/Parent%20Index%20Note.md)

## Purpose

Briefly explain why this exists.

## Current Implementation

Describe how it works today.

## Important Files

- `path/to/file.php`: Why this file matters.

## Data / Tables

List important tables, options, JSON payloads, or config values.

## Permissions / Security

Describe access controls and risks.

## Tenant Considerations

Describe tenant-specific behavior, paths, settings, or data isolation.

## Logging / Observability

Describe expected logs, activity log entries, and operational failure points.

## Common Workflows

List the most common developer/admin workflows.

## Open Questions

Capture unresolved decisions.

## Related

- [[Some Related Note]] | [Some Related Note](../Path/Some%20Related%20Note.md)
</code></pre>
<p>Use this template together with the vault structure guide:</p>
<ul>
<li>identify the canonical home for the concept before creating the note</li>
<li>add an explicit parent/index link</li>
<li>link to the canonical related notes instead of duplicating their content</li>
</ul>
<h2>Related</h2>
<ul>
<li>[[Documentation Standards/Obsidian Vault Structure Guide]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FObsidian%20Vault%20Structure%20Guide.md">Obsidian Vault Structure Guide</a></li>
<li>[[Documentation Standards/How To Write Docs]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FHow%20To%20Write%20Docs.md">How To Write Docs</a></li>
<li>[[Documentation Standards/Templates/Tutorial Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FTutorial%20Template.md">Tutorial Template</a></li>
<li>[[Documentation Standards/Templates/How-To Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FHow-To%20Template.md">How-To Template</a></li>
<li>[[Documentation Standards/Templates/Reference Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FReference%20Template.md">Reference Template</a></li>
<li>[[Documentation Standards/Templates/Explanation Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FExplanation%20Template.md">Explanation Template</a></li>
<li>[[Documentation Standards/Templates/Feature Spec Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FFeature%20Spec%20Template.md">Feature Spec Template</a></li>
<li>[[Documentation Standards/Templates/Runbook Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FRunbook%20Template.md">Runbook Template</a></li>
<li>[[Documentation Standards/Templates/ADR Template]] | <a href="https://staging.parasolutions.com/platform/docs?path=Documentation%20Standards%2FTemplates%2FADR%20Template.md">ADR Template</a></li>
</ul>

                </article>
	  ```
- [x]  Click a leaf document (e.g., "Requirements")
- [x]  Verify:
    - All parent `<details>` elements expand to show the path
    - The active document is highlighted
    - Page scrolls to make the active document visible
    - Tree collapses when you navigate to a different top-level section

### **5. Account Menu Click-Away**

**Verify Account Menu Closes on Click-Away:**

- [x]  Click your avatar/account icon in top-right corner
- [x]  Menu opens showing Settings, Preferences, Logout
- [x]  Click **outside the menu** (on the page background) → menu closes
- [x]  Open menu again, press **ESC** key → menu closes
- [ ]  Mobile test (resize browser to mobile): verify hamburger/account menu is accessible

### **6. Sidebar Mobile Visibility**

**Verify Sidebar is Always Visible:**

- [ ]  Resize browser to mobile width (< 600px)
- [ ]  Verify sidebar **remains visible** on left (not hidden by default)
- [ ]  Sidebar should not require a toggle to show
- [ ]  Navigate to different pages and verify sidebar stays visible

Sidebar displays full width and at the top of the page, which is extremely annoying to have to scroll down towards. Sidebar menu should instead be a collapsible pop out and in from the left hand side that when minimized displays a little action button in the top left with the standard 3 lines icon for menu that expands and collapses the sidebar menu for navigation. 
### **7. Light Mode Contrast**

**Verify Light Mode Color Contrast:**

- [x]  Change theme to Light mode (if theme selector exists in settings)
- [x]  Navigate to audit-logs and error-logs tables
- [x]  Verify all elements are readable:
    - **Buttons**: Dark text on light background (Save/Apply/Cancel, View buttons)
    - **Alerts**: Emerald text on light green background (success), Rose text on light red background (error)
    - **Table pagination buttons**: Current page is darker, non-current pages lighter
    - **Badges**: Severity badges (amber, emerald, rose) have readable text
    - **Form labels & inputs**: Dark text, clean borders, not washed-out
- [ ]  Verify no "white-on-white" or "light-on-light" combinations
	- You fixed some of the colored problems, but you've broken a significant portion of the Docs viewer in light mode now. Not sure what happened but that is ridiculous.

### **8. Navigation Structure (Setup Sidebar)**

**Verify Navigation Reorganization:**

- [x]  Go to Administration (or Setup if configured)
- [x]  In the settings sidebar, verify:
    - Setup section headers are properly labeled ("Setup Admin", "Setup Logs", "Setup Base")
    - Audit logs and Error logs are **grouped under "Setup Logs"** (not scattered)
    - Each section is collapsible/expandable if using nested groups
    - "Back to Setup" button at sidebar bottom returns to setup home

### **9. Shared Form Components**

**Verify Flash Messages & Action Bars:**

- [ ]  Navigate to any form (settings, account, user, etc.)
- [ ]  Verify:
    - Flash messages at **top** of form (success/error alerts using `.ui-alert-success` or `.ui-alert-error` styling) - This is bad in general and I am not a fan. Flash messages would be better implemented in a similar style to notification pop-up windows. 
    - Action bar at **bottom** with Save, Apply, Cancel buttons (using `.ui-button-*` classes)
	    - Broken on create / edit user. Off page and at bottom as a footer and non-functioning. 
    - Buttons are consistent in style and spacing across all forms

### **10. Unsaved Form Guard**

**Verify Unsaved Changes Warning:**

- [x]  Navigate to a form
- [x]  Change an input field
- [x]  Attempt to navigate away (click a nav link, go back, etc.)
- [x]  A browser confirmation dialog should appear: "You have unsaved changes"
- [x]  Clicking "Stay" keeps you on the form
- [x]  Submitting the form (Save/Apply) clears the guard, allowing navigation
- [x]  Clicking a link on the form (not a navigation link) should **not** trigger the guard

### **11. Settings Change Requests:**
1. No dropdown and standard timezones options or locale options mapped from V1 and utilized in General Settings General tab
	1. Same for Localization: Time Format, Date Format, Default Language
2. Vault Access Settings
	1. Options in light mode are poorly displayed. Backgrounds are too similar, non-standardized option display toggle sizes, and hard to tell which option is actually enabled / active and which isn't. 
		1. This current Active Vs Inactive display is a standardized problem with light mode defaults that needs to be addressed. 

### **12.Misc Notes & Change Requests:**
1. Remove visual displays of 'Platform' site wide.