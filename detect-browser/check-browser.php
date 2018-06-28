
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script language="JavaScript">

        <?php

        function ThDate()
        {
//วันภาษาไทย
            $ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
            $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
            $week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
            $months = date( "m" )-1; // ค่าเดือน (1-12)
            $day = date( "d" ); // ค่าวันที่(1-31)
            $years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

            return "วัน$ThDay[$week]
		ที่ $day
		เดือน $ThMonth[$months]
		พ.ศ. $years";
        }

        ?>
    </script>

</head>

<body>


<div class="container">

    <?php
    function chkBrowser($nameBrowser){
        return preg_match("/".$nameBrowser."/",$_SERVER['HTTP_USER_AGENT']);
    }
    ?>

    <?php

    preg_match( "#Chrome/(.+?)\.#", $_SERVER['HTTP_USER_AGENT'], $match );


    if(chkBrowser("Chrome")==1){
        if($match[1] < 50 ){
            ?>
            <div class="alert alert-warning">
                <strong>Warning!</strong> เวอร์ชันของบราวเซอร์ของคุณต่ำกว่าที่กำหนด กรุณาอัพเดทบราวเซอร์
            </div>

        <?php }


    }
    ?>

</div>
</body>
</html>





