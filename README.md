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

$GroupTitle = new GroupTitle(20);

$telegramUrl = 'https://t.me/+p4dnnFu1Clw1ZjNk';
echo "Telegram : " . ($GroupTitle->getTitle($telegramUrl) ?? "پیدا نشد") . PHP_EOL;

$eitaaUrl = 'https://eitaa.com/joinchat/3629122773C8f6cb2bfff';
echo "Eitaa : " . ($GroupTitle->getTitle($eitaaUrl) ?? "پیدا نشد") . PHP_EOL;

$whatsappUrl = 'https://chat.whatsapp.com/G1QSPihnowRHcdGyCX5bkw?mode=ems_wa_c';
echo "WhatsApp : " . ($GroupTitle->getTitle($whatsappUrl) ?? "پیدا نشد") . PHP_EOL;
