<!--SCRIPTS-->
<!-- Bootstrap core JavaScript -->
<script src="<?=base_url("vendor/jquery/jquery.min.js");?>"></script>
<script src="<?=base_url("vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
<script src="<?=base_url("vendor/jquery-easing/jquery.easing.min.js");?>"></script>
<script src="<?=base_url("assets/slick/slick.min.js");?>"></script>
<script src="<?=base_url("assets/js/scrolling-nav.js");?>"></script>

<script>
        
        $(function(){
            $('.single-item').slick({
                autoplay: true
            });
            
            $('.empresa_slide').slick({
                arrows: false,
                autoplay: true
            });
            $('.produtos_slide').slick({
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplay: true
            });
            $('.marcas_slide').slick({
                slidesToShow: 12,
                slidesToScroll: 2,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                        slidesToShow: 12,
                        slidesToScroll: 2,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 8,
                        slidesToScroll: 2,
                        infinite: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        slidesToShow: 4,
                        slidesToScroll: 2,
                        infinite: true
                    }
                }
                ]
            });
            
       
    });
        
    </script>
</body>
</html>