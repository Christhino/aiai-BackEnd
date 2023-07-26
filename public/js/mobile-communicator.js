$(function () {

    var isFlutterInAppWebViewReady = false;
    window.addEventListener("flutterInAppWebViewPlatformReady", function (event) {
        isFlutterInAppWebViewReady = true;
    });

    $('#closePageBtn').on("click touchstart", function () {
        closePage();
    });

    //
    function closePage() {
        if (isFlutterInAppWebViewReady) {
            window.flutter_inappwebview.callHandler('handlerClosePage', true);
        } else {
            window.close();
        }
    }

});
