<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use src\Helper\UtilsHelper;

$this->setCss([
    'creative/bundle.min',
    'creative/jquery.fancybox.min',
    'creative/owl.carousel.min',
    'creative/owl.theme.default.min',
    'creative/swiper.min',
    'creative/cubeportfolio.min',
    'creative/navigation',
    'creative/settings',
    'creative/slick',
    'creative/slick-theme',
    'creative/style',
    'creative/custom'
]);

$scripts = [
    'creative/bundle.min',
        'creative/jquery.fancybox.min',
        'creative/owl.carousel.min',
        'creative/swiper.min',
        'creative/jquery.cubeportfolio.min',
        'creative/jquery.appear',
        'creative/parallaxie.min',
        'creative/wow.min',
        'creative/owl.carousel',
        'creative/slick.min',
        'creative/TweenMax.min',
        'creative/morphext.min',
        'creative/jquery.themepunch.tools.min',
        'creative/jquery.themepunch.revolution.min',
        'creative/extensions/revolution.extension.actions.min',
        'creative/extensions/revolution.extension.kenburn.min',
        'creative/extensions/revolution.extension.carousel.min',
        'creative/extensions/revolution.extension.layeranimation.min',
        'creative/extensions/revolution.extension.migration.min',
        'creative/extensions/revolution.extension.navigation.min',
        'creative/extensions/revolution.extension.parallax.min',
        'creative/extensions/revolution.extension.slideanims.min',
        'creative/extensions/revolution.extension.video.min',
        'creative/maps.min',
        'creative/script'
];

$this->setJs(
    $scripts,
    'down_aux'
);
?>
<!-- Main Section start -->
<section id="home" class="p-0 h-100vh cursor-light">
    <h2 class="d-none">heading</h2>
    <!--Main Slider-->
    <div id="rev_slider_8_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="weone" data-source="gallery" style="background:transparent;padding:0px;">
        <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
        <div id="rev_slider_8_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.8.1">
            <ul><!-- SLIDE  -->
                <!-- SLIDE 1 -->
                <li data-index="rs-36" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <!-- LAYERS -->

                    <!-- LAYER Text -->
                    <div class="tp-caption color-yellow"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['top','top','top','top']" data-voffset="['270','200','100','55']"
                         data-fontsize="['60','50','40','40']"
                         data-lineheight="['75','75','75','40']"
                         data-width="['556','556','556','300']"
                         data-height="['none','none','none','87']"
                         data-whitespace="nowrap"

                         data-type="text"
                         data-responsive_offset="on"

                         data-frames='[{"delay":100,"split":"chars","splitdelay":0.1,"speed":1480,"split_direction":"random","frame":"0","from":"y:50px;sX:1;sY:1;opacity:0;fb:20px;","color":"rgba(0,0,0,0)","to":"o:1;fb:0;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","color":"transparent","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['center','center','center','center']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 10; min-width: 556px; max-width: 556px; white-space: nowrap; font-size: 60px; line-height: 75px; font-weight: 300; letter-spacing: 0px;font-family: 'Montserrat', sans-serif;">Creative</div>

                    <!-- LAYER Text -->
                    <div class="tp-caption color-black"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['top','top','top','top']" data-voffset="['348','260','155','98']"
                         data-fontsize="['60','50','40','40']"
                         data-lineheight="['75','75','45','45']"
                         data-width="['556','556','556','350']"
                         data-height="['none','none','none','87']"
                         data-whitespace="nowrap"

                         data-type="text"
                         data-responsive_offset="on"

                         data-frames='[{"delay":150,"speed":1500,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'

                         data-textAlign="['center','center','center','center']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 10; min-width: 556px; max-width: 556px; white-space: nowrap; font-weight: 700; letter-spacing: 0px;font-family: 'Montserrat', sans-serif;"><div id="js-rotating">Digital Agency, Modern Works, Design Elevation </div> </div>

                    <!-- LAYER Text -->
                    <div class="tp-caption color-black"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['top','middle','middle','middle']" data-voffset="['460','95','0','10']"
                         data-whitespace="normal"
                         data-width="['630','630','550','440']"
                         data-fontsize="['16','15','15','15']"
                         data-lineheight="['25','25','22','22']"
                         data-type="text"
                         data-responsive_offset="on"
                         data-frames='[{"delay":100,"speed":1480,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['center','center','center','center']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 10; min-width: 650px; max-width: 650px; white-space: nowrap; font-weight: 400; letter-spacing: 0px;font-family: 'Source Sans Pro', sans-serif;">Lorem ipsum is simply dummy text of the printing and typesetting. Lorem Ipsum has been the industry’s standard dummy.  Lorem Ipsum has been the industry’s standard dummy.
                    </div>

                    <!-- LAYER Button -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['middle','middle','middle','middle']" data-voffset="['170','200','90','120']"
                         data-frames='[{"from":"y:50px;opacity:0;","speed":1000,"to":"o:1;","delay":800,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"300","ease":"Power1.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);bw:2px 2px 2px 2px;"}]'
                         data-textAlign="['center','center','center','center']"
                         data-width="['160','160','160','160']"
                         style="z-index: 10; min-width: 960px; max-width: 960px">
                        <a href="javascript:void(0)" class="btn-setting color-black btn-hvr-up btn-hvr-yellow link">learn more</a>
                    </div>

                    <!-- LAYER Cylinder -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['center','center','center','center']" data-hoffset="['-20','-20','-20','-20']"
                         data-y="['top','top','top','top']" data-voffset="['100','0','-150','-150']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:bottom;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-slideloop"  data-easing="Power0.easeInOut" data-speed="12" data-xs="0" data-xe="60" data-ys="100" data-ye="60"><img src="<?= $this->webroot ?>img/creative/slider-shape1.png" alt="" data-ww="['51px','51px','51px','51px']" data-hh="['52px','52px','52px','52px']"  data-no-retina> </div></div>

                    <!-- LAYER Top Wave Pink -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['right','right','right','right']" data-hoffset="['150','150','30','30']"
                         data-y="['top','top','top','top']" data-voffset="['160','80','-100','-100']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:middle;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-slideloop"  data-easing="Power0.easeInOut" data-speed="12" data-xs="0" data-xe="-50" data-ys="50" data-ye="20"><img src="<?= $this->webroot ?>img/creative/slider-shape2.png" alt="" data-ww="['50px','50px','50px','50px']" data-hh="['14px','14px','14px','14px']"  data-no-retina> </div></div>

                    <!-- LAYER Semi Circle -->
                    <div class="tp-caption tp-resizeme"

                         data-x="['left','left','left','left']" data-hoffset="['250','80','80','30']"
                         data-y="['top','top','top','top']" data-voffset="['227','-16','-16','-36']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:right;y:bottom;rZ:360deg;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-rotate"  data-easing="Power0.easeIn" data-startdeg="0" data-enddeg="360" data-speed="15" data-origin="50% 50%"><img src="<?= $this->webroot ?>img/creative/slider-shape3.png" alt="" data-ww="['67px','67px','67px','67px']" data-hh="['69px','69px','69px','69px']" data-no-retina> </div></div>

                    <!-- LAYER Circle Gray Small -->
                    <div class="tp-caption"

                         data-x="['right','right','right','right']" data-hoffset="['300','200','100','100']"
                         data-y="['bottom','bottom','center','center']" data-voffset="['200','50','200','200']"
                         data-whitespace="normal"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1490,"frame":"0","from":"x:center;y:top;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 2;">
                        <div class="rs-looped rs-wave"  data-speed="12" data-angle="90" data-radius="22px" data-origin="50% 50%">
                            <div class="animated-wrap slider-social icon-small">
                                <div class="animated-element icon-box-small bg-gray-two pinterest-bg-hvr d-flex justify-content-center align-items-center">
                                    <a class="pinterest-text-hvr" href="javascript:void(0);">
                                        <i class="fab fa-youtube font-16" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAYER Circle Pink Small -->
                    <div class="tp-caption"

                         data-x="['left','left','left','left']" data-hoffset="['350','350','120','120']"
                         data-y="['bottom','bottom','center','center']" data-voffset="['80','0','200','200']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="normal"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1490,"frame":"0","from":"y:center;x:bottom;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 2;">

                        <div class="rs-looped rs-wave"  data-speed="12" data-angle="-90" data-radius="22px" data-origin="-50% -50%">
                            <div class="animated-wrap slider-social icon-small">
                                <div class="animated-element icon-box-small bg-pink-two instagram-bg-hvr d-flex justify-content-center align-items-center">
                                    <a class="instagram-text-hvr" href="javascript:void(0);">
                                        <i class="fab fa-instagram font-16" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAYER Circle Yellow -->
                    <div class="tp-caption"

                         data-x="['right','right','right','right']" data-hoffset="['-110','-20','0','0']"
                         data-y="['middle','middle','bottom','bottom']" data-voffset="['200','300','50','10']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="normal"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1490,"frame":"0","from":"x:center;y:top;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 2;">

                        <div class="rs-looped rs-wave"  data-speed="19" data-angle="45" data-radius="22px" data-origin="50% 50%">
                            <div class="animated-wrap slider-social icon-small">
                                <div class="animated-element icon-box-large-two bg-yellow twitter-bg-hvr d-flex justify-content-center align-items-center">
                                    <a class="twitter-text-hvr" href="javascript:void(0);">
                                        <i class="fab fa-twitter font-20" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAYER Circle Pink -->
                    <div class="tp-caption"

                         data-x="['left','left','left','left']" data-hoffset="['-250','-20','0','0']"
                         data-y="['middle','middle','bottom','bottom']" data-voffset="['70','70','100','100']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="normal"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1490,"frame":"0","from":"y:center;x:bottom;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 2;">

                        <div class="rs-looped rs-slideloop"  data-easing="Power0.easeInOut" data-speed="12" data-xs="0" data-xe="0" data-ys="-10" data-ye="60">
                            <div class="animated-wrap slider-social icon-small">
                                <div class="animated-element icon-box-large bg-pink facebook-bg-hvr d-flex justify-content-center align-items-center">
                                <a class="facebook-text-hvr" href="javascript:void(0);">
                                    <i class="fab fa-facebook-f font-20" aria-hidden="true"></i>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAYER Bottom Wave Gray -->
                    <div class="tp-caption tp-resizeme"

                         data-x="['right','right','right','right']" data-hoffset="['-200','-200','-5000','-5000']"
                         data-y="['bottom','bottom','bottom','bottom']" data-voffset="['150','150','150','150']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:middle;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-slideloop"  data-easing="Power0.easeInOut" data-speed="12" data-xs="0" data-xe="0" data-ys="10" data-ye="-50"><img src="<?= $this->webroot ?>img/creative/slider-shape4.png" alt="" data-ww="['24px','24px','24px','24px']" data-hh="['87px','87px','87px','87px']"  data-no-retina> </div></div>

                    <!-- LAYER Bottom Diamond -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['left','left','left','left']" data-hoffset="['83','66','20','20']"
                         data-y="['bottom','bottom','bottom','bottom']" data-voffset="['200','80','-100','-100']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:middle;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-slideloop" data-easing="Power0.easeInOut" data-speed="12" data-ys="-40" data-ye="40" data-xs="0" data-xe="20"><img src="<?= $this->webroot ?>img/creative/slider-shape5.png" alt="" data-ww="['44px','44px','44px','44px']" data-hh="['87px','87px','87px','87px']"  data-no-retina> </div></div>

                    <!-- LAYER Top Diamond -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['right','right','right','right']" data-hoffset="['150','150','50','50']"
                         data-y="['top','top','top','top']" data-voffset="['70','-70','-130','-130']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:middle;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-wave" data-speed="12" data-angle="90" data-radius="12px" data-origin="0% 0%"><img src="<?= $this->webroot ?>img/creative/slider-shape6.png" alt="" data-ww="['44px','44px','44px','44px']" data-hh="['87px','87px','87px','87px']"  data-no-retina> </div></div>

                    <!-- LAYER Top Left -->
                    <div class="tp-caption"
                         data-x="['left','left','left','left']" data-hoffset="['-500','-500','5000','5000']"
                         data-y="['top','top','top','top']" data-voffset="['-100','-100','0','0']"
                         data-whitespace="nowrap"
                         data-width="['394px','394px','394px','394px']" data-height="['393px','393px','393px','393px']"
                         data-responsive_offset="on"

                         data-frames='[{"delay":319.921875,"speed":500,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-rotate" data-easing="Power0.easeIn" data-speed="150" data-startdeg="0" data-enddeg="360" data-origin="45% 45%"><img src="<?= $this->webroot ?>img/creative/circle-top-left.png" alt="" data-ww="['394px','394px','394px','394px']" data-hh="['394px','394px','394px','394px']"  data-no-retina> </div>
                    </div>

                    <!-- LAYER Top Right Inner -->
                    <div class="tp-caption"
                         data-x="['left','left','left','left']" data-hoffset="['1180','1180','5000','5000']"
                         data-y="['top','top','top','top']" data-voffset="['-200','-200','-200','-200']"
                         data-width="['575px','575px','575px','575px']" data-height="['571px','571px','571px','571px']"

                         data-frames='[{"delay":319.921875,"speed":500,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-wave"  data-speed="6" data-angle="0" data-radius="5px" data-origin="50% 50%"><img src="<?= $this->webroot ?>img/creative/circle-top-right-inner.png" alt="" data-ww="['575px','575px','575px','575px']" data-hh="['571px','571px','571px','571px']"> </div>
                    </div>

                    <!-- LAYER Top Right -->
                    <div class="tp-caption"
                         data-x="['left','left','left','left']" data-hoffset="['1280','1280','5000','5000']"
                         data-y="['top','top','top','top']" data-voffset="['-110','-110','-110','-110']"
                         data-width="['381px','381px','381px','381px']" data-height="['380px','380px','380px','380px']"

                         data-frames='[{"delay":319.921875,"speed":500,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped"  data-easing="Power0.easeInOut" data-speed="0" data-xs="0" data-xe="0" data-ys="0" data-ye="0"><img src="<?= $this->webroot ?>img/creative/circle-top-right.png" alt="" data-ww="['381px','381px','381px','381px']" data-hh="['380px','380px','380px','380px']"  data-no-retina> </div>
                    </div>

                    <!-- LAYER Center -->
                    <div class="tp-caption tp-resizeme rs-parallaxlevel-8"
                         data-x="['left','left','center','center']" data-hoffset="['300','300','-5000','-5000']"
                         data-y="['top','top','middle,'middle']" data-voffset="['50','50','0','0']"
                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":319.921875,"speed":500,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'

                         style="z-index: 1;">
                        <div class="rs-looped rs-wave"  data-speed="15" data-angle="90" data-radius="12px" data-origin="50% 50%"><img src="<?= $this->webroot ?>img/creative/circle-center.png" alt="" data-ww="['672px','672px','500px','320px']" data-hh="['673px','673px','500px','320px']" data-no-retina> </div>
                    </div>

                    <!-- LAYER Arrows -->
                    <div class="tp-caption tp-resizeme"
                         data-x="['left','left','left','left']" data-hoffset="['30','30','-20','-100']"
                         data-y="['top','top','top','top']" data-voffset="['50','50','50','50']"
                         data-width="none"
                         data-height="none"
                         data-whitespace="nowrap"

                         data-type="image"
                         data-responsive_offset="on"

                         data-frames='[{"delay":50,"speed":1480,"frame":"0","from":"x:center;y:middle;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":350,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                         data-textAlign="['inherit','inherit','inherit','inherit']"
                         data-paddingtop="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"

                         style="z-index: 1;">
                        <div class="rs-looped rs-slideloop"  data-easing="Power0.easeInOut" data-speed="30" data-xs="-90" data-xe="90" data-ys="0" data-ye="20"><img src="<?= $this->webroot ?>img/creative/arrows.png" alt="" data-ww="['97px','97px','97px','97px']" data-hh="['98px','98px','98px','98px']"  data-no-retina> </div></div>

                </li>
            </ul>

            <div class="tp-bannertimer" style="height: 5px; background: rgba(0,0,0,0.15);"></div>	</div>
    </div>
    <!--Main Slider ends -->

</section>
<!-- Main Section end -->

<!--About start-->
<section class="about pb-0 overflow-visible" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pr-5 mb-5 mb-lg-0 wow fadeInLeft">
                <div class="rare-box"></div>
                <img src="<?= $this->webroot ?>img/creative/about.jpg" class="about-img-small position-relative w-100" alt="">
            </div>
            <div class="col-lg-6 pl-6">
                <div class="main-title text-lg-left offset-md-1 mb-0 wow fadeInUp" data-wow-delay="300ms">
                    <h5 class="wow fadeInUp" data-wow-delay="300ms"> Lorem ipsum dolor sit amet consectetur </h5>
                    <h2 class="wow fadeInUp font-weight-light" data-wow-delay="400ms"> We are making <span class="color-pink">design</span> better for everyone</h2>
                    <p class="pb-4 wow fadeInUp" data-wow-delay="500ms">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed augue diam, accumsan vitae justo non, euismod aliquam lectus. Etiam elementum tortor quis risus posuere, in cursus arcu lobortis.</p>

                    <ul class="pb-5 text-left wow fadeInUp" data-wow-delay="600ms">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                        <li>Morbi ornare nibh id cursus vestibulum.</li>
                        <li>Duis vitae lectus facilisis, tristique lorem sit amet, malesuada diam.</li>
                    </ul>

                    <a href="javascript:void(0)" class="btn-setting color-black btn-hvr-up btn-yellow btn-hvr-pink text-white link wow fadeInUp" data-wow-delay="700ms">learn more</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--About end-->

<!-- About Boxes start -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title wow fadeIn" data-wow-delay="300ms">
                    <h2>We’re <span class="color-pink">Creative</span> Branding<br>and Corporate Identity <span class="color-blue">Agency</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="about-box mb-5 mb-lg-0 mx-auto bg-blue">
                    <span class="pro-step d-inline-block color-white"><i class="fa fa-pencil-alt"></i></span>
                    <h5 class="font-weight-500 color-white mt-25px mb-15px text-capitalize">branding design</h5>
                    <p class="font-weight-light color-white">Lorem dapibus, tortor eget turpis auctor, convallis odio ac.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="about-box mb-5 mb-lg-0 mx-auto bg-yellow">
                    <span class="pro-step d-inline-block color-white"><i class="fa fa-cog"></i></span>
                    <h5 class="font-weight-500 color-white mt-25px mb-15px">SEO Marketing</h5>
                    <p class="font-weight-light color-white">Etiam luctus, lacus maximus elementum dapibus felis.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="about-box mb-0 mx-auto bg-pink">
                    <span class="pro-step d-inline-block color-white"><i class="fa fa-code"></i></span>
                    <h5 class="font-weight-500 color-white mt-25px mb-15px text-capitalize">web development</h5>
                    <p class="font-weight-light color-white">Pellentesque habitant morbi tristique senectus et malesuada.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Boxes ends -->

<!-- Team start -->
<section id="team" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title wow fadeIn" data-wow-delay="300ms">
                    <h5> Lorem ipsum dolor sit amet </h5>
                    <h2 class="mb-0">Our <span class="color-pink">Creative</span> Team </h2>
                </div>
            </div>
        </div>
        <div class="row wow fadeInUp team" data-wow-delay="300">
            <div class="col-lg-6 col-xl-3 p-0 team-col ml-md-auto mr-md-0 mx-auto">
                <div class="team-image">
                    <img src="<?= $this->webroot ?>img/creative/team1.jpg" alt="team1" class="m-image1">
                </div>
                <div class="team-classic-content hvr-team pink">
                    <h3 class="mb-3 text-capitalize color-black">Jessica Jones</h3>
                    <h5 class="mb-3 text-capitalize color-pink">Lead Designer</h5>
                    <p class="mt-3 mb-3 color-black">Lorem ipsum dolor sit amet, consectetur adipiscing elit augue.</p>
                    <ul class="team-social">
                        <li class="d-inline-block"><a href="javascript:void(0)" class="facebook-bg-hvr"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                        <li class="d-inline-block"><a href="javascript:void(0)" class="twitter-bg-hvr"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                        <li class="d-inline-block"><a href="javascript:void(0)" class="google-bg-hvr"><i class="fab fa-google" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 p-0 team-col2 mr-md-auto ml-md-0 mx-auto">
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <div class="team-image">
                            <img src="<?= $this->webroot ?>img/creative/team2.jpg" alt="team2" class="m-image2">
                        </div>
                    </div>
                    <div class="col-md-12 order-md-0">
                        <div class="team-classic-content hvr-team2 blue">
                            <h3 class="mb-3 text-capitalize color-black">Rob Clark</h3>
                            <h5 class="mb-3 text-capitalize color-blue">marketing head</h5>
                            <p class="mt-3 mb-3 color-black">Lorem ipsum dolor sit amet, consectetur adipiscing elit augue.</p>
                            <ul class="team-social">
                                <li class="d-inline-block"><a href="javascript:void(0)" class="facebook-bg-hvr"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                <li class="d-inline-block"><a href="javascript:void(0)" class="twitter-bg-hvr"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li class="d-inline-block"><a href="javascript:void(0)" class="google-bg-hvr"><i class="fab fa-google" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 d-none d-lg-block d-xl-none"></div>
            <div class="col-lg-6 col-xl-3 p-0 team-col ml-md-auto mr-md-0 mx-auto team-row2">
                <div class="team-image">
                    <img src="<?= $this->webroot ?>img/creative/team3.jpg" alt="team3" class="m-image3">
                </div>
                <div class="team-classic-content hvr-team yellow">
                    <h3 class="mb-3 text-capitalize color-black">Nicole Cross</h3>
                    <h5 class="mb-3 text-capitalize color-yellow">Visualizer</h5>
                    <p class="mt-3 mb-3 color-black">Lorem ipsum dolor sit amet, consectetur adipiscing elit augue.</p>
                    <ul class="team-social">
                        <li class="d-inline-block"><a href="javascript:void(0)" class="facebook-bg-hvr"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                        <li class="d-inline-block"><a href="javascript:void(0)" class="twitter-bg-hvr"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                        <li class="d-inline-block"><a href="javascript:void(0)" class="google-bg-hvr"><i class="fab fa-google" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 p-0 team-col2 mr-md-auto ml-md-0 mx-auto team-row2">
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <div class="team-image2">
                            <img src="<?= $this->webroot ?>img/creative/team4.jpg" alt="team4" class="m-image2">
                        </div>
                    </div>
                    <div class="col-md-12 order-md-0">
                        <div class="team-classic-content hvr-team2 pink">
                            <h3 class="mb-3 text-capitalize color-black">Albert Rodricks</h3>
                            <h5 class="mb-3 text-capitalize color-pink">Creative Lead</h5>
                            <p class="mt-3 mb-3 color-black">Lorem ipsum dolor sit amet, consectetur adipiscing elit augue.</p>
                            <ul class="team-social">
                                <li class="d-inline-block"><a href="javascript:void(0)" class="facebook-bg-hvr"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                <li class="d-inline-block"><a href="javascript:void(0)" class="twitter-bg-hvr"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li class="d-inline-block"><a href="javascript:void(0)" class="google-bg-hvr"><i class="fab fa-google" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Team ends -->

<!-- Quote start -->
<section class="parallax-setting parallaxie parallax1">
    <h2 class="d-none">heading</h2>
        <div class="container">
            <div class="row align-items-center position-relative">
                <div class="col-md-12">
                    <div class="quote-text text-center wow fadeInRight" data-wow-delay="300ms">
                        <div class="quote d-flex justify-content-start mb-2rem"><i class="fa fa-quote-left"></i></div>
                        <h2 class="font-weight-light mb-5 line-height-normal"><span class="color-yellow">Creativity</span> is allowing yourself to make mistakes Art is knowing which ones to keep.</h2>
                        <h3 class="color-pink">Alice Johnson</h3>
                        <div class="quote d-flex justify-content-end mb-3"><i class="fa fa-quote-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Quote ends -->

<!-- Work Starts -->
<section id="work" class="pb-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title wow fadeIn" data-wow-delay="300ms">
                    <h5> Lorem ipsum dolor sit amet </h5>
                    <h2 class="mb-0">Creative<span class="color-pink"> Portfolio</span> </h2>
                </div>
            </div>
        </div>
        <div class="row d-block">

            <div id="js-filters-mosaic-flat" class="cbp-l-filters-alignCenter">
                <div data-filter="*" class="cbp-filter-item-active cbp-filter-item cbp-filter-style">
                    All <div class="cbp-filter-counter"></div>
                </div>
                <div data-filter=".graphic-designs" class="cbp-filter-item cbp-filter-style">
                    Graphic Designs <div class="cbp-filter-counter"></div>
                </div>
                <div data-filter=".web-designs" class="cbp-filter-item cbp-filter-style">
                    Web Designs <div class="cbp-filter-counter"></div>
                </div>
                <div data-filter=".seo" class="cbp-filter-item cbp-filter-style">
                    SEO <div class="cbp-filter-counter"></div>
                </div>
                <div data-filter=".marketing" class="cbp-filter-item">
                    Marketing <div class="cbp-filter-counter"></div>
                </div>
            </div>

            <div id="js-grid-mosaic-flat" class="cbp cbp-l-grid-mosaic-flat no-transition">
                <div class="cbp-item web-designs marketing">
                    <a href="<?= $this->webroot ?>img/creative/work1.jpg" class="cbp-caption cbp-lightbox" data-title="Bolt UI<br>by Tiberiu Neamu">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work1.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">We are digital agency</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="cbp-item graphic-designs seo">
                    <a href="<?= $this->webroot ?>img/creative/work2.jpg" class="cbp-caption cbp-lightbox" data-title="World Clock<br>by Paul Flavius Nechita">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work2.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">Creative art work</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="cbp-item graphic-designs web-designs">
                    <a href="<?= $this->webroot ?>img/creative/work3.jpg" class="cbp-caption cbp-lightbox" data-title="WhereTO App<br>by Tiberiu Neamu">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work3.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">Modern portfolio</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="cbp-item seo marketing">
                    <a href="<?= $this->webroot ?>img/creative/work6.jpg" class="cbp-caption cbp-lightbox" data-title="Remind~Me Widget<br>by Tiberiu Neamu">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work6.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">Digital art works</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="cbp-item web-designs seo">
                    <a href="<?= $this->webroot ?>img/creative/work4.jpg" class="cbp-caption cbp-lightbox" data-title="Seemple* Music<br>by Tiberiu Neamu">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work4.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">Photography</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="cbp-item web-designs marketing">
                    <a href="<?= $this->webroot ?>img/creative/work5.jpg" class="cbp-caption cbp-lightbox" data-title="iDevices<br>by Tiberiu Neamu">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $this->webroot ?>img/creative/work5.jpg" alt="work">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <p>Elegant | Images</p>
                                    <div class="cbp-l-caption-title">Modern workspace</div>
                                    <span class="work-icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Work ends -->

<!-- Pricing start -->
<section id="pricing" class="bg-light-gray pricing-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title wow fadeIn" data-wow-delay="300ms">
                    <h5> Lorem ipsum dolor sit amet </h5>
                    <h2 class="mb-0">Flexible<span class="color-pink"> Pricing</span> Packages </h2>
                </div>
            </div>
        </div>
        <div class="row mt-66px mt-xs-4rem">
            <div class="col-lg-4 col-md-6 col-sm-12 text-center mb-xs-5 wow fadeInUp">
                <div class="pricing-item hvr-bg-blue">
                    <div class="price-box clearfix">
                        <div class="price_title">
                            <h4 class="text-capitalize">Basic</h4>
                        </div>
                    </div>
                    <div class="price">
                        <h2 class="position-relative"><span class="dollar">$</span>19<span class="month">/ month</span></h2>
                    </div>
                    <div class="price-description">
                        <p>Full Access</p>
                        <p>Unlimited Bandwidth</p>
                        <p>Email Accounts</p>
                        <p>8 Free Forks Every Months</p>
                    </div>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn-setting color-black btn-hvr-up btn-blue btn-hvr-white">learn more</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 text-center mb-xs-5 wow fadeInUp">
                <div class="pricing-item price-transform hvr-bg-yellow">
                    <div class="quarter-triangle"></div>

                    <div class="triangle-inner-content">
                        <i class="fa fa-star"></i>
                        <span> SPECIAL </span>
                    </div>

                    <div class="price-box2 clearfix">
                        <div class="price_title">
                            <h4 class="text-capitalize m-0">Standard</h4>
                            <p class="price-sub-heading text-capitalize">the most popular</p>
                        </div>
                    </div>
                    <div class="price">
                        <h2 class="position-relative"><span class="dollar">$</span>29<span class="month">/ month</span></h2>
                    </div>
                    <div class="price-description">
                        <p> Full Access</p>
                        <p>Unlimited Bandwidth</p>
                        <p>Email Accounts</p>
                        <p>8 Free Forks Every Months</p>
                    </div>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn-setting color-black btn-hvr-up btn-yellow btn-hvr-white">learn more</a>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 text-center wow fadeInUp">
                <div class="pricing-item hvr-bg-pink">
                    <div class="price-box clearfix">
                        <div class="price_title">
                            <h4 class="text-capitalize">Advance</h4>
                        </div>
                    </div>
                    <div class="price">
                        <h2 class="position-relative"><span class="dollar">$</span>49<span class="month">/ month</span></h2>
                    </div>
                    <div class="price-description">
                        <p> Full Access</p>
                        <p>Unlimited Bandwidth</p>
                        <p>Email Accounts</p>
                        <p>8 Free Forks Every Months</p>
                    </div>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn-setting color-black btn-hvr-up btn-pink btn-hvr-white">learn more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pricing ends -->

<!-- Clients start -->
<section id="clients" class="bg-white p-0 cursor-light no-transition">
    <h2 class="d-none">heading</h2>
    <div class="section-padding parallax-setting parallaxie parallax2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title wow fadeIn" data-wow-delay="300ms">
                        <h5> Lorem ipsum dolor sit amet </h5>
                        <h2 class="mb-0">Valuable<span class="color-pink"> Clients</span></h2>
                    </div>
                </div>
            </div>

            <div class="testimonial-images">
                <div class="owl-thumbs owl-dots d-lg-block d-none">
                    <div class="owl-dot animated-wrap active"><img src="<?= $this->webroot ?>img/creative/testimonial1.png" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial2.png" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial3.png" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial4.png" alt="" class="animated-element"></div>

                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial5.png" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial6.png" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial7.jpg" alt="" class="animated-element"></div>
                    <div class="owl-dot animated-wrap"><img src="<?= $this->webroot ?>img/creative/testimonial8.jpg" alt="" class="animated-element"></div>
                </div>
            </div>

            <div class="row align-items-center position-relative">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme testimonial-two hide-cursor mx-auto wow zoomIn" data-wow-delay="400ms">
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>
                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial1.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">David Walker</h5>
                                    <p class="color-grey"> Chairman, AcroEx </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item hide-cursor">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial2.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Christina Williams</h5>
                                    <p class="color-grey"> HR Manager </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial3.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Sarah Jones</h5>
                                    <p class="color-grey"> Sales Executive </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial4.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Chris Gorgano</h5>
                                    <p class="color-grey"> Photographer </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial5.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Kate Carter</h5>
                                    <p class="color-grey"> Model </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial6.png" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Alex Curtis </h5>
                                    <p class="color-grey"> Manager </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial7.jpg" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Ashley Wilson</h5>
                                    <p class="color-grey"> Actor </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <p class="color-black testimonial-para mb-15px"> Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

                            <div class="testimonial-post">
                                <a href="javascript:void(0)" class="post"><img src="<?= $this->webroot ?>img/creative/testimonial8.jpg" alt="image"></a>
                                <div class="text-content">
                                    <h5 class="color-black text-capitalize">Johnny Perkins</h5>
                                    <p class="color-grey"> Athlete </p>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Clients ends -->

<!-- Blog start -->
<section id="blog" class="half-section p-0 bg-change bg-yellow">
    <h2 class="d-none">heading</h2>
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12 p-0">
                <div class="hover-effect">
                    <img alt="blog" src="<?= $this->webroot ?>img/creative/split-blog.jpg" class="about-img">
                </div>
            </div>

            <div class="col-lg-6 col-md-12 p-lg-0">
                <div class="split-container-setting style-three text-center">
                    <div class="main-title mb-5 wow fadeIn" data-wow-delay="300ms">
                        <h5 class="font-18 text-blue"> Oct 12, 2019</h5>
                        <h2 class="mb-0 font-weight-normal"> Agency Blog </h2>
                    </div>
                    <p class="color-black mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodt temp to the incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis a nostr a exercitation ullamco laboris nisi ut aliquip.</p>

                    <a href="creative-studio/blog.html" class="btn-setting color-black btn-hvr-up btn-blue btn-hvr-pink">learn more</a>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Blog ends -->

<!-- Contact & Map starts -->
<section id="contact" class="bg-light-gray">
    <div class="container">
        <div class="row mx-lg-0">
            <div class="col-lg-6 col-md-6 col-sm-12 p-0">
                <div class="contact-box">
                    <div class="main-title text-center text-md-left mb-4">
                        <h2 class="font-weight-normal">Connect With Us </h2>
                    </div>

                    <div class="text-center text-md-left">

                        <!--Address-->
                        <p class="mb-3">123 Street New York City , United States Of America. </p>

                        <!--Phone-->
                        <p class="mb-3"> Office Telephone : 001 01085379709 <br>
                            Mobile : 001 63165370895 </p>

                        <!--Email-->
                        <p class="mb-3"> Email: <a href="mailto:email@website.com" class="color-black">admin@website.com</a> <br>
                            Inquiries: <a href="mailto:email@website.com" class="color-black">email@website.com</a> </p>

                        <!--Timing-->
                        <p class="mb-0">Mon-Sat: 9am to 6pm</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 p-0 col-map box-shadow-map">
                <div id="google-map" class="bg-light-gray map"></div>
            </div>
        </div>
    </div>
</section>
<!-- Contact & Map ends -->