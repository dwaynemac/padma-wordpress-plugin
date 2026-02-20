# PADMA WordPress Plugin

This plugin forwards form submissions from WordPress to PADMA CRM using:

- Contact Form 7 (`wpcf7_mail_sent`)
- Thrive Leads (`tcb_api_form_submit`)

Submissions are sent to:

`https://crm.padm.am/api/v1/form_integration`

## Prerequisites

- WordPress admin access.
- A valid PADMA API key. (https://deroseapp.notion.site/DeROSE-app-API-KEYs-e4d01c76e83743bda023941d99cb0f39)
- At least one form field named `name`, `firstname`, or `first_name`.
- Contact Form 7 installed and active.
  - Current plugin code checks `WPCF7_VERSION` directly during load.
  - If Contact Form 7 is missing, the plugin can fail to load on modern PHP versions.
- Thrive Leads is optional, but supported.

## Install The Plugin

1. Copy this plugin folder to:
   `wp-content/plugins/padma-wordpress-plugin`
2. In WordPress Admin, open `Plugins`.
3. Activate `PADMA Wordpress Plugin`.

## Configure Global Settings

1. In WordPress Admin, open:
   `Settings > PADMA Options`
2. Configure these fields:
   - `PADMA API KEY`
   - `Default username for communication`
   - `Nome do site`
3. Save.

### What each setting does

- `PADMA API KEY`: sent as `api_key` in every forwarded payload.
- `Default username for communication`: sent as `padma_username` unless overridden per form.
- `Nome do site`: sent as `contacted_from_site` in every forwarded payload.

## Per-Form Configuration

### Ignore a form (do not forward)

Add a hidden field:

```html
<input type="hidden" name="padma_ignore_this_form" value="1" />
```

### Override communication username for one form

Add a hidden field:

```html
<input type="hidden" name="padma_username" value="username.in.padma" />
```

This overrides the default username from plugin settings for that submission.

## Contact Form 7 Notes

- The plugin forwards only after a successful mail send event (`wpcf7_mail_sent`).
- Contact Form 7 internal fields matching `_wpcf7*` are removed before forwarding.
- Standard noise fields are also removed (see filtering section below).

## Thrive Leads Notes

- The plugin forwards submissions from `tcb_api_form_submit`.
- Thrive Leads fields matching `*_optin` are removed before forwarding.
- Standard noise fields are also removed (see filtering section below).

## Payload Filtering Rules

Before forwarding, these keys are removed when their names match:

- `.*captcha.*`
- `.*submit.*`
- `.*_asset.*`
- `url`
- `.*_wpnonce.*`
- Contact Form 7 only: `_wpcf7.*`
- Thrive Leads only: `.*_optin`

## Merge And Override Behavior

When plugin settings and form fields both provide the same key:

- `padma_username`: form value wins over default plugin value.
- `api_key`: plugin option value wins over form value.
- `contacted_from_site`: plugin option value wins over form value.

## Verification Checklist

1. Confirm plugin is active.
2. Confirm `Settings > PADMA Options` is filled and saved.
3. Submit a test form from Contact Form 7 or Thrive Leads.
4. Confirm the form includes a name field (`name`, `firstname`, or `first_name`).
5. Ensure `padma_ignore_this_form` is not present unless intentionally skipping forwarding.

## Troubleshooting

- No submissions in PADMA:
  - Recheck API key in `Settings > PADMA Options`.
  - Recheck required name field.
  - Recheck that the form is not setting `padma_ignore_this_form`.
- Plugin fails to load:
  - Ensure Contact Form 7 is installed and activated.
- Unexpected username in PADMA:
  - Check if the form includes `padma_username` hidden input (it overrides default).
