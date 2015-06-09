<footer>
    <div style="text-align:center;background-color: white;">
        Copyright Inserm - Version 1.5 rev. <?php include 'revision_number.php' ?>- Project Biobanques <a href="http://www.biobanques.eu">www.biobanques.eu</a>
    </div>
</footer>

<?php if (!CommonTools::isInDevMode()) { ?>
    <!-- code google analytics pour tracking du suivi -->
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-44379278-1']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <?php
}?>