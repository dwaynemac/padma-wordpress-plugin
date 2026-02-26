Use wp-plugin-development skill to follow up-to-date WordPress standards

# PADMA WordPress Plugin — Agents

This plugin will forward wordpress form submissions to PADMA CRM.
Submissions are sent to:

`https://crm.padm.am/api/v1/form_integration`

See “Supported Fields” in `README.md` for the exact payload keys the PADMA API accepts and their aliases.

## Overview

When a submission occurs, data flows through a common pipeline:

1. Agent hook receives raw form data from the source plugin.
2. Common filters remove noise fields and per‑agent extras via the `padma_filter_form_data` filter.
3. Global settings are merged via the `padma_merge_options` filter:
   - `padma_username` defaults to the plugin option “Default username for communication” (can be overridden per form).
   - `api_key` always comes from the plugin option, even if the form provided one.
   - `contacted_from_site` comes from the plugin option “Nome do site”.
4. If the special field `padma_ignore_this_form` is present, the payload is NOT forwarded.
5. Otherwise, the payload is POSTed to the PADMA Form Integration endpoint.

## Common Filtering Rules

These keys are stripped from every submission before forwarding (case‑insensitive pattern match):

- `.*captcha.*`
- `.*submit.*`
- `.*_asset.*`
- `url`
- `.*_wpnonce.*`

Each agent can contribute its own additional filters (see below).

## Agents

### 1) Contact Form 7

- Trigger: `wpcf7_mail_sent` (fires after CF7 has sent its email; spam is already filtered).
- Version handling:
  - For CF7 >= 4.1: uses `WPCF7_Submission::get_instance()->get_posted_data()`.
  - For older CF7 (<= 4.1): accesses `$form->posted_data`.
- Additional filtering: removes all internal keys matching `_wpcf7.*`.
- Notes:
  - The plugin checks `WPCF7_VERSION` at load time. If CF7 is missing, loading can fail on some PHP versions. Ensure CF7 is installed and active.

#### Per‑form overrides (CF7 or any agent)

- Ignore a single form:
  ```html
  <input type="hidden" name="padma_ignore_this_form" value="1" />
  ```
- Override the PADMA username for one submission:
  ```html
  <input type="hidden" name="padma_username" value="username.in.padma" />
  ```

### 2) Thrive Leads

- Trigger: `tcb_api_form_submit`.
- Additional filtering: removes keys that end with `_optin` (pattern `.*_optin`).
- Notes: Supported out of the box; no extra configuration is required beyond the global plugin options.

## Merge and Override Behavior

When both plugin settings and form fields supply the same logical value, precedence is:

- `padma_username`: form value overrides the default from plugin options.
- `api_key`: plugin option value overrides any value provided by the form.
- `contacted_from_site`: plugin option value overrides any value provided by the form.

## Supported Fields (Reference)

The PADMA CRM API accepts specific field names and aliases for contacts, identification, address, and other information. For the complete, up‑to‑date list, see the “Supported Fields” section in `README.md`.

## Troubleshooting

- No submissions arriving in PADMA
  - Verify the plugin is active and `Settings > PADMA Options` are correctly filled and saved.
  - Confirm the form has a name field (`name`, `firstname`, or `first_name`).
  - Ensure the form is not sending `padma_ignore_this_form`.
- Contact Form 7 issues
  - Make sure CF7 is installed and active; check `WPCF7_VERSION`.
  - Confirm the event is `wpcf7_mail_sent` and emails are being sent successfully.
- Thrive Leads issues
  - Confirm the form is actually firing `tcb_api_form_submit` upon submit.

## Extending: Adding a New Agent

To integrate another form plugin:

1. Hook into that plugin’s “submission succeeded” event.
2. In your callback, normalize the captured data into a flat associative array and call:
   ```php
   $data = apply_filters('padma_filter_form_data', $data);
   do_action('padma_post_form', $data);
   ```
3. If the source plugin adds its own noise/meta fields, register an additional filter on `padma_filter_form_data` to strip them.
4. Rely on the common pipeline to merge options and post to PADMA.
