# Organization Configuration Guide

## Overview
This CBT application now includes a flexible organization configuration system that allows you to easily change organization details without modifying code throughout the application.

## Configuration Location
All organization details are configured in: `app/Helpers/General.php`

## Available Configuration Constants

```php
// Organization Configuration
const ORG_NAME = 'Community Health Practitioners Registration Board of Nigeria';
const ORG_SHORT_NAME = 'CHPRBN';
const ORG_ACRONYM = 'CHPRBN';
const ORG_WEBSITE = 'https://chprbn.gov.ng';
const ORG_EMAIL = 'info@chprbn.gov.ng';
const ORG_PHONE = '+234-XXX-XXX-XXXX';
const ORG_ADDRESS = 'Abuja, Nigeria';
```

## How to Change Organization

### Step 1: Update Constants
Edit the constants in `app/Helpers/General.php`:

```php
// Example: Changing to a different organization
const ORG_NAME = 'National Medical Registration Board';
const ORG_SHORT_NAME = 'NMRB';
const ORG_ACRONYM = 'NMRB';
const ORG_WEBSITE = 'https://nmrb.gov.ng';
const ORG_EMAIL = 'info@nmrb.gov.ng';
const ORG_PHONE = '+234-123-456-7890';
const ORG_ADDRESS = 'Lagos, Nigeria';
```

### Step 2: Clear Application Cache
Run the following command to ensure changes take effect:
```bash
php artisan config:clear
php artisan cache:clear
```

## Available Helper Functions

### Basic Functions
- `org_name()` - Returns full organization name
- `org_short_name()` - Returns short organization name
- `org_acronym()` - Returns organization acronym
- `org_website()` - Returns organization website URL
- `org_email()` - Returns organization email
- `org_phone()` - Returns organization phone number
- `org_address()` - Returns organization address

### Advanced Functions
- `org_display_name($format)` - Returns formatted name
  - `org_display_name('full')` - Full name
  - `org_display_name('short')` - Short name
  - `org_display_name('acronym')` - Acronym only
- `org_full_details()` - Returns array of all organization details

## Usage Examples in Views

### Basic Usage
```blade
{{-- Display full organization name --}}
<h1>{{ org_name() }}</h1>

{{-- Display acronym --}}
<title>{{ org_acronym() }} CBT System</title>

{{-- Link to website --}}
<a href="{{ org_website() }}">{{ org_short_name() }}</a>

{{-- Footer with dynamic year --}}
<p>Copyright {{ date('Y') }} {{ org_acronym() }}. All Rights Reserved</p>
```

### Advanced Usage
```blade
{{-- Conditional display based on format --}}
<h2>{{ org_display_name('short') }} Examination Portal</h2>

{{-- Contact information --}}
<div class="contact-info">
    <p>Email: {{ org_email() }}</p>
    <p>Phone: {{ org_phone() }}</p>
    <p>Address: {{ org_address() }}</p>
</div>

{{-- Using all details --}}
@php $org = org_full_details(); @endphp
<div class="organization-info">
    <h3>{{ $org['name'] }}</h3>
    <p>{{ $org['address'] }}</p>
    <a href="{{ $org['website'] }}">Visit Website</a>
</div>
```

## Usage Examples in Controllers

```php
// In a controller method
public function generateReport()
{
    $organizationName = org_name();
    $reportTitle = org_display_name('short') . ' Examination Report';
    
    return view('reports.summary', compact('organizationName', 'reportTitle'));
}

// Passing all organization details to a view
public function aboutPage()
{
    $organization = org_full_details();
    return view('pages.about', compact('organization'));
}
```

## Files Already Updated

The following files have been updated to use the helper functions:

1. **layouts/app.blade.php**
   - Page title: `{{ org_acronym() }} CBT Exam`
   - Meta author: `{{ org_acronym() }}`

2. **commons/footer.blade.php**
   - Copyright: `Copyright {{ date('Y') }} {{ org_acronym() }}`
   - Website link: `{{ org_website() }}`

3. **commons/header.blade.php**
   - Welcome text: `{{ org_name() }}`

## Benefits

✅ **Centralized Management** - Change organization details in one place
✅ **Consistency** - Same organization name used throughout the application
✅ **Easy Maintenance** - No need to search and replace across multiple files
✅ **Flexible Display** - Different formats (full, short, acronym) for different contexts
✅ **Future-Proof** - Easy to rebrand or deploy for different organizations
✅ **Type Safety** - Helper functions ensure consistent data types

## Migration Guide

To migrate existing hardcoded organization references:

1. **Search for hardcoded references:**
   ```bash
   grep -r "Community Health" resources/views/
   grep -r "CHPRBN" resources/views/
   ```

2. **Replace with helper functions:**
   - `Community Health Practitioners Registration Board of Nigeria` → `{{ org_name() }}`
   - `CHPRBN` → `{{ org_acronym() }}`
   - `https://chprbn.gov.ng` → `{{ org_website() }}`

3. **Test thoroughly:**
   - Check all pages that display organization information
   - Verify emails and notifications use helper functions
   - Ensure reports and exports show correct organization details

## Troubleshooting

### Helper Functions Not Working
- Ensure `app/Helpers/General.php` is included in `composer.json` autoload
- Run `composer dump-autoload` to refresh autoload files
- Clear application cache: `php artisan cache:clear`

### Changes Not Appearing
- Clear config cache: `php artisan config:clear`
- Clear view cache: `php artisan view:clear`
- Restart web server if using local development

## Example: Changing to a Different Organization

To change from CHPRBN to another organization (e.g., Medical Laboratory Science Council):

1. **Update constants in `app/Helpers/General.php`:**
```php
const ORG_NAME = 'Medical Laboratory Science Council of Nigeria';
const ORG_SHORT_NAME = 'MLSCN';
const ORG_ACRONYM = 'MLSCN';
const ORG_WEBSITE = 'https://mlscn.gov.ng';
const ORG_EMAIL = 'info@mlscn.gov.ng';
const ORG_PHONE = '+234-XXX-XXX-XXXX';
const ORG_ADDRESS = 'Abuja, Nigeria';
```

2. **Clear cache:**
```bash
php artisan cache:clear
php artisan config:clear
```

3. **Verify changes:**
- Check page titles show "MLSCN CBT Exam"
- Footer shows "MLSCN" copyright
- Header displays "Medical Laboratory Science Council of Nigeria"

That's it! Your entire application now reflects the new organization branding.

---

**Note:** Remember to also update logos, favicons, and any other brand-specific assets that are not text-based.

