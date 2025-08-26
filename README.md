# Extracting-Group-Titles
MessengerScraper – PHP Library for Extracting Group Titles
# MessengerScraper

یک کتابخانه‌ی ساده‌ی PHP برای گرفتن نام گروه‌ها/کانال‌ها از لینک‌های دعوت  
پشتیبانی از پلتفرم‌های زیر:

- [x] Telegram (`t.me` / `telegram.me`)
- [x] Eitaa (`eitaa.com`)
- [x] WhatsApp (`chat.whatsapp.com`)

---

## 📦 نصب

فقط فایل `src/MessengerScraper.php` را در پروژه‌ات کپی کن.  
(اگر دوست داشتی می‌تونی بعداً این ریپو رو به شکل **Composer package** هم منتشر کنی.)

---

## 🚀 استفاده

```php
<?php
require_once __DIR__ . '/src/MessengerScraper.php';

$scraper = new MessengerScraper(20);

// Telegram
echo "Telegram: " . ($scraper->getTitle("https://t.me/English_National_Group") ?? "پیدا نشد") . PHP_EOL;

// Eitaa
echo "Eitaa: " . ($scraper->getTitle("https://eitaa.com/joinchat/2368602885Cf7be009384") ?? "پیدا نشد") . PHP_EOL;

// WhatsApp
echo "WhatsApp: " . ($scraper->getTitle("https://whatsapgrouplink.com/join-new-actress-whatsapp-group-link/") ?? "پیدا نشد") . PHP_EOL;
