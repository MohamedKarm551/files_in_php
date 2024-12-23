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
    <link rel="stylesheet" href="style.css">
    <title>Daily Use Sentences</title>

</head>

<body>
    <div class="container">

        <h2>30 Daily Use Sentences in English and Arabic</h2>
        <div class="table-container">
            <?php foreach ($dataOfDailyUse as $index => $row) : ?>
                <?php if ($index == 0):  ?>
                    <div class="table-header"><?php echo $row[0] ?></div>
                    <div class="table-header"><?php echo $row[1] ?></div>
                <?php else: ?>
    
                    <div class="table-item" data-index="<?php echo $index; ?>"> <?php echo htmlspecialchars($row[0]); ?> </div>
    
                    <div class="table-item" data-index="<?php echo $index; ?>"> <?php echo htmlspecialchars($row[1]); ?> </div>
                <?php endif; ?>
            <?php endforeach; ?>
    
        </div>
           <!-- فورم لإدخال الجملة الجديدة -->
    <form method="post" action="addSentence.php">
        <input type="text" name="english_sentence" placeholder="Enter English sentence" required>
        <input type="text" name="arabic_sentence" placeholder="Enter Arabic sentence" required>
        <button type="submit" name="add_sentence">Add Sentence</button>
    </form>
    </div>
                
    <!-- النموذج (popup) مخفي لحين الضغط على أحد الكلمات -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <form method="post" action="updateAndDelete.php">
                <input type="hidden" id="index" name="index">
                <input type="text" id="english_sentence" name="english_sentence" required>
                <input type="text" id="arabic_sentence" name="arabic_sentence" required>
                <button type="submit" name="update_sentence">Update</button>
                <button type="submit" name="delete_sentence">Delete</button>
            </form>
        </div>
    </div>

</body>
<script>
    // دالة لفتح النموذج (popup) 
    function openModal(index) {
        document.getElementById("index").value = index;
        const data = <?php echo json_encode($dataOfDailyUse); ?>;
        document.getElementById("english_sentence").value = data[index][0];
        document.getElementById("arabic_sentence").value = data[index][1];
        document.getElementById("myModal").style.display = "block";
    } // دالة لإغلاق النموذج (popup)
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
    // إضافة حدث click لكل العناصر في الجدول 
    document.querySelectorAll(".table-item").forEach(function(element) {
        element.addEventListener("click", function() {
            openModal(this.getAttribute("data-index"));
        });
    }); // إضافة حدث click لإغلاق النموذج 
    document.getElementById("closeModal").addEventListener("click", function() {
        closeModal();
    });
</script>

</html>