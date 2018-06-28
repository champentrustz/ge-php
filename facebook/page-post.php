<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script  type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>




</head>

<style>

    @font-face {
        font-family: 'CSChatThaiUI';
        src: url('../fonts/CSChatThaiUI.eot') format('embedded-opentype'),
        url('../fonts/CSChatThaiUI.ttf')  format('truetype');
        font-weight: normal;
        font-style: normal;
    }


    * {
        font-family: 'CSChatThaiUI', sans-serif;
        font-size: 14px;
    }

    /*@font-face {*/
        /*font-family: 'TH Sarabun New';*/
        /*src: url('../fonts/thsarabunnew-webfont.eot') format('embedded-opentype'),*/
        /*url('../fonts/thsarabunnew-webfont.woff') format('woff'),*/
        /*url('../fonts/thsarabunnew-webfont.ttf')  format('truetype');*/
        /*font-weight: normal;*/
        /*font-style: normal;*/
    /*}*/


    /*div {*/
        /*font-family: 'TH Sarabun New', sans-serif;*/
        /*font-size: 12px;*/
    /*}*/

    /*hr {*/
        /*background-color: #fff;*/
        /*border-top: 2px dotted #8c8b8b;*/
    /*}*/


</style>




<body>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '1657794661002656',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v3.0'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>

<script>
    function facebookPost() {
        var value = $( "#post-facebook" ).val();
        FB.api(
            "/631150690239437/feed",
            "POST",
            {
                "message": value,
                "access_token" : "EAAXjwWXhLaABAEoPBw1fzokbgCcQZB6i5y6MBdqCEtqayLg6BFykZCCBvP5OnW1EDcf27EYzUtSc7PsAhddb9ZBkXVZB3mlK7rem3Wd3BYGBPWTMcVRZCVTgI6gAbkghfenYzS4tpPbGRREZBENctDxmB8mMZCWkYKRQP61zdeacwZDZD"
            },
            function (response) {
                if (response && !response.error) {
                    window.location.reload();
                }
            }
        );
    }

</script>



<div class="container">

    <br>
    <div class="form-group">
<!--        <label for="post">โพสต์เฟสบุ๊ค</label>-->
        <div class="row">
        <div class="col-sm-10">
        <textarea class="form-control" rows="5" id="post-facebook" name="post-facebook"></textarea>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary btn-block" onclick="facebookPost()">โพสต์</button>
        </div>
        </div>
    </div>

</div>
</body>
</html>