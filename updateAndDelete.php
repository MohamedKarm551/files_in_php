<?php
// قراءة البيانات من ملف CSV
$fileHandlerDailyUse = fopen("dailyUse.csv", "r");
$dataOfDailyUse = []; // هملا فيها البيانات اللي جايه من الملف
if ($fileHandlerDailyUse !== false) { // قرأ الملف بشكل صحيح
    while (!feof($fileHandlerDailyUse)) { // لو مش وصل لنهاية الملف
        $data = fgetcsv($fileHandlerDailyUse, 1000, ","); // استخراج البيانات من السطر الحالي
        if ($data !== false && !empty(array_filter($data))) { // تأكد من وجود بيانات وليست فارغة
            $dataOfDailyUse[] = $data; // إضافة البيانات إلى المصفوفة
        }
    }
    fclose($fileHandlerDailyUse); // اقفل الملف بعد الانتهاء من القراءة
}

// معالجة التحديث والحذف
if (isset($_POST['update_sentence']) || isset($_POST['delete_sentence'])) { // تحقق من الضغط على زر التحديث أو الحذف
    // if (isset($_POST['update_sentence'])) {
    //     //  لو ضغط على تحديث البيانات 
    //     $index = $_POST['index'];
    //     $english_sentence = $_POST['english_sentence'];
    //     $arabic_sentence = $_POST['arabic_sentence'];
    //     // تحديث البيانات في المصفوفة
    //     $dataOfDailyUse[$index] = [$english_sentence, $arabic_sentence];
    //     // تحديث السطر المحدد فقط
    //     $fileHandlerDailyUse = fopen("dailyUse.csv", "r+"); // فتح الملف للقراءة والكتابة
    //     $current_line = 0; // تعريف متغير لتتبع السطر الحالي
    //     while (($row = fgetcsv($fileHandlerDailyUse)) !== false) {
    //         // قراءة البيانات من الملف
    //         if ($current_line == $index) {
    //              // إذا كان السطر الحالي هو السطر المحدد للتحديث
    //             // الموقع الحالي للمؤشر 
    //             $currentPosition = ftell($fileHandlerDailyUse);
    //             // echo $currentPosition; //1383
    //             // ليه بنعمل الخطوة دي؟ 
    //             // بنحتاج نعرف مكان المؤشر حاليًا في الملف عشان نعرف نحركه. 
                
    //             // طول السطر الحالي 
    //             $rowString = implode(',', $row);
    //             // echo $rowString ."<br>"; //"hi","أهلا"
    //             $rowLength = strlen($rowString) + 1;      
    //             // echo $rowLength; // 14   
    //             // die();
    //              // ليه بنعمل الخطوة دي؟ 
    //             // implode بتحول المصفوفة لسلسلة نصية مفصولة بفواصل.

    //             // بنضيف 1 عشان الـ newline character (حرف النهاية الجديد). 
                
    //             // حساب الموقع الجديد للمؤشر 
    //             $newPosition = $currentPosition - $rowLength; 
    //             // ليه بنعمل الخطوة دي؟ 
                
    //             // بنحسب المكان اللي المفروض المؤشر يكون فيه عشان نكتب فوق السطر القديم. 
    //             // شوف انت فين بعد ما قريت السطر اللي قبله ، ثم ارجع هات السطر من أوله عشان تكتب عليه تحدث قيمته يعني  وعشان ترجع لأوله يبقا هتطرح طول السطر اللي قرأه وتطرح كمان الواحد اللي نزله السطر الجديد اللي نزل خطوة ده 
    //             // تحريك المؤشر للموقع الجديد 
    //             fseek($fileHandlerDailyUse, $newPosition); 
    //             // ليه بنعمل الخطوة دي؟  : 
                
    //             // بنستخدم fseek لتحريك المؤشر للمكان اللي حسبناه بحيث نقدر نكتب فوق السطر القديم. 
    //             // كتابة البيانات المحدثة في السطر 
    //             fputcsv($fileHandlerDailyUse, [$english_sentence, $arabic_sentence], ',');
    //             // بنستخدم fputcsv لكتابة السطر الجديد في المكان اللي حركنا المؤشر إليه.
    //             // نحافظ على علامات التنصيص للحفاظ على سلامة النصوص.
        
    //              // كسر الحلقة بعد التحديث 
    //             break;
    //             // ليه بنعمل الخطوة دي؟ // بنستخدم break عشان نطلع من الحلقة لأننا حدثنا السطر المطلوب. 
    //         }
    //         // زيادة متغير السطر الحالي 
    //          $current_line++; // ليه بنعمل الخطوة دي؟ // بنزود قيمة $current_line بمقدار 1 عشان نعرف أي سطر بنقرأ فيه دلوقتي. 
    //     }
    //     fclose($fileHandlerDailyUse);
    // }
    // أو طريقة تانية عشان دي فيها بج 
    // هنقرأ الملف كله ونحفظه في مصفوفة ونعدل عليها ونكتبها في الملف من جديد
    $fileHandlerDailyUse = fopen("dailyUse.csv", "r+"); // فتح الملف للقراءة والكتابة
$dataOfDailyUse = [];
$current_line = 0;
$index = $_POST['index'];
// قراءة البيانات من الملف وتخزينها في مصفوفة
while (($row = fgetcsv($fileHandlerDailyUse)) !== false) {
    $dataOfDailyUse[] = $row;
}
fclose($fileHandlerDailyUse); // إغلاق الملف بعد القراءة
    $english_sentence = $_POST['english_sentence'];
    $arabic_sentence = $_POST['arabic_sentence'];
// تحديث السطر في المصفوفة
$dataOfDailyUse[$index] = [$english_sentence, $arabic_sentence];

// إعادة كتابة الملف بالكامل
$fileHandlerDailyUse = fopen("dailyUse.csv", "w");
foreach ($dataOfDailyUse as $row) {
    fputcsv($fileHandlerDailyUse, $row, ',');
}
fclose($fileHandlerDailyUse); // إغلاق الملف بعد الكتابة

}
// لو ضغط على حذف البيانات
if (isset($_POST['delete_sentence'])) {
    $index = $_POST['index'];
    unset($dataOfDailyUse[$index]);
    $dataOfDailyUse = array_values($dataOfDailyUse); // لإعادة ترتيب الفهارس
    // كتابة البيانات المحدثة في ملف CSV بدون السطر المحذوف
    $fileHandlerDailyUse = fopen("dailyUse.csv", "w"); 
    foreach ($dataOfDailyUse as $row) {
        fputcsv($fileHandlerDailyUse, $row);
    }
    fclose($fileHandlerDailyUse);
}


// إعادة التوجيه للصفحة الرئيسية بعد التحديث أو الحذف
header("Location: index.php"); // استبدل "index.php" باسم ملفك الرئيسي
exit();
