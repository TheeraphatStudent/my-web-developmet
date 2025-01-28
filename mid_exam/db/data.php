<?php

include "phone.php";

session_start();

if(isset($_SESSION['phones'])){    
    unset($_SESSION['phones']);
}

$_SESSION['phones'] = array();

array_push($_SESSION['phones'], new Phone(
    '1',
    'iPhone 12',
    'Apple A14 Bionic - Hexa-core',
    '4 GB',
    'ระบบกล้องคู่ความละเอียด 12MP: กล้องอัลตร้าไวด์​และไวด์ อัลตร้าไวด์: รูรับแสงขนาด ƒ/2.4 และมุมมองภาพ 120° ไวด์: รูรับแสงขนาด ƒ/1.6',
    '6.1 inches',
    '146.7 x 71.5 x 7.4 mm',
    '2815 mAh, Li-Ion',
    'บันทึกวิดีโอ HDR ในแบบ Dolby Vision สูงสุด 30 fps บันทึกวิดีโอระดับ 4K ที่ 24 fps, 30 fps หรือ 60 fps บันทึกวิดีโอระดับ HD 1080p ที่ 30 fps หรือ 60 fps บันทึกวิดีโอระดับ HD 720p ที่ 30 fps ระบบป้องกันภาพสั่นไหวแบบออปติคอลสำหรับวิดีโอ (ไวด์)',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/apple/iphone/iphone-12-series/iphone-12/product-detail/th/green/iphone-12-pdp-position-1b-color-green-th.png',
    '6,900'
));

array_push($_SESSION['phones'], new Phone(
    '2',
    'iPhone 13',
    'ชิป A15 Bionic - แบบ 6-core ใหม่ มีคอร์ด้านประสิทธิภาพ 2 คอร์ และคอร์ด้านประหยัดพลังงาน 4 คอร์',
    'N/A',
    'ระบบกล้องคู่ ความละเอียด 12MP: กล้องไวด์และอัลตร้าไวด์​ ไวด์: รูรับแสงขนาด ƒ/1.6 อัลตร้าไวด์: รูรับแสงขนาด ƒ/2.4 และมุมมองภาพ 120°',
    'ขนาด 6.1 นิ้ว (จอภาพ OLED)',
    '71.5 มม.x 146.7 มม. x 7.65 มม.',
    'แบตเตอรี่ลิเธียมไอออนชนิดชาร์จซ้ำได้ภายในตัวเครื่อง (ชาร์จแบบไร้สายในแบบ MagSafe สูงสุด 15 วัตต์, ชาร์จแบบไร้สายในแบบ Qi สูงสุด 7.5 วัตต์)',
    'โหมดภาพยนตร์สำหรับการบันทึกวิดีโอที่มีมิติความชัดตื้น (1080p ที่ 30 fps) บันทึกวิดีโอ HDR ในแบบ Dolby Vision สูงสุด 4K ที่ 60 fps บันทึกวิดีโอระดับ 4K ที่ 24 fps, 25 fps, 30 fps หรือ 60 fps บันทึกวิดีโอระดับ HD 1080p ที่ 25 fps, 30 fps หรือ 60 fps',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/apple/iphone/iphone-13-series/iphone-13/product-detail/th/midnight/iphone-13-pdp-position-1a-color-midnight-th.jpg',
    '8,400'
));

array_push($_SESSION['phones'], new Phone(
    '3',
    'iPhone 16',
    'Chip A18',
    'N/A',
    '48MP',
    '6.1" จอภาพ Super Retina XDR',
    '147.6 x 71.6 x 7.8mm',
    'เล่นวิดีโอ นานสูงสุด 27 ชั่วโมง (ระยะเวลาการใช้งานแบตเตอรี่แตกต่างกันไปตามการใช้งานและการกำหนดค่า ดูข้อมูลเพิ่มเติมได้ที่ apple.com/th/batteries)',
    'เล่นวิดีโอนานสูงสุด 22 ชั่วโมง',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/apple/iphone/iphone-16-series/iphone-16/product-detail/th/ultramarine/iphone-16-pdp-image-position-1a-ultramarine-color.jpg',
    '22,000'
));

array_push($_SESSION['phones'], new Phone(
    '4',
    'iPhone 16 Pro',
    'Chip A18 Pro',
    'N/A',
    '48MP',
    '6.3" จอภาพ Super Retina XDR',
    '149.6 x 71.5 x 8.25mm.',
    'เล่นวิดีโอ นานสูงสุด 33 ชั่วโมง (ระยะเวลาการใช้งานแบตเตอรี่แตกต่างกันไปตามการใช้งานและการกำหนดค่า ดูข้อมูลเพิ่มเติมได้ที่ apple.com/th/batteries)',
    'เล่นวิดีโอนานสูงสุด 27 ชั่วโมง',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/apple/iphone/iphone-16-series/iphone-16-pro/product-detail/th/desert-titanium/iphone-16-pro-pdp-image-position-1a-desert-titanium-color.jpg',
    '31,800'
));

array_push($_SESSION['phones'], new Phone(
    '5',
    'Samsung Galaxy S24 Ultra',
    '-',
    '12 GB',
    'กล้องหน้า 12MP 2PD AF (F2.2), 1.12um กล้องหลัง UW 12 MP 1.14um, FF (F2.2) + W 200 MP 0.6um, 4PD (F1.7) + Tele 3x 10 MP, 1.12um, 2PD AF (F2.4) + Tele 5x 50 MP 0.7um, 4PD AF (F43.4)',
    '6.8"',
    '162.3 x 79.0 x 8.6mm.',
    '5,000 mAh',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/samsung/phone/galaxy-s24-series/s24-ultra-5g/product-detail/titanium-black/samsung-galaxy-s24-ultra-5g-pdp-position-1-color-titanium-black.jpg',
    '46,900'
));

array_push($_SESSION['phones'], new Phone(
    '6',
    'Samsung Galaxy S23 Ultra',
    'Snapdragon 8 Gen 2',
    '8 GB',
    'กล้องหลัง UW 12 MP AF (F2.2) + W 200 MP (F1.7) + Tele 3x 10 MP(F2.4) + Tele 10x 10 MP(F4.9) กล้องหน้า 12MP 2PD AF (F2.2)',
    '6.8"',
    '78.1 x 163.4 x 8.9 mm',
    '5,000 mAh, non-removable',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/samsung/phone/galaxy-s23-series/s23-ultra-5g/product-detail/green/samsung-galaxy-s23-ultra-5g-pdp-position-1-pevicepenfront-color-green.jpg',
    '30,900'
));

array_push($_SESSION['phones'], new Phone(
    '7',
    'Samsung Galaxy S24 Plus',
    '-',
    '12 GB',
    'กล้องหน้า 12MP 2PD AF (F2.2), 1.12um กล้องหลัง UW 12 MP 1.4um, FF (F2.2) + W 50 MP 1.0um, 2PD AF (F1.8) + Tele 3x 10 MP 1.0um, PDAF (F2.4)',
    '6.7"',
    '158.5 x 75.9 x 7.7mm',
    '4,900 mAh',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/samsung/phone/galaxy-s24-series/s24-plus/product-detail/amber-yellow/samsung-galaxy-s24-plus-5g-pdp-position-1-color-amber-yellow.jpg',
    '26,600'
));

array_push($_SESSION['phones'], new Phone(
    '8',
    'Samsung Galaxy A55 5G',
    'Samsung | Exynos 1480',
    '12 GB',
    'กล้องหน้า 32MP กล้องหลัง Main: 50 MP (OIS) Ultra wide: 12MP Macro: 5MP',
    '6.6"',
    '161.1 x 77.4 x 8.2 mm',
    '5,000 mAh',
    'UHD 4K (3840 x 2160)@30fps',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/samsung/phone/galaxy-a55-5g/product-detail/ice-blue/samsung-a55-5g-image-pdp-position-1-color-ice-blue.jpg',
    '10,899'
));

array_push($_SESSION['phones'], new Phone(
    '9',
    'ROG Phone 8 5G',
    'Qualcomm Snapdragon 8 Gen 3, SM8650',
    '12 GB',
    'Front Camera 32 MP Main Rear Camera 50 MP Ultrawide Camera 13 MP Macro Camera 5MP, missing "P"',
    '6.78"',
    '163.8 x 76.8 x 8.9mm',
    '5,500 mAh',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/asus/phone/rog-8-series/rog-phone-8/product-detail/strom-grey/asus-rog-phone-8-image-pdp-position-1-color-storm-grey.jpg',
    '19,690'
));

array_push($_SESSION['phones'], new Phone(
    '10',
    'HUAWEI Pura 70 Pro',
    'Kirin 9010',
    '12 GB',
    'กล้องหน้า13 MP Selfie Camera (Wide Angle, F2.4, autofocus) กล้องหลัง 50 MP Ultra Lighting Camera (F1.4~F4.0 aperture,OIS) 12.5 MP Ultra-Wide Angle Camera (F2.2 aperture) 48 MP Ultra Lighting Macro Telephoto Camera (F2.1 aperture, OIS)',
    '6.8" LTPO OLED',
    '162.6 x 75.1 x 8.4mm',
    '5,050 mAh',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/huawei/phone/pura-70-pro/product-detail/white/huawei-pura-70-pro-image-pdp-position-1-color-white.jpg',
    '26,590'
));

array_push($_SESSION['phones'], new Phone(
    '11',
    'vivo X200 Pro 5G',
    'Mediatek Dimensity 9400 V3+',
    '16 GB',
    'กล้องหน้า 32 MP (f/2.0) กล้องหลัง 50MP(f/1.57)+50MP(f/2.0)+200MP(f/2.67)',
    '6.78"',
    '162.36 x 75.95 x 8.2 mm',
    '6000mAh 90W + 30W （ชาร์จไร้สาย',
    '-',
    'https://www.ais.th/content/dam/ais/consumer/store/devices/vivo/phone/x200-pro-5g/product-detail/ocean-blue/vivo-x200-pro-5g-image-pdp-position-4-color-ocean-blue.jpg',
    '31,599'
));

// foreach($_SESSION['phones'] as $phone){
//     echo $phone->model . "<br>";
// }


