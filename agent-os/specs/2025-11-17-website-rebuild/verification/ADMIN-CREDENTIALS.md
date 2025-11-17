# Admin Credentials

**IMPORTANT: DO NOT COMMIT THIS FILE TO GIT**

This file is excluded from git via .gitignore and contains sensitive admin credentials.

## Admin Users

### Developer Admin
- **Name:** Jacques van Wyk
- **Email:** jvw679@gmail.com
- **Password:** Generated during UserSeeder execution (randomly generated 16-character password)
- **Login URL:** http://kmgenviro.test/admin

### Client Admin
- **Name:** Khumbelo Marabe
- **Email:** marabekg@kmgenviro.co.za
- **Password:** Generated during UserSeeder execution (randomly generated 16-character password)
- **Login URL:** http://kmgenviro.test/admin

## Password Location

The passwords were displayed when the UserSeeder was run:
```bash
php artisan db:seed --class=UserSeeder
```

The passwords are randomly generated each time the seeder runs and should have been saved when first executed.

## Resetting Passwords

To reset a user's password, use Laravel Tinker:

```bash
php artisan tinker
```

Then execute:
```php
$user = \App\Models\User::where('email', 'jvw679@gmail.com')->first();
$user->password = \Illuminate\Support\Facades\Hash::make('YourNewPassword');
$user->save();
```

## Production Setup

For production deployment:
1. Run UserSeeder on production server
2. Save the generated passwords securely (password manager recommended)
3. Share client admin credentials securely with Khumbelo Marabe
4. Recommend changing passwords after first login via the admin panel

## Security Notes

- Passwords are hashed using bcrypt
- Email verification is enabled
- Two-factor authentication is available (can be enabled in Fortify config)
- All admin routes are protected by authentication middleware
