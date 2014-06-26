/**
 * Created with JetBrains PhpStorm.
 * User: yukan
 * Date: 13-9-2
 * Time: 下午7:22
 * To change this template use File | Settings | File Templates.
 */
KISSY.use('node,dom',function(S){
    S.ready(function(){
        if(window.parent._setIFrameSize) return;
        var controlBar = S.Node('<div id="J_JSTestControlBar">收起</div>'),
            isPackup = false;//表示是否收起
        controlBar.appendTo('body');
        controlBar.on('click',function(){
            if(isPackup){
                S.one('#HTMLReporter').fadeIn();
                controlBar.html('收起');
                isPackup = false;
            }else{
                S.one('#HTMLReporter').fadeOut();
                controlBar.html('展开');
                isPackup = true;
            }
        });
    });
});
/**
 * jasmine的一些定制操作
 */
(function(S){
    if(!window.jasmine) return;
    window.setPageSize = function(width,height){
        if(window.parent._setIFrameSize)
            window.parent._setIFrameSize(width,height);
    };
    window.runAsync = function(config){
        var operationFn = config.perform;
        var conditionFn = config.until;
        var conditionTitle = config.status;
        var timeElapsed = config.maxWaitTime;
        var checkFn = config.then;

        if(!(operationFn || conditionFn || conditionTitle || timeElapsed || checkFn)) {
            alert("runAsync参数不足");
            return;
        }

        runs(function() {
            operationFn();
        });

        waitsFor(conditionFn,conditionTitle,timeElapsed);

        runs(function(){
            checkFn();
        });
    };
    beforeEach(function(){
        this.addMatchers({
            toExist: function () {
                return S.all(this.actual).length > 0;
            },
            toHasClass: function (className) {
                return S.all(this.actual).hasClass(className);
            },
            toStructLike: function(structStr){
                return this.actual.replace(/\>[^\<]*\</g,"><") == structStr;
            }
        })
    });
})(KISSY);
