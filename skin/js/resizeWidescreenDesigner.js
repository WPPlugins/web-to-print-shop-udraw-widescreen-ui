(function ($) {
    RacadDesigner.mobile = {
        resizeDesigner: function () {
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            }
        }
    }

    RacadDesigner.updateModalSideBar = function () {
        return;
    }
    
    RacadDesigner.changeDisplayOrientation = function (direction) {
        if (direction == 'rtl') {
        }
    }
    jQuery('[data-udraw="duplicateButton"]').click(function () {
        RacadDesigner.copyObject();
        RacadDesigner.pasteObject();
    });
    RacadDesigner.triggerImageUpload = function () {
        jQuery('[data-udraw="uploadImage"]').trigger('click');
    }
    RacadDesigner.changeZoom = function (quantity) {
        var newZoom = RacadDesigner.zoom.currentZoom + quantity;
        var passCheck = false;
        if (quantity > 0) {
            if (newZoom <= 5.01) {
                passCheck = true;
            }
        } else if (quantity < 0) {
            if (newZoom >= 0.09) {
                passCheck = true;
            }
        }
        if (passCheck) {
            RacadDesigner.zoom.zoomChange = Math.round((newZoom - RacadDesigner.zoom.currentZoom) * 100) / 100;
            RacadDesigner.zoom.currentZoom = newZoom;
            RacadDesigner.ScaleCanvas(newZoom);
            var zoomPercentage = Math.round((newZoom * 100));
            $('[data-udraw="zoomPercentage"]').html(zoomPercentage + '%');
            __center_canvas();
        }
    }
    jQuery('[data-udraw="increaseZoomButton"]').click(function () {
        RacadDesigner.changeZoom(0.1);
        jQuery('[data-udraw="zoomDisplay"]').text(Math.round(RacadDesigner.zoom.currentZoom * 100) + "%");
    });
    jQuery('[data-udraw="decreaseZoomButton"]').click(function () {
        RacadDesigner.changeZoom(-0.1);
        jQuery('[data-udraw="zoomDisplay"]').text(Math.round(RacadDesigner.zoom.currentZoom * 100) + "%");
    });
    jQuery('[data-udraw="imageApplyMask"]').click(function () {
        var activeObject = RacadDesigner.canvas.getActiveObject();
        if (activeObject) {
            var _id = activeObject.racad_properties._id;
            RacadDesigner.Image.displayAdvancedImagePropertiesUI(_id);
        }
    });
    jQuery('[data-udraw="bringForwardButton"]').click(function () {
        var activeObject = RacadDesigner.canvas.getActiveObject();
        if (activeObject) {
            activeObject.bringForward();
            RacadDesigner.ReloadObjects();
        }
    });
    jQuery('[data-udraw="sendBackwardsButton"]').click(function () {
        var activeObject = RacadDesigner.canvas.getActiveObject();
        if (activeObject) {
            activeObject.sendBackwards();
            RacadDesigner.ReloadObjects();
        }
    });
    jQuery('[data-udraw="imageToSVG"]').click(function(){
        var activeObject = RacadDesigner.canvas.getActiveObject();
        if (activeObject && activeObject.hasOwnProperty('racad_properties')) {
            var _id = activeObject.racad_properties._id;
            try {
                RacadDesigner.SVG.loadSVGImageById(_id);
            } catch (error) {
                console.log(error);
            }
        }
    });
    RacadDesigner.canvas.on('object:selected', function (object) {
        jQuery('[data-udraw="objectOptionsContainer"], [data-udraw="generalOptionsContainer"]').fadeIn();
        if (object.target.type == 'image') {
            jQuery('[data-udraw="imageOptionsContainer"]').fadeIn();
            jQuery('[data-udraw="gradientColourContainer"]').fadeOut();
            var _src = object.target.getSrc();
            if (_src.endsWith('svg')) {
                jQuery('[data-udraw="imageToSVG"]').show();
            } else {
                jQuery('[data-udraw="imageToSVG"]').hide();
            }
        } else {
            jQuery('[data-udraw="imageOptionsContainer"]').fadeOut();
            if (object.target.type == 'group' || object.target.type == 'path-group') {
                jQuery('[data-udraw="gradientColourContainer"]').fadeOut();
            } else {
                jQuery('[data-udraw="gradientColourContainer"]').fadeIn();
            }
        }
        if (object.target.type == 'i-text' || object.target.type == 'text' || object.target.type == 'textbox' || (object.target.type == 'group' && object.target.hasOwnProperty('racad_properties') && object.target.racad_properties.isAdvancedText)) {
            jQuery('[data-udraw="textOptionsContainer"]').fadeIn();
            if (object.target.curvedText) {
                jQuery('[data-udraw="curvedTextContainer"]').fadeIn();
            } else {
                jQuery('[data-udraw="curvedTextContainer"]').fadeOut();
            }
        } else {
            jQuery('[data-udraw="textOptionsContainer"]').fadeOut();
        }
        if (object.target.hasOwnProperty('racad_properties') && !object.target.racad_properties.hasOwnProperty('clipLocked')) {
            jQuery('[data-udraw="imageClippingModal"]').modal('hide');
        }
        var objectStroke = object.target.getStroke() || 'rgb(0,0,0)';
        jQuery('[data-udraw="objectStrokeColour"]').spectrum('set', objectStroke);
        jQuery('[data-udraw="objectStrokeSpinner"]').val(object.target.strokeWidth || '0.00');

    });
    RacadDesigner.canvas.on('selection:cleared', function (object) {
        jQuery('[data-udraw="imageOptionsContainer"],[data-udraw="generalOptionsContainer"],[data-udraw="objectOptionsContainer"],[data-udraw="textOptionsContainer"]').fadeOut();
    });
    jQuery('#udraw-bootstrap').on('udraw-switched-page', function (event) {
        jQuery('[data-udraw="zoomDisplay"]').text(Math.round(RacadDesigner.zoom.currentZoom * 100) + "%");
    });
    RacadDesigner.togglePages = function () {
        if (RacadDesigner.pagesContainer.container.is(':visible')) {
            RacadDesigner.pagesContainer.container.hide();
        } else {
            RacadDesigner.pagesContainer.container.show();
        }
    }

    __load_extra_functions = function () {
        jQuery('#udraw-options-page-design-btn').show();
        jQuery(window).resize(function(){
            __initialize_widescreen();
        });
    }
    __initialize_widescreen = function(){
        jQuery('[data-udraw="zoomDisplay"]').text(Math.round(RacadDesigner.zoom.currentZoom * 100) + "%");
        /*var margin_width = (jQuery('[data-udraw="uDrawBootstrap"]').width() - jQuery('#designer-wrapper').width()) / 2;
        var wrapper_margin = (jQuery('body').width() - jQuery('#designer-wrapper').width()) / 2;
        if (wrapper_margin > margin_width) {
            jQuery('[data-udraw="uDrawBootstrap"]').css('margin-left', margin_width * -1);
        } else {
            jQuery('[data-udraw="uDrawBootstrap"]').css('margin-left', wrapper_margin * -1);
        }*/
        __center_canvas();
    }
    __center_canvas = function(){
        var canvas_wrapper_left_margin = (jQuery('[data-udraw="canvasWrapper"]').width() - jQuery('[data-udraw="canvas"]').width()) / 2;
        var canvas_wrapper_top_margin = (jQuery('[data-udraw="canvasWrapper"]').height() - jQuery('[data-udraw="canvas"]').height()) / 2;
        if (canvas_wrapper_left_margin > 15 && canvas_wrapper_top_margin > 15) {
            jQuery('.canvas-container').css({
                'margin-top': canvas_wrapper_top_margin,
                'margin-left': canvas_wrapper_left_margin
            });
        }
    }
})(window.jQuery);