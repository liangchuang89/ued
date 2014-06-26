(function(S) {
    var D = S.DOM, E = S.Event, $ = S.get;
    Search.add('form-validate', function(srh) {

        //默认为不为负的浮点数
        function checkNumber(_val, extraConf) {
            var reg = /^\d+\.?\d*$/;
            if (extraConf) {
                var isInterger = extraConf.isInterger,
                noNegative = extraConf.noNegative;
            }
            if (isInterger) reg = /^\d*$/;
            if (reg.test(_val)) {
                return true;
            } else {
                if (isInterger) {
                    _val = parseInt(_val);
                } else {
                    _val = parseFloat(_val);
                }
                if (noNegative) _val = Math.abs(_val);
                if (isNaN(_val)) _val = '';
                return _val;
            }
        }

        //暴露验证函数的接口
        srh.vcheck = {
            number: checkNumber
        };

        //扩展 KISSY node
        /**
        * 绑定验证事件的接口
        * @param {HTMLElement} el 要绑定到的元素.
        * @param {string} checkfunc 要用来验证的方法(同 Search.vcheck 提供的值).
        * @param {string} eventName 绑定什么事件，默认为 keyup.
        * @param {number} delay 验证延时.
        * @param {object.<string>} extraConf 额外的配置项.
        */
        S.augment(S.Node, {
            validateBind: function(checkfunc, extraConf) {
                if (!checkfunc) return;

                extraConf = S.merge({
                    autoCorrect: true,
                    eventName: 'keyup',
                    delay: 0
                }, extraConf);

                var eventName = extraConf.eventName,
                delay = extraConf.delay;

                this.on(eventName, function() {
                    var _result = srh.vcheck[checkfunc](this.val(), extraConf);
                    if (_result === true) return true;
                    if (extraConf.autoCorrect) this.val(_result);
                });

                return this;
            }
        });
    });
})(KISSY);
