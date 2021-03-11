
# Movie Booking Assignment

### Laravel Customization/Setup
- Rename public to public_html
  - Laravel mix setPublicPath to public_html
  - /app/Providers/AppServiceProvider: bind new public_path
- /config/app: change timezone to 'Africa/Johannesburg'
- /config/database: 'strict' => false & 'engine' => 'InnoDB'
- /config/filesystems: public -> public_html & adding 'base' disk
- /app/Providers/AppServiceProvider: Add Schema::defaultStringLength(191), needed for local development for default key length
- Create databases and update env file
