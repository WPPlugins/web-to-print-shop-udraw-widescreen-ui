<?php

include_once(UDRAW_PLUGIN_DIR . '/designer/designer-header-init.php');

$load_frontend_navigation = true;
$displayInlineAddToCart = false;

$uDraw = new uDraw();
$udrawSettings = new uDrawSettings();
$_udraw_settings = $udrawSettings->get_settings();
if ($product->product_type == "simple" && !$isPriceMatrix) {
    $displayInlineAddToCart = true;
}
$friendly_item_name = get_the_title($post->ID);
?>
<div id="designer-wrapper" data-udraw="designerWrapper">
    <div id="udraw-bootstrap" data-udraw="uDrawBootstrap" style="display: none;">
        <div id="udraw-main-designer-ui">
            <div id="designer-menu" data-udraw="designerMenu">
                <div id="version-number-container" data-udraw="versionContainer">
                    <span class="small" id="racad-designer-version" data-udraw="designerVersion"></span>
                </div>
                <div class="btn-group">
                    <button class="dropdown-toggle" data-udraw="editButton" type="button" data-toggle="dropdown">
                        <span data-i18n="[html]menu_label.edit"></span>
                    </button>
                    <ul class="dropdown-menu" data-udraw="editDropdown" role="menu">
                        <li role="presentation">
                            <a role="menuitem" href="#" data-udraw="undoButton"><i class="fa fa-undo"></i>&nbsp;<span data-i18n="[html]button_label.undo"></span></a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" href="#" data-udraw="redoButton"><i class="fa fa-repeat"></i>&nbsp;<span data-i18n="[html]button_label.redo"></span></a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" href="#" data-udraw="removeButton"><i class="fa fa-remove"></i>&nbsp;<span data-i18n="[html]button_label.delete"></span></a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" href="#" data-udraw="duplicateButton"><i class="fa fa-copy"></i>&nbsp;<span data-i18n="[html]button_label.duplicate"></span></a>
                        </li>
                    </ul>
                </div>
                <!--You may style the following block or move it to a different location, but please leave the PHP and any onclick javascript code as is-->
                <?php if ($allowCustomerDownloadDesign) {
                    if (uDraw::is_udraw_okay()) { ?>
                <div class="btn-group">
                <button type="button" onclick="javascript:RacadDesigner.settings.pdfQualityLevel = 8;RacadDesigner.ExportToLayeredPDF(function(url){ var dl = document.createElement('a'); dl.setAttribute('href', url); dl.setAttribute('download', '<?php echo $friendly_item_name ?>'); dl.click(); });"><span>Download PDF &nbsp;&nbsp;&nbsp;</span><i class="fa fa-cloud-download"></i></button>
                </div>
                    <?php } else { ?>
                    <div class="btn-group">
                        <button type="button" onclick="javascript:RacadDesigner.settings.pdfQualityLevel = 8;RacadDesigner.ExportToMultiPagePDF('<?php echo $friendly_item_name ?>',false);"><span>Download PDF &nbsp;&nbsp;&nbsp;</span><i class="fa fa-cloud-download"></i></button>
                    </div>
                <?php 
                    }
                } ?>
                <?php if ( (wp_get_current_user()->ID > 0) && ($_udraw_settings['udraw_customer_saved_design_page_id'] > 1) ) { ?>
                <div class="btn-group">
                    <button type="button" id="udraw-save-later-design-btn"><i class="fa fa-floppy-o"></i><span>&nbsp;Save Design</span></button>
                </div>
                <?php } ?>
                <?php if ($displayOptionsFirst) { ?>
                    <div class="btn-group">
                        <button type="button" id="show-udraw-display-options-ui-btn"><i class="fa fa-chevron-left"></i><span>&nbsp;&nbsp;&nbsp;Back to Options</span></button>
                    </div>
                    <?php if ($product->product_type == "variable") { ?>
                        <div class="btn-group">
                            <button type="button" onclick="javascript:__finalize_add_to_cart();"><span><?php _e('Next Step', 'udraw') ?></span>&nbsp;<i class="fa fa-chevron-right"></i></button>
                        </div>
                    <?php } ?>
                    <?php if ($product->product_type == "simple" && $displayInlineAddToCart) { ?>
                        <form class="cart" method="post" enctype="multipart/form-data" style="display: inline-block; margin-top: -3px; margin-left: 0!important; float: right;">
                            <input type="hidden" value="" name="udraw_product">
                            <input type="hidden" value="" name="udraw_product_data">
                            <input type="hidden" value="" name="udraw_product_svg">
                            <input type="hidden" value="" name="udraw_product_preview">
                            <input type="hidden" value="" name="udraw_product_cart_item_key">
                            <input type="hidden" value="" name="ua_ud_graphic_url" />
                            
                            <div class="btn-group" style="border-left: 1px solid #aaaaaa;margin-top: 3px;">
                                <button type="button" onclick="javascript:__finalize_add_to_cart();" id="simple-add-to-cart-btn" style="margin-left: 0;"><i class="fa fa-shopping-cart"></i><i class="fa fa-spinner fa-pulse" style="display: none;"></i><span style="margin-left: 5px;"><?php echo $product->single_add_to_cart_text(); ?></span></button>
                            </div>
                        </form>
                <?php } // End If Product type is Simple ?>
            <?php } ?>
            <?php if (!$displayOptionsFirst && ($templateCount > 1 || $isTemplatelessProduct)) { ?>
                <div class="btn-group">
                    <button type="button" id="show-udraw-display-options-ui-btn"><i class="fa fa-chevron-left"></i><span style="margin-left: 5px;">Back to Options</span></button>
                </div>
            <?php }
            if (isset($displayPriceMatrixOptions)) { ?>
                <div class="btn-group">
                    <button type="button" id="udraw-price-matrix-show-quote"><i class="fa fa-chevron-left"></i><span style="margin-left: 5px;"><?php _e('Show Quote', 'udraw') ?></span></button>
                </div>
                <div class="btn-group">
                    <button type="button" id="udraw-price-matrix-designer-save"><span style="margin-right: 5px;"><?php _e('Next', 'udraw') ?></span><i class="fa fa-chevron-right"></i></button>
                </div>
            <?php } ?>
            <?php if (!$displayOptionsFirst && !isset($displayPriceMatrixOptions)) { ?>
                <?php if ($product->product_type == "variable") { ?>
                    <div class="btn-group">
                        <button type="button" id="udraw-variations-step-1-btn"><span id="udraw-variations-step-1-btn-label">Next Step</span>&nbsp;<i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" id="udraw-variations-step-0-btn" style="display:none;"><span id="udraw-variations-step-0-btn-label"><i class="fa fa-chevron-left"></i>&nbsp;Back to Design</span></button>                   
                    </div>
                <?php } else if ($product->product_type == "variable" ||$isPriceMatrix) { ?>
                    <div class="btn-group">
                        <button type="button" id="udraw-next-step-1-btn"><span id="udraw-next-step-1-btn-label">Next Step</span>&nbsp;<i class="fa fa-chevron-right"></i></button>
                    </div>
                <?php } else { ?>
                <form class="cart" method="post" enctype="multipart/form-data" style="display: inline-block; float: right;">
                    <input type="hidden" value="" name="udraw_product">
                    <input type="hidden" value="" name="udraw_product_data">
                    <input type="hidden" value="" name="udraw_product_svg">
                    <input type="hidden" value="" name="udraw_product_preview">
                    <input type="hidden" value="" name="udraw_product_cart_item_key">

                    <?php if ($displayInlineAddToCart) {?>
                        <input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" style="width: 60px; display: inline; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 5px;">
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>"> 
                        <span style="font-size:1.5em; vertical-align:middle;"><?php echo get_woocommerce_currency_symbol(); ?></span><span id="product_total_price" style="font-size:1.5em; vertical-align:middle;"><?php echo $product->get_price(); ?></span>
                        <div class="btn-group" style="margin-left: 5px;">
                            <button type="button" onclick="javascript:__finalize_add_to_cart();" style="margin-right: -1px;"><i class="fa fa-shopping-cart"></i><span>&nbsp;<?php echo $product->single_add_to_cart_text(); ?></span></button>
                        </div>
                    <?php } ?>

                </form>
               <?php } ?>
            <?php } else { ?>
                <?php if ($isPriceMatrix) { ?>
                    <?php if ($product->product_type != "variable") { ?>
                        <div class="btn-group">
                            <button type="button" onclick="javascript:__finalize_add_to_cart();"><span><?php _e('Next Step', 'udraw') ?></span>&nbsp;<i class="fa fa-chevron-right"></i></button>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <!--PHP block end-->
            </div>

            <div class="body-block">
                <div id="designer-left-toolbar" data-udraw="designerSideBar">
                    <ul data-udraw="toolbarList">
                        <li data-udraw="imagesGroup">
                            <button onclick="javascript: RacadDesigner.Freedraw.disableDrawMode();" data-toggle="dropdown">
                                <i class="fa fa-picture-o fa-2x"></i>
                                <span data-i18n="[html]common_label.image"></span>
                            </button>
                            <ul class="dropdown-menu left-dropdown" id="images-dropdown" role="menu">
                                <li id="Upload-Image-list-container">
                                    <input class="jQimage-upload-btn" type="file" name="files[]" multiple data-udraw="uploadImage" />
                                    <a href="#" onclick="javascript: RacadDesigner.triggerImageUpload();">
                                        <span data-i18n="[html]common_label.upload-image"></span>
                                    </a>
                                </li>
                                <li id="User-Uploaded-Images-list-container">
                                    <a href="#" id="local-images-nav-btn" data-udraw="userUploadedImages">
                                        <span data-i18n="[html]common_label.local-storage"></span>
                                    </a>
                                </li>
                                <?php if (!$_udraw_settings['designer_disable_global_clipart']) { ?>
                                <li id="Clipart-Collection-list-container">
                                    <a href="#" id="clipart-collection-nav-btn" data-udraw="clipartCollection">
                                        <span data-i18n="[html]common_label.clipart-collection"></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if ($_udraw_settings['designer_enable_local_clipart']) { ?>
                                <li id="Private-Clipart-Collection-list-container">
                                    <a href="#" id="private-clipart-collection-nav-btn" data-udraw="privateClipartCollection">
                                        <span data-i18n="[html]menu_label.private-clipart-collection"></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <li id="Image-Placeholder-list-container">
                                    <a href="#" id="image-placeholder-btn" data-udraw="imagePlaceHolder">
                                        <span data-i18n="[html]menu_label.image-placeholder"></span>
                                    </a>
                                </li>
                                <?php if ($_udraw_settings['designer_enable_facebook_photos']) {?>
                                <li id="Facebook-Uploads-list-container">
                                    <a href="#" id="facebook-image-btn" data-udraw="facebookPhotos">
                                        <span data-i18n="[html]menu_label.facebook-uploads"></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if ($_udraw_settings['designer_enable_instagram_photos']) { ?>
                                <li id="Instagram-Uploads-list-container">
                                    <a href="#" id="instagram-image-btn" data-udraw="instagramPhotos">
                                        <span data-i18n="[html]menu_label.instagram-uploads"></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="#" data-udraw="qrCode">
                                        <span data-i18n="[html]common_label.QRcode"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li data-udraw="textGroup">
                            <button onclick="javascript: RacadDesigner.Freedraw.disableDrawMode();" data-toggle="dropdown">
                                <i class="fa fa-font fa-2x"></i>
                                <span data-i18n="[html]common_label.text"></span>
                            </button>
                            <ul class="dropdown-menu left-dropdown" id="text-dropdown" role="menu">
                                <li>
                                    <a href="#" id="add-text-btn" data-udraw="addText">
                                        <span data-i18n="[html]common_label.text"></span>
                                    </a>
                                </li>
                                <li>
                                    <!--Curved text-->
                                    <a href="#" id="add-curved-text-btn" data-udraw="addCurvedText">
                                        <span data-i18n="[html]menu_label.curvetext"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="add-textbox-btn" data-udraw="addTextbox">
                                        <span data-i18n="[html]menu_label.textbox"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if (!$_udraw_settings['designer_disable_shapes']) { ?>
                        <li data-udraw="shapesGroup">
                            <button typeonclick="javascript: RacadDesigner.Freedraw.disableDrawMode();" data-toggle="dropdown">
                                <i class="fa fa-circle icon fa-2x"></i>
                                <span data-i18n="[html]common_label.shapes"></span>
                            </button>
                            <ul class="dropdown-menu left-dropdown" role="menu">
                                <li id="Circle-list-container">
                                    <a href="#" id="shapes-circle-add-btn" data-udraw="addCircle">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>circle-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.circle-shape"></span>
                                    </a>
                                </li>
                                <li id="Rectangle-list-container">
                                    <a href="#" id="shapes-sqaure-add-btn" data-udraw="addRectangle">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>square-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.rect-shape"></span>
                                    </a>
                                </li>
                                <li id="Triangle-list-container">
                                    <a href="#" id="shapes-triangle-add-btn" data-udraw="addTriangle">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>triangle-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.triangle-shape"></span>
                                    </a>
                                </li>
                                <li id="Line-list-container">
                                    <a href="#" id="shapes-line-add-btn" data-udraw="addLine">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>line-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.line-shape"></span>
                                    </a>
                                </li>
                                <li id="Curved-line-list-container">
                                    <a href="#" id="shapes-curved-line-add-btn" data-udraw="addCurvedLine">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>curved-line-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.curved-line-shape"></span>
                                    </a>
                                </li>
                                <li id="Polygon-list-container">
                                    <a href="#" id="open-polyshape-modal-btn" data-udraw="addPolygon">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>octagon-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.polyshape-shape"></span>
                                    </a>
                                </li>
                                <li id="Star-list-container">
                                    <a href="#" id="shapes-star-add-btn" data-udraw="addStar">
                                        <img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>star-icon.png" class="shape-icon" />
                                        &nbsp;<span data-i18n="[html]menu_label.star-shape"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li data-udraw="backgroundColourContainer">
                            <button data-udraw="backgroundColour">
                                <i class="fa fa-pencil-square fa-2x"></i>
                                <span data-i18n="[html]menu_label.background"></span>
                            </button>
                        </li>
                        <li>
                            <button data-udraw="togglePages">
                                <i class="fa fa-file fa-2x"></i>
                                <span data-i18n="[html]common_label.pages"></span>
                            </button>
                        </li>
                        <li>
                            <button data-udraw="undoButton">
                                <i class="fa fa-undo fa-2x"></i>
                                <span data-i18n="[html]button_label.undo"></span>
                            </button>
                        </li>
                        <li>
                            <button data-udraw="redoButton">
                                <i class="fa fa-repeat fa-2x"></i>
                                <span data-i18n="[html]button_label.redo"></span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!--Canvas-->
                <div id="canvas-container" data-udraw="canvasContainer">
                    <div id="racad-designer-loading" data-udraw="progressDialog">
                        <div class="alert alert-info">
                            <strong><span data-i18n="[html]common_label.progress"></span></strong>
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="105" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <div id="racad-designer" data-udraw="canvasWrapper">
                        <canvas id="racad-designer-canvas" width="504" height="288" data-udraw="canvas"></canvas>
                    </div>
                    <div id="zoom-container" data-udraw="zoomContainer">
                        <span data-i18n="[html]text.zoom" style="width: 100px" data-udraw="zoomDisplay"></span>
                        <a href="#" class="round-btn" data-udraw="decreaseZoomButton"><i class="fa fa-search-minus"></i></a>
                        <a href="#" class="round-btn" data-udraw="increaseZoomButton"><i class="fa fa-search-plus"></i></a>
                    </div>
                </div>

                <!--Side Bar-->
                <div data-udraw="rightSidebar">
                    <div data-udraw="linkedTemplatesModal" class="widescreen_modal objectEditorContainer">
                        <label data-i18n="[html]header_label.linked-templates-header"></label>
                        <div data-udraw="linkedTemplatesContainer"></div>
                    </div>
                    <div data-udraw="multilayerImageModal" class="widescreen_modal objectEditorContainer">
                        <label data-i18n="[html]header_label.multi-layer-header"></label>
                        <ul id="multi-layer-selection-panel" style="padding-left: 0px;" data-udraw="multilayerImageContainer"></ul>
                    </div>
                    <div data-udraw="pagesContainer" class="objectEditorContainer">
                        <label data-i18n="[html]common_label.pages"></label>
                        <div id="pages-carousel" data-udraw="pagesList"></div>
                    </div>
                    <div data-udraw="objectOptionsContainer" class="objectEditorContainer buttonsContainer">
                        <a href="#" data-udraw="bringForwardButton">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-arrow-up"></i>
                                <span data-i18n="[html]button_label.bring-forward"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="sendBackwardsButton">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-arrow-down"></i>
                                <span data-i18n="[html]button_label.send-backwards"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="duplicateButton">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-copy"></i>
                                <span data-i18n="[html]button_label.duplicate"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="removeButton">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-trash"></i>
                                <span data-i18n="[html]common_label.remove"></span>
                            </div>
                        </a>
                    </div>
                    <div data-udraw="layerLabelsModal" class="widescreen_modal objectEditorContainer" style="display: none;">
                        <label data-i18n="[html]header_label.layers-label-header"></label>
                        <div data-udraw="layerLabelsContent"></div>
                    </div>
                    <div data-udraw="imageOptionsContainer" class="objectEditorContainer buttonsContainer">
                        <?php if (!$_udraw_settings['designer_disable_image_replace']) { ?>
                        <a href="#" data-udraw="replaceImage">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-retweet"></i>
                                <span data-i18n="[html]common_label.replace"></span>
                            </div>
                        </a>
                        <?php } ?>
                        <a href="#" data-udraw="cropButton">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-crop"></i>
                                <span data-i18n="[html]button_label.crop"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="imageApplyMask">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-filter"></i>
                                <span data-i18n="[html]button_label.mask"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="imageToSVG">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-star"></i>
                                <span data-i18n="[html]button_label.convert-svg"></span>
                            </div>
                        </a>
                        <a href="#" data-udraw="clipImage">
                            <div class="innerAnchorDiv">
                                <i class="fa fa-cut"></i>
                                <span data-i18n="[html]button_label.clip-image"></span>
                            </div>
                        </a>
                    </div>
                    <div data-udraw="imageColouringModal" class="widescreen_modal objectEditorContainer">
                        <label data-i18n="[html]header_label.svg-header"></label>
                        <div data-udraw="imageColourContainer"></div>
                    </div>
                    <div data-udraw="imageFilterModal" class="widescreen_modal objectEditorContainer">
                        <label data-i18n="[html]button_label.grayscale"></label>
                        <a href="#" data-udraw="grayscale" class="btn image-filter-btn" data-i18n="[html]button_label.grayscale"></a>
                        <label data-i18n="[html]button_label.purple-sepia"></label>
                        <a href="#" data-udraw="sepiaPurple"  class="btn image-filter-btn" data-i18n="[html]button_label.purple-sepia"></a>
                        <label data-i18n="[html]button_label.yellow-sepia"></label>
                        <a href="#" data-udraw="sepiaYellow"  class="btn image-filter-btn" data-i18n="[html]button_label.yellow-sepia"></a>
                        <label data-i18n="[html]button_label.sharpen"></label>
                        <a href="#" data-udraw="sharpen"  class="btn image-filter-btn" data-i18n="[html]button_label.sharpen"></a>
                        <label data-i18n="[html]button_label.emboss"></label>
                        <a href="#" data-udraw="emboss"  class="btn image-filter-btn" data-i18n="[html]button_label.emboss"></a>
                        <label data-i18n="[html]button_label.blur"></label>
                        <a href="#" data-udraw="blur"  class="btn image-filter-btn" data-i18n="[html]button_label.blur"></a>
                        <label data-i18n="[html]button_label.invert"></label>
                        <a href="#" data-udraw="invert"  class="btn image-filter-btn" data-i18n="[html]button_label.invert"></a>

                        <label data-i18n="[html]button_label.tint"></label><a href="#" data-udraw="tint" class="btn image-filter-btn" data-i18n="[html]button_label.tint"></a>
                        <div data-udraw="imageTintContainer" class="image-filter-container">
                            <input type="hidden" data-opacity="1" data-udraw="tintColourPicker" />
                        </div>

                        <label data-i18n="[html]button_label.brightness"></label>
                        <a href="#" data-udraw="brightness" class="btn image-filter-btn" data-i18n="[html]button_label.brightness"></a>
                        <div data-udraw="imageBrightnessContainer" class="image-filter-container">
                            <div class="slider-class" style="width: 90%" data-udraw="imageBrightnessLevel"></div>
                        </div>

                        <label data-i18n="[html]button_label.noise"></label>
                        <a href="#" data-udraw="noise" class="btn image-filter-btn" data-i18n="[html]button_label.noise"></a>
                        <div data-udraw="imageNoiseContainer" class="image-filter-container">
                            <div class="slider-class" style="width: 90%" data-udraw="imageNoiseLevel"></div>
                        </div>

                        <label data-i18n="[html]button_label.pixelate"></label>
                        <a href="#" data-udraw="pixelate" class="btn image-filter-btn" data-i18n="[html]button_label.pixelate"></a>
                        <div data-udraw="imagePixelateContainer" class="image-filter-container">
                            <div class="slider-class" style="width: 90%" data-udraw="imagePixelateLevel"></div>
                        </div>

                        <label data-i18n="[html]text.opacity-level"></label>
                        <div style="padding-top: 10px; padding-bottom: 5px; display: inline-block; width: 50%;">
                            <div class="slider-class" id="image-opacity-slider" style="width: 100%" data-udraw="opacityLevel"></div>
                        </div>
                        <br />
                    </div>

                    <div data-udraw="imageClippingModal" class="widescreen_modal objectEditorContainer">
                        <div data-i18n="[html]text.clip-usage"></div>
                        <span data-i18n="[html]text.select-clip-image-shape" style="font-size: 12px; width: 30%"></span>
                        <select id="clip-image-shapes-selection" class="image-clipping-box" style="width: 30%;" data-udraw="imageClippingSelection">
                            <option value="Circle" data-i18n="[html]menu_label.circle-shape" selected="selected"></option>
                            <option value="Rectangle" data-i18n="[html]menu_label.rect-shape"></option>
                            <option value="Triangle" data-i18n="[html]menu_label.triangle-shape"></option>
                        </select>
                        <div style="margin-top: 5px;">
                            <a href="#" class="btn" style="width: initial;" data-udraw="applyImageClippingMask"><span data-i18n="[html]button_label.clip-image"></span></a>
                            <a href="#" class="btn" style="width: initial;" data-udraw="removeImageClippingMask"><span data-i18n="[html]button_label.clip-image-remove"></span></a>
                        </div>
                        <div id="clip-image-shape-mask-control" style="margin-top: 15px;">
                            <div data-i18n="[html]text.clip-image-offset"></div>
                            <a href="#" class="btn clip-image-offset-btn" id="move-clip-image-up" style="margin-left: 30px;" data-udraw="imageClippingOffsetUp">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <div style="margin-left: -5px;">
                                <a href="#" class="btn clip-image-offset-btn" id="move-clip-image-left" data-udraw="imageClippingOffsetLeft">
                                    <i class="fa fa-chevron-left"></i>
                                </a>
                                <a href="#" class="btn clip-image-offset-btn" id="move-clip-image-right" style="margin-left: 30px;" data-udraw="imageClippingOffsetRight">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                            <a href="#" class="btn clip-image-offset-btn" id="move-clip-image-down" style="margin-left: 30px;" data-udraw="imageClippingOffsetDown">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div data-udraw="textOptionsContainer" class="objectEditorContainer">
                        <textarea class="form-control" data-udraw="textArea"></textarea>
                        <div data-udraw="fontFamilyContainer">
                            <label data-i18n="[html]text.restrict-font-family"></label>
                            <select class="font-family-selection" name="font-family-selection" data-udraw="fontFamilySelector">
                                <option value="Arial" style="font-family:'Arial';">Arial</option>
                                <option value="Calibri" style="font-family:'Calibri';">Calibri</option>
                                <option value="Times New Roman" style="font-family:'Times New Roman'">Times New Roman</option>
                                <option value="Comic Sans MS" style="font-family:'Comic Sans MS';">Comic Sans MS</option>
                                <option value="French Script MT" style="font-family:'French Script MT';">French Script MT</option>
                            </select>
                        </div>
                        <div data-udraw="fontSizeContainer">
                            <label data-i18n="[html]text.restrict-font-size"></label>
                            <select class="dropdownList font-size-select-option" data-udraw="fontSizeSelector"></select>
                        </div>
                        <div data-udraw="fontHeightContainer">
                            <label data-i18n="[html]text_label.font-height"></label>
                            <select class="dropdownList" id="font-line-height-select-option" data-udraw="fontHeightSelector"></select>
                        </div>
                        <div data-toggle="buttons-checkbox" data-udraw="fontStyleContainer">
                            <label data-i18n="[html]text_label.bold"></label>
                            <a href="#" class="btn" data-udraw="boldButton" data-i18n="[html]text_label.bold"></a>
                            <label data-i18n="[html]text_label.italic"></label>
                            <a href="#" class="btn" data-udraw="italicButton" data-i18n="[html]text_label.italic"></a>
                            <label data-i18n="[html]text_label.underline"></label>
                            <a href="#" class="btn" data-udraw="underlineButton" data-i18n="[html]text_label.underline"></a>
                            <label data-i18n="[html]menu_label.font-overline"></label>
                            <a href="#" class="btn" data-udraw="overlineButton" data-i18n="[html]menu_label.font-overline"></a>
                            <label data-i18n="[html]menu_label.font-linethrough"></label>
                            <a href="#" class="btn" data-udraw="strikeThroughButton" data-i18n="[html]menu_label.font-linethrough"></a>
                        </div>

                        <div data-udraw="fontAlignContainer">
                            <label data-i18n="[html]text_label.alignment"></label>
                            <a data-udraw="textAlignLeft"><div class="innerAnchorDiv"><i class="fa fa-align-left fa-2x"></i></div></a>
                            <a data-udraw="textAlignCenter"><div class="innerAnchorDiv"><i class="fa fa-align-center fa-2x"></i></div></a>
                            <a data-udraw="textAlignRight"><div class="innerAnchorDiv"><i class="fa fa-align-right fa-2x"></i></div></a>
                            <a data-udraw="textAlignJustify"><div class="innerAnchorDiv"><i class="fa fa-align-justify fa-2x"></i></div></a>
                        </div>
                        
                        <div data-udraw="curvedTextContainer">
                            <label data-i18n="[html]menu_label.curvetext"></label>
                            <div style="padding: 5px;">
                                <div style="width: 20%; display:inline-block;"><span data-i18n="[html]text_label.curved-text-spacing"></span></div>
                                <div class="slider-class" style="width: 60%;" data-udraw="curvedTextSpacing"></div>
                            </div>
                            <div style="padding: 5px;">
                                <div style="width: 20%; display:inline-block;" ><span data-i18n="[html]text_label.curved-text-radius"></span></div>
                                <div class="slider-class" style="width: 60%;" data-udraw="curvedTextRadius"></div>
                            </div>
                            <a href="#" style="display: inline-block;" data-udraw="reverseCurve"><span data-i18n="[html]button_label.flip-curve"></span></a>
                        </div>
                    </div>

                    <div data-udraw="generalOptionsContainer" class="objectEditorContainer">
                        <div data-udraw="designerColourContainer">
                            <label data-i18n="[html]text_label.object-fill"></label>
                            <input type="text" value="#000000" data-opacity="1" class="standard-js-colour-picker text-colour-picker" style="background-color: rgb(255, 255, 255);" data-udraw="designerColourPicker">
                            <input type="hidden" data-opacity="1" data-udraw="restrictedColourPicker" />
                        </div>
                        <?php if (!$_udraw_settings['designer_disable_text_gradient']) { ?>
                        <div data-udraw="gradientColourContainer">
                            <label data-i18n="[html]menu_label.gradient"></label>
                            <div data-udraw="gradientButton"></div>
                        </div>
                        <div data-udraw="gradientModal" class="widescreen_modal">
                            <div id="text-gradient" data-udraw="gradientContainer">
                            </div>
                        </div>
                        <?php } ?>
                        <div data-udraw="strokeWidthContainer">
                            <label data-i18n="[html]text_label.stroke-width"></label>
                            <input data-udraw="objectStrokeSpinner" type="text" value="0" data-opacity="1" class="stroke-spinner spinedit noSelect form-control" />
                        </div>
                        <div data-udraw="strokeColourContainer">
                            <label data-i18n="[html]text_label.stroke-colour"></label>
                            <input data-udraw="objectStrokeColour" type="color" value=""data-opacity="1" class="col-sm-3 stroke-colour-picker"/>
                        </div>
                        <div data-udraw="objectAlignContainer">
                            <label data-i18n="[html]text_label.object-align"></label>
                            <a href="#" data-udraw="objectsAlignLeft">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_left.png" alt="Align Left" /></div>
                            </a>
                            <a href="#" data-udraw="objectsAlignCenter">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_center.png" alt="Align Center" /></div>
                            </a>
                            <a href="#" data-udraw="objectsAlignRight">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_right.png" alt="Align Right" /></div>
                            </a>
                            <a href="#" data-udraw="objectsAlignTop">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_top.png" alt="Align Top" /></div>
                            </a>
                            <a href="#" data-udraw="objectsAlignMiddle">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_middle.png" alt="Align Middle" /></div>
                            </a>
                            <a href="#" data-udraw="objectsAlignBottom">
                                <div class="innerAnchorDiv"><img src="<?php echo UDRAW_DESIGNER_IMG_PATH ?>bg_btn_align_bottom.png" alt="Align Bottom" /></div>
                            </a>
                        </div>
                        <div data-udraw="shadowContainer">
                            <p style="text-align: center;"><label><span data-i18n="[html]menu_label.shadow"></span></label></p>
                            <label><span data-i18n="[html]text_label.shadows-x-offset"></span></label>
                            <div class="slider-class" data-udraw="shadowOffsetX"></div>
                            <br />
                            <label><span data-i18n="[html]text_label.shadows-y-offset"></span></label>
                            <div class="slider-class" data-udraw="shadowOffsetY"></div>
                            <br />
                            <label><span data-i18n="[html]text_label.shadows-blur"></span></label>
                            <div class="slider-class" data-udraw="shadowBlur"></div>
                            <br />
                            <a href="#" class="btn" data-udraw="shadowRemove"><span data-i18n="[html]button_label.remove-shadow"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="display: none;">
                <div class="modal toolbox-modal" id="layers-modal" style="display: none!important;" data-udraw="layersModal">
                <div class="modal-dialog modal-md" style="margin: 0px auto 0px auto;">
                    <div class="modal-content">
                        <div class="modal-header toolbox-header">
                            <span data-i18n="[html]common_label.layers"></span>
                            <div class="modal-header-btn-container" style="float:right;">
                                <a href="#" class="btn btn-default btn-xs" id="refresg-designer-layers-box" style="padding-top:0px;" data-udraw="layersRefresh"><i class="fa fa-refresh"></i><span data-i18n="[html]common_label.refresh"></span></a>
                                <a href="#" class="btn btn-default btn-xs" id="hide-designer-layers-box" style="padding-top:0px;" data-udraw="toolboxHide"><i class="fa fa-chevron-up"></i><span id="layers-box-span" data-i18n="[html]common_label.hide"></span></a>
                                <a href="#" class="btn btn-default btn-xs" id="close-designer-layers-box" style="padding-top:0px;" data-udraw="toolboxClose"><i class="fa fa-close"></i><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                        </div>
                        <div class="modal-body toolbox-body">
                            <div id="object-rotation-slider-container" class="object-rotation-slider-container" data-udraw="objectRotationContainer">
                                <span data-i18n="[html]text_label.object-angle"></span>
                                <div id="object-rotation-slider-label" style="width: 30px; display: inline-block;" data-udraw="objectRotationLabel"></div>
                                <div id="object-rotation-slider" class="slider-class" style="width: 200px; display: inline-block; margin-left: 5px;" data-udraw="objectRotationSelector"></div>
                                <a href="#" id="close-rotation-slider-btn" class="btn btn-warning btn-sm" style="float: right; margin-top: -4px; padding:2px;" data-udraw="objectRotationClose"><i class="fa fa-times"></i><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                            <div id="object-scaling-slider-container" class="object-rotation-slider-container" data-udraw="objectScaleContainer">
                                <span data-i18n="[html]text_label.object-scale"></span>
                                <div id="object-scaling-slider-label" style="width: 30px; display: inline-block;" data-udraw="objectScaleLabel"></div>
                                <div id="object-scaling-slider" class="slider-class" style="width: 200px; display: inline-block; margin-left: 5px;" data-udraw="objectScaleSelector"></div>
                                <a href="#" id="close-scaling-slider-btn" class="btn btn-warning btn-sm" style="float: right; margin-top: -4px; padding:2px;" data-udraw="objectScaleClose"><i class="fa fa-times"></i><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                            <div id="rectangle-corner-rounder" data-udraw="rectangleCornerContainer">
                                <span data-i18n="[html]text_label.rectangle-corner-radius"></span><input type="number" id="rectangle-corner-radius-spinner" min="0" max="50" step="1" data-udraw="rectangleCornerSelector" />
                                <a href="#" id="close-rectangle-corner-rounder-btn" class="btn btn-warning btn-sm" style="float: right; margin-top: 0px; padding:2px;" data-udraw="rectangleCornerClose"><i class="fa fa-times"></i><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                            <div class="scroll-content panel-body designer-panel-body" id="layers-box-body" style="padding: 5px; height:inherit; min-height:10px; max-height:250px;">
                                <ul class="layer-box" id="layersContainer" data-udraw="layersContainer"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
            <!--Polyshape dialog-->
            <div class="modal" style="top:305px;" data-udraw="polygonModal">
                <div class="modal-dialog modal-md" style="margin: 0px auto 0px auto;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span data-i18n="[html]button_label.create-polyshape"></span>
                            <div class="topRightContainer">
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                        </div>
                        <div class="modal-body toolbox-body">
                            <div id="create-polyshape-div" style="padding: 5px;">
                                <div>
                                    <label style="width: 30%; font-weight: normal; font-size: 14px;"><span data-i18n="[html]text.polygon-sides"></span></label>
                                    <input id="polygon-sides-input" type="number" min="3" value="3" data-udraw="polygonSideSelector" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer toolbox-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal" data-udraw="polygonCancel"><span data-i18n="[html]common_label.cancel"></span></a>
                            <a href="#" class="btn btn-success" tabindex="3" data-udraw="polygonCreate"><span data-i18n="[html]common_label.create"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="toolbox-holder" data-udraw="toolboxContainer">
                <!--bounding box dialog-->
                <div class="modal toolbox-modal" id="bounding-box-modal" style="top: 95px;" data-udraw="boundingBoxModal">
                    <div class="modal-dialog modal-md" style="margin: 0px auto 0px auto;">
                        <div class="modal-content">
                            <div class="modal-header toolbox-header">
                                <span data-i18n="[html]menu_label.bounding-box"></span>
                                <div class="modal-header-btn-container" style="float:right;">
                                    <a href="#" class="btn btn-default btn-xs hide-toolbox" id="hide-boundingbox-control" style="padding-top:0px;" data-udraw="toolboxHide"><i class="fa fa-chevron-up"></i><span id="bounding-box-span" data-i18n="[html]common_label.hide"></span></a>
                                    <a href="#" class="btn btn-default btn-xs" id="close-boundingbox-control" style="padding-top:0px;" data-udraw="toolboxClose"><i class="fa fa-close"></i><span data-i18n="[html]common_label.close"></span></a>
                                </div>
                            </div>
                            <div class="modal-body toolbox-body">
                                <div class="panel-body designer-panel-body" id="bounding-box-body">
                                    <div class=" row" id="boundingbox-create-btn-area" data-udraw="boundingBoxCreateContainer">
                                        <a href="#" id="boundingbox-create-btn" class="btn btn-xs btn-success col-sm-3" style="margin-left:15px;" data-udraw="boundingBoxCreate"><i class="fa fa-plus-circle"></i>&nbsp;<span data-i18n="[html]common_label.create"></span></a>
                                    </div>
                                    <div id="boundingbox-control-div" style="display:none;" data-udraw="boundingBoxControlContainer">
                                        <div class="row" id="boundingbox-remove-btn-area">
                                            <a href="#" id="boundingbox-lock-btn" class="btn btn-xs btn-info col-sm-3" style="margin-left:15px;" data-udraw="boundingBoxLock"><i class="fa fa-lock"></i>&nbsp;<span data-i18n="[html]common_label.lock"></span></a>
                                            <a href="#" id="boundingbox-unlock-btn" class="btn btn-xs btn-info col-sm-3" style="margin-left:15px;" data-udraw="boundingBoxUnlock"><i class="fa fa-unlock"></i>&nbsp;<span data-i18n="[html]common_label.unlock"></span></a>
                                            <a href="#" id="boundingbox-remove-btn" class="btn btn-xs btn-danger col-sm-3" style="margin-left:15px;" data-udraw="boundingBoxRemove"><i class="fa fa-times-circle"></i>&nbsp;<span data-i18n="[html]common_label.remove"></span></a>
                                        </div>
                                        <div class="row" style="margin-top: 5px;">
                                            <div id="boundingbox-visual-options">
                                                <span class="col-md-8">
                                                    <span class="input-group">
                                                        <span class="input-group-addon" data-i18n="[html]text_label.thickness"></span>
                                                        <input class="boundingbox-spinner spinedit noselect form-control" type="text" id="boundingbox-stroke-size" value="1" data-udraw="boundingBoxSpinner" />
                                                    </span>
                                                </span>
                                                <span class="col-md-4">
                                                    <input type="color" id="boundingbox-colour-picker" value="#000000" data-opacity="1" style="height:15px;" data-udraw="boundingBoxColourPicker" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Advanced colouring dialog-->
                <div class="modal toolbox-modal" id="advanced-colouring-modal" style="top: 200px;" data-udraw="objectColouringModal">
                    <div class="modal-dialog modal-md" style="margin: 0px auto 0px auto;">
                        <div class="modal-content">
                            <div class="modal-header toolbox-header">
                                <span data-i18n="[html]header_label.advanced-colouring-header"></span>
                                <div class="modal-header-btn-container" style="float:right;">
                                    <a href="#" class="btn btn-default btn-xs" id="hide-designer-header-advanced-colouring-box" style="padding-top:0px;" data-udraw="toolboxHide"><i class="fa fa-chevron-up"></i><span id="advanced-colouring-box-span" data-i18n="[html]common_label.hide"></span></a>
                                    <a href="#" class="btn btn-default btn-xs" id="close-designer-header-advanced-colouring-box" style="padding-top:0px;" data-udraw="toolboxClose"><i class="fa fa-close"></i><span data-i18n="[html]common_label.close"></span></a>
                                </div>
                            </div>
                            <div class="modal-body toolbox-body">
                                <a href="#" class="btn btn-default" id="trigger-object-pattern-upload-btn" style="margin: 5px;" data-udraw="triggerObjectColouringUpload">
                                    <i class="fa fa-upload icon"></i>&nbsp; <span data-i18n="[html]button_label.upload-pattern"></span>
                                </a>
                                <input id="object-pattern-upload-btn" type="file" name="files[]" multiple style="width:142px; height:34px;" data-udraw="objectColouringUpload" />
                                <div class="panel-body designer-panel-body" id="advanced-colouring-panel">
                                    <span data-i18n="[html]header_label.advanced-colouring-fill-header"></span>
                                    <div id="advanced-colouring-fill-box" style="margin: 5px;" data-udraw="objectColouringFillContainer">

                                    </div>
                                    <span data-i18n="[html]header_label.advanced-colouring-stroke-header"></span>
                                    <div id="advanced-colouring-stroke-box" style="margin: 5px;" data-udraw="objectColouringStrokeContainer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Freedraw modal-->
                <div class="modal toolbox-modal" id="freedraw-modal" style="top:270px;" data-udraw="freedrawModal">
                    <div class="modal-dialog modal-md" style="margin: 0px auto 0px auto;">
                        <div class="modal-content">
                            <div class="modal-header toolbox-header">
                                <span data-i18n="[html]header_label.free-draw-head"></span>
                                <div class="modal-header-btn-container" style="float:right;">
                                    <a href="#" class="btn btn-default btn-xs" id="hide-freedrawing-box" style="padding-top:0px;" data-udraw="toolboxHide"><i class="fa fa-chevron-up"></i><span id="freedrawing-box-span" data-i18n="[html]common_label.hide"></span></a>
                                    <a href="#" class="btn btn-default btn-xs" id="close-freedrawing-box" style="padding-top:0px;" data-udraw="toolboxClose"><i class="fa fa-close"></i><span data-i18n="[html]common_label.close"></span></a>
                                </div>
                            </div>
                            <div class="modal-body toolbox-body">
                                <div class="panel-body" style="padding-top: 5px; font-size: 12px; font-weight:normal;" id="freedraw-tools">
                                    <div style="padding: 5px;">
                                        <label id="brush-type-label" style="width: 30%"><span data-i18n="[html]text_label.brush-type"></span></label>
                                        <select id="brush-type-select-option" data-udraw="brushSelection">
                                            <option value="Pencil" selected="selected" data-i18n="[html]select_text.pencil"></option>
                                            <option value="Circle">Circle</option>
                                        </select>
                                    </div>
                                    <div style="padding: 5px;">
                                        <label style="width: 30%"><span data-i18n="[html]text_label.brush-colour"></span></label>
                                        <input type="hidden" id="brush-colour-picker" value="#000000" data-opacity="1" data-udraw="brushColourPicker" />
                                    </div>
                                    <div style="padding: 5px;">
                                        <label style="width: 30%"><span data-i18n="[html]text_label.brush-size"></span></label>
                                        <input type="number" value="1" min="1" max="25" id="brush-width" style="width: 60px;" data-udraw="brushSize" />
                                    </div>
                                    <div id="freedraw-shadow-container" data-udraw="freedrawShadowContainer">
                                        <div style="padding: 5px;">
                                            <label style="width:30%"><span data-i18n="[html]text_label.brush-shadow-size"></span></label>
                                            <input type="number" value="0" min="0" max="50" id="brush-shadow-width" style="width: 60px;" data-udraw="brushShadowSize" />
                                        </div>
                                        <div style="padding: 5px;">
                                            <label style="width: 30%"><span data-i18n="[html]text_label.brush-shadow-depth"></span></label>
                                            <input type="number" value="1" min="1" max="25" id="brush-shadow-depth" style="width: 60px;" data-udraw="brushShadowDepth" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer toolbox-footer">
                                <a href="#" class="btn btn-success" tabindex="3" id="freedraw-enable-btn" style="display: none;" data-udraw="enableDraw"><span data-i18n="[html]button_label.start-freedraw"></span></a>
                                <a href="#" class="btn btn-danger" data-dismiss="modal" id="freedraw-cancel-btn" data-udraw="disableDraw"><span data-i18n="[html]button_label.exit-freedraw"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Footer-->
            <div id="designer-footer" data-udraw="designerFooter">
            </div>
            <!--End-->
            <!-- Public Template Browser Dialog -->
            <div class="modal" id="browse-templates-modal" data-udraw="templatesModal">
                <div class="modal-dialog" style="width:1000px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2><span data-i18n="[html]header_label.templates-header"></span></h2>
                        </div>
                        <div class="modal-body" style="min-height: 520px; max-height: 520px; overflow: auto;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2" style="margin-left: 0px; width:250px; display: inline-block;" data-udraw="templatesCategoryList">
                                    </div>
                                    <div class="col-md-8" style="display: inline-block;">
                                        <h4 data-udraw="templatesCategoryTitle"><span data-i18n="[html]header_label.items"></span></h4>
                                        <div data-udraw="templatesContainer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Private Template Browser Dialog -->
            <div class="modal" id="browse-private-templates-modal" data-udraw="privateTemplatesModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2><span data-i18n="[html]header_label.templates-header"></span></h2>
                        </div>
                        <div class="modal-body" style="min-height:520px; max-height: 520px; overflow:auto;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2" id="private-templates-category-list" style="margin-left: 0px; width:250px; display: inline-block;" data-udraw="privateTemplatesCategoryList">
                                        <h4 id="private-templates-category-list-container"><span data-i18n="[html]common_label.category"></span></h4>
                                    </div>
                                    <div id="private-templates-category-content" class="col-md-10" style="display:inline-block;">
                                        <h4 id="private-templates-container-title"><span data-i18n="[html]header_label.items"></span></h4>
                                        <div id="private-templates-container-list" data-udraw="privateTemplatesContainer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar Dialog -->
            <div class="modal" id="progress-bar-modal" data-udraw="progressModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!--<button class="close" data-dismiss="modal">×</button>-->
                            <strong style="font-size:larger;"><span data-i18n="[html]common_label.progress"></span></strong>
                        </div>
                        <div class="modal-body">
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="105" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Local Images Dialog -->
            <div class="modal" id="local-images-modal" data-udraw="userUploadedModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong style="font-size:large;"><span data-i18n="[html]header_label.image-header"></span></strong>
                            <div class="topRightContainer">
                                <a href="#" onclick="javascript: jQuery('[data-udraw=\'uploadImage\']').trigger('click');">
                                    <span data-i18n="[html]common_label.upload-image"></span>
                                </a>
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                            <div style="padding-top:10px;">
                                <ol class="breadcrumb" id="local-images-folder-list" data-udraw="localFoldersList"></ol>
                            </div>
                        </div>
                        <div class="modal-body" style="max-height: 575px; overflow:auto;">
                            <div id="local-images-list" data-udraw="localImageList">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clipart Collection Dialog -->
            <div class="modal" id="clipart-collection-modal" data-udraw="clipartModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong style="font-size:large; padding-right: 15px;"><span data-i18n="[html]header_label.image-header"></span></strong>
                            <div class="topRightContainer">
                                <a href="#" data-udraw="uDrawClipartButton"><span data-i18n="[html]button_label.udraw-clipart"></span></a>
                                <a href="#" data-udraw="openClipartButton"><span data-i18n="[html]button_label.open-clipart"></span></a>
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                        </div>
                        <div class="modal-body" style="max-height: 575px; overflow:auto;">
                            <div data-udraw="uDrawClipartFolderContainer">

                            </div>
                            <div id="clipart-collection-list" data-udraw="uDrawClipartList">

                            </div>
                            <div style="display: none" data-udraw="openClipartContainer">
                                <div data-udraw="openClipartList">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div data-udraw="openClipartPageContainer" style="float: left; display: inline-block;">
                                <a href="#" class="btn btn-default btn-sm" data-udraw="openClipartPrevious"><span data-i18n="[html]common_label.previous"></span></a>
                                <a href="#" class="btn btn-default btn-sm" data-udraw="openClipartNext"><span data-i18n="[html]common_label.next"></span></a>
                                <span data-i18n="[html]text_label.clipart-page"></span>
                                <select data-udraw="openClipartPageSelect"></select>
                                <a href="#" class="btn btn-default btn-sm" data-udraw="openClipartGoButton"><span data-i18n="[html]common_label.go"></span></a>
                            </div>
                            <ol class="breadcrumb" data-udraw="clipartFolderList"></ol>
                            <div style="float: right; display: none;" data-udraw="searchOpenClipartContainer">
                                <input type="text" data-i18n="[placeholder]text.search-by-word" data-udraw="searchOpenClipartInput" />
                                <a href="#" class="btn btn-default btn-sm" data-udraw="searchOpenClipartButton"><span data-i18n="[html]button_label.search"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Private  Clipart Collection Dialog -->
            <div class="modal" id="private-clipart-collection-modal" data-udraw="privateClipartModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong style="font-size:large;"><span data-i18n="[html]header_label.image-header"></span></strong>
                            <div class="topRightContainer">
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                        </div>
                        <div class="modal-body" style="max-height: 575px; overflow:auto;">
                            <div data-udraw="privateClipartFolderContainer">

                            </div>
                            <div id="private-clipart-collection-list" data-udraw="privateClipartList">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <ol class="breadcrumb" id="private-clipart-collection-folder-list" data-udraw="privateClipartFolderList"></ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Dialog -->
            <div class="modal" id="qrcode-modal" data-udraw="qrModal">
                <div class="modal-dialog modal-md" style="width: 600px;">
                    <div class="modal-content">
                        <div class="modal-body" style="max-height: 575px; overflow:auto;">
                            <span class="col-md-8">
                                <input type="text" class="form-control" tabindex="1" id="qrcode-value-txtbox" value="http://somedomain" data-udraw="qrInput" />
                            </span>
                            <span class="col-md-2">
                                <input type="hidden" id="qrcode-colour-picker" value="#000000" data-udraw="qrColourPicker" />
                            </span>
                            <span class="col-md-2">
                                <a href="#" class="btn btn-success btn-sm" data-udraw="qrRefreshButton">
                                    <i class="fa fa-refresh"></i>&nbsp;<span data-i18n="[html]common_label.refresh"></span>
                                </a>
                            </span>
                            <br />
                            <div id="qrcode-preview" style="padding-top:25px;" data-udraw="qrPreviewContainer">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal"><span data-i18n="[html]common_label.cancel"></span></a>
                            <a href="#" class="btn btn-success" tabindex="3" id="qrcode-add-btn" data-udraw="qrAddButton"><span data-i18n="[html]common_label.add"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crop Dialog -->
            <div class="modal" id="crop-modal" data-udraw="cropModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div data-udraw="crop_preview" style="padding-top:35px;">
                                <img src="#" data-udraw="image_crop" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal" data-udraw="crop_cancel"><span data-i18n="[html]common_label.cancel"></span></a>
                            <a href="#" class="btn btn-success" tabindex="3" data-udraw="crop_apply"><span data-i18n="[html]common_label.apply"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crop Button ( Overlay on Images ) -->
            <button id="image-crop-btn" class="btn btn-warning btn-xs" style="position:absolute; display:none;"><i class="fa fa-crop"></i>&nbsp;Crop</button>

            <!-- Replace Image Dialog -->
            <div class="modal" id="replace-image-modal" data-udraw="replaceImageModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="replace-image-body-div">
                                <input class="replace-image-upload-btn" type="file" name="files[]" multiple accept="image/*" />

                                <a href="#" class="btn btn-default " style="width:175px;">
                                    <i class="fa fa-upload" style="font-size:1.5em"></i>&nbsp; <span data-i18n="[html]common_label.upload-image"></span>
                                </a>
                                <a href="#" class="replace-image-local-storage-btn btn btn-default" style="width: 175px;">
                                    <i class="fa fa-briefcase" style="font-size:1.5em"></i>&nbsp; <span data-i18n="[html]button_label.replace-image-local"></span>
                                </a>
                                <a href="#" class="replcae-image-clipart-btn btn btn-default" style="width: 175px;">
                                    <i class="fa fa-picture-o" style="font-size:1.5em"></i>&nbsp; <span data-i18n="[html]common_label.clipart-collection"></span>
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal"><span data-i18n="[html]common_label.cancel"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Facebook Images Dialog -->
            <div class="modal" id="facebook-images-modal" data-udraw="facebookModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong style="font-size:large;"><span>Facebook Images</span></strong>
                            <div class="topRightContainer">
                                <a href="#" data-udraw="facebookYourPhotos">Your Photos</a>
                                <a href="#" data-udraw="facebookTaggedPhotos">Photos of You</a>
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                            <div id="facebook-login" style="display: inline-block; float:right;">
                                <div id="fb-root"></div>
                                <div class="fb-login-button" data-scope="user_photos" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true" onlogin="javascript: RacadDesigner.Facebook.OnLoginLogout()"></div>
                            </div>
                        </div>
                        <div class="modal-body" style="max-height: 500px; overflow:auto;">
                            <div id="facebook-images-container">
                                <div id="image-container">
                                    <div data-udraw="facebookImages">Please log in to facebook</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div data-udraw="facebookPaging" style="display: inline-block; float: left;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instagram Images Dialog -->
            <div class="modal" id="instagram-images-modal" data-udraw="instagramModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong style="font-size:large;"><span>Instagram Images</span></strong>
                            <div class="topRightContainer">
                                <div style="display: inline-block;">
                                    <a href="#" data-udraw="instagramLogin">Login / Authenticate</a>
                                    <a href="#" data-udraw="instagramLogout" style="display: none;">Logout</a>
                                </div>
                                <a href="#" data-dismiss="modal"><span data-i18n="[html]common_label.close"></span></a>
                            </div>
                        </div>
                        <div class="modal-body" style="max-height: 500px; overflow:auto;">
                            <div data-udraw="instagramContent" style="margin: auto;"></div>
                        </div>
                        <div class="modal-footer">
                            <div data-udraw="instagramSearchContainer" style="float: right; display: inline-block; display: none;">
                                <input type="text" data-udraw="instagramSearchInput" data-i18n="[placeholder]text.search-tags" />
                                <a href="#" data-udraw="instagramSearchButton" class="btn btn-default" data-i18n="[html]button_label.search"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="udraw-preview-ui" style="display: none; padding-left: 30px;">
            <div class="row" style="padding-bottom: 15px;">
                <button class="btn button" id="udraw-preview-back-to-design-btn" style="color: #000 !important;"><i class="fa fa-chevron-left"></i><strong style="margin-left: 5px;">Back to Update Design</strong></button>
                <button class="btn button" id="udraw-preview-add-to-cart-btn" style="color: #000 !important;"><strong style="margin-right: 5px;">Approve &amp; Add to Cart</strong><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="row" id="udraw-preview-design-placeholer">
            </div>
        </div>
    </div>
</div>

<form method="POST" action="" name="udraw_save_later_form" id="udraw_save_later">
    <input type="hidden" name="udraw_save_product_data" value="" />
    <input type="hidden" name="udraw_save_product_preview" value="" />
    <input type="hidden" name="udraw_save_post_id" value="<?php echo $post->ID ?>" />
    <input type="hidden" name="udraw_save_access_key" value="<?php echo (isset($_GET['udraw_access_key'])) ? $_GET['udraw_access_key'] : NULL; ?>" />
    <input type="hidden" name="udraw_is_saving_for_later" value="1" />
    <?php wp_nonce_field('save_udraw_customer_design'); ?>
</form>
<?php include_once(UDRAW_PLUGIN_DIR . '/designer/multi-udraw-templates.php'); ?>
<?php include_once(UDRAW_PLUGIN_DIR . '/designer/designer-template-script.php'); ?>

<style type="text/css">
    <?php echo $_udraw_settings['udraw_designer_css_hook']; ?>
</style>

<script>
    jQuery(document).ready(function () {
        jQuery('div.entry-summary form.cart div.quantity input').css('width', '5em');
        <?php echo $_udraw_settings['udraw_designer_js_hook']; ?>
                
        jQuery('#udraw-options-page-design-btn').on('click', function(){
            __initialize_widescreen();
        });
        <?php if (!$displayOptionsFirst) { ?>
            jQuery('[data-udraw="uDrawBootstrap"]').on('udraw-loaded-design', function(){
                __initialize_widescreen();
            });
        <?php } ?>
        jQuery('div.widescreen_modal').modal({
            'backdrop': false,
            'keyboard': false,
            'show' : false
        });
        jQuery('[data-toggle="dropdown"]').dropdown();
    });
</script>