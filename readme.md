## Officegest Email (Laravel Package)

This is a laravel package to send email using officegest.

## Installation

    composer require officegest/officegest-send-email

Laravel < 8.0 Add ServiceProvider to your `config/app.php`

    OfficegestEmail\OfficegestEmailServiceProvider::class,

If you need to publish the config file for this package. This will add the file `config/officegest-sms.php`, where you can configure this package.

    $ php artisan vendor:publish --provider="OfficegestEmail\OfficegestEmailServiceProvider" --tag=config

You need add this variables to your .env

    OFFICEGEST_EMAIL_ACTIVE=true
    OFFICEGEST_EMAIL_URL="your_officegest_url"
    OFFICEGEST_EMAIL_USER="your_user"
    OFFICEGEST_EMAIL_KEY="your_api_key"



## Usage

### Function OfficegestSms->send()

Parameters: string $phone_number, string $text

![Screenshot](https://i.imgur.com/4SBYJV0.png)

## Security

If you discover any security related issues, please email suporte@guisoft.net or use issues of this repo.

## Credits

- [Officegest.com][link-author]
- [Guisoft.net][link-guisoft]
- [All Contributors][link-contributors]


[link-author]: https://officegest.com
[link-guisoft]: https://guisoft.net
[link-contributors]: ../../contributors
