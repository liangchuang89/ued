(function(S) {
    var D = S.DOM, E = S.Event, $ = S.get;
    Search.add('form-validate', function(srh) {

        //Ĭ��Ϊ��Ϊ���ĸ�����
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

        //��¶��֤�����Ľӿ�
        srh.vcheck = {
            number: checkNumber
        };

        //��չ KISSY node
        /**
        * ����֤�¼��Ľӿ�
        * @param {HTMLElement} el Ҫ�󶨵���Ԫ��.
        * @param {string} checkfunc Ҫ������֤�ķ���(ͬ Search.vcheck �ṩ��ֵ).
        * @param {string} eventName ��ʲô�¼���Ĭ��Ϊ keyup.
        * @param {number} delay ��֤��ʱ.
        * @param {object.<string>} extraConf �����������.
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
