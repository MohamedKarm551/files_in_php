<?php 
    if(isset($_POST['add_sentence'])){
        $english_sentence = $_POST['english_sentence'];
        $arabic_sentence = $_POST['arabic_sentence'];
        $fileHandlerDailyUse = fopen("dailyUse.csv", "a");//ضيف على الملف القديم بدون مسح
        fputcsv($fileHandlerDailyUse, [$english_sentence, $arabic_sentence], ',', '"'); // كتابة البيانات في الملف بالشكل التالي  "" , ""
        fclose($fileHandlerDailyUse);
        header("Location: index.php");  // لتحديث الصفحة بعد الإضافة

    }
    ?>