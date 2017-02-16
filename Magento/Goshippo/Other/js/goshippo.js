
    function openMyPopup(url) {



        if ($('browser_window') && typeof(Windows) != 'undefined') {
            Windows.focus('browser_window');
            return;
        }
        var dialogWindow = Dialog.info(null, {
            closable:true,
            resizable:false,
            draggable:true,
            className:'magento',
            windowClassName:'popup-window',
            title:'List of services',
            top:100,
            width:800,
            height:350,
            zIndex:1000,
            recenterAuto:false,
            hideEffect:Element.hide,
            showEffect:Element.show,
            id:'browser_window',
            url:url,
            onClose:function (param, el) {

            }
        });
    }

    function closePopup() {
        Windows.close('browser_window');
    }

