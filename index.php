<?php
$fileHandler = fopen("test.csv", "r");
$fileSize = filesize("test.csv");
// echo $fileSize;
$date = fread($fileHandler, $fileSize); //return string;

//  echo '$date= fread($fileHandler,$fileSize) is : <br>'.$date ."<br>";
// ملحوظة مهمة 
// fread : rewind هتخليه يوصل لآخر بيت  وبالتالي محتاج أعمل 
rewind($fileHandler); //  اعادة تأشير إلى أول بيت عشان لو هقرا تاني 
//   while(!feof($fileHandler)){
//      echo fgets($fileHandler,$fileSize)."<br>";//return one line 
//      }
$arr = [];
while (!feof($fileHandler)) {
    $arr[] = fgetcsv($fileHandler, $fileSize, ";");
}
// echo "<pre>"; print_r($arr);
// =======================
$fileHandlerDailyUse    = fopen("dailyUse.csv", "r");
$dataOfDailyUse = [];
if ($fileHandlerDailyUse !== false) { //قرأ الملف بشكل صحيح

    while (!feof($fileHandlerDailyUse)) {
        //    و في أغلب الحالات، 1000 حرف بيكون كافي لمعظم ملفات CSV الشائعة
        $data = fgetcsv($fileHandlerDailyUse, 1000, ",");
        if ($data !== false && !empty(array_filter($data))) {
            //تأكد من وجود داتا لان آخر سطر بيجي فاضي
            $dataOfDailyUse[] = $data;
        }
    }
}
// echo "<pre>"; print_r($dataOfDailyUse);

fclose($fileHandler);
fclose($fileHandlerDailyUse);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Daily Use Sentences</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .table-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .table-header {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .table-item {
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .table-item:hover{
            background-color: #e0f7fa; transform: scale(1.05);
            font-weight: bold;
        }
        .table-item:nth-child(even) {
            background-color: #e0f7fa;
        }

        .table-item:nth-child(odd) {
            background-color: #e0f2f1;
        }
    </style>
</head>

<body>
    <h2>30 Daily Use Sentences in English and Arabic</h2>
    <div class="table-container">
        <?php foreach ($dataOfDailyUse as $index=>$row) : ?>
           <?php if($index == 0):  ?>
                <div class="table-header"><?php echo $row[0] ?></div>
                <div class="table-header"><?php echo $row[1] ?></div>
            <?php else: ?>
            <div class="table-item">
                <?php echo htmlspecialchars($row[0]); ?>
            </div>
            <div class="table-item">
                <?php echo htmlspecialchars($row[1]); ?>
            </div> 
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>

</html>